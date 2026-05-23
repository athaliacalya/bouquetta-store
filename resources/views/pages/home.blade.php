{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')

@section('title', 'A Digital Flower Boutique')

@section('content')

    {{-- Hero --}}
    <x-hero />

    {{-- Marquee strip --}}
    <div class="marquee-section overflow-hidden bg-terracotta py-6 whitespace-nowrap">
        <div class="marquee-track inline-flex" id="marqueeTrack">
            {{-- Populated by JS --}}
        </div>
    </div>

    {{-- Blooms Collection --}}
    <section class="py-20 px-12 bg-cream-light" id="blooms">
        <div class="flex items-end justify-between mb-12 flex-wrap gap-6">
            <div>
                <div class="section-tag">
                    <span class="inline-block w-10 h-px bg-terracotta/50"></span>
                    Our Flowers
                </div>
                <h2 class="section-title">
                    Pick your favourite<br>
                    <em class="italic text-terracotta">blooms</em>
                </h2>
            </div>
            <p class="section-desc max-w-[300px] text-sm">
                Each flower is hand-illustrated in watercolor & ink — organic, imperfect, and full of soul.
            </p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5" id="bloomsGrid">
            {{-- Populated by JS from flower data --}}
        </div>
    </section>

    {{-- Bouquet Builder --}}
    <x-bouquet-builder />

    {{-- Story / About --}}
    <section class="py-28 px-12 bg-cream-light grid grid-cols-1 lg:grid-cols-2 gap-20 items-center" id="story">

        {{-- Visual --}}
        <div class="relative h-[480px]">
            <div class="absolute top-0 left-0 w-[340px] h-[400px] rounded-[32px] overflow-hidden border border-sage/50"
                 style="background: linear-gradient(145deg, #FAD5DC, #F8C6A8);">
                <div class="flex items-center justify-center h-full">
                    <svg width="200" height="220" viewBox="0 0 200 220" fill="none">
                        <path d="M100 200 Q95 160 88 120" stroke="#9E9878" stroke-width="2" stroke-linecap="round"/>
                        <path d="M100 200 Q105 155 115 115" stroke="#9E9878" stroke-width="2" stroke-linecap="round"/>
                        <ellipse cx="90" cy="155" rx="14" ry="7" fill="#C8C2A3" transform="rotate(-30 90 155)"/>
                        <circle cx="100" cy="100" r="26" fill="#F4B6C2"/>
                        <circle cx="100" cy="100" r="18" fill="#F8C6A8"/>
                        <circle cx="100" cy="100" r="12" fill="#D85B34"/>
                        <circle cx="100" cy="100" r="6" fill="#F8C6A8"/>
                        <circle cx="68" cy="118" r="16" fill="#FAD5DC"/>
                        <circle cx="68" cy="118" r="9" fill="#F4B6C2"/>
                        <circle cx="68" cy="118" r="5" fill="#8A5B44"/>
                        <circle cx="134" cy="112" r="18" fill="#F8C6A8"/>
                        <circle cx="134" cy="112" r="11" fill="#F4B6C2"/>
                        <circle cx="134" cy="112" r="5" fill="#D85B34"/>
                    </svg>
                </div>
            </div>

            <div class="absolute bottom-0 right-0 w-[200px] h-[240px] rounded-[28px] overflow-hidden border border-sage/50"
                 style="background: linear-gradient(145deg, #F8C6A8, #C8C2A3);">
                <div class="flex items-center justify-center h-full">
                    <svg width="100" height="130" viewBox="0 0 100 130" fill="none">
                        <path d="M50 120 Q48 95 44 70" stroke="#9E9878" stroke-width="2"/>
                        <path d="M50 120 Q52 95 56 70" stroke="#9E9878" stroke-width="2"/>
                        <circle cx="50" cy="52" r="20" fill="#F4B6C2"/>
                        <circle cx="50" cy="52" r="14" fill="#F8C6A8"/>
                        <circle cx="50" cy="52" r="8" fill="#D85B34"/>
                    </svg>
                </div>
            </div>

            {{-- Sticker labels --}}
            <div class="absolute top-5 right-12 bg-white px-3 py-1.5 rounded-lg shadow-md font-hand text-brown-dark text-sm rotate-2 z-10">
                Made with love 🌸
            </div>
            <div class="absolute bottom-16 left-6 bg-white px-3 py-1.5 rounded-lg shadow-md font-hand text-brown-dark text-sm -rotate-3 z-10">
                Est. 2024 ✦
            </div>
        </div>

        {{-- Story text --}}
        <div>
            <div class="section-tag">
                <span class="inline-block w-10 h-px bg-terracotta/50"></span>
                Our Story
            </div>

            <p class="font-display text-3xl italic text-terracotta leading-snug mb-6">
                "We believe flowers deserve to be felt, not just seen."
            </p>

            <p class="text-[0.98rem] leading-[1.85] text-brown mb-4">
                Bouquetta was born from a sketchbook and a dream — a tiny studio where watercolors bled into paper and each petal was drawn twice, then painted over with light.
            </p>

            <p class="text-[0.98rem] leading-[1.85] text-brown mb-4">
                We wanted to build something that felt warm in your hands, even through a screen. A space where every bloom is intentional, every arrangement personal, and every bouquet is a tiny act of love.
            </p>

            {{-- Stats --}}
            <div class="flex gap-10 mt-8">
                @foreach([['11', 'Flower Varieties'], ['∞', 'Combinations'], ['100%', 'Handcrafted']] as $stat)
                    <div>
                        <div class="font-display text-[2.2rem] text-terracotta leading-none">{{ $stat[0] }}</div>
                        <div class="text-sage-dark text-[0.82rem] mt-1 tracking-wide">{{ $stat[1] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-24 px-12 bg-cream text-center">
        <div class="max-w-[500px] mx-auto mb-14">
            <div class="section-tag justify-center">
                <span class="inline-block w-10 h-px bg-terracotta/50"></span>
                Love Notes
                <span class="inline-block w-10 h-px bg-terracotta/50"></span>
            </div>
            <h2 class="section-title text-center">
                What our<br>
                <em class="italic text-terracotta">customers say</em>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-[1000px] mx-auto" id="testimonialsGrid">
            @foreach($testimonials as $t)
                <div class="bg-white border border-sage/30 rounded-3xl p-8 text-left hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="text-terracotta text-base tracking-widest mb-4">★★★★★</div>
                    <p class="font-hand text-[1.05rem] leading-relaxed text-brown mb-5">"{{ $t['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xl"
                             style="background: {{ $t['bg'] }}">🌸</div>
                        <div>
                            <div class="font-body text-[0.85rem] font-semibold text-brown-dark">{{ $t['author'] }}</div>
                            <div class="text-sage-dark text-[0.75rem]">{{ $t['city'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection