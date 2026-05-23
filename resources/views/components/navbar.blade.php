{{-- resources/views/components/navbar.blade.php --}}
<nav class="navbar fixed top-0 left-0 right-0 z-[1000] px-12 py-5 flex items-center justify-between
            backdrop-blur-md bg-cream/75 border-b border-brown/10 transition-all duration-300"
     id="navbar"
     aria-label="Main navigation">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="logo flex items-center font-serif text-3xl font-bold text-brown-dark no-underline">
        B
        <x-logo-flower class="w-7 h-7 mx-0.5 -translate-y-0.5" />
        uquetta
    </a>

    {{-- Desktop nav links --}}
    <ul class="hidden md:flex gap-10 list-none items-center">
        <li>
            <a href="#blooms" class="nav-link text-sm font-medium text-brown uppercase tracking-widest
               hover:text-terracotta transition-colors duration-200 relative">
                Our Blooms
            </a>
        </li>
        <li>
            <a href="#builder" class="nav-link text-sm font-medium text-brown uppercase tracking-widest
               hover:text-terracotta transition-colors duration-200 relative">
                Build Bouquet
            </a>
        </li>
        <li>
            <a href="#story" class="nav-link text-sm font-medium text-brown uppercase tracking-widest
               hover:text-terracotta transition-colors duration-200 relative">
                Our Story
            </a>
        </li>
        <li>
            <a href="#builder"
               class="bg-terracotta text-white text-sm font-semibold tracking-wide
                      px-6 py-2.5 rounded-full transition-all duration-200
                      hover:bg-terracotta-dark hover:-translate-y-0.5 shadow-terracotta">
                Start Building ✦
            </a>
        </li>
    </ul>

    {{-- Mobile menu button --}}
    <button class="md:hidden p-2 text-brown" id="mobileMenuBtn" aria-label="Toggle menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
</nav>

{{-- Mobile menu --}}
<div id="mobileMenu" class="fixed inset-0 z-[999] bg-cream/98 backdrop-blur-lg flex flex-col items-center
     justify-center gap-8 translate-x-full transition-transform duration-300 md:hidden">
    <button id="closeMobileMenu" class="absolute top-5 right-6 text-brown text-2xl">✕</button>
    <a href="#blooms" class="font-serif text-3xl text-brown-dark hover:text-terracotta">Our Blooms</a>
    <a href="#builder" class="font-serif text-3xl text-brown-dark hover:text-terracotta">Build Bouquet</a>
    <a href="#story" class="font-serif text-3xl text-brown-dark hover:text-terracotta">Our Story</a>
    <a href="#builder" class="bg-terracotta text-white px-8 py-3 rounded-full text-lg font-semibold mt-4">
        Start Building ✦
    </a>
</div>