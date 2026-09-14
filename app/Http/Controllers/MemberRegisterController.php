<?php

namespace App\Http\Controllers;

use App\Models\MemberBarcode;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberRegisterController extends Controller
{
    /**
     * Tampilkan form pendaftaran member (publik, tanpa login).
     *
     * Dipakai oleh calon member yang TIDAK bisa pakai aplikasi
     * Flutter (karena app cuma tersedia untuk Android) — misalnya
     * pengguna iPhone — supaya tetap bisa daftar jadi member lewat
     * browser.
     */
    public function create()
    {
        $setting = Setting::first();

        return view('pages.member-register.create', compact('setting'));
    }

    /**
     * Proses pendaftaran member baru dari web.
     *
     * Logikanya sengaja disamakan dengan Api\AuthController@register
     * (bikin User + MemberBarcode sekaligus dalam satu transaction),
     * supaya member yang daftar lewat web maupun lewat app punya
     * struktur data yang konsisten.
     *
     * PENGECUALIAN YANG SENGAJA BEDA dari register mobile:
     *
     * - phone_number IKUT disimpan di sini (form web-nya memang
     *   menanyakan nomor HP), padahal register mobile TIDAK
     *   menyimpan phone_number sama sekali saat ini. Kalau kamu mau
     *   strict sama persis, tinggal hapus baris phone_number di
     *   bawah — tapi datanya jadi kebuang percuma padahal form-nya
     *   sudah nanya.
     *
     * stamp_target SENGAJA disamakan jadi 5 (bukan 10) supaya
     * perilakunya identik sama member yang daftar lewat app —
     * nanti otomatis di-normalisasi ke 10 oleh MemberStampController
     * pas member itu pertama kali buka halaman stamp/redeem.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'birth_date'   => ['required', 'date', 'before:today'],
            'password'     => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        try {

            $result = DB::transaction(function () use ($validated) {

                // =====================================================
                // CREATE USER
                // =====================================================

                $user = User::create([
                    'name'         => $validated['name'],
                    'email'        => $validated['email'],
                    'phone_number' => $validated['phone_number'] ?? null,
                    'password'     => Hash::make($validated['password']),

                    // Tetap USER — sama seperti registrasi lewat app.
                    'role' => 'user',
                ]);

                // =====================================================
                // CREATE MEMBER BARCODE
                // =====================================================

                $memberBarcode = MemberBarcode::create([
                    'user_id' => $user->id,

                    'birth_date' => $validated['birth_date'],

                    'code' => $this->generateMemberCode(),

                    // =================================================
                    // DEFAULT MEMBER DISCOUNT
                    // =================================================

                    'discount_type'  => 'percentage',
                    'discount_value' => 0,

                    // =================================================
                    // STAMP
                    // =================================================
                    //
                    // 5, BUKAN 10 — disamakan dengan register mobile.
                    // Nanti otomatis ke-normalisasi jadi 10 lewat
                    // MemberStampController pas member pertama kali
                    // buka fitur stamp/redeem, persis kayak member
                    // yang daftar lewat app.
                    //
                    // =================================================

                    'stamp_count'  => 0,
                    'stamp_target' => 5,

                    // =================================================
                    // STATUS
                    // =================================================

                    'is_active'   => true,
                    'valid_from'  => now(),
                    'valid_until' => null,
                ]);

                return [
                    'user'   => $user,
                    'member' => $memberBarcode,
                ];
            });

        } catch (\Throwable $e) {

            // Sama seperti register mobile: kalau transaction gagal
            // (misalnya race condition email/kode barcode), jangan
            // biarkan user lihat error 500 polos — balik ke form
            // dengan pesan yang jelas.

            return redirect()
                ->route('member.register')
                ->withInput()
                ->withErrors([
                    'email' => 'Registrasi gagal, silakan coba lagi. (' . $e->getMessage() . ')',
                ]);
        }

        // =========================================================
        // REDIRECT KE HALAMAN SUKSES
        // =========================================================
        //
        // Data member ditaruh di session flash (bukan query string),
        // supaya gak nyangkut di URL / history browser / bisa
        // di-refresh tanpa data ilang selama masih 1 request cycle.
        //
        // =========================================================

        return redirect()
            ->route('member.register.success')
            ->with('member', [
                'name'  => $result['user']->name,
                'email' => $result['user']->email,
                'code'  => $result['member']->code,
            ]);
    }

    /**
     * Halaman sukses setelah daftar — nampilin kode member + instruksi
     * lanjutan, supaya bisa langsung dipakai walau belum punya
     * aplikasi Flutter (khususnya buat pengguna non-Android).
     */
    public function success(Request $request)
    {
        $member = session('member');

        // Kalau halaman ini diakses langsung tanpa lewat proses
        // pendaftaran (session kosong), lempar balik ke form.
        if (!$member) {
            return redirect()->route('member.register');
        }

        $setting = Setting::first();

        return view('pages.member-register.success', [
            'member'  => $member,
            'setting' => $setting,
        ]);
    }

    /**
     * Generate kode barcode unik untuk member baru.
     *
     * Format sama persis dengan yang dipakai Api\AuthController,
     * supaya kode member konsisten mau daftar lewat web atau app.
     */
    private function generateMemberCode(): string
    {
        do {
            $code = 'MM-' . strtoupper(Str::random(10));
        } while (MemberBarcode::where('code', $code)->exists());

        return $code;
    }
}
