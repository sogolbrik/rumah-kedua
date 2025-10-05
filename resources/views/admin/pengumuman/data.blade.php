@extends('layouts.admin-main')

@section('title', 'Pengumuman')

@section('admin-main')
    {{-- Halaman Pengumuman (UI biru, tanpa global style) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-slate-900">Daftar Pengumuman</h2>
                <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-3 py-2 text-sm hover:bg-blue-700">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </div>
            <ul class="mt-4 space-y-3">
                <li class="p-3 rounded-lg border border-slate-100 bg-white">
                    <p class="text-sm font-medium text-slate-900">Perawatan Air (5–6 Okt)</p>
                    <p class="text-xs text-slate-600">Aliran air akan bergilir pukul 10.00–14.00</p>
                </li>
                <li class="p-3 rounded-lg border border-slate-100 bg-white">
                    <p class="text-sm font-medium text-slate-900">Pembayaran Online</p>
                    <p class="text-xs text-slate-600">Dukungan e-wallet telah tersedia.</p>
                </li>
            </ul>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <h3 class="text-base font-semibold text-slate-900">Form Pengumuman</h3>
            <form class="mt-4 space-y-3">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Judul</label>
                    <input type="text" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Konten</label>
                    <textarea rows="4" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2">
                    <button type="reset" class="px-3 py-2 rounded-lg border border-slate-200 text-sm bg-white hover:bg-slate-50">Batal</button>
                    <button type="submit" class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
