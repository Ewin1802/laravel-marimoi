<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TaxPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/**
 * SETOR PAJAK
 *
 * Murni laporan. Tidak mengubah orders / order_items.
 * Pajak terkumpul = SUM(orders.tax) per bulan transaksi.
 */
class TaxPaymentController extends Controller
{
    /**
     * transaction_time disimpan sebagai string "2026-08-17T13:25:00",
     * jadi 7 karakter pertama = "YYYY-MM" (aman di MySQL maupun SQLite).
     */
    private function collectedByPeriod(?string $year = null): array
    {
        $query = Order::selectRaw(
            'SUBSTR(transaction_time, 1, 7) as period, SUM(tax) as total'
        )->groupBy('period');

        if ($year) {
            $query->whereRaw('SUBSTR(transaction_time, 1, 4) = ?', [$year]);
        }

        return $query->pluck('total', 'period')
            ->map(fn($v) => (int) $v)
            ->all();
    }

    private function collectedFor(string $period): int
    {
        return (int) Order::whereRaw(
            'SUBSTR(transaction_time, 1, 7) = ?',
            [$period]
        )->sum('tax');
    }

    private function paidFor(string $period, ?int $exceptId = null): int
    {
        return (int) TaxPayment::where('period', $period)
            ->when($exceptId, fn($q) => $q->where('id', '!=', $exceptId))
            ->sum('amount');
    }

    /**
     * Daftar bulan (12 bulan terakhir + bulan yang pernah ada setoran)
     * beserta pajak terkumpul, sudah disetor, dan sisa.
     */
    private function periodOptions(): array
    {
        $collected = $this->collectedByPeriod();
        $paid = TaxPayment::selectRaw('period, SUM(amount) as total')
            ->groupBy('period')->pluck('total', 'period')->all();

        $periods = array_unique(array_merge(
            array_keys($collected),
            array_keys($paid),
            [now()->format('Y-m')]
        ));
        rsort($periods);

        $options = [];
        foreach ($periods as $p) {
            $c = $collected[$p] ?? 0;
            $s = (int) ($paid[$p] ?? 0);
            $options[$p] = [
                'label' => TaxPayment::periodLabel($p),
                'collected' => $c,
                'paid' => $s,
                'remaining' => max($c - $s, 0),
            ];
        }

        return $options;
    }

    // ------------------------------------------------------------

    public function index(Request $request)
    {
        $year = $request->input('year', now()->format('Y'));

        $collected = $this->collectedByPeriod($year);

        $paidByPeriod = TaxPayment::where('period', 'like', $year . '-%')
            ->selectRaw('period, SUM(amount) as total')
            ->groupBy('period')->pluck('total', 'period')->all();

        $periods = array_unique(array_merge(
            array_keys($collected),
            array_keys($paidByPeriod)
        ));
        rsort($periods);

        $recap = [];
        foreach ($periods as $p) {
            $c = $collected[$p] ?? 0;
            $s = (int) ($paidByPeriod[$p] ?? 0);
            $remaining = $c - $s;

            $recap[] = [
                'period' => $p,
                'label' => TaxPayment::periodLabel($p),
                'collected' => $c,
                'paid' => $s,
                'remaining' => max($remaining, 0),
                'status' => $c === 0 && $s === 0 ? 'none'
                    : ($s <= 0 ? 'unpaid' : ($remaining > 0 ? 'partial' : 'paid')),
            ];
        }

        $totals = [
            'collected' => array_sum(array_column($recap, 'collected')),
            'paid' => array_sum(array_column($recap, 'paid')),
        ];
        $totals['remaining'] = max($totals['collected'] - $totals['paid'], 0);

        $payments = TaxPayment::with('user')
            ->where('period', 'like', $year . '-%')
            ->latest('payment_date')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $years = collect(range((int) now()->format('Y'), (int) now()->format('Y') - 4));

        return view('pages.tax-payments.index', compact(
            'year', 'years', 'recap', 'totals', 'payments'
        ));
    }

    // ------------------------------------------------------------
    // LAPORAN CETAK (A4) — untuk owner & petugas pajak
    // ------------------------------------------------------------

