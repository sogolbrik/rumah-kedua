@extends('layouts.admin-main')

@section('title', 'User')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">
                Daftar User
            </h1>
            <p class="mt-0.5 text-sm text-slate-600">Semua informasi user ada di sini, gampang banget buat dilihat dan dikelola.</p>
        </div>
        <div>
            <a href="{{ route('user.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 text-sm font-medium hover:from-blue-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Tambah User
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 rounded-xl bg-emerald-50 border border-emerald-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-2 text-emerald-800">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 rounded-xl bg-red-50 border border-red-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-2 text-red-800">
                <i class="fa-solid fa-circle-exclamation text-lg"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="mt-4 rounded-2xl border border-slate-200/40 bg-white overflow-hidden shadow-[0_4px_20px_-8px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-slate-50 to-white border-b border-slate-200/50">
                    <tr>
                        <th class="text-left px-6 py-4 w-12"><span class="text-slate-500">#</span></th>
                        <th class="text-left px-6 py-4">
                            <span class="text-slate-700 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-user text-slate-500 text-xs"></i> Nama
                            </span>
                        </th>
                        <th class="text-left px-6 py-4">
                            <span class="text-slate-700 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-amber-500 text-xs"></i> Status
                            </span>
                        </th>
                        <th class="text-left px-6 py-4 w-36">
                            <span class="text-slate-700 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-user-tag text-purple-500 text-xs"></i> Role
                            </span>
                        </th>
                        <th class="text-right px-6 py-4 w-52">
                            <span class="text-slate-700 font-medium flex items-center gap-2 justify-end">
                                <i class="fa-solid fa-gears text-slate-500 text-xs"></i> Aksi
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-200 group">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-200">
                                    @else
                                        @php
                                            $initial = strtoupper(substr($user->name, 0, 1));
                                            if (in_array($initial, ['A', 'B', 'C', 'D', 'E'])) {
                                                $bg = 'bg-gradient-to-br from-indigo-500 to-teal-500';
                                                $ring = 'ring-indigo-200';
                                            } elseif (in_array($initial, ['F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'])) {
                                                $bg = 'bg-gradient-to-br from-rose-500 to-orange-500';
                                                $ring = 'ring-rose-200';
                                            } else {
                                                $bg = 'bg-gradient-to-br from-violet-500 to-pink-500';
                                                $ring = 'ring-violet-200';
                                            }
                                        @endphp
                                        <div class="w-10 h-10 rounded-full {{ $bg }} flex items-center justify-center text-white font-bold text-sm ring-2 {{ $ring }}">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-900 group-hover:text-indigo-900">{{ $user->name }}</span>
                                        <span class="text-slate-400 text-[12px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if (!$penghuniMenunggak->contains($user->id))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-check text-emerald-600 text-xs"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-xs"></i> Menunggak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->role == 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                        <i class="fa-solid fa-shield-halved text-xs"></i> Admin
                                    </span>
                                @elseif($user->role == 'penghuni')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <i class="fa-solid fa-house-user text-xs"></i> Penghuni
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fa-solid fa-user text-xs"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="showDetailModal({{ $user->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-all shadow-sm hover:shadow">
                                        <i class="fa-solid fa-eye text-xs"></i> Detail
                                    </button>
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 transition-all shadow-sm hover:shadow">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline" id="hapus-data-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-red-200 text-red-700 hover:bg-red-50 transition-all shadow-sm hover:shadow"
                                            onclick="konfirmasiHapusUser({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-slate-100 text-slate-400 mb-3">
                                    <i class="fa-regular fa-user text-2xl"></i>
                                </div>
                                <p class="text-base font-medium">Tidak ada user</p>
                                <p class="text-sm text-slate-500 mt-1">Buat user pertama Anda sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="border-t border-slate-200/30 px-6 py-4 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-sm text-slate-600 text-center sm:text-left">
                        Menampilkan <span class="font-bold text-slate-800">{{ $users->firstItem() }}</span>–
                        <span class="font-bold text-slate-800">{{ $users->lastItem() }}</span> dari
                        <span class="font-bold text-slate-800">{{ $users->total() }}</span> hasil
                    </p>
                    <div class="flex gap-2">
                        @if ($users->onFirstPage())
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i> Sebelumnya
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium shadow-sm hover:shadow transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i> Sebelumnya
                            </a>
                        @endif

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium shadow-md hover:shadow-lg hover:from-blue-700 hover:to-cyan-700 transition-all">
                                Selanjutnya <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                Selanjutnya <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Detail User -->
    <div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 ease-out opacity-0 pointer-events-none">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div id="modalBackdrop" class="fixed inset-0 transition-all duration-300 ease-out bg-slate-900/70 backdrop-blur-md" onclick="hideDetailModal()"></div>

            <div id="modalContent"
                class="relative inline-block w-full max-w-5xl overflow-hidden text-left align-bottom transition-all duration-300 ease-out transform scale-95 translate-y-4 bg-slate-50 rounded-3xl shadow-2xl sm:my-8 sm:align-middle">

                <div class="absolute right-4 top-4 z-10">
                    <button type="button" onclick="hideDetailModal()" class="p-2 text-slate-400 hover:text-slate-600 transition-all rounded-full hover:bg-white shadow-sm">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <div class="lg:col-span-4 bg-white p-8 border-r border-slate-200">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-6">
                                <div class="w-40 h-40 rounded-2xl overflow-hidden border-4 border-white shadow-xl ring-1 ring-slate-200">
                                    <img id="modalAvatar" src="" alt="Foto Profil" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-3 left-1/2 -translate-x-1/2">
                                    <span id="modalStatus" class="px-4 py-1 rounded-full text-xs font-bold tracking-wider uppercase shadow-sm border border-white"></span>
                                </div>
                            </div>

                            <h3 class="text-2xl font-bold text-slate-900 mb-1" id="modalNamaUser">Nama User</h3>
                            <p id="modalRole" class="text-sm font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-lg inline-block mb-6"></p>

                            <div class="w-full space-y-3 pt-6 border-t border-slate-100 text-left">
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i class="fa-solid fa-envelope text-sm"></i>
                                    </div>
                                    <span id="modalEmail" class="text-sm truncate"></span>
                                </div>
                                <div class="flex items-center gap-3 text-slate-600">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i class="fa-solid fa-phone text-sm"></i>
                                    </div>
                                    <span id="modalTelepon" class="text-sm font-medium"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-8 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-8">
                                <h4 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Informasi Lengkap</h4>
                                <div class="h-px flex-1 bg-slate-200"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm transition-hover hover:shadow-md transition-all">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-id-card"></i>
                                        </div>
                                        <h5 class="font-bold text-slate-700">Data Diri</h5>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Nama Lengkap</p>
                                            <p id="modalName" class="text-slate-900 font-medium"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Tanggal Bergabung</p>
                                            <div class="flex items-center gap-2 text-slate-900">
                                                <i class="fa-solid fa-calendar-day text-slate-400"></i>
                                                <span id="modalTanggalMasuk" class="font-medium"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="modalKamarInfo" class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 shadow-sm hidden">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-door-open"></i>
                                        </div>
                                        <h5 class="font-bold text-emerald-800">Detail Kamar</h5>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-[10px] uppercase font-bold text-emerald-600/60 mb-1">Kode Kamar</p>
                                            <p id="modalKodeKamar" class="text-emerald-900 font-bold text-lg"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] uppercase font-bold text-emerald-600/60 mb-1">Masuk Kamar Sejak</p>
                                            <p id="modalTanggalMasukKamar" class="text-emerald-900 font-medium"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4 mt-12 pt-6 border-t border-slate-200">
                            <button type="button" id="inactiveButton"
                                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-100 hover:text-amber-800 transition-all duration-200">
                                <i class="fa-solid fa-user-slash"></i>
                                Nonaktifkan User
                            </button>

                            <div class="flex items-center gap-3">
                                <button type="button" onclick="hideDetailModal()"
                                    class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all duration-200">
                                    Tutup
                                </button>
                                <a href="#" id="modalEditLink"
                                    class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 transition-all duration-200 inline-flex items-center gap-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const userData = @json($users->keyBy('id')->toArray());

        function showDetailModal(userId) {
            const user = userData[userId];
            if (!user) return;

            // Isi data ke modal
            document.getElementById('modalNamaUser').textContent = `Detail ${user.name}`;
            document.getElementById('modalName').textContent = user.name;
            document.getElementById('modalEmail').textContent = user.email;
            document.getElementById('modalTelepon').textContent = user.telepon || '-';
            document.getElementById('modalTanggalMasuk').textContent = user.tanggal_masuk ? formatTanggal(user.tanggal_masuk) : '-';
            document.getElementById('modalEditLink').href = `/user/${user.id}/edit`;

            // Set avatar
            const avatarElement = document.getElementById('modalAvatar');
            if (user.avatar) {
                avatarElement.src = `/storage/${user.avatar}`;
            } else {
                avatarElement.src = '/assets/image/avatar/default-avatar.png';
            }
            avatarElement.alt = `Foto ${user.name}`;

            // Set role
            const roleElement = document.getElementById('modalRole');
            if (user.role === 'admin') {
                roleElement.innerHTML = '<i class="fa-solid fa-shield-halved mr-1"></i> Admin';
                roleElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200';
            } else if (user.role === 'penghuni') {
                roleElement.innerHTML = '<i class="fa-solid fa-house-user mr-1"></i> Penghuni';
                roleElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200';
            } else {
                roleElement.innerHTML = '<i class="fa-solid fa-user mr-1"></i> User';
                roleElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200';
            }

            // Set status (asumsi ada field status)
            const statusElement = document.getElementById('modalStatus');
            const inactiveButton = document.getElementById('inactiveButton');

            inactiveButton.style.display = 'none';
            inactiveButton.onclick = null;

            if (user.role === 'penghuni') {
                statusElement.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Aktif';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200';

                inactiveButton.innerHTML = '<i class="fa-solid fa-user-slash mr-2"></i> Nonaktifkan User';
                inactiveButton.className =
                    'inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-100 border border-amber-200 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:shadow-sm';
                inactiveButton.onclick = function() {
                    nonaktifkanUser(user.id, user.name);
                };
                inactiveButton.style.display = 'inline-flex';
            } else {
                statusElement.innerHTML = '-';
            }

            // Tampilkan informasi kamar jika user adalah penghuni dan memiliki id_kamar
            const kamarInfoElement = document.getElementById('modalKamarInfo');
            if (user.role === 'penghuni' && user.id_kamar) {
                kamarInfoElement.classList.remove('hidden');

                // Isi data kamar
                document.getElementById('modalKodeKamar').textContent = user.kamar.kode_kamar || '-';
                document.getElementById('modalTanggalMasukKamar').textContent = user.tanggal_masuk ? formatTanggal(user.tanggal_masuk) : '-';

            } else {
                kamarInfoElement.classList.add('hidden');
            }

            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');

            void modal.offsetWidth;

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                backdrop.classList.remove('bg-gray-900/60');
                backdrop.classList.add('bg-gray-900/70');
                content.classList.remove('scale-95', 'translate-y-4');
                content.classList.add('scale-100', 'translate-y-0');
            }, 10);

            document.body.classList.add('overflow-hidden');
        }

        function hideDetailModal() {
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            backdrop.classList.remove('bg-gray-900/70');
            backdrop.classList.add('bg-gray-900/60');
            content.classList.remove('scale-100', 'translate-y-0');
            content.classList.add('scale-95', 'translate-y-4');

            setTimeout(() => {
                modal.classList.remove('pointer-events-auto');
                modal.classList.add('pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        function formatTanggal(tanggal) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Date(tanggal).toLocaleDateString('id-ID', options);
        }

        function nonaktifkanUser(userId, namaUser) {
            const url = "{{ route('user.nonaktifkan', ':id') }}".replace(':id', userId);
            Swal.fire({
                title: 'Nonaktifkan User?',
                html: `
                    <div class="text-center">
                        <p class="text-slate-700 mb-2">Anda akan menonaktifkan user:</p>
                        <p class="text-lg font-bold text-amber-600 mb-3">${namaUser}</p>
                        <p class="text-sm text-slate-500">User akan tidak dapat mengakses sistem</p>
                    </div>
                    `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-user-slash mr-2"></i>Ya, Nonaktifkan',
                cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 focus:bg-amber-700 active:bg-amber-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2',
                    cancelButton: 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.id = 'nonaktifkan-user-' + userId;
                    form.method = 'POST';
                    form.action = url;
                    form.style.display = 'none';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);

                    form.submit();
                }
            });
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideDetailModal();
            }
        });

        function konfirmasiHapusUser(id, namaUser) {
            Swal.fire({
                title: 'Hapus User?',
                html: `
                    <div class="text-center">
                        <p class="text-slate-700 mb-2">Anda akan menghapus user:</p>
                        <p class="text-lg font-bold text-red-600 mb-3">${namaUser}</p>
                        <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-trash mr-2"></i>Ya, Hapus',
                cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2',
                    cancelButton: 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('hapus-data-' + id).submit();
                }
            });
        }
    </script>

    <style>
        .aspect-w-1::before {
            padding-bottom: 100%;
        }

        .aspect-w-16::before {
            padding-bottom: 56.25%;
        }

        .aspect-w-1>*,
        .aspect-w-16>* {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .aspect-w-1 {
            position: relative;
        }

        .aspect-w-1::before {
            content: "";
            display: block;
            padding-bottom: 100%;
            /* 1:1 Aspect Ratio */
        }

        .aspect-w-16 {
            position: relative;
        }

        .aspect-w-16::before {
            content: "";
            display: block;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
        }

        .aspect-w-1>*,
        .aspect-w-16>* {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        /* Smooth transitions for all interactive elements */
        .transition-all {
            transition-property: all;
        }

        /* Custom scrollbar for modal */
        #detailModal ::-webkit-scrollbar {
            width: 6px;
        }

        #detailModal ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #detailModal ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #detailModal ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endsection
