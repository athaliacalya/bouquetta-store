<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bouquetta') – Rangkaian Bunga Artisan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink: #E91E63;
            --pink-light: #FCE4EC;
            --pink-dark: #C2185B;
            --rose: #F48FB1;
            --cream: #FFF8F0;
            --dark: #1a1a2e;
            --gray: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --radius: 16px;
            --shadow: 0 4px 24px rgba(0,0,0,.08);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #fff; color: var(--dark); }
        a { text-decoration: none; color: inherit; }

        /* NAV */
        nav {
            position: sticky; top: 0; z-index: 1000;
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #f0e0e8;
            padding: 0 5%;
            display: flex; align-items: center; justify-content: space-between;
            height: 70px;
        }
        .nav-logo { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--pink); font-weight: 700; }
        .nav-logo span { color: var(--dark); }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a { font-size: .9rem; font-weight: 500; color: #555; transition: color .2s; }
        .nav-links a:hover { color: var(--pink); }
        .nav-actions { display: flex; align-items: center; gap: 1rem; }
        .btn-nav { padding: .5rem 1.2rem; border-radius: 50px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .2s; border: 2px solid transparent; }
        .btn-outline { border-color: var(--pink); color: var(--pink); background: transparent; }
        .btn-outline:hover { background: var(--pink); color: #fff; }
        .btn-primary-nav { background: var(--pink); color: #fff; }
        .btn-primary-nav:hover { background: var(--pink-dark); }
        .cart-badge { position: relative; }
        .cart-count { position: absolute; top: -8px; right: -8px; background: var(--pink); color: #fff; border-radius: 50%; width: 18px; height: 18px; font-size: .65rem; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; padding: 5px; }
        .hamburger span { width: 24px; height: 2px; background: var(--dark); border-radius: 2px; transition: all .3s; }
        .mobile-menu { display: none; position: fixed; inset: 0; background: rgba(255,255,255,.98); z-index: 999; flex-direction: column; align-items: center; justify-content: center; gap: 2rem; }
        .mobile-menu.open { display: flex; }
        .mobile-menu a { font-size: 1.3rem; font-weight: 600; color: var(--dark); }
        .mobile-menu a:hover { color: var(--pink); }
        .mobile-close { position: absolute; top: 1.5rem; right: 5%; font-size: 2rem; cursor: pointer; background: none; border: none; color: var(--dark); }

        /* ALERTS */
        .alert { padding: 1rem 1.5rem; border-radius: var(--radius); margin-bottom: 1.5rem; font-size: .9rem; font-weight: 500; display: flex; align-items: center; gap: .75rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error   { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-warning  { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .75rem 1.75rem; border-radius: 50px; font-size: .9rem; font-weight: 600; cursor: pointer; transition: all .25s; border: 2px solid transparent; text-decoration: none; }
        .btn-pink { background: var(--pink); color: #fff; }
        .btn-pink:hover { background: var(--pink-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,30,99,.3); }
        .btn-outline-pink { border-color: var(--pink); color: var(--pink); background: transparent; }
        .btn-outline-pink:hover { background: var(--pink); color: #fff; }
        .btn-sm { padding: .4rem 1rem; font-size: .8rem; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #b02a37; }

        /* FOOTER */
        footer { background: var(--dark); color: #ccc; padding: 3rem 5% 2rem; margin-top: 5rem; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 3rem; margin-bottom: 2rem; }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--rose); margin-bottom: 1rem; }
        .footer-grid h4 { color: #fff; margin-bottom: 1rem; font-size: .9rem; text-transform: uppercase; letter-spacing: 1px; }
        .footer-grid ul { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
        .footer-grid ul li a { color: #aaa; font-size: .85rem; transition: color .2s; }
        .footer-grid ul li a:hover { color: var(--rose); }
        .footer-bottom { border-top: 1px solid #333; padding-top: 1.5rem; text-align: center; font-size: .8rem; color: #777; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-links, .nav-actions .btn-nav { display: none; }
            .hamburger { display: flex; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
        }
        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
<nav>
    <a href="{{ route('home') }}" class="nav-logo">Bouquet<span>ta</span></a>
    <div class="nav-links">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('home') }}#builder">Buat Bouquet</a>
        <a href="{{ route('home') }}#bestsellers">Koleksi</a>
        <a href="{{ route('home') }}#about">Tentang</a>
    </div>
    <div class="nav-actions">
        <a href="{{ route('cart.index') }}" class="cart-badge" title="Keranjang">
            🛒 <span class="cart-count" id="cartCount">0</span>
        </a>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn-nav btn-outline">Dashboard</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                @csrf
                <button type="submit" class="btn-nav btn-outline">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn-nav btn-outline">Login</a>
            <a href="{{ route('register') }}" class="btn-nav btn-primary-nav">Daftar</a>
        @endauth
    </div>
    <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <button class="mobile-close" onclick="toggleMenu()">✕</button>
    <a href="{{ route('home') }}" onclick="toggleMenu()">Beranda</a>
    <a href="{{ route('home') }}#builder" onclick="toggleMenu()">Buat Bouquet</a>
    <a href="{{ route('home') }}#bestsellers" onclick="toggleMenu()">Koleksi</a>
    <a href="{{ route('cart.index') }}" onclick="toggleMenu()">🛒 Keranjang</a>
    @auth
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" onclick="toggleMenu()">Admin Dashboard</a>
        @endif
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="font-size:1.2rem;font-weight:600;background:none;border:none;color:var(--pink);cursor:pointer;">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}" onclick="toggleMenu()">Login</a>
        <a href="{{ route('register') }}" onclick="toggleMenu()">Daftar</a>
    @endauth
</div>

<main>
    @if(session('success'))
        <div style="padding: 0 5%; padding-top:1rem">
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div style="padding: 0 5%; padding-top:1rem">
            <div class="alert alert-error">❌ {{ session('error') }}</div>
        </div>
    @endif
    @yield('content')
</main>

<footer>
    <div class="footer-grid">
        <div>
            <div class="footer-brand">Bouquetta</div>
            <p style="font-size:.85rem;line-height:1.7;color:#aaa">Rangkaian bunga artisan dengan ilustrasi cantik dan surat personal yang menyentuh hati. Dibuat dengan cinta untuk setiap momen spesialmu.</p>
        </div>
        <div>
            <h4>Navigasi</h4>
            <ul>
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('home') }}#builder">Buat Bouquet</a></li>
                <li><a href="{{ route('home') }}#bestsellers">Koleksi</a></li>
                <li><a href="{{ route('cart.index') }}">Keranjang</a></li>
            </ul>
        </div>
        <div>
            <h4>Akun</h4>
            <ul>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Daftar</a></li>
            </ul>
        </div>
        <div>
            <h4>Kontak</h4>
            <ul>
                <li><a href="#">📧 hello@bouquetta.id</a></li>
                <li><a href="#">📱 0812-3456-7890</a></li>
                <li><a href="#">📍 Bandung, Jawa Barat</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} Bouquetta. Dibuat dengan 💗 untuk semua momen spesialmu.</p>
    </div>
</footer>

<script>
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('open');
}

// Load cart count
async function loadCartCount() {
    try {
        const r = await fetch('/cart/count');
        const d = await r.json();
        document.getElementById('cartCount').textContent = d.count;
    } catch(e) {}
}
loadCartCount();
</script>
@stack('scripts')
</body>
</html>