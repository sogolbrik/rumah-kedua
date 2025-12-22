@extends('layouts.frontend-main')
@section('title', 'Verifikasi Pembayaran...')

@section('frontend-main')
    <div class="max-w-md mx-auto text-center py-20">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-600 mb-6"></div>
        <h2 class="text-xl font-bold text-gray-800 mb-2">Memverifikasi pembayaran...</h2>
        <p class="text-gray-600">Mohon tunggu. Sistem sedang mengecek status pembayaran Anda.</p>
        <p class="text-sm text-gray-500 mt-2">Ini mungkin memakan waktu 5-10 detik.</p>
    </div>

    <script>
        // Redirect ke halaman verifikasi setiap 3 detik (auto-retry)
        setTimeout(() => {
            window.location.href = "{{ route('user.pembayaran.verifikasi-data') }}";
        }, 3000);
    </script>
@endsection
