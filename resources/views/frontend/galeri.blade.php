@extends('layouts.frontend-main')

@section('title', 'Galeri')

@section('frontend-main')
    <div x-data="{
        images: @js($galeri->map(fn($item) => ['src' => Storage::url($item->gambar)])),
        currentIndex: null,
        openLightbox(index) { this.currentIndex = index;
            document.body.style.overflow = 'hidden'; },
        closeLightbox() { this.currentIndex = null;
            document.body.style.overflow = ''; },
        next() { this.currentIndex = (this.currentIndex + 1) % this.images.length; },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length; }
    }" class="min-h-screen bg-gradient-to-br from-[#f9fafb] to-[#e5e7eb] py-12 px-4 sm:px-6 lg:px-8">
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
            @if ($galeri->isNotEmpty())
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach ($galeri as $index => $item)
                        <div class="group relative break-inside-avoid rounded-2xl overflow-hidden shadow-lg bg-white/80 backdrop-blur-sm border border-white/20 cursor-pointer transform transition duration-500 hover:shadow-2xl hover:-translate-y-1"
                            @click="openLightbox({{ $index }})">
                            <div class="relative pb-[75%] w-full overflow-hidden">
                                <img src="{{ Storage::url($item->gambar) }}" alt="Galeri Kamar" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <span class="text-white text-sm font-medium backdrop-blur-sm bg-black/20 px-3 py-1 rounded-full">Lihat</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="text-gray-500 text-lg">Tidak ada gambar galeri tersedia</div>
                </div>
            @endif
        </div>

        <!-- Lightbox -->
        <div x-show="currentIndex !== null" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm" @keydown.escape.window="closeLightbox" @click.self="closeLightbox">
            <button @click="closeLightbox" class="absolute top-6 right-6 text-white bg-black/30 hover:bg-black/50 rounded-full p-2 transition" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <button @click="prev" class="absolute left-4 text-white bg-black/30 hover:bg-black/50 rounded-full p-3 transition" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button @click="next" class="absolute right-4 text-white bg-black/30 hover:bg-black/50 rounded-full p-3 transition" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="max-w-4xl max-h-[90vh] overflow-hidden rounded-xl">
                <img x-show="currentIndex !== null" x-transition x-src="images[currentIndex]?.src" :src="images[currentIndex]?.src" alt="Galeri Lightbox" class="max-h-[90vh] w-auto object-contain" />
            </div>
        </div>
    </div>
@endsection
