<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">

    {{-- Vite (Tailwind v4 + Alpine dari app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Style Global --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <!-- Spinner -->
    <div id="initial-loader" class="fixed inset-0 z-[9999] flex items-center justify-center bg-white">
        <style>
            @keyframes loading-wave-animation {

                0%,
                100% {
                    height: 10px;
                }

                50% {
                    height: 50px;
                }
            }
        </style>
        <div class="flex justify-center items-end w-[120px] h-[60px] gap-[6px]">
            <div class="w-5 h-2.5 bg-blue-500 rounded-[5px]" style="animation: loading-wave-animation 1s ease-in-out 0s infinite;"></div>
            <div class="w-5 h-2.5 bg-blue-500 rounded-[5px]" style="animation: loading-wave-animation 1s ease-in-out 0.1s infinite;"></div>
            <div class="w-5 h-2.5 bg-blue-500 rounded-[5px]" style="animation: loading-wave-animation 1s ease-in-out 0.2s infinite;"></div>
            <div class="w-5 h-2.5 bg-blue-500 rounded-[5px]" style="animation: loading-wave-animation 1s ease-in-out 0.3s infinite;"></div>
        </div>
    </div>
    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('initial-loader');
            if (loader) {
                loader.style.opacity = '0';
                loader.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    loader.remove();

                    // 🔥 Tampilkan toast setelah loader benar-benar hilang
                    const alerts = window.pageAlerts || {};
                    if (alerts.success) showToast('success', alerts.success);
                    if (alerts.error) showToast('error', alerts.error);
                    if (alerts.info) showToast('info', alerts.info);
                }, 300);
            } else {
                // Jika tidak ada loader (misal cache atau SPA), tampilkan langsung
                const alerts = window.pageAlerts || {};
                if (alerts.success) showToast('success', alerts.success);
                if (alerts.error) showToast('error', alerts.error);
                if (alerts.info) showToast('info', alerts.info);
            }
        });
    </script>

    {{-- Mobile overlay --}}
    <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

    <div class="min-h-screen lg:flex">
        {{-- Sidebar --}}
        <div class="lg:flex-shrink-0 lg:sticky lg:top-0 lg:self-start lg:h-screen">
            @include('components.admin-sidebar')
        </div>

        {{-- Kolom utama --}}
        <div class="flex-1 flex flex-col lg:min-w-0">
            {{-- Top bar --}}
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-slate-200 h-16">
                <div class="flex items-center gap-3 px-4 py-3">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 lg:hidden"
                        @click="sidebarOpen = true" aria-label="Buka navigasi">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    <div class="flex-1 flex items-center gap-3">
                        <h1 class="text-lg md:text-xl font-semibold text-slate-900 text-balance">@yield('title', 'Admin Panel')</h1>
                        <div class="ml-auto flex items-center gap-3">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-2 rounded-md hover:bg-slate-100 text-slate-600" aria-label="Notifikasi">
                                    <i class="fa-regular fa-bell text-lg"></i>
                                    @if ($penghuniCount > 0)
                                        <span class="absolute -top-1 -right-1 h-2.5 w-2.5 rounded-full bg-blue-600"></span>
                                    @endif
                                </button>
                                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-slate-200/80 py-3 z-30">
                                    <div class="px-5 py-2 text-base font-semibold text-slate-800 tracking-tight">Notifikasi</div>
                                    @if ($penghuni ?? 0)
                                        <div class="px-5 py-2.5 text-sm text-slate-700">
                                            <span class="font-bold text-blue-600">{{ $penghuniCount }}</span> penghuni menunggak
                                        </div>
                                        <a href="{{ url('laporan/#penghuniMenunggak') }}" class="flex items-center justify-between px-5 py-2.5 text-sm text-blue-600 rounded-lg mx-2 transition">
                                            <span class="font-medium">Ayo lihat <i class="fa-solid fa-arrow-right text-xs ml-2"></i></span>
                                        </a>
                                    @else
                                        <div class="px-5 py-2.5 text-sm text-slate-500">Tidak ada notifikasi</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Dropdown menu pengguna --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                    aria-label="Menu pengguna">
                                    @if (auth()->check() && auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="h-9 w-9 rounded-full object-cover ring-1 ring-blue-200">
                                    @else
                                        <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center ring-1 ring-blue-200">
                                            <i class="fa-solid fa-user text-blue-600"></i>
                                        </div>
                                    @endif
                                    <i class="fa-solid fa-chevron-down text-xs text-slate-500"></i>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-2" @click.outside="open = false" x-cloak
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200/80 py-2 z-30">
                                    <div class="px-4 py-2">
                                        <p class="text-sm font-semibold text-slate-800 tracking-tight">
                                            {{ auth()->user()->name ?? 'Admin Kos' }}
                                        </p>
                                        <p class="text-xs text-slate-500 capitalize">
                                            {{ auth()->user()->role ?? 'admin' }}
                                        </p>
                                    </div>
                                    <div class="border-t border-slate-200 my-2"></div>
                                    <a href="{{ route('profil-admin.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-lg mx-2 transition">
                                        <i class="fa-solid fa-user text-slate-500"></i>
                                        <span>Profil</span>
                                    </a>
                                    <a href="{{ route('pengaturan-admin.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-lg mx-2 transition">
                                        <i class="fa-solid fa-gear text-slate-500"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <div class="border-t border-slate-200 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="mx-2">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 md:p-6">
                @yield('admin-main')
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="px-4 py-4 text-sm text-slate-500">
                    ©2025 RumahKedua. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

    {{-- Alert --}}
    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-slide-in {
            animation: slideInRight 0.3s ease-out forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }

        .toast-fade-out {
            animation: fadeOut 0.3s forwards;
        }
    </style>

    <div id="toast-container" class="fixed top-4 right-4 z-[9999] space-y-3 pointer-events-none"></div>

    <script>
        // Fungsi reusable untuk menampilkan toast
        window.showToast = function(type, message) {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const types = {
                success: {
                    bgColor: 'bg-white',
                    waveColor: '#04e4003a',
                    iconBg: '#04e40048',
                    iconColor: '#269b24',
                    icon: 'fa-check',
                    textColor: '#269b24'
                },
                error: {
                    bgColor: 'bg-white',
                    waveColor: '#ff4d4d3a',
                    iconBg: '#ff4d4d48',
                    iconColor: '#d32f2f',
                    icon: 'fa-circle-xmark',
                    textColor: '#d32f2f'
                },
                info: {
                    bgColor: 'bg-white',
                    waveColor: '#2196f33a',
                    iconBg: '#2196f348',
                    iconColor: '#1976d2',
                    icon: 'fa-circle-info',
                    textColor: '#1976d2'
                }
            };

            const config = types[type] || types.info;

            // Buat elemen toast
            const toastEl = document.createElement('div');
            toastEl.className =
                `${config.bgColor} rounded-xl shadow-[0_8px_24px_rgba(149,157,165,0.2)] w-[330px] h-[80px] p-2.5 flex items-center justify-between gap-3 overflow-hidden pointer-events-auto relative`;
            toastEl.innerHTML = `
                <svg class="absolute -left-8 top-8 w-20 rotate-90" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z"
                    fill="${config.waveColor}"></path>
                </svg>

                <div class="flex-shrink-0 w-9 h-9 rounded-full flex items-center justify-center ml-2" style="background-color: ${config.iconBg}">
                    <i class="fas ${config.icon}" style="color: ${config.iconColor}; font-size: 0.875rem"></i>
                </div>

                <div class="flex flex-col items-start flex-grow">
                    <p class="font-bold text-base m-0" style="color: ${config.textColor}">${message}</p>
                </div>

                <button class="flex-shrink-0 w-5 h-5 text-gray-500 hover:text-gray-700 flex items-center justify-center">
                    <i class="fas fa-xmark text-sm"></i>
                </button>
                `;

            // Tambahkan animasi masuk
            toastEl.classList.add('toast-slide-in');

            // Tambahkan ke container
            container.appendChild(toastEl);

            // Ambil tombol tutup
            const closeBtn = toastEl.querySelector('button');
            let timeout = setTimeout(() => {
                toastEl.classList.replace('toast-slide-in', 'toast-fade-out');
                setTimeout(() => {
                    if (toastEl.parentNode) toastEl.parentNode.removeChild(toastEl);
                }, 300);
            }, 4000);

            closeBtn.addEventListener('click', () => {
                clearTimeout(timeout);
                toastEl.classList.replace('toast-slide-in', 'toast-fade-out');
                setTimeout(() => {
                    if (toastEl.parentNode) toastEl.parentNode.removeChild(toastEl);
                }, 300);
            });
        };
    </script>

    <script>
        window.pageAlerts = {
            success: "{{ session('success') }}",
            error: "{{ session('error') }}",
            info: "{{ session('info') }}"
        };
    </script>

    @stack('scripts')
</body>

</html>
