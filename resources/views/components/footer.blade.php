{{-- resources/views/components/footer.blade.php --}}
<footer class="bg-brown-dark text-cream pt-20 pb-8 px-12 relative overflow-hidden">

    {{-- Cream arch at top --}}
    <div class="absolute top-0 left-0 right-0 h-48 bg-cream pointer-events-none"
         style="clip-path: ellipse(80% 100% at 50% 0%);"></div>

    <div class="relative z-10">
        {{-- Footer top grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-12 border-b border-cream/15 mb-8">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="footer-logo flex items-center font-serif text-2xl font-bold text-cream no-underline mb-4">
                    B
                    <x-logo-flower class="w-6 h-6 mx-0.5" color="light" />
                    uquetta
                </a>
                <p class="text-cream/70 text-sm leading-relaxed max-w-xs">
                    A digital flower boutique where every petal is painted with love. Build your dream bouquet and share it with someone special.
                </p>
            </div>

            {{-- Flowers --}}
            <div>
                <h4 class="font-heading text-sm font-semibold tracking-widest uppercase mb-5 text-pink-light">
                    Flowers
                </h4>
                <ul class="space-y-2.5">
                    @foreach(['Roses', 'Peonies', 'Daisies', 'Marigolds', 'All Blooms'] as $flower)
                        <li>
                            <a href="#blooms" class="text-cream/65 text-sm hover:text-pink-light transition-colors">
                                {{ $flower }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Studio --}}
            <div>
                <h4 class="font-heading text-sm font-semibold tracking-widest uppercase mb-5 text-pink-light">
                    Studio
                </h4>
                <ul class="space-y-2.5">
                    @foreach(['Our Story', 'The Artist', 'Process', 'Contact'] as $link)
                        <li>
                            <a href="#story" class="text-cream/65 text-sm hover:text-pink-light transition-colors">
                                {{ $link }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Footer bottom --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <span class="font-hand text-xl text-cream/40">With love, Bouquetta 🌸</span>
            <span class="text-cream/40 text-xs">
                © {{ date('Y') }} Bouquetta Studio — All rights reserved
            </span>
        </div>
    </div>
</footer>