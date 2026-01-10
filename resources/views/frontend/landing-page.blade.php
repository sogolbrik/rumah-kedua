@extends('layouts.frontend-main')

@section('title', 'RumahKedua - Hunian Modern & Eksklusif')
@section('frontend-main')

    {{-- 1. HERO SECTION: Premium Mesh Gradient & Noise --}}
    <header class="relative min-h-[90vh] flex items-center pt-25 overflow-hidden bg-slate-50">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-cyan-200/40 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-blue-200/30 rounded-full blur-[120px]"></div>
            <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <div class="lg:col-span-7 space-y-8 animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-100/50 border border-cyan-200 text-cyan-700 text-sm font-medium">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                        </span>
                        Hunian Modern Generasi Baru
                    </div>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 leading-[1.1] tracking-tight">
                        Definisi Baru <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Kenyamanan</span> Menginap.
                    </h1>
                    <p class="text-xl text-slate-600 leading-relaxed max-w-2xl">
                        Lebih dari sekadar tempat tinggal. RumahKedua menggabungkan estetika modern, teknologi pintar, dan komunitas yang hangat dalam satu ekosistem hunian.
                    </p>
                    <div class="flex flex-wrap gap-5">
                        <a href="{{ route('booking') }}"
                            class="group relative px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold transition-all hover:shadow-[0_20px_50px_rgba(8,_112,_184,_0.3)] hover:-translate-y-1 overflow-hidden">
                            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 to-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="relative z-10 flex items-center gap-2">
                                Pesan Kamar Sekarang <i class="fas fa-arrow-right text-sm"></i>
                            </span>
                        </a>
                        <a href="{{ route('galeri-kamar') }}" class="px-8 py-4 bg-white text-slate-900 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition-all">
                            Eksplor Galeri
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-5 relative">
                    <div class="relative z-10 rounded-[2.5rem] overflow-hidden shadow-2xl transform lg:rotate-3 hover:rotate-0 transition-transform duration-700 border-8 border-white">
                        <img src="{{ asset('assets/image/landing-page/hero.svg') }}" alt="Premium Interior" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-10 -left-10 z-20 bg-white/80 backdrop-blur-xl p-6 rounded-3xl shadow-xl border border-white/50 animate-bounce-slow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                                <i class="fas fa-check-double text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-medium">Status Hunian</p>
                                <p class="text-lg font-bold text-slate-900">98% Terisi Penuh</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- 2. WHY CHOOSE US: Dark Neutral / Tech Focus --}}
    <section class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <h2 class="text-white text-4xl md:text-5xl font-bold mb-6 italic tracking-tight">Kenapa Harus Kami?</h2>
                    <p class="text-slate-400 text-lg">Kami tidak hanya menyewakan kamar, kami membangun standar hidup baru dengan fasilitas yang mendukung produktivitas dan istirahat Anda.</p>
                </div>
                <div class="text-cyan-500 font-mono tracking-widest text-sm uppercase">/ standard-of-excellence</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([['icon' => 'fa-shield-halved', 'title' => 'Advanced Security', 'desc' => 'Enkripsi akses digital & pengawasan AI-CCTV 24/7.'], ['icon' => 'fa-bolt', 'title' => 'Hyper-Fast WiFi', 'desc' => 'Dedicated 100 Mbps fiber optic di setiap sudut lantai.'], ['icon' => 'fa-leaf', 'title' => 'Ecotherapy Design', 'desc' => 'Sirkulasi udara alami dengan konsep green open space.'], ['icon' => 'fa-location-dot', 'title' => 'Elite Access', 'desc' => '3 menit menuju transportasi publik & pusat bisnis utama.']] as $feature)
                    <div class="group p-8 rounded-[2rem] bg-slate-800/50 border border-slate-700 hover:border-cyan-500/50 transition-all duration-500">
                        <div class="w-14 h-14 bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl flex items-center justify-center text-cyan-400 mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas {{ $feature['icon'] }} text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-slate-400 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 3. FASILITAS: Light Textured & Bento Grid Feel --}}
    <section id="fasilitas" class="py-24 bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-20">
                <span class="text-blue-600 font-bold tracking-tighter uppercase text-sm">Full Experience</span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-2">Fasilitas Tanpa Kompromi</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach ([['icon' => 'fa-shower', 'label' => 'Smart Shower', 'color' => 'bg-blue-50 text-blue-600'], ['icon' => 'fa-wifi', 'label' => 'Mesh Network', 'color' => 'bg-cyan-50 text-cyan-600'], ['icon' => 'fa-kitchen-set', 'label' => 'Chef Kitchen', 'color' => 'bg-orange-50 text-orange-600'], ['icon' => 'fa-parking', 'label' => 'Secure Deck', 'color' => 'bg-slate-50 text-slate-600'], ['icon' => 'fa-video', 'label' => 'Night Vision', 'color' => 'bg-red-50 text-red-600'], ['icon' => 'fa-wind', 'label' => 'Ducting AC', 'color' => 'bg-emerald-50 text-emerald-600']] as $f)
                    <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all text-center group">
                        <div class="w-16 h-16 {{ $f['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:rotate-12 transition-transform">
                            <i class="fas {{ $f['icon'] }} text-2xl"></i>
                        </div>
                        <p class="font-bold text-slate-800 tracking-tight">{{ $f['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 4. KAMAR SECTION: Neutral Background with Spotlight --}}
    <section id="kamar" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-16">
                <div class="text-left">
                    <h2 class="text-4xl font-bold text-slate-900 tracking-tight">Katalog Hunian</h2>
                    <p class="text-slate-500 mt-2 italic">Setiap kamar didesain dengan presisi ergonomis.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- Standard Room --}}
                @if ($standard)
                    <div class="group bg-white rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-200/60">
                        <div class="relative h-64 rounded-[2rem] overflow-hidden">
                            <img src="{{ Storage::url($standard->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-xs font-bold shadow-sm italic">Efficient Living</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $standard->tipe }}</h3>
                            <p class="text-slate-500 text-sm mb-6 leading-relaxed">{{ $standard->deskripsi }}</p>
                            <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-widest">Mulai Dari</p>
                                    <p class="text-xl font-extrabold text-blue-600">Rp {{ number_format($standard->harga, 0, ',', '.') }}<span class="text-sm font-normal text-slate-400">/bln</span></p>
                                </div>
                                <a href="{{ route('booking-detail', $standard->id) }}"
                                    class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Medium (The Spotlight Card) --}}
                @if ($medium)
                    <div
                        class="relative group bg-slate-900 rounded-[2.5rem] p-4 shadow-[0_30px_60px_-15px_rgba(8,145,178,0.3)] transform lg:-translate-y-6 transition-all duration-500 border border-cyan-500/30">
                        <div
                            class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-6 py-2 rounded-full text-xs font-black tracking-widest shadow-lg z-20">
                            BEST SELLER
                        </div>
                        <div class="relative h-64 rounded-[2rem] overflow-hidden">
                            <img src="{{ Storage::url($medium->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $medium->tipe }}</h3>
                            <p class="text-slate-400 text-sm mb-6 leading-relaxed">{{ $medium->deskripsi }}</p>
                            <div class="flex items-center justify-between pt-6 border-t border-slate-700">
                                <div>
                                    <p class="text-xs text-slate-500 uppercase font-bold tracking-widest">Mulai Dari</p>
                                    <p class="text-xl font-extrabold text-cyan-400">Rp {{ number_format($medium->harga, 0, ',', '.') }}<span class="text-sm font-normal text-slate-500">/bln</span></p>
                                </div>
                                <a href="{{ route('booking-detail', $medium->id) }}" class="px-6 py-3 bg-cyan-500 text-slate-900 rounded-xl font-bold hover:bg-white transition-all">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Exclusive Room --}}
                @if ($exclusive)
                    <div class="group bg-white rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-200/60">
                        <div class="relative h-64 rounded-[2rem] overflow-hidden">
                            <img src="{{ Storage::url($exclusive->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 right-4 bg-slate-900/90 backdrop-blur text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-sm italic">Presidential Suite</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $exclusive->tipe }}</h3>
                            <p class="text-slate-500 text-sm mb-6 leading-relaxed">{{ $exclusive->deskripsi }}</p>
                            <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-bold tracking-widest">Mulai Dari</p>
                                    <p class="text-xl font-extrabold text-blue-600">Rp {{ number_format($exclusive->harga, 0, ',', '.') }}<span class="text-sm font-normal text-slate-400">/bln</span>
                                    </p>
                                </div>
                                <a href="{{ route('booking-detail', $exclusive->id) }}"
                                    class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white hover:bg-blue-600 transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- 5. TESTIMONI: Soft Gradient & Human Centric --}}
    <section class="py-24 bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-600 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-20 opacity-10">
            <i class="fas fa-quote-right text-[15rem] text-white"></i>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-4xl font-bold text-white mb-16 tracking-tight">Apa Kata Penghuni?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                @foreach ([['name' => 'Siti Nur Azizah', 'role' => 'Tech Lead at Startup', 'text' => 'Fasilitas internetnya luar biasa stabil untuk WFH. Estetika kamarnya sangat menenangkan setelah kerja seharian.'], ['name' => 'Budi Santoso', 'role' => 'Business Student', 'text' => 'Lokasinya juara. Dekat kemana-mana, tapi suasananya tetap tenang untuk belajar. Sangat worth it!'], ['name' => 'Rina Wijaya', 'role' => 'Content Creator', 'text' => 'Pencahayaan alami di kamar Exclusive sangat bagus untuk shooting konten. Tim manajemennya juga sangat responsif.']] as $testi)
                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-8 rounded-[2rem] hover:bg-white/20 transition-all">
                        <div class="flex gap-1 mb-6 text-cyan-300">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-sm"></i>
                            @endfor
                        </div>
                        <p class="text-white text-lg italic mb-8 leading-relaxed">"{{ $testi['text'] }}"</p>
                        <div class="flex items-center gap-4 border-t border-white/10 pt-6">
                            <div class="w-12 h-12 rounded-full bg-slate-200 border-2 border-white/30 overflow-hidden">
                                <img src="{{ asset('assets/image/avatar/default-avatar.png') }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-white font-bold">{{ $testi['name'] }}</h4>
                                <p class="text-cyan-200 text-xs uppercase tracking-widest">{{ $testi['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 6. FAQ: Structured & Readable --}}
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-slate-900 tracking-tight">Punya Pertanyaan?</h2>
                <p class="text-slate-500 mt-4 italic">Segala hal yang perlu Anda ketahui sebelum memesan.</p>
            </div>

            <div x-data="{ activeIndex: 0 }" class="space-y-4">
                @foreach ([
            'Apakah tersedia tempat parkir?' => 'Ya, kami menyediakan area parkir tertutup dengan akses kartu keamanan khusus untuk motor dan mobil.',
            'Minimum kontrak sewa berapa lama?' => 'Sistem kami fleksibel. Mulai dari bulanan hingga tahunan dengan diskon khusus untuk pembayaran di muka.',
            'Bolehkah membawa tamu?' => 'Tamu diperbolehkan di area lobby dan komunal hingga jam 21:00 demi kenyamanan bersama.',
            'Apakah harga sudah termasuk listrik?' => 'Harga dasar kami sudah termasuk air dan WiFi. Listrik menggunakan sistem token masing-masing kamar agar lebih transparan.',
        ] as $question => $answer)
                    <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all" :class="activeIndex === {{ $loop->index }} ? 'shadow-lg border-blue-200' : ''">
                        <button @click="activeIndex = activeIndex === {{ $loop->index }} ? null : {{ $loop->index }}"
                            class="w-full flex items-center justify-between p-6 text-left hover:bg-slate-50 transition-colors">
                            <span class="text-lg font-bold text-slate-800 tracking-tight">{{ $question }}</span>
                            <i class="fas fa-chevron-right text-blue-500 transition-transform" :class="activeIndex === {{ $loop->index }} ? 'rotate-90' : ''"></i>
                        </button>
                        <div x-show="activeIndex === {{ $loop->index }}" x-collapse class="px-6 pb-6 text-slate-600 leading-relaxed">
                            {{ $answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 7. LOKASI: Immersive & Serious --}}
    <section id="lokasi" class="py-24 bg-slate-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Konektivitas Tanpa Batas</h2>
                    <p class="text-slate-400 text-lg leading-relaxed">
                        RumahKedua berlokasi strategis di pusat denyut nadi kota. Akses instan ke perkantoran, pusat edukasi, dan hiburan.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                            <i class="fas fa-train text-cyan-400 text-xl mt-1"></i>
                            <div>
                                <h4 class="text-white font-bold">Stasiun Utama</h4>
                                <p class="text-slate-500 text-sm">Hanya 5 menit berkendara</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                            <i class="fas fa-graduation-cap text-emerald-400 text-xl mt-1"></i>
                            <div>
                                <h4 class="text-white font-bold">Kampus A</h4>
                                <p class="text-slate-500 text-sm">10 menit jalan kaki</p>
                            </div>
                        </div>
                    </div>
                    <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-900 rounded-2xl font-bold hover:-translate-y-1 transition-all">
                        Petunjuk Arah <i class="fas fa-map-marked-alt"></i>
                    </a>
                </div>
                <div class="relative h-[500px] rounded-[3rem] overflow-hidden border-8 border-slate-800 shadow-2xl group">
                    <iframe width="100%" height="100%" class="grayscale invert brightness-90 hover:grayscale-0 transition-all duration-700" src="{{ $mapUrl }}" style="border:0;"
                        loading="lazy"></iframe>
                    <div class="absolute inset-0 pointer-events-none border-[20px] border-slate-900/10"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- 8. CALL TO ACTION: The Visual Anchor --}}
    <section class="py-24 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="relative bg-gradient-to-r from-slate-900 to-blue-900 rounded-[3.5rem] p-12 md:p-24 overflow-hidden text-center shadow-2xl">
                <div class="absolute top-0 left-0 w-64 h-64 bg-cyan-500/20 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-500/20 rounded-full blur-[100px] translate-x-1/3 translate-y-1/3"></div>

                <div class="relative z-10 max-w-3xl mx-auto space-y-8">
                    <h2 class="text-4xl md:text-6xl font-black text-white leading-tight">Mulai Babak Baru <br> Hidup Anda Disini.</h2>
                    <p class="text-blue-100/70 text-xl">Slot kamar sangat terbatas. Amankan unit Anda sekarang dan rasakan kenyamanan yang belum pernah ada sebelumnya.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                        <a href="https://wa.me/{{ str_replace([' ', '+'], '', $pengaturan->no_telepon ?? '6287870327957') }}"
                            class="px-10 py-5 bg-white text-slate-900 rounded-[2rem] font-black text-lg hover:shadow-2xl hover:shadow-white/20 hover:-translate-y-2 transition-all">
                            Hubungi via WhatsApp
                        </a>
                        <a href="mailto:{{ $pengaturan->email_kos ?? 'rumahkedua@gmail.com' }}"
                            class="px-10 py-5 bg-transparent border-2 border-white/30 text-white rounded-[2rem] font-bold text-lg hover:bg-white/10 transition-all">
                            Konsultasi via Email
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 4s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth Scroll Animation */
        .scroll-animate {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-animate.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.1
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('section').forEach(section => {
                section.classList.add('scroll-animate');
                observer.observe(section);
            });
        });
    </script>
@endsection
