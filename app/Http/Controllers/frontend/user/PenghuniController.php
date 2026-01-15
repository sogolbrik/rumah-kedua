<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pengumuman;
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
            ->value('tanggal_pembayaran');

        $transaksiTerakhir = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_jatuhtempo', 'desc')
            ->where('status_pembayaran', 'paid')
            ->first();

        $menunggak = false;
        if ($transaksiTerakhir) {
            $hariSampaiJatuhTempo = now()->diffInDays(Carbon::parse($transaksiTerakhir->tanggal_jatuhtempo), false);

            if ($hariSampaiJatuhTempo < 7) {
                $menunggak = true;
            }
        }

        if ($user->role === 'penghuni' && !$user->kamar) {
            $transaksiPaid = Transaksi::where('id_user', $user->id)
                ->where('status_pembayaran', 'paid')
                ->first();

            if ($transaksiPaid) {
                $user->update([
                    'id_kamar' => $transaksiPaid->id_kamar,
                    'tanggal_masuk' => $transaksiPaid->masuk_kamar,
                ]);
                Kamar::where('id', $transaksiPaid->id_kamar)->update(['status' => 'Terisi']);
            } else {
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

    public function pengumuman(Request $request)
    {
        $query = Pengumuman::query();

        // Filter berdasarkan kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian berdasarkan judul atau isi
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul', 'like', "%{$searchTerm}%")
                    ->orWhere('isi', 'like', "%{$searchTerm}%");
            });
        }

        // Sortir
        $sortBy = $request->get('sort', 'terbaru');
        switch ($sortBy) {
            case 'terlama':
                $query->oldest();
                break;
            case 'populer':
            default:
                $query->latest();
                break;
        }

        $pengumuman = $query->paginate(6)->appends($request->only(['search', 'kategori', 'sort']));

        return view('frontend.user.pengumuman-penghuni', compact('pengumuman'));
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
