@extends('layouts.frontend-main')

@section('title', 'RumahKedua - Hunian Modern & Eksklusif')
@section('frontend-main')

    {{-- 1. HERO SECTION: Premium Mesh Gradient & Noise --}}
    <header class="relative min-h-screen flex items-center py-16 md:py-20 lg:pt-32 overflow-hidden bg-[#fffffe]">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-[-5%] right-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-[#90b4ce]/20 rounded-full blur-[80px] md:blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-[-5%] left-[-10%] w-[350px] md:w-[600px] h-[350px] md:h-[600px] bg-[#3da9fc]/10 rounded-full blur-[80px] md:blur-[120px]"></div>
            <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                <div class="lg:col-span-7 space-y-6 md:space-y-8 animate-fade-in-up text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#90b4ce]/20 border border-[#90b4ce]/30 text-[#094067] text-xs md:text-sm font-medium">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#3da9fc] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#3da9fc]"></span>
                        </span>
                        Hunian Modern Generasi Baru
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-[#094067] leading-[1.1] tracking-tight">
                        Definisi Baru <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#3da9fc] to-[#90b4ce]">Kenyamanan</span> Menginap.
                    </h1>

                    <p class="text-lg md:text-xl text-[#5f6c7b] leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Lebih dari sekadar tempat tinggal. RumahKedua menggabungkan estetika modern, teknologi pintar, dan komunitas yang hangat dalam satu ekosistem hunian.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 md:gap-5">
                        <a href="{{ route('booking') }}"
                            class="w-full sm:w-auto group relative px-8 py-4 bg-[#094067] text-[#fffffe] rounded-2xl font-bold transition-all hover:shadow-[0_20px_50px_rgba(61,169,252,0.3)] hover:-translate-y-1 overflow-hidden text-center">
                            <div class="absolute inset-0 w-full h-full bg-[#3da9fc] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                Pesan Kamar Sekarang <i class="fas fa-arrow-right text-sm"></i>
                            </span>
                        </a>

                        <a href="{{ route('galeri-kamar') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-[#fffffe] text-[#094067] border border-[#90b4ce]/50 rounded-2xl font-bold hover:bg-[#90b4ce]/10 transition-all text-center">
                            Eksplor Galeri
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 relative mt-10 lg:mt-0">
                    <div
                        class="relative z-10 rounded-[2rem] md:rounded-[2.5rem] overflow-hidden shadow-2xl transform rotate-0 lg:rotate-3 hover:rotate-0 transition-transform duration-700 border-4 md:border-8 border-[#fffffe] max-w-[500px] mx-auto lg:max-w-none">
                        <img src="{{ asset('assets/image/landing-page/hero.svg') }}" alt="Premium Interior" class="w-full h-full object-cover">
                    </div>

                    <div
                        class="absolute -bottom-6 -left-4 md:-bottom-10 md:-left-10 z-20 bg-[#fffffe]/90 backdrop-blur-xl p-4 md:p-6 rounded-2xl md:rounded-3xl shadow-xl border border-[#90b4ce]/20 animate-bounce-slow">
                        <div class="flex items-center gap-3 md:gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-[#ef4565] rounded-xl md:rounded-2xl flex items-center justify-center text-[#fffffe] shadow-lg shadow-[#ef4565]/20">
                                <i class="fas fa-check-double text-lg md:text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[10px] md:text-sm text-[#5f6c7b] font-medium uppercase tracking-wider">Konsep Hunian</p>
                                <p class="text-sm md:text-lg font-bold text-[#094067]">Privasi & Kenyamanan</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    {{-- 2. WHY CHOOSE US: Dark Neutral / Tech Focus --}}
    <section class="py-24 bg-[#094067] relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#90b4ce]/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#3da9fc]/10 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/4"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <h2 class="text-[#fffffe] text-4xl md:text-5xl font-extrabold mb-6 tracking-tight">
                        Kenapa Harus Kami?
                    </h2>
                    <p class="text-[#90b4ce] text-lg leading-relaxed">
                        Kami tidak hanya menyewakan kamar, kami membangun standar hidup baru dengan fasilitas yang mendukung produktivitas dan istirahat Anda.
                    </p>
                </div>
                <div class="text-[#3da9fc] font-mono tracking-[0.2em] text-xs uppercase font-bold border-b-2 border-[#3da9fc] pb-1">
                    / standard-of-excellence
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([['icon' => 'fa-shield-halved', 'title' => 'Advanced Security', 'desc' => 'Enkripsi akses digital & pengawasan AI-CCTV 24/7.'], ['icon' => 'fa-bolt', 'title' => 'Hyper-Fast WiFi', 'desc' => 'Dedicated 100 Mbps fiber optic di setiap sudut lantai.'], ['icon' => 'fa-leaf', 'title' => 'Ecotherapy Design', 'desc' => 'Sirkulasi udara alami dengan konsep green open space.'], ['icon' => 'fa-location-dot', 'title' => 'Elite Access', 'desc' => '3 menit menuju transportasi publik & pusat bisnis utama.']] as $feature)
                    <div class="group p-8 rounded-[2.5rem] bg-[#fffffe]/5 border border-[#fffffe]/10 backdrop-blur-sm hover:bg-[#fffffe]/10 hover:border-[#3da9fc]/50 transition-all duration-500">

                        <div
                            class="w-16 h-16 bg-[#ef4565]/10 rounded-2xl flex items-center justify-center text-[#ef4565] mb-8 group-hover:bg-[#ef4565] group-hover:text-[#fffffe] transition-all duration-500 shadow-lg shadow-[#ef4565]/20">
                            <i class="fas {{ $feature['icon'] }} text-2xl"></i>
                        </div>

                        <h3 class="text-xl font-black text-[#fffffe] mb-4 tracking-tight">
                            {{ $feature['title'] }}
                        </h3>

                        <p class="text-[#90b4ce] text-sm leading-relaxed group-hover:text-[#fffffe] transition-colors">
                            {{ $feature['desc'] }}
                        </p>
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
    <section id="kamar" class="py-24 bg-[#fffffe]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-16">
                <div class="text-left">
                    <h2 class="text-4xl font-black text-[#094067] tracking-tight">Katalog Hunian</h2>
                    <p class="text-[#5f6c7b] mt-2 italic">Setiap kamar didesain dengan presisi ergonomis.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- Standard Room (Light Card) --}}
                @if ($standard)
                    <div class="group bg-[#fffffe] rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-[#90b4ce]/20">
                        <div class="relative h-64 rounded-[2rem] overflow-hidden">
                            <img src="{{ Storage::url($standard->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 left-4 bg-[#fffffe]/90 backdrop-blur px-4 py-1.5 rounded-full text-xs font-bold shadow-sm italic text-[#094067]">Efficient Living</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-[#094067] mb-2">{{ $standard->tipe }}</h3>
                            <p class="text-[#5f6c7b] text-sm mb-6 leading-relaxed">{{ $standard->deskripsi }}</p>
                            <div class="flex items-center justify-between pt-6 border-t border-[#90b4ce]/10">
                                <div>
                                    <p class="text-xs text-[#90b4ce] uppercase font-bold tracking-widest">Mulai Dari</p>
                                    <p class="text-xl font-extrabold text-[#3da9fc]">Rp {{ number_format($standard->harga, 0, ',', '.') }}<span class="text-sm font-normal text-[#90b4ce]">/bln</span></p>
                                </div>
                                <a href="{{ route('booking-detail', $standard->id) }}"
                                    class="w-12 h-12 bg-[#094067] rounded-2xl flex items-center justify-center text-[#fffffe] hover:bg-[#3da9fc] transition-colors">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Medium (The Spotlight Card - Dark Mode) --}}
                @if ($medium)
                    <div
                        class="relative group bg-[#094067] rounded-[2.5rem] p-4 shadow-[0_30px_60px_-15px_rgba(9,64,103,0.3)] transform lg:-translate-y-6 transition-all duration-500 border border-[#3da9fc]/30">
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-[#ef4565] text-[#fffffe] px-6 py-2 rounded-full text-xs font-black tracking-widest shadow-lg z-20">
                            BEST SELLER
                        </div>
                        <div class="relative h-64 rounded-[2rem] overflow-hidden">
                            <img src="{{ Storage::url($medium->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#094067]/80 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-[#fffffe] mb-2">{{ $medium->tipe }}</h3>
                            <p class="text-[#90b4ce] text-sm mb-6 leading-relaxed">{{ $medium->deskripsi }}</p>
                            <div class="flex items-center justify-between pt-6 border-t border-[#90b4ce]/20">
                                <div>
                                    <p class="text-xs text-[#90b4ce] uppercase font-bold tracking-widest">Mulai Dari</p>
                                    <p class="text-xl font-extrabold text-[#3da9fc]">Rp {{ number_format($medium->harga, 0, ',', '.') }}<span class="text-sm font-normal text-[#90b4ce]">/bln</span></p>
                                </div>
                                <a href="{{ route('booking-detail', $medium->id) }}"
                                    class="px-6 py-3 bg-[#3da9fc] text-[#fffffe] rounded-xl font-bold hover:bg-[#fffffe] hover:text-[#094067] transition-all">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Exclusive Room (Light Card) --}}
                @if ($exclusive)
                    <div class="group bg-[#fffffe] rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-[#90b4ce]/20">
                        <div class="relative h-64 rounded-[2rem] overflow-hidden">
                            <img src="{{ Storage::url($exclusive->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-4 right-4 bg-[#094067]/90 backdrop-blur text-[#fffffe] px-4 py-1.5 rounded-full text-xs font-bold shadow-sm italic">Presidential Suite</div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-[#094067] mb-2">{{ $exclusive->tipe }}</h3>
                            <p class="text-[#5f6c7b] text-sm mb-6 leading-relaxed">{{ $exclusive->deskripsi }}</p>
                            <div class="flex items-center justify-between pt-6 border-t border-[#90b4ce]/10">
                                <div>
                                    <p class="text-xs text-[#90b4ce] uppercase font-bold tracking-widest">Mulai Dari</p>
                                    <p class="text-xl font-extrabold text-[#3da9fc]">Rp {{ number_format($exclusive->harga, 0, ',', '.') }}<span class="text-sm font-normal text-[#90b4ce]">/bln</span>
                                    </p>
                                </div>
                                <a href="{{ route('booking-detail', $exclusive->id) }}"
                                    class="w-12 h-12 bg-[#094067] rounded-2xl flex items-center justify-center text-[#fffffe] hover:bg-[#3da9fc] transition-colors">
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
    <section class="py-24 bg-gradient-to-br from-[#90b4ce] via-[#3da9fc] to-[#094067] relative overflow-hidden">
        <div class="absolute top-0 right-0 p-20 opacity-10">
            <i class="fas fa-quote-right text-[15rem] text-[#fffffe]"></i>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <h2 class="text-4xl font-black text-[#fffffe] mb-16 tracking-tight">Apa Kata Penghuni?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                @foreach ([['name' => 'Siti Nur Azizah', 'role' => 'Tech Lead at Startup', 'text' => 'Fasilitas internetnya luar biasa stabil untuk WFH. Estetika kamarnya sangat menenangkan setelah kerja seharian.'], ['name' => 'Budi Santoso', 'role' => 'Business Student', 'text' => 'Lokasinya juara. Dekat kemana-mana, tapi suasananya tetap tenang untuk belajar. Sangat worth it!'], ['name' => 'Rina Wijaya', 'role' => 'Content Creator', 'text' => 'Pencahayaan alami di kamar Exclusive sangat bagus untuk shooting konten. Tim manajemennya juga sangat responsif.']] as $testi)
                    <div class="bg-[#fffffe]/10 backdrop-blur-lg border border-[#fffffe]/20 p-8 rounded-[2.5rem] hover:bg-[#fffffe]/20 transition-all duration-500 group">

                        <div class="flex gap-1 mb-6 text-[#ef4565]">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-sm"></i>
                            @endfor
                        </div>

                        <p class="text-[#fffffe] text-lg italic mb-8 leading-relaxed font-medium">
                            "{{ $testi['text'] }}"
                        </p>

                        <div class="flex items-center gap-4 border-t border-[#fffffe]/20 pt-6">
                            <div class="w-12 h-12 rounded-full bg-[#fffffe]/20 border-2 border-[#fffffe]/40 overflow-hidden group-hover:scale-110 transition-transform">
                                <img src="{{ asset('assets/image/avatar/default-avatar.png') }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="text-[#fffffe] font-bold">{{ $testi['name'] }}</h4>
                                <p class="text-[#fffffe]/70 text-xs uppercase tracking-widest font-bold">
                                    {{ $testi['role'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 6. FAQ: Structured & Readable --}}
    <section id="faq" class="py-24 bg-[#fffffe]">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-[#094067] tracking-tight">Punya Pertanyaan?</h2>
                <p class="text-[#5f6c7b] mt-4 italic">Segala hal yang perlu Anda ketahui sebelum memesan.</p>
            </div>

            <div x-data="{ activeIndex: 0 }" class="space-y-4">
                @foreach ([
            'Apakah tersedia tempat parkir?' => 'Ya, kami menyediakan area parkir tertutup dengan akses kartu keamanan khusus untuk motor dan mobil.',
            'Minimum kontrak sewa berapa lama?' => 'Sistem kami fleksibel. Mulai dari bulanan hingga tahunan dengan diskon khusus untuk pembayaran di muka.',
            'Bolehkah membawa tamu?' => 'Tamu diperbolehkan di area lobby dan komunal hingga jam 21:00 demi kenyamanan bersama.',
            'Apakah harga sudah termasuk listrik?' => 'Harga dasar kami sudah termasuk air dan WiFi. Listrik menggunakan sistem token masing-masing kamar agar lebih transparan.',
            'Bagaimana Pembayarannya?' => 'Pembayaran bisa dilakukan langsung melalui website, bisa juga datang ke tempat.',
        ] as $question => $answer)
                    <div class="border border-[#90b4ce]/30 rounded-[1.5rem] overflow-hidden transition-all duration-300 bg-[#fffffe]"
                        :class="activeIndex === {{ $loop->index }} ? 'shadow-[0_15px_30px_rgba(9,64,103,0.08)] border-[#3da9fc]/40' : ''">

                        <button @click="activeIndex = activeIndex === {{ $loop->index }} ? null : {{ $loop->index }}"
                            class="w-full flex items-center justify-between p-6 text-left hover:bg-[#90b4ce]/5 transition-colors group">

                            <span class="text-lg font-bold text-[#094067] tracking-tight group-hover:text-[#3da9fc] transition-colors">
                                {{ $question }}
                            </span>

                            <div class="w-8 h-8 rounded-full bg-[#3da9fc]/10 flex items-center justify-center transition-transform duration-300"
                                :class="activeIndex === {{ $loop->index }} ? 'rotate-90 bg-[#3da9fc] text-[#fffffe]' : 'text-[#3da9fc]'">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </div>
                        </button>

                        <div x-show="activeIndex === {{ $loop->index }}" x-collapse class="px-6 pb-6 text-[#5f6c7b] leading-relaxed">
                            <div class="pt-2 border-t border-[#90b4ce]/10">
                                {{ $answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 7. LOKASI: Immersive & Serious --}}
    <section id="lokasi" class="py-24 bg-[#094067] overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[400px] h-[400px] bg-[#3da9fc] rounded-full blur-[100px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <h2 class="text-4xl md:text-5xl font-black text-[#fffffe] tracking-tight">Konektivitas Tanpa Batas</h2>
                    <p class="text-[#90b4ce] text-lg leading-relaxed">
                        RumahKedua berlokasi strategis di pusat denyut nadi kota. Akses instan ke perkantoran, pusat edukasi, dan hiburan.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="flex items-start gap-4 p-5 rounded-[2rem] bg-[#fffffe]/5 border border-[#fffffe]/10 hover:bg-[#fffffe]/10 hover:border-[#3da9fc]/30 transition-all duration-300 group">
                            <i class="fas fa-train text-[#3da9fc] text-xl mt-1 group-hover:scale-110 transition-transform"></i>
                            <div>
                                <h4 class="text-[#fffffe] font-bold">Stasiun Utama</h4>
                                <p class="text-[#90b4ce] text-sm">Hanya 5 menit berkendara</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-5 rounded-[2rem] bg-[#fffffe]/5 border border-[#fffffe]/10 hover:bg-[#fffffe]/10 hover:border-[#3da9fc]/30 transition-all duration-300 group">
                            <i class="fas fa-graduation-cap text-[#ef4565] text-xl mt-1 group-hover:scale-110 transition-transform"></i>
                            <div>
                                <h4 class="text-[#fffffe] font-bold">Kampus A</h4>
                                <p class="text-[#90b4ce] text-sm">10 menit jalan kaki</p>
                            </div>
                        </div>
                    </div>

                    <a href="https://maps.app.goo.gl/eiYrueVEhWNgF62Y6" target="_blank"
                        class="inline-flex items-center gap-3 px-8 py-4 bg-[#3da9fc] text-[#fffffe] rounded-2xl font-bold hover:shadow-[0_15px_30px_rgba(61,169,252,0.3)] hover:-translate-y-1 transition-all">
                        Petunjuk Arah <i class="fas fa-map-marked-alt text-sm"></i>
                    </a>
                </div>

                <div class="relative h-[500px] rounded-[3rem] overflow-hidden border-8 border-[#fffffe]/10 shadow-2xl group">
                    <iframe width="100%" height="100%"
                        class="grayscale invert-[0.9] hue-rotate-[200deg] brightness-75 hover:grayscale-0 hover:invert-0 hover:brightness-100 transition-all duration-1000" src="{{ $mapUrl }}"
                        style="border:0;" loading="lazy">
                    </iframe>

                    <div class="absolute inset-0 pointer-events-none ring-1 ring-inset ring-[#fffffe]/20 rounded-[3rem]"></div>

                    <div class="absolute bottom-6 right-6 bg-[#ef4565] text-[#fffffe] px-4 py-2 rounded-xl text-xs font-black tracking-widest shadow-lg">
                        LIVE LOCATION
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 8. CALL TO ACTION: The Visual Anchor --}}
    <section class="py-24 px-4 bg-[#fffffe]">
        <div class="max-w-7xl mx-auto">
            <div class="relative bg-gradient-to-br from-[#3da9fc] to-[#094067] rounded-[3.5rem] p-12 md:p-24 overflow-hidden text-center shadow-[0_30px_60px_-15px_rgba(9,64,103,0.4)]">

                <div class="absolute top-0 left-0 w-64 h-64 bg-[#90b4ce]/30 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-80 h-80 bg-[#ef4565]/20 rounded-full blur-[100px] translate-x-1/3 translate-y-1/3"></div>

                <div class="relative z-10 max-w-3xl mx-auto space-y-8">
                    <h2 class="text-4xl md:text-6xl font-black text-[#fffffe] leading-tight">
                        Mulai Babak Baru <br> Hidup Anda Disini.
                    </h2>

                    <p class="text-[#fffffe]/80 text-xl leading-relaxed">
                        Slot kamar sangat terbatas. Amankan unit Anda sekarang dan rasakan kenyamanan yang belum pernah ada sebelumnya.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                        <a href="https://wa.me/{{ str_replace([' ', '+'], '', $pengaturan->no_telepon ?? '6287870327957') }}"
                            class="px-10 py-5 bg-[#fffffe] text-[#094067] rounded-[2rem] font-black text-lg hover:shadow-2xl hover:shadow-[#fffffe]/20 hover:-translate-y-2 transition-all duration-300">
                            Hubungi via WhatsApp
                        </a>

                        <a href="mailto:{{ $pengaturan->email_kos ?? 'rumahkedua@gmail.com' }}"
                            class="px-10 py-5 bg-transparent border-2 border-[#fffffe]/30 text-[#fffffe] rounded-[2rem] font-bold text-lg hover:bg-[#fffffe]/10 transition-all duration-300">
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
