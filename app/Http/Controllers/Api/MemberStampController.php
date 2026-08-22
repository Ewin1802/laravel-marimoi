<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberBarcode;
use App\Models\MysteryBoxReward;
use App\Models\Product;
use App\Models\StampTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberStampController extends Controller
{
    // ============================================================
    // SHOW STAMP
    // ============================================================

    public function show(Request $request)
    {
        $user = $request->user();

        $barcode = MemberBarcode::with('user')
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        if (!$barcode) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data member tidak ditemukan.',
            ], 404);
        }

        if (!$barcode->isValid()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak aktif atau barcode sudah tidak berlaku.',
            ], 422);
        }

        return response()->json([
            'status' => 'success',

            'data' => [

                // =====================================================
                // MEMBER
                // =====================================================

                'id' => $barcode->id,

                'user_id' => $barcode->user_id,

                'name' => $barcode->user->name,

                'email' => $barcode->user->email,

                // =====================================================
                // BARCODE
                // =====================================================

                'code' => $barcode->code,

                'birth_date' => $barcode->birth_date,

                // =====================================================
                // DISCOUNT
                // =====================================================

                'discount_type' => $barcode->discount_type,

                'discount_value' => $barcode->discount_value,

                // =====================================================
                // STAMP
                // =====================================================

                'stamp_count' => $barcode->stamp_count,

                'stamp_target' => $barcode->stamp_target,

                // =====================================================
                // STATUS
                // =====================================================

                'is_active' => $barcode->is_active,

                // =====================================================
                // VALIDITY
                // =====================================================

                'valid_from' => $barcode->valid_from,

                'valid_until' => $barcode->valid_until,
            ],
        ], 200);
    }

    // ============================================================
    // HISTORY
    // ============================================================

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
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $history,
        ]);
    }

    // ============================================================
    // EARN
    // ============================================================

    public function earn(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'member_code' => 'required|string|max:100',
        ]);

        return DB::transaction(function () use ($request) {

            // ====================================================
            // LOCK MEMBER
            // ====================================================

            $member = MemberBarcode::where(
                'code',
                $request->member_code
            )
                ->lockForUpdate()
                ->first();

            if (!$member) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Member tidak ditemukan.',
                ], 404);
            }

            // ====================================================
            // CEK ORDER
            // ====================================================

            $order = DB::table('orders')
                ->where('id', $request->order_id)
                ->first();

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order tidak ditemukan.',
                ], 404);
            }

            // ====================================================
            // CEK DUPLICATE STAMP
            // ====================================================

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
                    'status' => 'exists',
                    'message' => 'Order ini sudah mendapatkan stamp.',
                    'data' => [
                        'stamp_count' => $member->stamp_count,
                        'stamp_target' => $member->stamp_target,
                    ],
                ]);
            }

            // ====================================================
            // TAMBAH 1 STAMP
            // ====================================================

            $member->increment('stamp_count');

            $member->refresh();

            // ====================================================
            // CATAT TRANSAKSI
            // ====================================================

            StampTransaction::create([
                'member_barcode_id' => $member->id,
                'order_id' => $order->id,
                'type' => 'earn',
                'amount' => 1,
                'note' => 'Stamp dari transaksi order #' . $order->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Stamp berhasil ditambahkan.',
                'data' => [
                    'stamp_count' => $member->stamp_count,
                    'stamp_target' => $member->stamp_target,
                    'mystery_box_ready' =>
                        $member->stamp_count >= $member->stamp_target,
                ],
            ]);
        });
    }

    // ============================================================
    // REDEEM MYSTERY BOX
    // ============================================================

    public function redeem(Request $request)
    {
        return DB::transaction(function () use ($request) {

            // ====================================================
            // USER
            // ====================================================

            $user = $request->user();

            // ====================================================
            // LOCK MEMBER
            // ====================================================

            $member = MemberBarcode::where(
                'user_id',
                $user->id
            )
                ->lockForUpdate()
                ->first();

            if (!$member) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data member tidak ditemukan.',
                ], 404);
            }

            // ====================================================
            // CEK MEMBER AKTIF
            // ====================================================

            if (!$member->isValid()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Member tidak aktif.',
                ], 422);
            }

            // ====================================================
            // CEK STAMP
            // ====================================================

            if ($member->stamp_count < $member->stamp_target) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stamp belum mencukupi.',
                    'data' => [
                        'stamp_count' => $member->stamp_count,
                        'stamp_target' => $member->stamp_target,
                    ],
                ], 422);
            }

            // ====================================================
            // CEK REWARD YANG BELUM DIKLAIM
            // ====================================================

            $existingReward = MysteryBoxReward::where(
                'member_barcode_id',
                $member->id
            )
                ->where(
                    'status',
                    'available'
                )
                ->first();

           if ($existingReward) {

                // ============================================================
                // REWARD SUDAH ADA
                // ============================================================
                // Jangan buat reward kedua.
                // Tetapi jika stamp masih mencapai target,
                // konsumsi stamp untuk Mystery Box tersebut.
                // ============================================================

                if ($member->stamp_count >= $member->stamp_target) {

                    $usedStamp = $member->stamp_target;

                    $member->decrement(
                        'stamp_count',
                        $usedStamp
                    );

                    $member->refresh();

                    // ========================================================
                    // CATAT REDEEM
                    // ========================================================

                    StampTransaction::create([
                        'member_barcode_id' => $member->id,
                        'order_id' => null,
                        'type' => 'redeem',
                        'amount' => $usedStamp,
                        'note' =>
                            'Redeem Mystery Box #' .
                            $existingReward->id .
                            ' - ' .
                            $existingReward->product_name,
                    ]);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Mystery Box berhasil diredeem.',
                    'data' => [
                        'reward_id' => $existingReward->id,

                        'product' => [
                            'id' => $existingReward->product_id,
                            'name' => $existingReward->product_name,
                            'price' => $existingReward->product_price,
                        ],

                        'stamp_count' => $member->stamp_count,

                        'stamp_target' => $member->stamp_target,

                        'mystery_box_ready' =>
                            $member->stamp_count >= $member->stamp_target,
                    ],
                ]);
            }

            // ====================================================
            // CARI PRODUK BONUS
            // ====================================================

            $product = Product::where('status', 1)
                ->where('stock', '>', 0)
                ->inRandomOrder()
                ->lockForUpdate()
                ->first();

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' =>
                        'Saat ini belum ada produk yang tersedia untuk Mystery Box.',
                ], 422);
            }

            // ====================================================
            // SIMPAN REWARD
            // ====================================================

            $reward = MysteryBoxReward::create([
                'member_barcode_id' => $member->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price ?? 0,
                'status' => 'available',
            ]);

            // ====================================================
            // KURANGI STOCK
            // ====================================================

            $product->decrement('stock', 1);

            // ====================================================
            // KURANGI STAMP
            //
            // Contoh:
            //
            // 5 -> 0
            // 6 -> 1
            // 10 -> 5
            //
            // ====================================================

            $member->decrement(
                'stamp_count',
                $member->stamp_target
            );

            $member->refresh();

            // ====================================================
            // CATAT REDEEM
            // ====================================================

            StampTransaction::create([
                'member_barcode_id' => $member->id,
                'order_id' => null,
                'type' => 'redeem',
                'amount' => $member->stamp_target,
                'note' =>
                    'Redeem Mystery Box #' .
                    $reward->id .
                    ' - ' .
                    $product->name,
            ]);

            // ====================================================
            // RESPONSE
            // ====================================================

            return response()->json([
                'status' => 'success',
                'message' => 'Mystery Box berhasil dibuka!',
                'data' => [
                    'reward_id' => $reward->id,

                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image,
                    ],

                    'stamp_count' =>
                        $member->stamp_count,

                    'stamp_target' =>
                        $member->stamp_target,

                    'mystery_box_ready' =>
                        $member->stamp_count >=
                        $member->stamp_target,
                ],
            ]);
        });
    }
}
