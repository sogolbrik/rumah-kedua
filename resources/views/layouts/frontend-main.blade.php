<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - @yield('title', 'Temukan Kenyamanan Seperti di Rumah Sendiri')</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">

    {{-- Vite (Tailwind v4 + Alpine dari app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #3b82f6;
            --color-primary-dark: #1e40af;
            --color-neutral-light: #f9fafb;
            --color-neutral-dark: #1f2937;
            --color-accent: #0891b2;
        }

        body {
            scroll-behavior: smooth;
        }

        .transition-bg {
            transition: background-color 0.3s ease;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    <!-- Loader Spinner -->
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

    @include('components.navbar-frontend')

    @yield('frontend-main')

    <!-- 9. FOOTER -->
    <footer class="bg-gray-900 text-gray-300 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- About -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-white">RumahKedua</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        {{ $pengaturan->deskripsi_kos ?? 'Temukan kenyamanan seperti di rumah sendiri dengan layanan terbaik dan fasilitas lengkap.' }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Link Cepat</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="{{ url('/#fasilitas') }}" class="hover:text-blue-400 transition-colors">Fasilitas</a></li>
                        <li><a href="{{ url('/#kamar') }}" class="hover:text-blue-400 transition-colors">Pilihan Kamar</a></li>
                        <li><a href="{{ url('/#lokasi') }}" class="hover:text-blue-400 transition-colors">Lokasi</a></li>
                        <li><a href="{{ url('/#faq') }}" class="hover:text-blue-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex gap-2"><i class="fas fa-phone w-4"></i> +{{ $pengaturan->no_telepon ?? '6287870327957' }}</li>
                        <li class="flex gap-2"><i class="fas fa-envelope w-4"></i> {{ $pengaturan->email_kos ?? 'rumahkedua@gmail.com' }}</li>
                        <li class="flex gap-2"><i class="fas fa-map-marker-alt w-4"></i> {{ $pengaturan->alamat_kos ?? 'Mojokerto Selatan' }}</li>
                    </ul>
                </div>

                <!-- Sosial Media -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-whatsapp text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 RumahKedua. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
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
</body>

</html>
