<nav x-cloak x-data="{
    mobileOpen: false,
    isScrolled: false,
    atTop: true
}" x-init="window.addEventListener('scroll', () => {
    isScrolled = window.scrollY > 20;
    atTop = window.scrollY < 10;
})" :class="atTop ? 'top-6' : 'top-4'"
    class="fixed left-1/2 -translate-x-1/2 z-[100] w-[calc(100%-1.5rem)] max-w-6xl transition-all duration-500 ease-in-out">

    <div :class="isScrolled ? 'bg-[#fffffe]/80 backdrop-blur-md shadow-[0_8px_32px_rgba(9,64,103,0.08)] border-[#90b4ce]/30 py-2' : 'bg-[#fffffe]/40 backdrop-blur-sm border-[#fffffe]/20 py-4'"
        class="relative px-5 md:px-8 rounded-[1.5rem] md:rounded-[2rem] border transition-all duration-500 overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-r from-[#90b4ce]/10 via-transparent to-[#90b4ce]/10 pointer-events-none"></div>

        <div class="relative flex justify-between items-center h-12">
            <a href="{{ route('landing-page') }}" class="flex items-center gap-3 group">
                <div class="relative w-10 h-10 flex items-center justify-center">
                    @if ($pengaturan->logo)
                        <img src="{{ Storage::url($pengaturan->logo) }}" alt="{{ $pengaturan->nama_kos }}-logo" class="w-[120%] h-[120%] object-contain rounded-lg">
                    @else
                        <div class="absolute inset-0 bg-[#094067] rounded-2xl rotate-6 group-hover:rotate-0 group-hover:bg-[#3da9fc] transition-all duration-500"></div>
                        <i class="fas fa-home text-[#fffffe] text-sm relative z-10"></i>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-black tracking-tight text-[#094067] leading-none">
                        @php
                            $raw = $pengaturan->nama_kos ?? 'RumahKedua';
                            $nama = strtoupper(trim($raw));
                            // Ambil 5 huruf pertama dan 5 huruf kedua
                            $kata1 = substr($nama, 0, 5);
                            $kata2 = substr($nama, 5, 5);
                        @endphp

                        {!! $kata1 !!}<span class="text-[#3da9fc]">{!! $kata2 !!}</span>
                    </span>
                    <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#5f6c7b]">Premium Living</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-8">
                @foreach ([['label' => 'Fasilitas', 'id' => 'fasilitas'], ['label' => 'Kamar', 'id' => 'kamar'], ['label' => 'Galeri', 'route' => 'galeri-kamar'], ['label' => 'FAQ', 'id' => 'faq']] as $item)
                    <a href="{{ isset($item['route']) ? route($item['route']) : url('/#' . $item['id']) }}"
                        class="text-[13px] font-bold uppercase tracking-widest text-[#5f6c7b] hover:text-[#3da9fc] transition-colors duration-300 relative group">
                        {{ $item['label'] }}
                        <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1 h-1 bg-[#ef4565] rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
                    </a>
                @endforeach
            </div>

            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-[13px] font-bold uppercase tracking-widest text-[#90b4ce] hover:text-[#094067] transition-colors">
                    Login
                </a>
                <a href="{{ route('booking') }}"
                    class="group relative inline-flex items-center gap-3 bg-[#3da9fc] text-[#fffffe] px-7 py-3 rounded-2xl overflow-hidden transition-all duration-300 hover:brightness-110 hover:shadow-[0_12px_24px_rgba(61,169,252,0.3)]">
                    <span class="relative z-10 text-[11px] font-black uppercase tracking-widest">Reserve Room</span>
                    <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <button @click="mobileOpen = !mobileOpen" class="md:hidden w-10 h-10 flex flex-col items-center justify-center gap-1.5 focus:outline-none">
                <span class="w-6 h-0.5 bg-[#094067] transition-all duration-300" :class="mobileOpen ? 'rotate-45 translate-y-2' : ''"></span>
                <span class="w-6 h-0.5 bg-[#094067] transition-all duration-300" :class="mobileOpen ? 'opacity-0' : ''"></span>
                <span class="w-6 h-0.5 bg-[#094067] transition-all duration-300" :class="mobileOpen ? '-rotate-45 -translate-y-2' : ''"></span>
            </button>
        </div>
    </div>

    <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 -translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-8 scale-95"
        class="absolute top-full left-0 right-0 mt-4 bg-[#fffffe]/fb backdrop-blur-xl rounded-[2rem] border border-[#90b4ce]/30 shadow-2xl p-6 md:hidden">

        <div class="flex flex-col gap-1">
            @foreach ([['label' => 'Fasilitas', 'id' => 'fasilitas'], ['label' => 'Kamar', 'id' => 'kamar'], ['label' => 'Galeri', 'route' => 'galeri-kamar'], ['label' => 'FAQ', 'id' => 'faq']] as $item)
                <a href="{{ isset($item['route']) ? route($item['route']) : url('/#' . $item['id']) }}" @click="mobileOpen = false"
                    class="flex items-center justify-between p-4 rounded-2xl hover:bg-[#90b4ce]/10 transition-colors group">
                    <span class="text-sm font-bold uppercase tracking-widest text-[#5f6c7b] group-hover:text-[#3da9fc]">{{ $item['label'] }}</span>
                    <i class="fas fa-chevron-right text-[10px] text-[#90b4ce] group-hover:text-[#3da9fc]"></i>
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-[#90b4ce]/20">
            <a href="{{ route('login') }}" class="flex items-center justify-center py-4 rounded-2xl border border-[#90b4ce]/50 text-xs font-black uppercase tracking-widest text-[#5f6c7b]">
                Login
            </a>
            <a href="{{ route('booking') }}"
                class="flex items-center justify-center py-4 rounded-2xl bg-[#3da9fc] text-[#fffffe] text-xs font-black uppercase tracking-widest shadow-lg shadow-[#3da9fc]/20">
                Booking
            </a>
        </div>
    </div>
</nav>
