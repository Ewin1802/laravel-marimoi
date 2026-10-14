@extends('layouts.app')

@section('title', 'Setor Pajak')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/tax-payments.css') }}">
@endpush

@section('content')

    @php $rp = fn($n) => 'Rp ' . number_format($n, 0, ',', '.'); @endphp

    <div class="tp-print-title">
        <h2>Laporan Setoran Pajak {{ $year }}</h2>
        <p>Marimoi Cafe &middot; dicetak {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="page-header no-print">
        <div>
            <h2>Setor Pajak</h2>
            <p>Catatan setoran pajak beserta bukti, sebagai laporan untuk owner dan petugas pajak.</p>
        </div>

        <div class="tp-filter">
            <form method="GET" action="{{ route('tax-payments.index') }}">
                <select name="year" onchange="this.form.submit()">
                    @foreach ($years as $y)
                        <option value="{{ $y }}" @selected($y == $year)>Tahun {{ $y }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('tax-payments.report', ['year' => $year]) }}" target="_blank" class="btn btn-light">
                <i data-lucide="file-text"></i> Laporan
            </a>

            <a href="{{ route('tax-payments.create') }}" class="btn btn-primary">
                <i data-lucide="plus"></i> Setor Pajak
            </a>
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="tp-summary">
        <div class="tp-sum collected">
            <small>Pajak Terkumpul {{ $year }}</small>
            <h3>{{ $rp($totals['collected']) }}</h3>
            <span>Dari seluruh transaksi</span>
        </div>
        <div class="tp-sum paid">
            <small>Sudah Disetor</small>
            <h3>{{ $rp($totals['paid']) }}</h3>
            <span>{{ $totals['collected'] > 0 ? round($totals['paid'] / $totals['collected'] * 100, 1) : 0 }}% dari pajak terkumpul</span>
        </div>
        <div class="tp-sum remaining">
            <small>Belum Disetor</small>
            <h3>{{ $rp($totals['remaining']) }}</h3>
            <span>Sisa kewajiban</span>
        </div>
    </div>

    {{-- REKAP PER BULAN --}}
    <div class="tp-card">
        <div class="tp-card-head">
            <div>
                <h3>Rekap per Masa Pajak</h3>
                <p>Pajak terkumpul dihitung otomatis dari transaksi tiap bulan.</p>
            </div>
        </div>

        <table class="tp-table">
            <thead>
                <tr>
                    <th>Masa Pajak</th>
                    <th class="num">Terkumpul</th>
                    <th class="num">Disetor</th>
                    <th class="num">Sisa</th>
                    <th>Status</th>
                    <th class="tp-actions-col" width="120"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recap as $row)
                    <tr>
                        <td><strong>{{ $row['label'] }}</strong></td>
                        <td class="num">{{ $rp($row['collected']) }}</td>
                        <td class="num">{{ $rp($row['paid']) }}</td>
                        <td class="num"><strong>{{ $rp($row['remaining']) }}</strong></td>
                        <td>
                            @switch($row['status'])
                                @case('paid') <span class="tp-badge paid">Lunas</span> @break
                                @case('partial') <span class="tp-badge partial">Sebagian</span> @break
                                @case('unpaid') <span class="tp-badge unpaid">Belum disetor</span> @break
                                @default <span class="tp-badge none">Tidak ada pajak</span>
                            @endswitch
                        </td>
                        <td class="tp-actions-col">
                            @if ($row['remaining'] > 0)
                                <a href="{{ route('tax-payments.create', ['period' => $row['period']]) }}"
                                    class="btn btn-primary btn-sm">Setor</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="tp-empty">Belum ada data pajak pada tahun {{ $year }}.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- RIWAYAT SETORAN --}}
    <div class="tp-card">
        <div class="tp-card-head">
            <div>
                <h3>Riwayat Setoran</h3>
                <p>Klik gambar bukti untuk memperbesar.</p>
            </div>
        </div>

        <table class="tp-table">
            <thead>
                <tr>
                    <th>Tanggal Setor</th>
                    <th>Masa Pajak</th>
                    <th>No. Referensi</th>
                    <th class="num">Nominal</th>
                    <th>Bukti</th>
                    <th class="tp-actions-col" width="110">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td>
                            {{ $p->payment_date->format('d/m/Y') }}
                            <div class="muted">oleh {{ $p->user->name ?? '-' }}</div>
                        </td>
                        <td>{{ $p->period_label }}</td>
                        <td>
                            {{ $p->reference ?: '-' }}
                            @if ($p->notes)
                                <div class="muted">{{ \Illuminate\Support\Str::limit($p->notes, 50) }}</div>
                            @endif
                        </td>
                        <td class="num"><strong>{{ $rp($p->amount) }}</strong></td>
                        <td>
                            <img src="{{ $p->proof_url }}" alt="Bukti setor" class="tp-proof"
                                onclick="tpOpen('{{ $p->proof_url }}')">
                        </td>
                        <td class="tp-actions-col">
                            <div class="tp-actions">
                                <a href="{{ route('tax-payments.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                    <i data-lucide="square-pen"></i>
                                </a>
                                <form action="{{ route('tax-payments.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus catatan setoran ini beserta buktinya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i data-lucide="trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="tp-empty">Belum ada setoran pajak tercatat.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="tp-pager">
            {{ $payments->links() }}
        </div>
    </div>

    <div class="tp-lightbox" id="tpLightbox" onclick="this.classList.remove('show')">
        <button type="button" aria-label="Tutup">&times;</button>
        <img src="" alt="Bukti setor" id="tpLightboxImg">
    </div>

@endsection

@push('scripts')
    <script>
        function tpOpen(url) {
            document.getElementById('tpLightboxImg').src = url;
            document.getElementById('tpLightbox').classList.add('show');
        }
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') document.getElementById('tpLightbox').classList.remove('show');
        });
    </script>
@endpush
