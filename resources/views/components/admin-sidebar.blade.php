<aside
    class="fixed inset-y-0 left-0 z-40 w-72 transform bg-gradient-to-b from-slate-50 to-slate-100 border-r border-slate-200 lg:relative lg:inset-auto lg:translate-x-0 transition-transform duration-300 ease-in-out h-screen pb-16 shadow-lg lg:shadow-none"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" aria-label="Sidebar Navigasi">
    <!-- Header Logo -->
    <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-200/60 sticky top-0 bg-white/80 backdrop-blur-lg z-10">
        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white shadow-sm">
            <i class="fa-solid fa-house text-sm"></i>
        </div>
        <div class="flex flex-col">
            <span class="font-bold text-slate-900 tracking-tight">RumahKedua</span>
            <span class="text-[10px] text-slate-500 uppercase tracking-wider font-medium">Admin Panel</span>
        </div>
        <button class="ml-auto lg:hidden p-2 rounded-lg hover:bg-slate-200/50 text-slate-600 transition-colors" @click="sidebarOpen = false" aria-label="Tutup navigasi">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    <!-- Navigation Menu -->
    <nav class="px-4 py-5 flex flex-col h-full relative">
        <div class="flex-1">
            <!-- Menu Section Label -->
            <div class="px-2 pb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">MENU UTAMA</div>

            <ul class="space-y-1.5">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard-admin') }}"
                        class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 group
                        {{ request()->routeIs('dashboard-admin') ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-md' : 'text-slate-700 hover:bg-slate-200/60 hover:text-slate-900' }}">
                        <i class="fa-solid fa-home text-sm group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Dropdown Master Data -->
                <li x-cloak x-data="{ open: {{ request()->routeIs('kamar.*') || request()->routeIs('user.*') || request()->routeIs('galeri.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full px-4 py-2.5 rounded-xl text-slate-700 hover:bg-slate-200/60 hover:text-slate-900 transition-all duration-200">
                        <div class="flex items-center gap-3.5">
                            <i class="fa-solid fa-layer-group text-sm"></i>
                            <span class="font-medium">Master Data</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="open ? 'rotate-180 text-slate-900' : 'text-slate-500'"></i>
                    </button>

                    <ul x-show="open" x-collapse.duration.200ms class="mt-2 ml-2 space-y-1.5 pl-4 border-l-2 border-slate-200/40">
                        <li>
                            <a href="{{ route('kamar.index') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                                {{ request()->routeIs('kamar.*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-800' }}">
                                <i class="fa-solid fa-door-open text-xs"></i>
                                <span>Kamar</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('galeri.index') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                                {{ request()->routeIs('galeri.*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-800' }}">
                                <i class="fa-solid fa-images text-xs"></i>
                                <span>Galeri</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.index') }}"
                                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all
                                {{ request()->routeIs('user.*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-slate-200/50 hover:text-slate-800' }}">
                                <i class="fa-solid fa-users text-xs"></i>
                                <span>User</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Transaksi -->
                <li>
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 group
                        {{ request()->routeIs('transaksi.index') ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md' : 'text-slate-700 hover:bg-slate-200/60 hover:text-slate-900' }}">
                        <i class="fa-solid fa-receipt text-sm group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Transaksi</span>
                    </a>
                </li>

                <!-- Pengumuman -->
                <li>
                    <a href="{{ route('pengumuman-admin') }}"
                        class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 group
                        {{ request()->routeIs('pengumuman-admin') ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-md' : 'text-slate-700 hover:bg-slate-200/60 hover:text-slate-900' }}">
                        <i class="fa-solid fa-bullhorn text-sm group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Pengumuman</span>
                    </a>
                </li>

                <!-- Laporan -->
                <li>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl transition-all duration-200 group
                        {{ request()->routeIs('laporan.*') ? 'bg-gradient-to-r from-violet-500 to-purple-500 text-white shadow-md' : 'text-slate-700 hover:bg-slate-200/60 hover:text-slate-900' }}">
                        <i class="fa-solid fa-chart-line text-sm group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Laporan</span>
                    </a>
                </li>
            </ul>

            <!-- Other Section -->
            <div class="mt-6 px-2 pb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">LAINNYA</div>
            <ul class="space-y-1.5">
                <li>
                    <a href="#" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-slate-700 hover:bg-slate-200/60 hover:text-slate-900 transition-all group">
                        <i class="fa-solid fa-gear text-sm group-hover:rotate-12 transition-transform"></i>
                        <span class="font-medium">Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Profile Section -->
        <div class="px-4 py-3 relative" x-data="{ openProfile: false }">
            <div class="border-t border-slate-200 my-2"></div>
            <button  @click="openProfile = !openProfile"
                class="flex items-center gap-3 w-full p-2 rounded-xl hover:bg-slate-200/60 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                <!-- Avatar -->
                <div class="relative">
                    @if (auth()->check() && auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="h-10 w-10 rounded-full object-cover border-2 border-white shadow-sm">
                    @else
                        <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center ring-1 ring-blue-200">
                            <i class="fa-solid fa-user text-blue-600"></i>
                        </div>
                    @endif
                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 border-2 border-white"></span>
                </div>
                <!-- Name & Role -->
                <div class="flex-1 text-left">
                    <p class="text-sm font-semibold text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Admin Kos' }}</p>
                    <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role ?? 'admin' }}</p>
                </div>
                <!-- Dropdown Icon -->
                <i class="fa-solid fa-chevron-up text-xs text-slate-400 transition-transform duration-300" :class="openProfile ? 'rotate-180' : ''"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-cloak x-show="openProfile" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2" class="absolute bottom-full left-4 right-4 mb-2 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden z-20">

                <a href="{{ route('profil-admin.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                    <i class="fa-solid fa-user text-slate-500"></i>
                    <span class="font-medium">Profil</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

    </nav>
</aside>
