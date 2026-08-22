<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberBarcode;
use App\Models\StampTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberStampController extends Controller
{
    /**
     * =========================================================
     * GET MEMBER STAMP
     * =========================================================
     *
     * Digunakan aplikasi Member untuk membaca
     * jumlah stamp terbaru dari server.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $member = MemberBarcode::where(
            'user_id',
            $user->id
        )->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data member tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $this->formatMember($member),
        ], 200);
    }

    /**
     * =========================================================
     * EARN STAMP
     * =========================================================
     *
     * Dipanggil oleh aplikasi kasir setelah pembayaran berhasil.
     *
     * Aturan:
     *
     * 1 order = maksimal 1 stamp.
     *
     * Contoh:
     *
     * 0/5
     * ↓ order
     * 1/5
     *
     * 4/5
     * ↓ order
     * 5/5 🎁
     *
     * 5/5
     * ↓ order lagi
     * 5/5 🎁
     *
     * 5/5
     * ↓ redeem
     * 0/5
     *
     * 0/5
     * ↓ order lagi
     * 1/5
     *
     * Semua perubahan stamp dilakukan SERVER.
     */
    public function earn(Request $request)
    {
        // ==========================================================
        // VALIDASI REQUEST
        // ==========================================================

        $request->validate([
            'member_code' => [
                'required',
                'string',
                'max:100',
            ],

            'order_id' => [
                'required',
                'integer',
                'exists:orders,id',
            ],
        ]);

        try {

            return DB::transaction(function () use ($request) {

                // ==================================================
                // LOCK MEMBER
                // ==================================================
                //
                // Member dikunci selama transaksi berlangsung.
                //
                // Ini penting jika:
                //
                // Kasir A -> earn
                // Kasir B -> earn
                //
                // terjadi hampir bersamaan.
                //
                // Hanya satu transaksi yang boleh mengubah
                // stamp member pada satu waktu.
                //

                $member = MemberBarcode::where(
                    'code',
                    $request->member_code
                )
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                // ==================================================
                // MEMBER TIDAK DITEMUKAN
                // ==================================================

                if (!$member) {

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Member tidak ditemukan atau tidak aktif.',
                    ], 404);
                }

                // ==================================================
                // CEK VALIDITAS BARCODE
                // ==================================================
                //
                // Kalau model MemberBarcode mempunyai isValid(),
                // gunakan juga validasi masa berlaku.
                //

                if (!$member->isValid()) {

                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Member tidak aktif atau barcode sudah tidak berlaku.',
                    ], 422);
                }

                // ==================================================
                // CEK ORDER
                // ==================================================

                $order = DB::table('orders')
                    ->where('id', $request->order_id)
                    ->first();

                if (!$order) {

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Order tidak ditemukan.',
                    ], 404);
                }

                // ==================================================
                // PASTIKAN ORDER MEMANG MENGGUNAKAN MEMBER INI
                // ==================================================
                //
                // Jangan sampai:
                //
                // Member A
                // order milik Member B
                //
                // lalu Member A mendapatkan stamp.
                //
                // Ini menggunakan member_code yang tersimpan
                // pada order.
                //

                if (
                    !isset($order->member_code) ||
                    $order->member_code !== $member->code
                ) {

                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Order tidak terkait dengan member ini.',
                    ], 422);
                }

                // ==================================================
                // CEK ORDER SUDAH MEMBERIKAN STAMP ATAU BELUM
                // ==================================================
                //
                // Idempotency stamp.
                //
                // Jika request yang sama dikirim dua kali:
                //
                // Request #1 -> earn
                // Request #2 -> earn
                //
                // Request #2 tidak akan menambah stamp lagi.
                //

                $alreadyExists = StampTransaction::where(
                    'member_barcode_id',
                    $member->id
                )
                    ->where(
                        'order_id',
                        $order->id
                    )
                    ->where(
                        'type',
                        'earn'
                    )
                    ->exists();

                if ($alreadyExists) {

                    return response()->json([
                        'status' => 'success',
                        'message' =>
                            'Order ini sudah mendapatkan stamp.',
                        'data' => $this->formatMember($member),
                    ], 200);
                }

                // ==================================================
                // CEK MYSTERY BOX SUDAH TERSEDIA
                // ==================================================
                //
                // Jika:
                //
                // stamp_count = 5
                // stamp_target = 5
                //
                // berarti Mystery Box sudah tersedia.
                //
                // Order berikutnya TIDAK boleh menghasilkan
                // stamp ke-6.
                //
                // Stamp baru akan aktif kembali setelah redeem.
                //

                if (
                    $member->stamp_count >=
                    $member->stamp_target
                ) {

                    return response()->json([
                        'status' => 'success',
                        'message' =>
                            'Mystery Box tersedia. '
                            . 'Stamp belum ditambahkan sampai Mystery Box diredeem.',
                        'data' => $this->formatMember($member),
                    ], 200);
                }

                // ==================================================
                // TAMBAH 1 STAMP
                // ==================================================

                $member->increment(
                    'stamp_count',
                    1
                );

                // ==================================================
                // REFRESH MEMBER
                // ==================================================
                //
                // Ambil nilai terbaru dari database.
                //

                $member->refresh();

                // ==================================================
                // SIMPAN HISTORY STAMP
                // ==================================================

                StampTransaction::create([
                    'member_barcode_id' => $member->id,

                    'order_id' => $order->id,

                    'type' => 'earn',

                    'amount' => 1,

                    'note' => 'Stamp dari transaksi pembelian.',
                ]);

                // ==================================================
                // CEK APAKAH SEKARANG MYSTERY BOX TERSEDIA
                // ==================================================

                $mysteryBoxAvailable =
                    $member->stamp_count >=
                    $member->stamp_target;

                // ==================================================
                // RESPONSE
                // ==================================================

                return response()->json([
                    'status' => 'success',

                    'message' =>
                        $mysteryBoxAvailable
                            ? 'Stamp berhasil ditambahkan. Mystery Box sekarang tersedia.'
                            : 'Stamp berhasil ditambahkan.',

                    'data' => $this->formatMember($member),
                ], 200);
            });

        } catch (\Throwable $e) {

            // ==========================================================
            // ERROR
            // ==========================================================

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan stamp.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * =========================================================
     * REDEEM MYSTERY BOX
     * =========================================================
     *
     * Untuk sekarang reward belum random.
     *
     * Endpoint ini hanya melakukan:
     *
     * 5/5
     * ↓
     * redeem
     * ↓
     * 0/5
     *
     * Sistem reward akan kita sambungkan setelah ini.
     */
    public function redeem(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {

                // =================================================
                // LOCK MEMBER
                // =================================================

                $member = MemberBarcode::where(
                    'user_id',
                    $request->user()->id
                )
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (!$member) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Data member tidak ditemukan.',
                    ], 404);
                }

                // =================================================
                // CEK STAMP
                // =================================================

                if (
                    $member->stamp_count <
                    $member->stamp_target
                ) {
                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Stamp belum mencukupi untuk Mystery Box.',
                        'data' => $this->formatMember($member),
                    ], 422);
                }

                $amount =
                    $member->stamp_target;

                // =================================================
                // RESET STAMP
                // =================================================

                $member->update([
                    'stamp_count' => 0,
                ]);

                // =================================================
                // SIMPAN HISTORY REDEEM
                // =================================================

                StampTransaction::create([
                    'member_barcode_id' => $member->id,
                    'order_id' => null,
                    'type' => 'redeem',
                    'amount' => $amount,
                    'note' => 'Penukaran Mystery Box.',
                ]);

                // =================================================
                // RESPONSE
                // =================================================

                return response()->json([
                    'status' => 'success',
                    'message' =>
                        'Mystery Box berhasil ditukarkan.',
                    'data' => $this->formatMember($member),
                ], 200);
            });

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' =>
                    'Gagal menukarkan Mystery Box.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * =========================================================
     * STAMP HISTORY
     * =========================================================
     */
    public function history(Request $request)
    {
        $member = MemberBarcode::where(
            'user_id',
            $request->user()->id
        )->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data member tidak ditemukan.',
            ], 404);
        }

        $history = $member
            ->stampTransactions()
            ->with('order:id,transaction_time,total')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,

                    'type' => $item->type,

                    'amount' => $item->amount,

                    'note' => $item->note,

                    'order_id' => $item->order_id,

                    'created_at' =>
                        $item->created_at,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => [
                'stamp_count' =>
                    $member->stamp_count,

                'stamp_target' =>
                    $member->stamp_target,

                'history' => $history,
            ],
        ], 200);
    }

    /**
     * =========================================================
     * FORMAT MEMBER
     * =========================================================
     */
    private function formatMember(
        MemberBarcode $member
    ): array {
        return [
            'id' => $member->id,

            'user_id' =>
                $member->user_id,

            'code' =>
                $member->code,

            'birth_date' =>
                $member->birth_date
                    ?->format('Y-m-d'),

            'discount_type' =>
                $member->discount_type,

            'discount_value' =>
                $member->discount_value,

            'stamp_count' =>
                $member->stamp_count,

            'stamp_target' =>
                $member->stamp_target,

            'mystery_box_available' =>
                $member->hasMysteryReward(),

            'is_active' =>
                $member->is_active,

            'valid_from' =>
                $member->valid_from,

            'valid_until' =>
                $member->valid_until,
        ];
    }
}
