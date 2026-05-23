{{-- resources/views/components/bouquet-builder.blade.php --}}
<section class="builder py-24 px-12 bg-cream relative" id="builder">

    {{-- Top divider --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-sage to-transparent"></div>

    {{-- Section header --}}
    <div class="text-center mb-14">
        <div class="section-tag justify-center">
            <span class="inline-block w-10 h-px bg-terracotta/50"></span>
            Interactive Builder
            <span class="inline-block w-10 h-px bg-terracotta/50"></span>
        </div>
        <h2 class="section-title text-center">
            Compose your<br>
            <em class="italic text-terracotta">perfect bouquet</em>
        </h2>
        <p class="section-desc mx-auto text-center mt-2">
            Click any flower below to add it to your bouquet. Hover over flowers in the preview to remove them.
        </p>
    </div>

    {{-- Builder grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        {{-- LEFT: Flower picker --}}
        <div class="lg:sticky lg:top-24">
            <div class="flex items-center justify-between mb-3">
                <p class="font-hand text-base text-brown">
                    Select your blooms
                    <span class="bouquet-count-badge ml-2" id="countBadge">0 / 8</span>
                </p>
            </div>

            {{-- Flower grid --}}
            <div class="grid grid-cols-4 gap-3" id="flowerPalette">
                {{-- Populated by JavaScript / Alpine.js --}}
            </div>

            {{-- Message card --}}
            <x-message-card />

            {{-- Order button --}}
            <button class="order-btn w-full mt-4" id="orderBtn" type="button">
                🌷 Send This Bouquet
            </button>
        </div>

        {{-- RIGHT: Preview canvas --}}
        <div>
            <x-bouquet-preview />
        </div>
    </div>
</section>