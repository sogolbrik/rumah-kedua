<!DOCTYPE html>
<html lang="id" x-data="{ dark: false }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Halaman Tidak Ditemukan</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>

    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-100 text-blue-600 mb-6">
            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
        </div>

        <h1 class="text-6xl font-extrabold text-slate-900 mb-3">404</h1>
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Halaman Tidak Ditemukan</h2>
        <p class="text-slate-600 mb-8">
            Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan.
        </p>

        <div class="space-y-3">
            <a href="{{ url('/') }}" class="inline-block w-full px-5 py-3 bg-white border border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-colors">
                Kembali ke Beranda
            </a>
        </div>

        <div class="mt-10 text-sm text-slate-500">
            <p>© {{ date('Y') }} RumahKedua. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
