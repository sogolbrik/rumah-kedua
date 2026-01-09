<aside
    class="fixed inset-y-0 left-0 z-40 w-72 transform bg-white border-r border-slate-200/60 lg:relative lg:inset-auto lg:translate-x-0 transition-all duration-300 ease-in-out h-screen flex flex-col shadow-2xl lg:shadow-none"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" aria-label="Sidebar Navigasi">

    <div class="h-20 flex items-center gap-3.5 px-6 sticky top-0 bg-white/80 backdrop-blur-md z-20">
        <div class="relative group">
            @if ($pengaturan->logo)
                <img src="{{ Storage::url($pengaturan->logo) }}" alt="Logo Kos" class="h-11 w-11 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform">
            @else
                <div
                    class="h-11 w-11 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-house-chimney text-base"></i>
                </div>
            @endif
            <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-emerald-500 border-2 border-white rounded-full"></div>
        </div>

        <div class="flex flex-col">
            <span class="font-black text-slate-900 tracking-tight leading-none text-lg">{{ $pengaturan->nama_kos ?? 'RumahKedua' }}</span>
            <span class="text-[10px] text-blue-600 uppercase tracking-[0.15em] font-black mt-1">Management v1.0</span>
        </div>

        <button class="ml-auto lg:hidden p-2 rounded-xl hover:bg-slate-100 text-slate-400 transition-colors" @click="sidebarOpen = false">
            <i class="fa-solid fa-chevron-left text-xs"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar space-y-8">

        <div>
            <div class="px-4 mb-4 flex items-center justify-between">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Menu Utama</span>
                <div class="h-px w-12 bg-slate-100"></div>
            </div>

            <ul class="space-y-1.5">
                <li>
                    <a href="{{ route('dashboard-admin') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition-all duration-300 group
                        {{ request()->routeIs('dashboard-admin') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200 active-nav' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                        <i class="fa-solid fa-home text-sm {{ request()->routeIs('dashboard-admin') ? '' : 'group-hover:rotate-6 transition-transform' }}"></i>
                        <span class="font-bold text-[14px]">Dashboard</span>
                    </a>
                </li>

                <li x-data="{ open: {{ request()->routeIs('kamar.*') || request()->routeIs('user.*') || request()->routeIs('galeri.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-3 rounded-2xl text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-all duration-300 group">
                        <div class="flex items-center gap-3.5">
                            <i class="fa-solid fa-box-archive text-sm group-hover:scale-110 transition-transform"></i>
                            <span class="font-bold text-[14px]">Master Data</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] transition-transform duration-300" :class="open ? 'rotate-90 text-blue-600' : 'text-slate-400'"></i>
                    </button>

                    <div x-show="open" x-collapse x-cloak>
                        <ul class="mt-1 ml-6 space-y-1 border-l-2 border-slate-100 pl-4">
                            <li>
                                <a href="{{ route('kamar.index') }}"
                                    class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm transition-all
                                    {{ request()->routeIs('kamar.*') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-blue-600' }}">
                                    <span>Kamar</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('galeri.index') }}"
                                    class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm transition-all
                                    {{ request()->routeIs('galeri.*') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-blue-600' }}">
                                    <span>Galeri</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.index') }}"
                                    class="flex items-center gap-3 py-2 px-3 rounded-xl text-sm transition-all
                                    {{ request()->routeIs('user.*') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-blue-600' }}">
                                    <span>User</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition-all duration-300 group
                        {{ request()->routeIs('transaksi.index') ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-500' }}">
                        <i class="fa-solid fa-wallet text-sm group-hover:-translate-y-0.5 transition-transform"></i>
                        <span class="font-bold text-[14px]">Transaksi</span>
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <div class="px-4 mb-4 flex items-center justify-between">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Sistem</span>
                <div class="h-px w-12 bg-slate-100"></div>
            </div>

            <ul class="space-y-1.5">
                <li>
                    <a href="{{ route('pengumuman-admin') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition-all duration-300 group
                        {{ request()->routeIs('pengumuman-admin') ? 'bg-amber-500 text-white shadow-lg shadow-amber-100' : 'text-slate-600 hover:bg-slate-50 hover:text-amber-500' }}">
                        <i class="fa-solid fa-bullhorn text-sm group-hover:animate-bounce"></i>
                        <span class="font-bold text-[14px]">Pengumuman</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition-all duration-300 group
                        {{ request()->routeIs('laporan.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="fa-solid fa-chart-pie text-sm group-hover:rotate-12 transition-transform"></i>
                        <span class="font-bold text-[14px]">Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengaturan-admin.index') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-2xl transition-all duration-300 group
                        {{ request()->routeIs('pengaturan-admin.*') ? 'bg-slate-800 text-white shadow-lg shadow-slate-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <i class="fa-solid fa-sliders text-sm group-hover:rotate-90 transition-transform"></i>
                        <span class="font-bold text-[14px]">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="p-4 bg-slate-50/50 border-t border-slate-100" x-data="{ openProfile: false }">
        <div class="relative">
            <div x-cloak x-show="openProfile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-150"
                class="absolute bottom-full left-0 w-full mb-4 bg-white rounded-2xl shadow-2xl border border-slate-200/60 overflow-hidden z-50">

                <div class="px-5 py-4 border-b border-slate-50 bg-slate-50/30">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Akun Anda</p>
                </div>
                <a href="{{ route('profil-admin.index') }}" class="flex items-center gap-3 px-5 py-3.5 text-sm font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-all">
                    <i class="fa-solid fa-circle-user text-slate-400 group-hover:text-blue-500"></i> Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-5 py-3.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-all">
                        <i class="fa-solid fa-power-off text-red-400"></i> Keluar Aplikasi
                    </button>
                </form>
            </div>

            <button @click="openProfile = !openProfile" class="flex items-center gap-3 w-full p-3 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-blue-300 transition-all group">
                <div class="relative flex-shrink-0">
                    @if (auth()->check() && auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" class="h-10 w-10 rounded-xl object-cover ring-2 ring-slate-100">
                    @else
                        <div
                            class="h-10 w-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 text-left min-w-0">
                    <p class="text-sm font-black text-slate-900 truncate tracking-tight">{{ Auth::user()->name ?? 'Admin Kos' }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase truncate">{{ Auth::user()->role ?? 'Superadmin' }}</p>
                </div>
                <i class="fa-solid fa-ellipsis-vertical text-slate-300 group-hover:text-slate-500 transition-colors px-1"></i>
            </button>
        </div>
    </div>
</aside>
