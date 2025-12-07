@extends('layouts.admin-main')

@section('title', 'User')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar User</h1>
            <p class="mt-0.5 text-sm text-slate-600">Semua informasi user ada di sini, gampang banget buat dilihat dan dikelola.</p>
        </div>
        <div>
            <a href="{{ Route('user.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-4 py-2.5 text-sm font-medium hover:bg-blue-700 transition-colors">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Tambah User
            </a>
        </div>
    </div>

    <div class="mt-4 rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-4 w-12">No</th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-user mr-2 text-xs"></i>
                            Nama
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-envelope mr-2 text-xs"></i>
                            Email
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-circle-info mr-2 text-xs"></i>
                            Status
                        </th>
                        <th class="text-left px-6 py-4 w-36">
                            <i class="fa-solid fa-user-tag mr-2 text-xs"></i>
                            Role
                        </th>
                        <th class="text-right px-6 py-4 w-52">
                            <i class="fa-solid fa-gears mr-2 text-xs"></i>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if ($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div @php
                                        $initial = strtoupper(substr($user->name, 0, 1));
                                            if (in_array($initial, ['A','B','C','D','E'])) {
                                                $gradient = 'from-indigo-500 to-teal-500 ring-indigo-200';
                                            } elseif (in_array($initial, ['F','G','H','I','J','K','L','M'])) {
                                                $gradient = 'from-rose-500 to-orange-500 ring-rose-200';
                                            } else {
                                                $gradient = 'from-violet-500 to-pink-500 ring-violet-200';
                                            } @endphp
                                            class="w-12 h-12 rounded-full bg-gradient-to-r {{ $gradient }} flex items-center justify-center text-white font-bold text-sm ring-2">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    @endif
                                    <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-envelope text-slate-400 text-sm"></i>
                                    <span class="text-slate-900">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if (!$penghuniMenunggak->contains($user->id))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs bg-white text-green-600 font-semibold shadow-sm border border-green-200">
                                        <i class="fa-solid fa-check text-green-500"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs bg-white text-amber-600 font-semibold shadow-sm border border-amber-200">
                                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                                        Menunggak
                                @endif
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($user->role == 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200">
                                        <i class="fa-solid fa-shield-halved text-xs"></i>
                                        Admin
                                    </span>
                                @elseif($user->role == 'penghuni')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <i class="fa-solid fa-house-user text-xs"></i>
                                        Penghuni
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fa-solid fa-user text-xs"></i>
                                        User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="showDetailModal({{ $user->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 hover:border-slate-300 transition-colors">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                        Detail
                                    </button>
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-blue-100 border border-blue-200 text-blue-700 hover:bg-blue-200 hover:border-blue-300 transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline" id="hapus-data-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-red-100 border border-red-200 text-red-700 hover:bg-red-200 hover:border-red-300 transition-colors"
                                            onclick="konfirmasiHapusUser({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination (jika menggunakan paginate) -->
        @if ($users->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-700">
                        Menampilkan
                        <span class="font-medium">{{ $users->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $users->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $users->total() }}</span>
                        hasil
                    </p>
                    <div class="flex gap-1">
                        @if ($users->onFirstPage())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </a>
                        @endif

                        @if ($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                Selanjutnya
                                <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                Selanjutnya
                                <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
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
            <!-- Backdrop dengan blur -->
            <div id="modalBackdrop" class="fixed inset-0 transition-all duration-300 ease-out bg-gray-900/60 backdrop-blur-sm" onclick="hideDetailModal()"></div>

            <!-- Modal Content -->
            <div id="modalContent"
                class="relative inline-block w-full max-w-4xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all duration-300 ease-out transform scale-95 translate-y-4 bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:p-6">
                <!-- Header Modal -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 text-blue-600">
                            <i class="fa-solid fa-user text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900" id="modalNamaUser">Detail User</h3>
                            <p class="text-sm text-slate-600">Informasi lengkap user</p>
                        </div>
                    </div>
                    <button type="button" onclick="hideDetailModal()" class="p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Content Modal -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Kolom 1: Foto Profil & KTP -->
                    <div class="space-y-4">
                        <!-- Foto Profil -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user text-blue-600"></i>
                                Foto Profil
                            </h4>
                            <div class="aspect-w-1 aspect-h-1 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                <img id="modalAvatar" src="" alt="Foto Profil" class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                        </div>

                        <!-- Foto KTP -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-amber-600"></i>
                                Foto KTP
                            </h4>
                            <div class="aspect-w-16 aspect-h-9 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                <img id="modalKtp" src="" alt="Foto KTP" class="w-full h-32 object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2: Informasi Utama -->
                    <div class="space-y-4">
                        <!-- Informasi Pribadi -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-blue-600"></i>
                                Informasi Pribadi
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Nama:</span>
                                    <span id="modalName" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Email:</span>
                                    <span id="modalEmail" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Telepon:</span>
                                    <span id="modalTelepon" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Tanggal Masuk:</span>
                                    <span id="modalTanggalMasuk" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Role -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user-tag text-purple-600"></i>
                                Status & Role
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Role:</span>
                                    <span id="modalRole" class="px-3 py-1 rounded-full text-xs font-medium"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Status:</span>
                                    <span id="modalStatus" class="px-3 py-1 rounded-full text-xs font-medium"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kamar (Hanya untuk Penghuni) -->
                        <div id="modalKamarInfo" class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm hidden">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-door-open text-emerald-600"></i>
                                Informasi Kamar
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Kode Kamar:</span>
                                    <span id="modalKodeKamar" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Tanggal Masuk Kamar:</span>
                                    <span id="modalTanggalMasukKamar" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 3: Alamat -->
                    <div class="space-y-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm h-full">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-red-600"></i>
                                Alamat
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-slate-600">Alamat:</span>
                                    <p id="modalAlamat" class="font-medium text-slate-900 mt-1"></p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Kota:</span>
                                    <span id="modalKota" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Provinsi:</span>
                                    <span id="modalProvinsi" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-slate-200">
                    <button type="button" id="inactiveButton"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-100 border border-amber-200 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:shadow-sm">
                        <i class="fa-solid fa-user-slash"></i>
                        Nonaktifkan User
                    </button>
                    <div class="flex gap-3 ml-auto">
                        <button type="button" onclick="hideDetailModal()"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-all duration-200 hover:shadow-sm">
                            <i class="fa-solid fa-times mr-2"></i>
                            Tutup
                        </button>
                        <a href="#" id="modalEditLink"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200 hover:shadow-sm inline-flex items-center">
                            <i class="fa-solid fa-pen-to-square mr-2"></i>
                            Edit User
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data user dari server (bisa juga di-fetch via AJAX)
        const userData = @json($users->keyBy('id')->toArray());

        // Fungsi untuk menampilkan modal detail dengan animasi
        function showDetailModal(userId) {
            const user = userData[userId];
            if (!user) return;

            // Isi data ke modal
            document.getElementById('modalNamaUser').textContent = `Detail ${user.name}`;
            document.getElementById('modalName').textContent = user.name;
            document.getElementById('modalEmail').textContent = user.email;
            document.getElementById('modalTelepon').textContent = user.telepon || '-';
            document.getElementById('modalAlamat').textContent = user.alamat || '-';
            document.getElementById('modalKota').textContent = user.kota || '-';
            document.getElementById('modalProvinsi').textContent = user.provinsi || '-';
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

            // Set KTP
            const ktpElement = document.getElementById('modalKtp');
            if (user.ktp) {
                ktpElement.src = `/storage/${user.ktp}`;
            } else {
                ktpElement.src = '/assets/image/avatar/default-ktp.jpg';
            }
            ktpElement.alt = `KTP ${user.name}`;

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

            // default hide dulu
            inactiveButton.style.display = 'none';
            inactiveButton.onclick = null;

            if (user.role === 'penghuni') {
                statusElement.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Aktif';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200';

                // Set tombol nonaktifkan
                inactiveButton.innerHTML = '<i class="fa-solid fa-user-slash mr-2"></i> Nonaktifkan User';
                inactiveButton.className =
                    'inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-amber-700 bg-amber-100 border border-amber-200 rounded-lg hover:bg-amber-200 transition-all duration-200 hover:shadow-sm';
                inactiveButton.onclick = function() {
                    nonaktifkanUser(user.id, user.name);
                };
                inactiveButton.style.display = 'inline-flex'; // Tampilkan tombol
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

            // Tampilkan modal dengan animasi
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');

            // Trigger reflow untuk memastikan animasi berjalan
            void modal.offsetWidth;

            // Animasikan backdrop dan content
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

        // Fungsi untuk menyembunyikan modal dengan animasi
        function hideDetailModal() {
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            // Animasikan keluar
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            backdrop.classList.remove('bg-gray-900/70');
            backdrop.classList.add('bg-gray-900/60');
            content.classList.remove('scale-100', 'translate-y-0');
            content.classList.add('scale-95', 'translate-y-4');

            // Tunggu animasi selesai sebelum menyembunyikan
            setTimeout(() => {
                modal.classList.remove('pointer-events-auto');
                modal.classList.add('pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        // Fungsi format tanggal
        function formatTanggal(tanggal) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Date(tanggal).toLocaleDateString('id-ID', options);
        }

        // Fungsi untuk nonaktifkan user
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
                    // Buat form secara dinamis
                    const form = document.createElement('form');
                    form.id = 'nonaktifkan-user-' + userId;
                    form.method = 'POST';
                    form.action = url;
                    form.style.display = 'none';

                    // Tambahkan CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    // Tambahkan method spoofing untuk PUT
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);

                    // Submit form
                    form.submit();
                }
            });
        }

        // Tutup modal dengan ESC key
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
