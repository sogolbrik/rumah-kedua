@extends('layouts.frontend-main')

@section('title', 'Galeri Eksklusif')

@section('frontend-main')
    <div x-data="{
        images: @js($galeri->map(fn($item) => ['src' => Storage::url($item->gambar)])),
        currentIndex: null,
        openLightbox(index) {
            this.currentIndex = index;
            document.body.style.overflow = 'hidden';
        },
        closeLightbox() {
            this.currentIndex = null;
            document.body.style.overflow = '';
        },
        next() { this.currentIndex = (this.currentIndex + 1) % this.images.length; },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length; }
    }" class="min-h-screen bg-[#fffffe] text-[#5f6c7b] selection:bg-[#3da9fc]/20 selection:text-[#094067]">

        <section class="relative pt-32 pb-20 overflow-hidden bg-[#fffffe]">
            <div class="absolute inset-0 z-0 opacity-30">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#90b4ce]/30 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[#3da9fc]/10 rounded-full blur-[120px]"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#90b4ce]/10 border border-[#90b4ce]/20 mb-6 transition-all hover:bg-[#90b4ce]/20 cursor-default">
                    <span class="w-2 h-2 rounded-full bg-[#ef4565] animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#094067]">Visual Experience</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-none mb-8 text-[#094067]">
                    Galeri <span class="text-[#90b4ce] font-light italic">Ruang</span>
                </h1>

                <div class="w-20 h-1.5 bg-[#3da9fc] mx-auto rounded-full mb-8 shadow-[0_40px_100px_rgba(61,169,252,0.4)]"></div>

                <p class="max-w-2xl mx-auto text-lg text-[#5f6c7b] font-medium leading-relaxed">
                    Setiap sudut dirancang dengan presisi. Jelajahi keindahan arsitektur dan detail interior melalui kurasi visual berkualitas tinggi.
                </p>
            </div>
        </section>

        <div class="h-24 bg-[#fffffe] flex items-center justify-center">
            <div class="w-[1px] h-full bg-[#90b4ce]/30"></div>
        </div>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-32">
            @if ($galeri->isNotEmpty())
                {{-- <div class="columns-1 sm:columns-2 lg:columns-3 gap-8 space-y-8"> --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($galeri as $index => $item)
                        <div @click="openLightbox({{ $index }})"
                            class="group relative break-inside-avoid rounded-[2.5rem] bg-[#fffffe] border border-[#90b4ce]/20 p-2.5 shadow-sm transition-all duration-500 hover:shadow-[0_32px_64px_-16px_rgba(9,64,103,0.15)] hover:-translate-y-2 cursor-pointer overflow-hidden">
                            <div class="relative overflow-hidden rounded-[2rem] aspect-[4/5] bg-[#094067]">
                                <img src="{{ Storage::url($item->gambar) }}" alt="Visual Detail"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110 group-hover:opacity-80">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#094067]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-8">
                                    <div
                                        class="px-6 py-2 rounded-full bg-[#fffffe]/20 backdrop-blur-md border border-[#fffffe]/30 text-[#fffffe] text-[10px] font-black uppercase tracking-[0.2em] transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                        View Details
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 border-2 border-dashed border-[#90b4ce]/30 rounded-[3rem]">
                    <div class="w-16 h-16 rounded-3xl bg-[#90b4ce]/10 flex items-center justify-center text-[#90b4ce] mb-6">
                        <i class="fa-solid fa-camera-retro text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-black text-[#90b4ce] uppercase tracking-widest">No Content Found</h3>
                </div>
            @endif
        </section>

        <div x-show="currentIndex !== null" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 backdrop-blur-0"
            x-transition:enter-end="opacity-100 backdrop-blur-xl" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 backdrop-blur-xl"
            x-transition:leave-end="opacity-0 backdrop-blur-0" class="fixed inset-0 z-[100] flex items-center justify-center bg-[#094067]/95" @keydown.escape.window="closeLightbox">

            <button @click="closeLightbox" class="absolute top-8 right-8 z-[110] group">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-[#fffffe]/40 uppercase tracking-[0.3em] group-hover:text-[#fffffe] transition-colors">Close</span>
                    <div
                        class="h-12 w-12 rounded-full bg-[#fffffe]/10 border border-[#fffffe]/20 flex items-center justify-center text-[#fffffe] transition-all group-hover:bg-[#3da9fc] group-hover:border-[#3da9fc]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </button>

            <div class="absolute inset-x-8 top-1/2 -translate-y-1/2 flex justify-between pointer-events-none">
                <button @click="prev"
                    class="pointer-events-auto h-16 w-16 rounded-2xl bg-[#fffffe]/5 border border-[#fffffe]/10 text-[#fffffe] flex items-center justify-center transition-all hover:bg-[#3da9fc] hover:border-[#3da9fc] hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next"
                    class="pointer-events-auto h-16 w-16 rounded-2xl bg-[#fffffe]/5 border border-[#fffffe]/10 text-[#fffffe] flex items-center justify-center transition-all hover:bg-[#3da9fc] hover:border-[#3da9fc] hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div x-show="currentIndex !== null" x-transition:enter="transition cubic-bezier(0.4, 0, 0.2, 1) duration-500 delay-100" x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative max-w-5xl w-full mx-6 lg:mx-auto shadow-[0_40px_100px_rgba(0,0,0,0.5)]">
                <img :src="images[currentIndex]?.src" alt="Cinema View" class="rounded-[2.5rem] w-full max-h-[80vh] object-contain bg-black/20" />

                <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 text-[#90b4ce] font-black text-[10px] tracking-[0.5em] uppercase">
                    <span class="text-[#3da9fc]" x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fffffe;
        }

        [x-cloak] {
            display: none !important;
        }

        .columns-1 {
            column-gap: 2rem;
        }

        @media (min-width: 640px) {
            .columns-2 {
                column-gap: 2rem;
            }
        }

        @media (min-width: 1024px) {
            .columns-3 {
                column-gap: 2rem;
            }
        }
    </style>
@endsection
