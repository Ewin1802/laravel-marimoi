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
     * ==========================================================
     * SHOW STAMP
     * ==========================================================
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
     * ==========================================================
     * HISTORY
     * ==========================================================
     */
    public function history(Request $request)
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

        $history = StampTransaction::where(
            'member_barcode_id',
            $member->id
        )
            ->with('order')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $history,
        ], 200);
    }


    /**
     * ==========================================================
     * EARN STAMP
     * ==========================================================
     *
     * 1 order = maksimal 1 stamp.
     *
     * Jika sudah 5/5:
     *
     * order baru
     *     ↓
     * tetap 5/5
     *
     * Harus redeem terlebih dahulu.
     */
    public function earn(Request $request)
    {
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

                $member = MemberBarcode::where(
                    'code',
                    $request->member_code
                )
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (!$member) {
                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Member tidak ditemukan atau tidak aktif.',
                    ], 404);
                }

                // ==================================================
                // VALIDASI MEMBER
                // ==================================================

                if (!$member->isValid()) {
                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Member tidak aktif atau barcode sudah tidak berlaku.',
                    ], 422);
                }

                // ==================================================
                // AMBIL ORDER
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
                // PASTIKAN ORDER MILIK MEMBER INI
                // ==================================================

                if (
                    empty($order->member_code) ||
                    $order->member_code !== $member->code
                ) {
                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Order tidak terkait dengan member ini.',
                    ], 422);
                }

                // ==================================================
                // IDEMPOTENCY
                // ==================================================
                //
                // Order yang sama tidak boleh menghasilkan
                // stamp dua kali.
                //

                $alreadyEarned = StampTransaction::where(
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

                if ($alreadyEarned) {

                    return response()->json([
                        'status' => 'success',
                        'message' =>
                            'Order ini sudah mendapatkan stamp.',
                        'data' =>
                            $this->formatMember($member),
                    ], 200);
                }

                // ==================================================
                // STOP JIKA MYSTERY BOX SUDAH READY
                // ==================================================
                //
                // INI BAGIAN PENTING.
                //
                // 5/5 + order baru
                // tidak boleh menjadi 6/5.
                //

                if (
                    $member->stamp_count >=
                    $member->stamp_target
                ) {

                    return response()->json([
                        'status' => 'success',
                        'message' =>
                            'Mystery Box tersedia. '
                            . 'Silakan redeem terlebih dahulu.',
                        'data' =>
                            $this->formatMember($member),
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
                // REFRESH
                // ==================================================

                $member->refresh();

                // ==================================================
                // SIMPAN HISTORY
                // ==================================================

                StampTransaction::create([
                    'member_barcode_id' => $member->id,
                    'order_id' => $order->id,
                    'type' => 'earn',
                    'amount' => 1,
                    'note' => 'Stamp dari transaksi pembelian.',
                ]);

                // ==================================================
                // RESPONSE
                // ==================================================

                $ready =
                    $member->stamp_count >=
                    $member->stamp_target;

                return response()->json([
                    'status' => 'success',

                    'message' => $ready
                        ? 'Stamp berhasil ditambahkan. Mystery Box tersedia!'
                        : 'Stamp berhasil ditambahkan.',

                    'data' => $this->formatMember($member),

                ], 200);
            });

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan stamp.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * ==========================================================
     * REDEEM MYSTERY BOX
     * ==========================================================
     *
     * Contoh:
     *
     * 5/5
     *   ↓
     * redeem
     *   ↓
     * 0/5
     */
    public function redeem(Request $request)
    {
        try {

            return DB::transaction(function () use ($request) {

                // ==================================================
                // USER LOGIN
                // ==================================================

                $user = $request->user();

                // ==================================================
                // LOCK MEMBER
                // ==================================================

                $member = MemberBarcode::where(
                    'user_id',
                    $user->id
                )
                    ->lockForUpdate()
                    ->first();

                if (!$member) {

                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Data member tidak ditemukan.',
                    ], 404);
                }

                // ==================================================
                // VALIDASI MEMBER
                // ==================================================

                if (!$member->isValid()) {
                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            'Member tidak aktif atau tidak berlaku.',
                    ], 422);
                }

                // ==================================================
                // CEK MYSTERY BOX
                // ==================================================

                if (
                    $member->stamp_count <
                    $member->stamp_target
                ) {

                    $remaining =
                        $member->stamp_target -
                        $member->stamp_count;

                    return response()->json([
                        'status' => 'error',
                        'message' =>
                            "Stamp belum cukup. "
                            . "Masih membutuhkan {$remaining} stamp.",
                        'data' =>
                            $this->formatMember($member),

                    ], 422);
                }

                // ==================================================
                // JUMLAH STAMP YANG DIREDEEM
                // ==================================================

                $redeemAmount = $member->stamp_target;

                // ==================================================
                // CATAT REDEEM
                // ==================================================

                StampTransaction::create([
                    'member_barcode_id' => $member->id,
                    /*
                     * Redeem Mystery Box tidak berasal
                     * dari order.
                     */
                    'order_id' => null,
                    'type' => 'redeem',
                    'amount' => $redeemAmount,
                    'note' =>'Redeem Mystery Box.',
                ]);

                // ==================================================
                // RESET STAMP
                // ==================================================

                $member->update([
                    'stamp_count' => 0,
                ]);

                // ==================================================
                // REFRESH
                // ==================================================

                $member->refresh();

                // ==================================================
                // RESPONSE
                // ==================================================

                return response()->json([
                    'status' => 'success',

                    'message' =>
                        'Mystery Box berhasil diredeem.',

                    'data' => [
                        'member' =>
                            $this->formatMember($member),

                        'redeemed_stamp' =>
                            $redeemAmount,

                        'mystery_box' => [
                            'redeemed' => true,
                            'remaining_stamp' =>
                                $member->stamp_count,
                        ],
                    ],

                ], 200);
            });

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' =>
                    'Gagal melakukan redeem Mystery Box.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * ==========================================================
     * FORMAT MEMBER
     * ==========================================================
     */
    private function formatMember(MemberBarcode $member)
    {
        return [
            'id' => $member->id,
            'user_id' => $member->user_id,
            'code' => $member->code,
            'stamp_count' => $member->stamp_count,
            'stamp_target' => $member->stamp_target,
            'is_active' => $member->is_active,
            'valid_from' => $member->valid_from,
            'valid_until' => $member->valid_until,
            'mystery_box_ready' =>
                $member->stamp_count >=
                $member->stamp_target,
        ];
    }
}
