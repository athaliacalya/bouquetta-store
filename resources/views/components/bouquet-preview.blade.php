{{-- resources/views/components/bouquet-preview.blade.php --}}
<div class="bouquet-preview relative rounded-[32px] min-h-[520px] flex flex-col items-center p-8 overflow-hidden border border-sage/30"
     style="background: linear-gradient(135deg, #FDF6EE 0%, #FAF0E8 50%, #F5EBDD 100%);">
    {{-- Gradient blobs --}}
    <div class="absolute inset-0 pointer-events-none"
         style="background: radial-gradient(circle at 20% 80%, rgba(244,182,194,0.2) 0%, transparent 50%),
                            radial-gradient(circle at 80% 20%, rgba(248,198,168,0.2) 0%, transparent 50%);">
    </div>
    {{-- Preview header bar --}}
    <div class="flex items-center justify-between w-full mb-6 relative z-10">
        <span class="font-hand text-lg text-brown">🌸 Your Bouquet Preview</span>
        <button class="clear-btn text-sm text-terracotta border border-terracotta/30 rounded-full px-3 py-1
                       hover:bg-terracotta/8 transition-all duration-200 font-body"
                id="clearBtn" type="button">
            Clear All
        </button>
    </div>
    {{-- Bouquet stage --}}
    <div class="w-full flex-1 relative min-h-[380px] flex items-end justify-center">
        <div class="relative w-[280px] h-[380px]" id="bouquetWrapper">
            {{-- Empty state --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 opacity-50 pointer-events-none"
                 id="emptyMsg">
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none">
                    <circle cx="30" cy="30" r="28" stroke="#C8C2A3" stroke-width="1.5" stroke-dasharray="4 4"/>
                    <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" font-size="26">🌿</text>
                </svg>
                <p class="font-hand text-sage-dark text-center text-lg">
                    Your bouquet is empty.<br/>Pick some blooms! ✨
                </p>
            </div>
            {{-- Bouquet wrap ribbon --}}
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-[5]" id="bouquetWrap" style="display:none;">
                <svg width="120" height="100" viewBox="0 0 120 100" fill="none">
                    <path d="M10 80 L30 20 Q60 10 90 20 L110 80 Q60 100 10 80Z" fill="#F5EBDD" stroke="#C8C2A3" stroke-width="1.5"/>
                    <path d="M25 75 L35 30 Q60 22 85 30 L95 75 Q60 90 25 75Z" fill="#FAD5DC" opacity="0.4"/>
                    <path d="M40 60 Q60 50 80 60" stroke="#D85B34" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                    <circle cx="60" cy="56" r="5" fill="#D85B34"/>
                    <path d="M55 52 Q50 44 44 46" stroke="#D85B34" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                    <path d="M65 52 Q70 44 76 46" stroke="#D85B34" stroke-width="1.8" fill="none" stroke-linecap="round"/>
                </svg>
            </div>
            {{-- Flower items rendered by JS --}}
            {{-- FIX: tambah position:relative + w-full h-full agar offsetWidth/offsetHeight terbaca --}}
            {{-- dan posisi absolute .bouquet-flower-item dihitung dari sini, bukan dari elemen luar --}}
            <div id="bouquetFlowers" class="relative w-full h-full"></div>
        </div>
    </div>
</div>