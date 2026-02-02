@extends('layouts.frontend-main')
@section('title', 'Verifikasi Pembayaran...')

@section('frontend-main')
    <div class="fixed inset-0 flex items-center justify-center bg-[#fffffe] z-50">
        <div class="max-w-md w-full px-8 text-center">

            {{-- <div class="relative inline-flex mb-10">
                <div class="w-20 h-20 rounded-full border-[3px] border-[#90b4ce] opacity-20"></div>
                <div class="w-20 h-20 rounded-full border-[3px] border-t-[#3da9fc] border-r-transparent border-b-transparent border-l-transparent animate-spin absolute top-0 left-0"></div>
            </div> --}}
            <div class="inline-block animate-spin rounded-full h-18 w-18 border-t-3 border-b-3 border-blue-600 mb-6"></div>

            <h2 class="text-3xl font-bold mb-4 tracking-tight" style="color: #094067;">
                Sedang Memverifikasi
            </h2>

            <p class="text-lg leading-relaxed mb-12" style="color: #5f6c7b;">
                Mohon tidak menutup atau menyegarkan halaman ini. Kami sedang memproses transaksi Anda.
            </p>

            <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-[#f2f7fb]">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color: #3da9fc;"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5" style="background-color: #3da9fc;"></span>
                </span>
                <span class="text-xs font-bold uppercase tracking-[0.2em]" style="color: #094067;">
                    Syncing Process
                </span>
            </div>
        </div>
    </div>

    <script>
        // Redirect otomatis setelah 3 detik
        setTimeout(() => {
            window.location.href = "{{ route('user.pembayaran.verifikasi-data') }}";
        }, 3000);
    </script>

    <style>
        /* Paksa body tidak bisa scroll saat halaman ini aktif */
        body {
            overflow: hidden;
        }

        .animate-spin {
            animation: spin 0.8s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
