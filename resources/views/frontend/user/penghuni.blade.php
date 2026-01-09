@extends('layouts.frontend-main')
@section('title', 'Dashboard Penghuni - RumahKedua')

@section('frontend-main')
    <div x-data="{
        openContact: false,
        openProfile: false,
        detailModal: false
    }" class="min-h-screen pt-28 pb-20 relative bg-[#f8fafc]">

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-100/40 rounded-full blur-[120px] -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-100/30 rounded-full blur-[100px] -ml-24 -mb-24"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <nav class="flex items-center gap-2 text-sm font-medium" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard-penghuni') }}" class="text-slate-400 hover:text-blue-600 transition-colors">Workspace</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300"></i>
                    <span class="text-slate-900 font-bold tracking-tight">Resident Dashboard</span>
                </nav>
                <div class="flex items-center gap-3 text-xs font-mono text-slate-400 bg-white px-3 py-1.5 rounded-full border border-slate-200 shadow-sm">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    LAST SYNC: {{ now()->format('H:i') }} WIB
                </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12 animate-fade-in-up">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-[2rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="relative w-20 h-20 rounded-[1.8rem] object-cover border-4 border-white shadow-xl">
                        @else
                            <div class="relative w-20 h-20 rounded-[1.8rem] bg-slate-900 flex items-center justify-center text-white font-black text-2xl border-4 border-white shadow-xl">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 border-4 border-[#f8fafc] rounded-full"></div>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tighter">
                            Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">{{ explode(' ', $user->name)[0] }}</span>!
                        </h1>
                        <p class="text-slate-500 font-medium mt-1">Kelola hunian dan pantau transaksi Anda dengan mudah.</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <div class="relative">
                        <button @click="openProfile = !openProfile"
                            class="flex items-center gap-3 px-6 py-3 bg-white border border-slate-200 text-slate-700 rounded-2xl hover:border-blue-300 hover:shadow-lg transition-all duration-300 font-bold text-sm">
                            <i class="fa-solid fa-user-gear text-blue-500"></i>
                            Settings
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="openProfile ? 'rotate-180' : ''"></i>
                        </button>
                        <template x-teleport="body">
                            <div x-cloak x-show="openProfile" @click.outside="openProfile = false" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="fixed top-[120px] right-[calc((100vw-1280px)/2+1rem)] 
                                w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 
                                py-2 z-[9999] overflow-hidden origin-top-right">
                                <a href="{{ route('profil-penghuni.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-600 hover:bg-slate-50 hover:text-blue-600 transition-colors">
                                    <i class="fa-solid fa-circle-user opacity-50"></i> Edit Profile
                                </a>

                                <div class="h-px bg-slate-100 my-1 mx-4"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-rose-500 hover:bg-rose-50 transition-colors">
                                        <i class="fa-solid fa-power-off opacity-50"></i> Secure Logout
                                    </button>
                                </form>
                            </div>
                        </template>


                    </div>

                    <button @click="openContact = true"
                        class="group flex items-center gap-3 px-6 py-3 bg-slate-900 text-white rounded-2xl shadow-xl shadow-slate-200 hover:bg-blue-600 hover:-translate-y-1 transition-all duration-300 font-bold text-sm">
                        <i class="fa-solid fa-headset group-hover:rotate-12 transition-transform"></i>
                        Support Center
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">

                <div class="lg:col-span-8 group">
                    <div
                        class="relative bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden h-full flex flex-col md:flex-row transition-all duration-500 hover:shadow-2xl hover:border-blue-100">
                        @if ($user->kamar)
                            <div class="md:w-2/5 relative overflow-hidden">
                                <img src="{{ Storage::url($user->kamar->gambar) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6">
                                    <span class="px-4 py-1.5 bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                        {{ $user->kamar->tipe }}
                                    </span>
                                </div>
                            </div>
                            <div class="md:w-3/5 p-8 md:p-10 flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-4">
                                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $user->kamar->kode_kamar }}</h2>
                                    <div class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-xs font-bold border border-emerald-100 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Active Unit
                                    </div>
                                </div>
                                <p class="text-slate-500 leading-relaxed text-sm mb-8 italic">"{{ Str::limit($user->kamar->deskripsi, 140) }}"</p>

                                <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Monthly Rent</p>
                                        <p class="text-xl font-black text-slate-900">Rp {{ number_format($user->kamar->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Billing Cycle</p>
                                        <p class="text-sm font-bold text-slate-700">Setiap Jatuh Tempo Anda</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full py-16 text-center space-y-6">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto border border-slate-100">
                                    <i class="fa-solid fa-door-open text-3xl text-slate-300"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900">Unit Belum Terdaftar</h3>
                                    <p class="text-slate-500 max-w-xs mx-auto mt-2">Segera pilih unit kamar impian Anda untuk menikmati fasilitas premium kami.</p>
                                </div>
                                <a href="{{ route('booking') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 text-white rounded-2xl font-bold hover:bg-slate-900 transition-all">
                                    Eksplorasi Unit <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-4 grid grid-cols-1 gap-6">
                    <div class="bg-slate-900 rounded-[2rem] p-8 relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all"></div>
                        <i class="fa-solid fa-wallet text-blue-400 text-xl mb-4"></i>
                        <h4 class="text-slate-400 text-xs font-black uppercase tracking-widest mb-1">Total Investasi Hunian</h4>
                        <p class="text-2xl font-black text-white tracking-tight">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
                        <div class="mt-4 flex items-center gap-2">
                            <span class="text-[10px] text-emerald-400 font-bold bg-emerald-400/10 px-2 py-0.5 rounded-md">
                                <i class="fa-solid fa-check-double mr-1"></i> Verified
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm hover:shadow-xl transition-all">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-900 border border-slate-100">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $menunggak ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                {{ $menunggak ? 'Outstanding' : 'Cleared' }}
                            </span>
                        </div>
                        <h4 class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Status Pembayaran</h4>
                        <p class="text-xl font-black text-slate-900">{{ $menunggak ? 'Ada Tunggakan' : 'Lunas & Aman' }}</p>
                        <p class="text-xs text-slate-400 mt-2 italic">Update terakhir: {{ $terakhirBayar?->translatedFormat('d M Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if ($menunggak)
                <div class="mb-12 relative group animate-bounce-slow">
                    <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-orange-500 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative bg-white border border-rose-100 p-6 md:p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 text-2xl shadow-inner">
                                <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">Perhatian: Tagihan Tertunggak</h3>
                                <p class="text-slate-500 text-sm">Selesaikan pembayaran sebelum tanggal jatuh tempo untuk menghindari denda administratif.</p>
                            </div>
                        </div>
                        <a href="{{ route('penghuni.pembayaran') }}"
                            class="w-full md:w-auto px-10 py-4 bg-rose-600 text-white rounded-2xl font-black text-sm shadow-xl shadow-rose-200 hover:bg-slate-900 hover:-translate-y-1 transition-all">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
                    <div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Ledger Transaksi</h3>
                        <p class="text-slate-500 text-xs font-medium mt-1 uppercase tracking-widest">Transaction History & Invoices</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-400">Total: {{ $totalTransaksi }} Records</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-white text-slate-400 border-b border-slate-100">
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Reference</th>
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Issued Date</th>
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Method</th>
                                <th class="px-8 py-5 text-left font-black uppercase tracking-widest text-[10px]">Status</th>
                                <th class="px-8 py-5 text-right font-black uppercase tracking-widest text-[10px]">Amount</th>
                                <th class="px-8 py-5 text-center font-black uppercase tracking-widest text-[10px]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($transaksis as $trx)
                                <tr class="hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-8 py-6">
                                        <span class="font-mono font-bold text-blue-600">#{{ $trx->kode }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-slate-600 font-medium">
                                        {{ $trx->tanggal_pembayaran?->format('d M, Y') ?? '—' }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 bg-slate-300 rounded-full"></div>
                                            <span class="capitalize text-slate-700 font-bold tracking-tight text-xs">{{ $trx->midtrans_payment_type ?? 'Cash' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @php
                                            $statusClasses = [
                                                'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'failed' => 'bg-rose-50 text-rose-600 border-rose-100',
                                                'cancelled' => 'bg-slate-50 text-slate-600 border-slate-200',
                                                'expired' => 'bg-orange-50 text-orange-600 border-orange-200',
                                            ];
                                            $currentClass = $statusClasses[$trx->status_pembayaran] ?? 'bg-gray-50 text-gray-600 border-gray-200';
                                            $labelMap = [
                                                'paid' => 'Settled',
                                                'pending' => 'Pending',
                                                'failed' => 'Failed',
                                                'cancelled' => 'Cancelled',
                                                'expired' => 'Expired',
                                            ];
                                            $displayLabel = $labelMap[$trx->status_pembayaran] ?? ucfirst($trx->status_pembayaran);
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg border {{ $currentClass }} font-black text-[10px] uppercase">
                                            {{ $displayLabel }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <span class="font-black text-slate-900">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <a href="{{ route('user.pembayaran.invoice', $trx->id) }}"
                                            class="inline-flex items-center justify-center w-10 h-10 bg-white border border-slate-200 text-slate-400 rounded-xl hover:text-blue-600 hover:border-blue-200 hover:shadow-md transition-all">
                                            <i class="fa-solid fa-file-invoice text-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="text-slate-300 mb-4 text-4xl"><i class="fa-solid fa-box-open"></i></div>
                                        <p class="text-slate-500 font-bold">Belum ada riwayat transaksi tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-10 py-6 bg-slate-50/50 border-t border-slate-100">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>

        <div x-show="openContact" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="openContact" @click="openContact = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="absolute inset-0 bg-slate-900/40 backdrop-blur-md"></div>

            <div x-show="openContact" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative bg-white rounded-[3rem] shadow-2xl max-w-lg w-full overflow-hidden border border-white/20">
                <div class="bg-slate-900 p-10 text-white relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl"></div>
                    <h3 class="text-3xl font-black tracking-tight mb-2">Concierge Support</h3>
                    <p class="text-slate-400 text-sm">Tim kami siap membantu kendala teknis maupun administratif Anda.</p>
                </div>
                <div class="p-10 space-y-4">
                    @foreach ([['icon' => 'fa-brands fa-whatsapp', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50', 'label' => 'WhatsApp Support', 'value' => '+62 858-7032-7957', 'link' => 'https://wa.me/6285870327957'], ['icon' => 'fa-envelope', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50', 'label' => 'Official Email', 'value' => 'care@rumahkedua.id', 'link' => 'mailto:rumahkedua@gmail.com'], ['icon' => 'fa-clock', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50', 'label' => 'Service Hours', 'value' => 'Mon - Sat, 08:00 - 20:00', 'link' => '#']] as $item)
                        <a href="{{ $item['link'] }}" class="flex items-center gap-5 p-4 rounded-2xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all group">
                            <div class="w-12 h-12 {{ $item['bg'] }} {{ $item['color'] }} rounded-xl flex items-center justify-center text-xl shadow-sm">
                                <i class="fa {{ $item['icon'] }} {{ strpos($item['icon'], 'fa-') === 0 ? '' : 'fa-solid' }}"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $item['label'] }}</p>
                                <p class="text-slate-900 font-bold">{{ $item['value'] }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-slate-300 group-hover:text-blue-500 transition-colors"></i>
                        </a>
                    @endforeach
                    <button @click="openContact = false" class="w-full mt-6 py-4 bg-slate-100 text-slate-600 rounded-2xl font-black text-sm hover:bg-slate-200 transition-colors">
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
