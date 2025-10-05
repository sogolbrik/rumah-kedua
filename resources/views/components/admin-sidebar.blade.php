<aside class="fixed inset-y-0 left-0 z-40 w-72 transform bg-white border-r border-slate-200 lg:relative lg:inset-auto lg:translate-x-0 transition-transform h-screen overflow-y-auto"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" aria-label="Sidebar Navigasi">
    <div class="h-16 flex items-center gap-2 px-4 border-b border-slate-200 sticky top-0 bg-white z-10">
        <div class="h-9 w-9 rounded-lg bg-blue-600 flex items-center justify-center text-white">
            <i class="fa-solid fa-house"></i>
        </div>
        <div class="flex flex-col">
            <span class="font-semibold text-slate-900 leading-tight">RumahKedua</span>
            <span class="text-xs text-slate-500 leading-tight">Admin Panel</span>
        </div>
        <button class="ml-auto lg:hidden p-2 rounded-md hover:bg-slate-100 text-slate-600" @click="sidebarOpen = false" aria-label="Tutup navigasi">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <nav class="px-3 py-4">
        <div class="px-2 pb-2 text-xs font-semibold text-slate-500">MENU</div>
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard-admin') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm
           {{ request()->routeIs('dashboard-admin') ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200' : 'text-slate-700 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Dropdown Master Data -->
            <li x-data="{ open: {{ request()->routeIs('kamar.*') || request()->routeIs('user.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-database"></i>
                        <span>Master Data</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <ul x-show="open" x-collapse class="mt-1 ml-4 space-y-1 border-l border-slate-200 pl-3">
                    <li>
                        <a href="{{ route('kamar.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm
                   {{ request()->routeIs('kamar.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200' : 'text-slate-700 hover:bg-slate-100' }}">
                            <i class="fa-solid fa-door-open text-xs"></i>
                            <span>Kamar</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md text-sm
                   {{ request()->routeIs('user.*') ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200' : 'text-slate-700 hover:bg-slate-100' }}">
                            <i class="fa-solid fa-users text-xs"></i>
                            <span>User</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('transaksi-admin') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm
           {{ request()->routeIs('transaksi-admin') ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200' : 'text-slate-700 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pengumuman-admin') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-md text-sm
           {{ request()->routeIs('pengumuman-admin') ? 'bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200' : 'text-slate-700 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>Pengumuman</span>
                </a>
            </li>
        </ul>

        <div class="mt-6 px-2 pb-2 text-xs font-semibold text-slate-500">LAINNYA</div>
        <ul class="space-y-1">
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm text-slate-700 hover:bg-slate-100">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
