<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\MemberBarcode;

class AuthController extends Controller
{
    /**
     * ============================================================
     * REGISTER MEMBER
     * ============================================================
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'birth_date' => ['required','date','before:today',],

            'password' => ['required','string','min:6','confirmed',],
        ]);

        try {
            $result = DB::transaction(function () use ($request) {

                // =====================================================
                // CREATE USER
                // =====================================================

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make(
                        $request->password
                    ),

                    // Tetap USER
                    'role' => 'user',
                ]);

                // =====================================================
                // CREATE MEMBER BARCODE
                // =====================================================

                $memberBarcode = MemberBarcode::create([
                    'user_id' => $user->id,

                    'birth_date' => $request->birth_date,

                    'code' => $this->generateMemberCode(),

                    // =================================================
                    // DEFAULT MEMBER DISCOUNT
                    // =================================================

                    'discount_type' => 'percentage',

                    // 'discount_value' => 10,
                    'discount_value' => 0,

                    // =================================================
                    // STAMP
                    // =================================================

                    'stamp_count' => 0,

                    'stamp_target' => 5,

                    // =================================================
                    // STATUS
                    // =================================================

                    'is_active' => true,

                    'valid_from' => now(),

                    'valid_until' => null,
                ]);

                // =====================================================
                // TOKEN
                // =====================================================

                $token = $user
                    ->createToken('android-member')
                    ->plainTextToken;

                return [
                    'user' => $user,
                    'member' => $memberBarcode,
                    'token' => $token,
                ];
            });

            // =========================================================
            // RESPONSE
            // =========================================================

            return response()->json([
                'status' => 'success',

                'message' => 'Registrasi member berhasil.',

                'data' => [
                    'token' => $result['token'],

                    'user' => [
                        'id' => $result['user']->id,
                        'name' => $result['user']->name,
                        'email' => $result['user']->email,
                        'role' => $result['user']->role,
                    ],

                    'member' => [
                        'id' =>
                            $result['member']->id,

                        'user_id' =>
                            $result['member']->user_id,

                        'birth_date' =>
                            $result['member']
                                ->birth_date
                                ?->format('Y-m-d'),

                        'code' =>
                            $result['member']->code,

                        'discount_type' =>
                            $result['member']
                                ->discount_type,

                        'discount_value' =>
                            $result['member']
                                ->discount_value,

                        'stamp_count' =>
                            $result['member']
                                ->stamp_count,

                        'stamp_target' =>
                            $result['member']
                                ->stamp_target,

                        'is_active' =>
                            $result['member']
                                ->is_active,

                        'valid_from' =>
                            $result['member']
                                ->valid_from,

                        'valid_until' =>
                            $result['member']
                                ->valid_until,
                    ],
                ],
            ], 201);

        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Registrasi member gagal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * ============================================================
     * GENERATE MEMBER CODE
     * ============================================================
     */
    private function generateMemberCode(): string
    {
        do {
            $code = 'MM-' . strtoupper(
                Str::random(10)
            );
        } while (
            MemberBarcode::where('code', $code)->exists()
        );

        return $code;
    }


    /**
     * ============================================================
     * LOGIN
     * ============================================================
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Ambil user sekaligus barcode member
        $user = User::with('memberBarcode')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Cek password
        if (!Hash::check(
            $request->password,
            $user->password
        )) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Generate token
        $token = $user
            ->createToken('auth-token')
            ->plainTextToken;

        return response()->json([
            'status' => 'success',

            'data' => [

                'token' => $token,

                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],

                'member' => $user->memberBarcode
                    ? [
                        'id' =>
                            $user->memberBarcode->id,

                        'user_id' =>
                            $user->memberBarcode->user_id,

                        'birth_date' =>
                            $user->memberBarcode->birth_date
                                ?->format('Y-m-d'),

                        'code' =>
                            $user->memberBarcode->code,

                        'discount_type' =>
                            $user->memberBarcode->discount_type,

                        'discount_value' =>
                            $user->memberBarcode->discount_value,

                        'stamp_count' =>
                            $user->memberBarcode->stamp_count,

                        'stamp_target' =>
                            $user->memberBarcode->stamp_target,

                        'is_active' =>
                            $user->memberBarcode->is_active,

                        'valid_from' =>
                            $user->memberBarcode->valid_from,

                        'valid_until' =>
                            $user->memberBarcode->valid_until,
                    ]
                    : null,
            ],
        ], 200);
    }


    /**
     * ============================================================
     * LOGOUT
     * ============================================================
     */
    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out',
        ], 200);
    }
}
