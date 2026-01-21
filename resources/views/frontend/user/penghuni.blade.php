@extends('layouts.frontend-main')
@section('title', 'Dashboard Penghuni - RumahKedua')

@section('frontend-main')
    <div x-data="{
        openContact: false,
        openProfile: false,
        detailModal: false
    }" class="min-h-screen pt-28 pb-20 relative bg-[#fffffe]">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#3da9fc]/10 rounded-full blur-[120px] -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#90b4ce]/10 rounded-full blur-[100px] -ml-24 -mb-24"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <nav class="flex items-center gap-2 text-sm font-medium" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard-penghuni') }}" class="text-[#5f6c7b] hover:text-[#3da9fc] transition-colors">Workspace</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-[#90b4ce]"></i>
                    <span class="text-[#094067] font-bold tracking-tight">Resident Dashboard</span>
                </nav>
                <div class="flex items-center gap-3 text-xs font-mono text-[#5f6c7b] bg-white px-3 py-1.5 rounded-full border border-[#90b4ce] shadow-sm">
                    <span class="w-2 h-2 bg-[#3da9fc] rounded-full animate-pulse"></span>
                    LAST SYNC: {{ now()->format('H:i') }} WIB
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12 animate-fade-in-up">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-tr from-[#094067] to-[#3da9fc] rounded-[2rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="relative w-20 h-20 rounded-[1.8rem] object-cover border-4 border-white shadow-xl">
                        @else
                            <div class="relative w-20 h-20 rounded-[1.8rem] bg-[#094067] flex items-center justify-center text-[#fffffe] font-black text-2xl border-4 border-white shadow-xl">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-[#3da9fc] border-4 border-[#fffffe] rounded-full"></div>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black text-[#094067] tracking-tighter">
                            Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#094067] to-[#3da9fc]">{{ explode(' ', $user->name)[0] }}</span>!
                        </h1>
                        <p class="text-[#5f6c7b] font-medium mt-1">Kelola hunian dan pantau transaksi Anda dengan mudah.</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('pengumuman-penghuni') }}"
                        class="flex items-center gap-3 px-6 py-3 bg-[#fffffe] border border-[#90b4ce]/50 text-[#094067] rounded-2xl hover:border-[#3da9fc] hover:bg-[#3da9fc]/5 hover:shadow-md transition-all duration-300 font-bold text-sm group">
                        <div class="relative">
                            <i class="fa-solid fa-bullhorn text-[#3da9fc] group-hover:scale-110 transition-transform"></i>
                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-[#ef4565] rounded-full border-2 border-[#fffffe]"></span>
                        </div>
                        Pengumuman
                    </a>

                    <div class="relative">
                        <button @click="openProfile = !openProfile"
                            class="flex items-center gap-3 px-6 py-3 bg-[#fffffe] border border-[#90b4ce] text-[#094067] rounded-2xl hover:border-[#3da9fc] hover:shadow-lg transition-all duration-300 font-bold text-sm">
                            <i class="fa-solid fa-user-gear text-[#3da9fc]"></i>
                            Settings
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="openProfile ? 'rotate-180' : ''"></i>
                        </button>
                        <template x-teleport="body">
                            <div x-cloak x-show="openProfile" @click.outside="openProfile = false" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="fixed top-[120px] right-[calc((100vw-1280px)/2+1rem)] 
                                w-56 bg-white rounded-2xl shadow-2xl border border-[#90b4ce]/30 
                                py-2 z-[9999] overflow-hidden origin-top-right">
                                <a href="{{ route('profil-penghuni.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-[#5f6c7b] hover:bg-[#3da9fc]/10 hover:text-[#094067] transition-colors">
                                    <i class="fa-solid fa-circle-user opacity-50 text-[#3da9fc]"></i> Edit Profile
                                </a>

                                <div class="h-px bg-[#90b4ce]/20 my-1 mx-4"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-[#ef4565] hover:bg-[#ef4565]/10 transition-colors">
                                        <i class="fa-solid fa-power-off opacity-50"></i> Secure Logout
                                    </button>
                                </form>
                            </div>
                        </template>
                    </div>

                    <button @click="openContact = true"
                        class="group flex items-center gap-3 px-6 py-3 bg-[#3da9fc] text-[#fffffe] rounded-2xl shadow-xl shadow-[#3da9fc]/20 hover:bg-[#094067] hover:-translate-y-1 transition-all duration-300 font-bold text-sm">
                        <i class="fa-solid fa-headset group-hover:rotate-12 transition-transform"></i>
                        Support Center
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">

                <div class="lg:col-span-8 group">
                    <div
                        class="relative bg-[#fffffe] rounded-[2.5rem] border border-[#90b4ce] shadow-sm overflow-hidden h-full flex flex-col md:flex-row transition-all duration-500 hover:shadow-2xl hover:border-[#3da9fc]">
                        @if ($user->kamar)
                            <div class="md:w-2/5 relative overflow-hidden">
                                <img src="{{ Storage::url($user->kamar->gambar) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#094067]/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6">
                                    <span class="px-4 py-1.5 bg-[#3da9fc] text-[#fffffe] text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                        {{ $user->kamar->tipe }}
                                    </span>
                                </div>
                            </div>
                            <div class="md:w-3/5 p-8 md:p-10 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-4">
                                    <h2 class="text-4xl font-black text-[#094067] tracking-tighter">{{ $user->kamar->kode_kamar }}</h2>
                                    <div class="px-4 py-1.5 bg-[#3da9fc]/10 text-[#3da9fc] rounded-full text-xs font-bold border border-[#3da9fc]/20 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-[#3da9fc] rounded-full"></span> Active Unit
                                    </div>
                                </div>
                                <p class="text-[#5f6c7b] leading-relaxed text-sm mb-8 italic">"{{ Str::limit($user->kamar->deskripsi, 140) }}"</p>

                                <div class="grid grid-cols-2 gap-6 pt-6 border-t border-[#90b4ce]/20">
                                    <div>
                                        <p class="text-[10px] font-black text-[#90b4ce] uppercase tracking-widest mb-1">Monthly Rent</p>
                                        <p class="text-xl font-black text-[#094067]">Rp {{ number_format($user->kamar->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-[#90b4ce] uppercase tracking-widest mb-1">Billing Cycle</p>
                                        <p class="text-sm font-bold text-[#5f6c7b]">Setiap Jatuh Tempo</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full py-16 text-center space-y-6">
                                <div class="w-20 h-20 bg-[#fffffe] rounded-[2rem] flex items-center justify-center mx-auto border border-[#90b4ce]">
                                    <i class="fa-solid fa-door-open text-3xl text-[#90b4ce]"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-[#094067]">Unit Belum Terdaftar</h3>
                                    <p class="text-[#5f6c7b] max-w-xs mx-auto mt-2">Segera pilih unit kamar impian Anda untuk menikmati fasilitas premium kami.</p>
                                </div>
                                <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-[#3da9fc] text-[#fffffe] rounded-2xl font-bold hover:bg-[#094067] transition-all">
                                    Eksplorasi Unit <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-4 grid grid-cols-1 gap-6">
                    <div class="bg-[#094067] rounded-[2rem] p-8 relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#3da9fc]/20 rounded-full blur-2xl group-hover:bg-[#3da9fc]/30 transition-all"></div>
                        <i class="fa-solid fa-wallet text-[#3da9fc] text-xl mb-4"></i>
                        <h4 class="text-[#90b4ce] text-xs font-black uppercase tracking-widest mb-1">Total Investasi</h4>
                        <p class="text-2xl font-black text-[#fffffe] tracking-tight">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-[10px] text-[#3da9fc] font-bold bg-[#3da9fc]/10 px-2 py-0.5 rounded-md">
                                <i class="fa-solid fa-check-double mr-1"></i> Verified
                            </span>
                        </div>
                    </div>

                    <div class="bg-[#fffffe] rounded-[2rem] p-8 border border-[#90b4ce] shadow-sm hover:shadow-xl transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-[#fffffe] rounded-2xl flex items-center justify-center text-[#094067] border border-[#90b4ce]">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $menunggak ? 'bg-[#ef4565]/10 text-[#ef4565] border border-[#ef4565]/20' : 'bg-[#3da9fc]/10 text-[#3da9fc] border border-[#3da9fc]/20' }}">
                                {{ $menunggak ? 'Outstanding' : 'Cleared' }}
                            </span>
                        </div>
                        <h4 class="text-[#5f6c7b] text-[10px] font-black uppercase tracking-widest mb-1">Status Pembayaran</h4>
                        <p class="text-xl font-black text-[#094067]">{{ $menunggak ? 'Ada Tunggakan' : 'Lunas & Aman' }}</p>
                        <p class="text-xs text-[#5f6c7b] mt-2 italic">Update: {{ $terakhirBayar?->translatedFormat('d M Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if ($menunggak)
                <div class="mb-12 relative group animate-bounce-slow">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#ef4565] to-[#ef4565]/50 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-white border border-[#ef4565]/30 p-6 md:p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-[#ef4565]/10 rounded-2xl flex items-center justify-center text-[#ef4565] text-2xl shadow-inner">
                                <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-[#094067] tracking-tight">Perhatian: Tagihan Tertunggak</h3>
                                <p class="text-[#5f6c7b] text-sm">Selesaikan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda administratif.</p>
                            </div>
                        </div>
                        <a href="{{ route('penghuni.pembayaran') }}"
                            class="w-full md:w-auto px-10 py-4 bg-[#ef4565] text-[#fffffe] rounded-2xl font-black text-sm shadow-xl shadow-[#ef4565]/20 hover:bg-[#094067] hover:-translate-y-1 transition-all">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] border border-[#90b4ce] shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-[#90b4ce]/10 flex flex-col md:flex-row justify-between items-center gap-4 bg-[#90b4ce]/5">
                    <div>
                        <h3 class="text-xl font-black text-[#094067] tracking-tight">Ledger Transaksi</h3>
                        <p class="text-[#5f6c7b] text-xs font-medium mt-1 uppercase tracking-widest">Transaction History & Invoices</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-[#5f6c7b]">Total: {{ $totalTransaksi }} Records</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-white text-[#5f6c7b] border-b border-[#90b4ce]/10">
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Reference</th>
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Issued Date</th>
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Method</th>
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Status</th>
                                <th class="px-8 py-5 text-right font-black uppercase tracking-widest text-[10px]">Amount</th>
                                <th class="px-8 py-5 text-center font-black uppercase tracking-widest text-[10px]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#90b4ce]/10">
                            @forelse($transaksis as $trx)
                                <tr class="hover:bg-[#3da9fc]/5 transition-colors group">
                                    <td class="px-8 py-6">
                                        <span class="font-mono font-bold text-[#3da9fc]">#{{ $trx->kode }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-[#5f6c7b] font-medium">
                                        {{ $trx->tanggal_pembayaran?->format('d M, Y') ?? '—' }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 bg-[#90b4ce] rounded-full"></div>
                                            @php
                                                if ($trx->metode_pembayaran == 'cash') {
                                                    $metode = 'Cash';
                                                } elseif ($trx->metode_pembayaran == 'midtrans') {
                                                    $metode = $trx->midtrans_payment_type ?? 'Online';
                                                } else {
                                                    $metode = '-';
                                                }
                                            @endphp
                                            <span class="capitalize text-[#094067] font-bold tracking-tight text-xs">{{ $metode }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @php
                                            $statusClasses = [
                                                'paid' => 'bg-[#3da9fc]/10 text-[#3da9fc] border-[#3da9fc]/20',
                                                'pending' => 'bg-[#90b4ce]/10 text-[#094067] border-[#90b4ce]/20',
                                                'failed' => 'bg-[#ef4565]/10 text-[#ef4565] border-[#ef4565]/20',
                                                'cancelled' => 'bg-[#5f6c7b]/10 text-[#5f6c7b] border-[#5f6c7b]/20',
                                                'expired' => 'bg-[#ef4565]/10 text-[#ef4565] border-[#ef4565]/20',
                                            ];
                                            $currentClass = $statusClasses[$trx->status_pembayaran] ?? 'bg-[#90b4ce]/10 text-[#5f6c7b] border-[#90b4ce]/20';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg border {{ $currentClass }} font-black text-[10px] uppercase">
                                            {{ $trx->status_pembayaran }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="font-black text-[#094067]">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <a href="{{ route('user.pembayaran.invoice', $trx->id) }}"
                                            class="inline-flex items-center justify-center w-10 h-10 bg-white border border-[#90b4ce] text-[#90b4ce] rounded-xl hover:text-[#3da9fc] hover:border-[#3da9fc] hover:shadow-md transition-all">
                                            <i class="fa-solid fa-file-invoice text-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="text-[#90b4ce] mb-4 text-4xl"><i class="fa-solid fa-box-open"></i></div>
                                        <p class="text-[#5f6c7b] font-bold">Belum ada riwayat transaksi tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-10 py-6 bg-[#90b4ce]/5 border-t border-[#90b4ce]/10">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>

        <div x-show="openContact" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="openContact" @click="openContact = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="absolute inset-0 bg-[#094067]/40 backdrop-blur-md"></div>

            <div x-show="openContact" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative bg-[#fffffe] rounded-[3rem] shadow-2xl max-w-lg w-full overflow-hidden border border-[#90b4ce]/20">
                <div class="bg-[#094067] p-10 text-[#fffffe] relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#3da9fc]/20 rounded-full blur-3xl"></div>
                    <h3 class="text-3xl font-black tracking-tight mb-2">Concierge Support</h3>
                    <p class="text-[#90b4ce] text-sm">Tim kami siap membantu kendala teknis maupun administratif Anda.</p>
                </div>
                <div class="p-10 space-y-4">
                    @foreach ([['icon' => 'fa-brands fa-whatsapp', 'color' => 'text-[#3da9fc]', 'bg' => 'bg-[#3da9fc]/10', 'label' => 'WhatsApp Support', 'value' => '+' . $pengaturan->no_telepon ?? '6285870327957', 'link' => 'https://wa.me/' . $pengaturan->no_telepon ?? '6285870327957'], ['icon' => 'fa-envelope', 'color' => 'text-[#3da9fc]', 'bg' => 'bg-[#3da9fc]/10', 'label' => 'Official Email', 'value' => $pengaturan->email ?? 'official@rumahkedua.id', 'link' => 'mailto:' . ($pengaturan->email ?? 'official@rumahkedua.id')]] as $item)
                        <a href="{{ $item['link'] }}" class="flex items-center gap-5 p-4 rounded-2xl border border-[#90b4ce]/20 hover:border-[#3da9fc] hover:bg-[#3da9fc]/5 transition-all group">
                            <div class="w-12 h-12 {{ $item['bg'] }} {{ $item['color'] }} rounded-xl flex items-center justify-center text-xl shadow-sm">
                                <i class="fa {{ $item['icon'] }}"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-[#90b4ce] uppercase tracking-widest">{{ $item['label'] }}</p>
                                <p class="text-[#094067] font-bold">{{ $item['value'] }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-[#90b4ce] group-hover:text-[#3da9fc] transition-colors"></i>
                        </a>
                    @endforeach
                    <button @click="openContact = false" class="w-full mt-6 py-4 bg-[#90b4ce]/10 text-[#094067] rounded-2xl font-black text-sm hover:bg-[#90b4ce]/20 transition-colors">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>

    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #5f6c7b;
        }

        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 4s ease-in-out infinite;
        }
    </style>
@endsection
