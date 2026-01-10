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
    }" class="min-h-screen bg-[#f8fafc] text-slate-900 selection:bg-blue-100 selection:text-blue-700">

        <section class="relative pt-27 pb-20 overflow-hidden bg-white">
            <div class="absolute inset-0 z-0 opacity-40">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-100 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-slate-100 rounded-full blur-[120px]"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 mb-6 transition-all hover:bg-slate-200/50 cursor-default">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Visual Experience</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-none mb-8">
                    Galeri <span class="text-slate-400 font-light italic">Ruang</span>
                </h1>

                <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full mb-8 shadow-[0_0_15px_rgba(37,99,235,0.4)]"></div>

                <p class="max-w-2xl mx-auto text-lg text-slate-500 font-medium leading-relaxed">
                    Setiap sudut dirancang dengan presisi. Jelajahi keindahan arsitektur dan detail interior melalui kurasi visual berkualitas tinggi.
                </p>
            </div>
        </section>

        <div class="h-24 bg-gradient-to-b from-white to-[#f8fafc] flex items-center justify-center">
            <div class="w-[1px] h-full bg-slate-200/60"></div>
        </div>

        <section class="max-w-7xl mx-auto px-6 lg:px-8 pb-32">
            @if ($galeri->isNotEmpty())
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-8 space-y-8">
                    @foreach ($galeri as $index => $item)
                        <div @click="openLightbox({{ $index }})"
                            class="group relative break-inside-avoid rounded-[2.5rem] bg-white border border-slate-200/60 p-2.5 shadow-sm transition-all duration-500 hover:shadow-[0_32px_64px_-16px_rgba(0,0,0,0.08)] hover:-translate-y-2 cursor-pointer overflow-hidden">
                            <div class="relative overflow-hidden rounded-[2rem] aspect-[4/5]">
                                <img src="{{ Storage::url($item->gambar) }}" alt="Visual Detail"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-center pb-8">
                                    <div
                                        class="px-6 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-[10px] font-black uppercase tracking-[0.2em] transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                        View Details
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 border-2 border-dashed border-slate-200 rounded-[3rem]">
                    <div class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center text-slate-300 mb-6">
                        <i class="fa-solid fa-camera-retro text-2xl"></i>
                    </div>
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">No Content Found</h3>
                </div>
            @endif
        </section>

        <div x-show="currentIndex !== null" x-cloak x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 backdrop-blur-0"
            x-transition:enter-end="opacity-100 backdrop-blur-xl" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 backdrop-blur-xl"
            x-transition:leave-end="opacity-0 backdrop-blur-0" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/90" @keydown.escape.window="closeLightbox">
            <button @click="closeLightbox" class="absolute top-8 right-8 z-[110] group">
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black text-white/40 uppercase tracking-[0.3em] group-hover:text-white transition-colors">Close</span>
                    <div class="h-12 w-12 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white transition-all group-hover:bg-white group-hover:text-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </button>

            <div class="absolute inset-x-8 top-1/2 -translate-y-1/2 flex justify-between pointer-events-none">
                <button @click="prev"
                    class="pointer-events-auto h-16 w-16 rounded-2xl bg-white/5 border border-white/10 text-white flex items-center justify-center transition-all hover:bg-white hover:text-slate-900 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button @click="next"
                    class="pointer-events-auto h-16 w-16 rounded-2xl bg-white/5 border border-white/10 text-white flex items-center justify-center transition-all hover:bg-white hover:text-slate-900 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div x-show="currentIndex !== null" x-transition:enter="transition cubic-bezier(0.4, 0, 0.2, 1) duration-500 delay-100" x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="relative max-w-5xl w-full mx-6 lg:mx-auto shadow-[0_40px_100px_rgba(0,0,0,0.5)]">
                <img :src="images[currentIndex]?.src" alt="Cinema View" class="rounded-[2.5rem] w-full max-h-[80vh] object-contain bg-black/20" />

                <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 text-white/40 font-black text-[10px] tracking-[0.5em] uppercase">
                    <span class="text-white" x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Engineered Spacing & Ritme Scroll */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Masonry behavior tweak for smoother columns */
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