    public function report(Request $request)
    {
        $year = $request->input('year', now()->format('Y'));
        $month = $request->input('month'); // "01".."12" atau kosong = setahun penuh

        if (!preg_match('/^\d{4}$/', (string) $year)) {
            $year = now()->format('Y');
        }
        if ($month !== null && $month !== '' && !preg_match('/^(0[1-9]|1[0-2])$/', (string) $month)) {
            $month = null;
        }
        $month = $month ?: null;

        $prefix = $month ? "$year-$month" : (string) $year;

        $scopeLabel = $month
            ? TaxPayment::periodLabel($prefix)
            : 'Tahun ' . $year;

        // Pajak terkumpul per masa (dalam cakupan laporan)
        $collected = collect($this->collectedByPeriod($year))
            ->filter(fn($v, $k) => str_starts_with($k, $prefix))
            ->all();

        $payments = TaxPayment::with('user')
            ->where('period', 'like', $prefix . '%')
            ->orderBy('payment_date')
            ->orderBy('id')
            ->get();

        $paidByPeriod = $payments->groupBy('period')
            ->map(fn($g) => (int) $g->sum('amount'))
            ->all();

        $periods = array_unique(array_merge(array_keys($collected), array_keys($paidByPeriod)));
        sort($periods);

        $recap = [];
        foreach ($periods as $p) {
            $c = $collected[$p] ?? 0;
            $paid = $paidByPeriod[$p] ?? 0;
            $remaining = max($c - $paid, 0);

            $recap[] = [
                'label' => TaxPayment::periodLabel($p),
                'collected' => $c,
                'paid' => $paid,
                'remaining' => $remaining,
                'status' => $c === 0 && $paid === 0 ? 'none'
                    : ($paid <= 0 ? 'unpaid' : ($remaining > 0 ? 'partial' : 'paid')),
            ];
        }

        $totalCollected = array_sum($collected);
        $totalPaid = (int) $payments->sum('amount');
        $totalRemaining = max($totalCollected - $totalPaid, 0);
        $percentPaid = $totalCollected > 0
            ? min(round($totalPaid / $totalCollected * 100, 1), 100)
            : 0;

        $years = collect(range((int) now()->format('Y'), (int) now()->format('Y') - 4));

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $key = str_pad((string) $m, 2, '0', STR_PAD_LEFT);
            $months[$key] = \Carbon\Carbon::create(2000, $m, 1)->locale('id')->translatedFormat('F');
        }

        return view('pages.tax-payments.report', [
            'year' => $year,
            'month' => $month,
            'years' => $years,
            'months' => $months,
            'scopeLabel' => $scopeLabel,
            'recap' => $recap,
            'payments' => $payments,
            'totalCollected' => $totalCollected,
            'totalPaid' => $totalPaid,
            'totalRemaining' => $totalRemaining,
            'percentPaid' => $percentPaid,
            'admin' => Auth::user(),
        ]);
    }

    public function create(Request $request)
    {
        $periods = $this->periodOptions();
        $selected = $request->input('period', now()->format('Y-m'));

        return view('pages.tax-payments.create', compact('periods', 'selected'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);

        $this->assertNotOverpaid($data['period'], $data['amount']);

        $data['proof_path'] = $request->file('proof')
            ->store('tax-proofs', 'public');
        unset($data['proof']);

        $data['user_id'] = Auth::id();

        TaxPayment::create($data);

        return redirect()
            ->route('tax-payments.index', ['year' => substr($data['period'], 0, 4)])
            ->with('success', 'Setoran pajak berhasil dicatat.');
    }

    public function edit(TaxPayment $taxPayment)
    {
        $periods = $this->periodOptions();

        return view('pages.tax-payments.edit', [
            'payment' => $taxPayment,
            'periods' => $periods,
        ]);
    }

    public function update(Request $request, TaxPayment $taxPayment)
    {
        $data = $this->validated($request, false);

        $this->assertNotOverpaid($data['period'], $data['amount'], $taxPayment->id);

        if ($request->hasFile('proof')) {
            Storage::disk('public')->delete($taxPayment->proof_path);
            $data['proof_path'] = $request->file('proof')
                ->store('tax-proofs', 'public');
        }
        unset($data['proof']);

        $taxPayment->update($data);

        return redirect()
            ->route('tax-payments.index', ['year' => substr($data['period'], 0, 4)])
            ->with('success', 'Setoran pajak berhasil diperbarui.');
    }

    public function destroy(TaxPayment $taxPayment)
    {
        Storage::disk('public')->delete($taxPayment->proof_path);

        $taxPayment->delete();

        return redirect()
            ->route('tax-payments.index')
            ->with('success', 'Setoran pajak berhasil dihapus.');
    }

    // ------------------------------------------------------------

    private function validated(Request $request, bool $proofRequired): array
    {
        return $request->validate([
            'period' => ['required', 'regex:/^\d{4}-(0[1-9]|1[0-2])$/'],
            'payment_date' => ['required', 'date'],
            'amount' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'proof' => [
                $proofRequired ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:4096',
            ],
        ], [
            'proof.required' => 'Bukti setor wajib diunggah.',
            'proof.image' => 'Bukti setor harus berupa gambar.',
            'proof.mimes' => 'Bukti setor harus berformat JPG atau PNG.',
            'proof.max' => 'Ukuran bukti setor maksimal 4 MB.',
            'amount.min' => 'Nominal harus lebih dari 0.',
            'amount.integer' => 'Nominal harus berupa angka bulat (rupiah).',
        ]);
    }

    /** Setoran tidak boleh melebihi sisa pajak pada masa tersebut. */
    private function assertNotOverpaid(string $period, int $amount, ?int $exceptId = null): void
    {
        $remaining = $this->collectedFor($period) - $this->paidFor($period, $exceptId);

        if ($amount > $remaining) {
            throw ValidationException::withMessages([
                'amount' => 'Nominal melebihi sisa pajak ' . TaxPayment::periodLabel($period)
                    . ' (sisa Rp ' . number_format(max($remaining, 0), 0, ',', '.') . ').',
            ]);
        }
    }
}
