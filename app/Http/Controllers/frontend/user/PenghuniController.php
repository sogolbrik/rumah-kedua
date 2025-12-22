<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PenghuniController extends Controller
{
    public function index()
    {
        $user = User::with('kamar', 'transaksi')->find(Auth::id());

        $transaksis = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->latest()
            ->paginate(10);

        $totalTransaksi = $transaksis->total();

        $totalBayar = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'paid')
            ->sum('total_bayar');

        $terakhirBayar = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'paid')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->value('tanggal_pembayaran'); // Carbon instance atau null

        // Ambil transaksi terakhir (tanggal_jatuhtempo terbesar) milik user
        $transaksiTerakhir = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_jatuhtempo', 'desc') // Urutkan dari terbaru
            ->where('status_pembayaran', 'paid') // Hanya transaksi yang sudah dibayar
            ->first(); // Ambil satu record pertama (yg terakhir)

        // Cek apakah transaksi terakhir ada dan tanggal_jatuhtempo-nya kurang dari hari ini
        $menunggak = false; // Default ke false
        if ($transaksiTerakhir) {
            // Hitung selisih hari antara hari ini dan tanggal jatuh tempo
            $hariSampaiJatuhTempo = now()->diffInDays(Carbon::parse($transaksiTerakhir->tanggal_jatuhtempo), false);

            // Jika tanggal jatuh tempo sudah lewat → $hariSampaiJatuhTempo negatif
            // Jika masih di masa depan → positif

            // Kita ingin tampilkan alert jika:
            // - Jatuh tempo sudah lewat (hariSampaiJatuhTempo < 0), ATAU
            // - Jatuh tempo dalam 7 hari ke depan (0 ≤ hariSampaiJatuhTempo < 7)
            if ($hariSampaiJatuhTempo < 7) {
                $menunggak = true;
            }
        }

        // Jika role = penghuni tapi belum punya kamar → coba verifikasi
        if ($user->role === 'penghuni' && !$user->kamar) {
            // Cek apakah ada transaksi paid yang belum di-update
            $transaksiPaid = Transaksi::where('id_user', $user->id)
                ->where('status_pembayaran', 'paid')
                ->first();

            if ($transaksiPaid) {
                // Update manual (fallback)
                $user->update([
                    'id_kamar' => $transaksiPaid->id_kamar,
                    'tanggal_masuk' => $transaksiPaid->masuk_kamar,
                ]);
                Kamar::where('id', $transaksiPaid->id_kamar)->update(['status' => 'Terisi']);
            } else {
                // Belum benar-benar jadi penghuni
                return redirect()->route('landing-page')
                    ->with('error', 'Akun Anda belum aktif. Silakan selesaikan pembayaran.');
            }
        }

        return view('frontend.user.penghuni', compact(
            'user',
            'transaksis',
            'totalTransaksi',
            'totalBayar',
            'terakhirBayar',
            'menunggak'
        ));
    }

    public function profil()
    {
        return view('frontend.user.profil-penghuni');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = User::findOrFail(Auth::id());
        $user->update($validation);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $user = User::findOrFail(Auth::id());
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        // Validasi avatar
        $validation = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());

        // Hapus avatar lama jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $gambarAvatar = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
            $avatarPath = $request->file('avatar')->storePubliclyAs('avatar', $gambarAvatar, 'public');
            $validation['avatar'] = $avatarPath;
        }

        $user->update($validation);

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }
}
