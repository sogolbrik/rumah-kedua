@extends('layouts.frontend-main')

@section('title', 'Galeri')

@section('frontend-main')
    <div class="min-h-screen bg-gradient-to-br from-[#f9fafb] to-[#e5e7eb] py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <section class="relative pt-10 pb-16 px-4 md:px-6 lg:px-8 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center space-y-6 mb-12">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-neutral-900 leading-tight">
                        Galeri<span class="text-blue-600"> Kamar</span>
                    </h1>
                    <p class="text-lg md:text-xl text-neutral-600 max-w-2xl mx-auto leading-relaxed">
                        Jelajahi koleksi visual kamar eksklusif kami. Setiap sudut diabadikan untuk menampilkan kenyamanan dan keindahan yang telah kami sediakan.
                    </p>
                </div>
            </div>
        </section>

        <!-- Gallery Grid -->
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($galeri as $item)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden transform transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl group border border-white/20">
                        <div class="relative overflow-hidden">
                            <img src="{{ Storage::url($item->gambar) }}" alt="Galeri Kamar" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-500 text-lg">Tidak ada gambar galeri tersedia</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
