<?php

namespace App\Http\Controllers;

use App\Models\MemberBarcode;
use App\Models\Setting;
use Illuminate\Http\Request;

class MemberPortalController extends Controller
{
    /**
     * Halaman "Kartu Member Saya" — QR code member bisa dibuka ulang
     * kapan aja selama login, gak cuma sekali pas baru daftar kayak
     * halaman sukses registrasi.
     *
     * Khusus untuk user dengan role 'user' (member biasa). Kalau
     * yang login adalah admin, lempar ke dashboard admin — halaman
     * ini gak relevan buat mereka.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        $memberBarcode = MemberBarcode::where('user_id', $user->id)->first();

        if (!$memberBarcode) {
            // Edge case: user role 'user' tapi entah kenapa gak punya
            // MemberBarcode (seharusnya gak mungkin lewat alur
            // registrasi normal, tapi dijaga biar gak crash).
            abort(404, 'Data member tidak ditemukan.');
        }

        $setting = Setting::first();

        return view('pages.member-portal.show', [
            'user'   => $user,
            'member' => $memberBarcode,
            'setting' => $setting,
        ]);
    }
}
