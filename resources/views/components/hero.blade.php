{{-- resources/views/components/hero.blade.php --}}
<section class="hero min-h-screen flex items-center relative overflow-hidden px-12 pt-32 pb-16" id="hero">

    {{-- Blurred blob backgrounds --}}
    <div class="blob blob-1 absolute w-[500px] h-[500px] rounded-full filter blur-[80px] opacity-40 bg-pink pointer-events-none"></div>
    <div class="blob blob-2 absolute w-[350px] h-[350px] rounded-full filter blur-[80px] opacity-40 bg-peach pointer-events-none"></div>
    <div class="blob blob-3 absolute w-[280px] h-[280px] rounded-full filter blur-[80px] opacity-25 bg-sage pointer-events-none"></div>

    {{-- Watercolor stain accents --}}
    <div class="absolute top-1/4 left-1/3 w-48 h-48 rounded-full bg-pink opacity-[0.07] blur-sm pointer-events-none"></div>

    {{-- Hero content --}}
    <div class="relative z-10 max-w-xl" id="heroContent">
        <p class="hero-eyebrow font-hand text-xl text-terracotta mb-4 flex items-center gap-2 opacity-0" id="heroEyebrow">
            <span class="text-sage-dark text-xs">✦</span>
            Handcrafted Digital Blooms
            <span class="text-sage-dark text-xs">✦</span>
        </p>

        <h1 class="font-display text-[clamp(3.2rem,6vw,5.5rem)] leading-[1.08] text-brown-dark mb-6 opacity-0" id="heroTitle">
            Every bloom<br>tells a <em class="italic text-terracotta">love story.</em>
        </h1>

        <p class="text-[1.05rem] leading-relaxed text-brown max-w-[460px] mb-10 opacity-0" id="heroSubtitle">
            Build your dream bouquet from our curated collection of hand-illustrated watercolor flowers.
            Arrange, personalize, and share — love made petal by petal.
        </p>

        <div class="flex gap-4 flex-wrap opacity-0" id="heroActions">
            <a href="#builder" class="btn-primary">
                Build Your Bouquet ✦
            </a>
            <a href="#blooms" class="btn-secondary">
                Explore Blooms →
            </a>
        </div>
    </div>

    {{-- Floating flower illustrations --}}
    <div class="absolute right-0 top-0 w-[55%] h-full pointer-events-none z-[1]" id="heroFlowers" aria-hidden="true">
        {{-- Injected dynamically by JS --}}
    </div>
</section>