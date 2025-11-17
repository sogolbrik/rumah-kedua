<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - RumahKedua</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slideInUp 0.6s ease-out forwards;
        }

        .input-focus {
            @apply transition-all duration-300 border-b-2 border-transparent focus:border-b-blue-600 outline-none;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md opacity-0" style="animation: slideInUp 0.6s ease-out forwards">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-block bg-blue-600 text-white p-3 rounded-full mb-4">
                    <i class="fas fa-home text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">RumahKedua</h1>
                <p class="text-gray-600 text-sm mt-1">Tempat tinggal nyaman Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('authentication') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6" style="animation: slideInUp 0.6s ease-out 0.1s both">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="input-focus w-full px-4 py-3 bg-gray-50 border-b-2 border-gray-300 rounded-lg focus:bg-white @error('email') border-b-red-600 @enderror" placeholder="nama@example.com"
                        required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-2" style="animation: slideInUp 0.6s ease-out 0.2s both">
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password"
                        class="input-focus w-full px-4 py-3 bg-gray-50 border-b-2 border-gray-300 rounded-lg focus:bg-white @error('password') border-b-red-600 @enderror" placeholder="••••••••"
                        required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-2"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6" style="animation: slideInUp 0.6s ease-out 0.3s both">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition duration-300 mb-4"
                    style="animation: slideInUp 0.6s ease-out 0.4s both">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>
            </form>

            <!-- Divider -->
            <div class="relative mb-6" style="animation: slideInUp 0.6s ease-out 0.5s both">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Atau</span>
                </div>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center" style="animation: slideInUp 0.6s ease-out 0.6s both">
                <p class="text-gray-600 text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6" style="animation: slideInUp 0.6s ease-out 0.7s both">
                <a href="/" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition text-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke beranda
                </a>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-white bg-opacity-80 rounded-xl p-4 text-center text-gray-600 text-sm" style="animation: slideInUp 0.6s ease-out 0.8s both">
            <i class="fas fa-lock text-blue-600 mr-2"></i>Data Anda aman dan terenkripsi dengan baik.
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>

    {{-- Sweetalert --}}
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    {{-- Success --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                position: "top-end",
                toast: true,
                timer: 3000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif

    {{-- Error --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                timer: 3000,
                position: "top-end",
                toast: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif
</body>

</html>
