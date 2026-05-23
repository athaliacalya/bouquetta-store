@extends('layouts.app')

@section('title', 'Bouquetta – Rangkaian Bunga Artisan')

@push('styles')
<style>
/* HERO */
.hero { background: linear-gradient(135deg, #FCE4EC 0%, #FFF8F0 60%, #EDE7F6 100%); padding: 6rem 5% 5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
.hero-text h1 { font-family: 'Playfair Display', serif; font-size: 3.5rem; line-height: 1.15; color: #1a1a2e; margin-bottom: 1.25rem; }
.hero-text h1 span { color: var(--pink); }
.hero-text p { font-size: 1.1rem; color: #666; line-height: 1.8; margin-bottom: 2rem; }
.hero-actions { display: flex; gap: 1rem; flex-wrap: wrap; }
.hero-visual { display: flex; justify-content: center; align-items: center; }
.hero-bouquet { width: 320px; height: 320px; background: rgba(255,255,255,.7); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 8rem; box-shadow: 0 20px 60px rgba(233,30,99,.15); animation: float 4s ease-in-out infinite; }
@keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-15px); } }

/* STATS */
.stats-bar { background: var(--dark); color: #fff; padding: 2.5rem 5%; display: flex; justify-content: space-around; flex-wrap: wrap; gap: 1.5rem; }
.stat-item { text-align: center; }
.stat-item h3 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--rose); }
.stat-item p { font-size: .85rem; color: #aaa; margin-top: .25rem; }

/* BEST SELLERS */
.section { padding: 5rem 5%; }
.section-header { text-align: center; margin-bottom: 3rem; }
.section-header h2 { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--dark); margin-bottom: .75rem; }
.section-header p { color: #888; font-size: 1rem; max-width: 500px; margin: 0 auto; }
.products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
.product-card { border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); transition: transform .3s, box-shadow .3s; cursor: pointer; }
.product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 40px rgba(0,0,0,.12); }
.product-visual { height: 220px; display: flex; align-items: center; justify-content: center; font-size: 5rem; position: relative; }
.product-tag { position: absolute; top: 1rem; right: 1rem; background: var(--pink); color: #fff; padding: .25rem .75rem; border-radius: 50px; font-size: .75rem; font-weight: 700; }
.product-info { background: #fff; padding: 1.25rem; }
.product-info h3 { font-family: 'Playfair Display', serif; font-size: 1.1rem; margin-bottom: .25rem; }
.product-info .meaning { font-size: .8rem; color: #888; margin-bottom: .75rem; }
.product-price { font-size: 1.1rem; font-weight: 700; color: var(--pink); }
.product-actions { display: flex; gap: .75rem; margin-top: 1rem; }
.btn-add-cart { flex: 1; padding: .6rem; background: var(--pink); color: #fff; border: none; border-radius: 50px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .2s; }
.btn-add-cart:hover { background: var(--pink-dark); }

/* BUILDER */
#builder { background: linear-gradient(135deg, #FFF8F0, #FCE4EC); padding: 5rem 5%; }
.builder-container { max-width: 900px; margin: 0 auto; }
.flowers-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem; margin: 2rem 0; }
.flower-card { border-radius: 12px; padding: 1rem; text-align: center; cursor: pointer; transition: all .25s; border: 2px solid transparent; position: relative; }
.flower-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.1); }
.flower-card.selected { border-color: var(--pink); box-shadow: 0 0 0 3px rgba(233,30,99,.2); }
.flower-card.selected::after { content: '✓'; position: absolute; top: .5rem; right: .5rem; background: var(--pink); color: #fff; width: 20px; height: 20px; border-radius: 50%; font-size: .7rem; display: flex; align-items: center; justify-content: center; }
.flower-img-wrap { width: 70px; height: 70px; margin: 0 auto .5rem; display: flex; align-items: center; justify-content: center; }
.flower-img { width: 100%; height: 100%; object-fit: contain; }
.flower-name { font-size: .8rem; font-weight: 600; color: var(--dark); }
.flower-meaning { font-size: .7rem; color: #888; margin-top: .2rem; }
.flower-price { font-size: .75rem; font-weight: 600; color: var(--pink); margin-top: .25rem; }
.builder-preview { background: rgba(255,255,255,.8); border-radius: var(--radius); padding: 2rem; margin: 2rem 0; text-align: center; min-height: 200px; }
.preview-flowers { display: flex; flex-wrap: wrap; gap: .5rem; justify-content: center; font-size: 3rem; }
.builder-actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
.letter-box { width: 100%; padding: 1rem; border: 1.5px solid #f0d0de; border-radius: 12px; font-family: inherit; font-size: .9rem; background: rgba(255,255,255,.8); resize: vertical; min-height: 120px; margin-bottom: 1rem; }
.letter-box:focus { outline: none; border-color: var(--pink); }

/* TESTIMONIALS */
.testimonials-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
.testimonial-card { padding: 1.75rem; border-radius: var(--radius); box-shadow: var(--shadow); }
.stars { font-size: 1rem; margin-bottom: .75rem; color: #f4c430; }
.testimonial-text { font-size: .9rem; line-height: 1.7; color: #555; font-style: italic; margin-bottom: 1rem; }
.testimonial-author { display: flex; align-items: center; gap: .75rem; }
.author-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--pink); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; }
.author-info p { font-size: .875rem; font-weight: 600; }
.author-info span { font-size: .8rem; color: #888; }

/* NEWSLETTER */
.newsletter { background: linear-gradient(135deg, var(--pink), var(--pink-dark)); color: #fff; padding: 4rem 5%; text-align: center; }
.newsletter h2 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 1rem; }
.newsletter p { opacity: .9; margin-bottom: 2rem; }
.newsletter-form { display: flex; max-width: 440px; margin: 0 auto; gap: .75rem; }
.newsletter-form input { flex: 1; padding: .9rem 1.25rem; border: none; border-radius: 50px; font-size: .95rem; outline: none; }
.newsletter-form button { padding: .9rem 2rem; background: var(--dark); color: #fff; border: none; border-radius: 50px; font-weight: 700; cursor: pointer; white-space: nowrap; transition: opacity .2s; }
.newsletter-form button:hover { opacity: .85; }

/* ABOUT */
#about { background: #fafafa; padding: 5rem 5%; }
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
.about-text h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 1rem; }
.about-text p { color: #666; line-height: 1.8; margin-bottom: 1rem; }
.feature-list { list-style: none; display: flex; flex-direction: column; gap: .75rem; margin-top: 1.5rem; }
.feature-list li { display: flex; align-items: center; gap: .75rem; font-size: .95rem; }
.feature-icon { width: 36px; height: 36px; border-radius: 50%; background: var(--pink-light); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
.about-visual { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.about-card { padding: 2rem; border-radius: var(--radius); text-align: center; box-shadow: var(--shadow); }
.about-card .icon { font-size: 2.5rem; margin-bottom: .75rem; }
.about-card h4 { font-size: 1rem; font-weight: 700; margin-bottom: .5rem; }
.about-card p { font-size: .8rem; color: #888; }

/* RESPONSIVE */
@media(max-width:900px) {
    .hero { grid-template-columns: 1fr; text-align: center; padding: 4rem 5%; }
    .hero-text h1 { font-size: 2.5rem; }
    .hero-actions { justify-content: center; }
    .hero-visual { display: none; }
    .about-grid { grid-template-columns: 1fr; }
    .about-visual { display: none; }
}
@media(max-width:480px) {
    .hero-text h1 { font-size: 2rem; }
    .newsletter-form { flex-direction: column; }
    .stats-bar { gap: 1rem; }
}
</style>
@endpush

@section('content')
<!-- HERO -->
<section class="hero">
    <div class="hero-text">
        <h1>Rangkaian Bunga<br><span>Artisan</span> untuk<br>Momen Spesialmu</h1>
        <p>Buat bouquet unik dengan sentuhan personal — pilih bunga favoritmu, tambahkan surat cinta, dan kirimkan kebahagiaan ke orang tersayang.</p>
        <div class="hero-actions">
            <a href="#builder" class="btn btn-pink">🌸 Buat Bouquet Sendiri</a>
            <a href="#bestsellers" class="btn btn-outline-pink">Lihat Koleksi</a>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-bouquet">🌸</div>
    </div>
</section>

<!-- STATS -->
<div class="stats-bar">
    <div class="stat-item"><h3>2,500+</h3><p>Bouquet Terkirim</p></div>
    <div class="stat-item"><h3>11</h3><p>Jenis Bunga Pilihan</p></div>
    <div class="stat-item"><h3>4.9★</h3><p>Rating Pelanggan</p></div>
    <div class="stat-item"><h3>100%</h3><p>Kepuasan Terjamin</p></div>
</div>

<!-- BEST SELLERS -->
<section class="section" id="bestsellers">
    <div class="section-header">
        <h2>🌺 Koleksi Terlaris</h2>
        <p>Bouquet pilihan yang paling dicintai pelanggan kami</p>
    </div>
    <div class="products-grid">
        @php
        $bestSellers = [
            ['name'=>'The Romance Set','flowers'=>['🌹','🌸'],'price'=>195000,'tag'=>'Best Seller','bg'=>'linear-gradient(135deg,#FCE4EC,#F5EDDF)','meaning'=>'Cinta & Kemakmuran'],
            ['name'=>'Morning Bliss','flowers'=>['🌼','🌻','🌾'],'price'=>145000,'tag'=>'New Arrival','bg'=>'linear-gradient(135deg,#FFF9C4,#E8F5E9)','meaning'=>'Sukacita & Awal Baru'],
            ['name'=>'Violet Dreams','flowers'=>['💜','🌺','🗡️'],'price'=>165000,'tag'=>null,'bg'=>'linear-gradient(135deg,#EDE7F6,#F5EDDF)','meaning'=>'Kesetiaan & Kekuatan'],
            ['name'=>'Sakura Garden','flowers'=>['🌸','🌹','💐'],'price'=>225000,'tag'=>'Limited','bg'=>'linear-gradient(135deg,#FCE4EC,#FAD5DC)','meaning'=>'Cinta Sejati'],
            ['name'=>'Warm Embrace','flowers'=>['🌻','🌸','🌼'],'price'=>125000,'tag'=>null,'bg'=>'linear-gradient(135deg,#FFF3E0,#FFF9C4)','meaning'=>'Kehangatan & Kemurnian'],
            ['name'=>'Water Garden','flowers'=>['🌊','💐','💜'],'price'=>175000,'tag'=>'Trending','bg'=>'linear-gradient(135deg,#E1F5FE,#EDE7F6)','meaning'=>'Kemurnian & Kelahiran'],
        ];
        @endphp
        @foreach($bestSellers as $product)
        <div class="product-card">
            <div class="product-visual" style="background: {{ $product['bg'] }}">
                <div style="font-size:4rem">{{ implode('', $product['flowers']) }}</div>
                @if($product['tag'])
                    <div class="product-tag">{{ $product['tag'] }}</div>
                @endif
            </div>
            <div class="product-info">
                <h3>{{ $product['name'] }}</h3>
                <p class="meaning">✨ {{ $product['meaning'] }}</p>
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <span class="product-price">Rp {{ number_format($product['price'],0,',','.') }}</span>
                </div>
                <div class="product-actions">
                    <button class="btn-add-cart" onclick="addPresetToCart('{{ $product['name'] }}', {{ $product['price'] }})">
                        🛒 Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- BUILDER -->
<section id="builder">
    <div class="builder-container">
        <div class="section-header">
            <h2>🎨 Buat Bouquetmu Sendiri</h2>
            <p>Pilih bunga favoritmu (max 8), tambahkan surat personal, dan masukkan ke keranjang</p>
        </div>

        <div class="flowers-grid" id="flowersGrid">
            @foreach($flowers as $flower)
            <div class="flower-card" id="fc-{{ $flower->slug }}"
                 style="background: linear-gradient(135deg, {{ $flower->color_primary }}, {{ $flower->color_secondary }}20)"
                 onclick="toggleFlower('{{ $flower->slug }}', '{{ $flower->image_url }}', '{{ $flower->name }}', {{ $flower->price }})">
                <div class="flower-img-wrap">
                    <img src="{{ $flower->image_url }}" alt="{{ $flower->name }}" class="flower-img">
                </div>
                <div class="flower-name">{{ $flower->name }}</div>
                <div class="flower-meaning">{{ $flower->meaning }}</div>
                <div class="flower-price">+Rp {{ number_format($flower->price, 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>

        <div class="builder-preview">
            <div id="preview-empty" style="color:#aaa;padding:2rem">
                <p style="font-size:3rem">💐</p>
                <p style="margin-top:.75rem">Pilih bunga untuk melihat preview bouquetmu</p>
            </div>
            <div id="preview-bouquet" style="display:none">
                <div class="preview-flowers" id="previewFlowers"></div>
                <p style="margin-top:1rem;color:#555;font-weight:600" id="previewSummary"></p>
                <p style="color:var(--pink);font-weight:700;font-size:1.1rem;margin-top:.5rem" id="previewPrice"></p>
            </div>
        </div>

        <div style="margin-bottom:1.5rem">
            <label style="font-weight:600;display:block;margin-bottom:.5rem">📝 Tulis Surat Personal (opsional)</label>
            <textarea class="letter-box" id="personalLetter" placeholder="Tulis pesan atau surat untuk orang spesialmu di sini... &#10;&#10;Contoh: 'Untuk kamu yang selalu menerangi hariku seperti matahari pagi. Bouquet ini aku rangkai dengan cinta, memilih setiap bunga yang menggambarkan perasaanku...'" maxlength="1000"></textarea>
            <p style="font-size:.8rem;color:#aaa;text-align:right"><span id="letterCount">0</span>/1000 karakter</p>
        </div>

        <div class="builder-actions">
            <button class="btn btn-pink" onclick="addCustomToCart()" id="btnAddCart">
                🛒 Tambah ke Keranjang
            </button>
            <a href="{{ route('cart.index') }}" class="btn btn-outline-pink">Lihat Keranjang</a>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="section" style="background:#fafafa">
    <div class="section-header">
        <h2>💬 Apa Kata Mereka</h2>
        <p>Ribuan pelanggan yang telah merasakan keajaiban Bouquetta</p>
    </div>
    <div class="testimonials-grid">
        @foreach($testimonials as $t)
        <div class="testimonial-card" style="background: {{ $t['bg'] }}">
            <div class="stars">{{ str_repeat('⭐', $t['stars']) }}</div>
            <p class="testimonial-text">"{{ $t['text'] }}"</p>
            <div class="testimonial-author">
                <div class="author-avatar">{{ strtoupper(substr($t['author'], 0, 1)) }}</div>
                <div class="author-info">
                    <p>{{ $t['author'] }}</p>
                    <span>{{ $t['city'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="section">
    <div class="about-grid">
        <div class="about-text">
            <h2>Mengapa Memilih Bouquetta?</h2>
            <p>Kami percaya bahwa setiap bunga memiliki cerita, dan setiap momen berhak mendapatkan yang terbaik.</p>
            <ul class="feature-list">
                <li><div class="feature-icon">🎨</div> <span>Desain bouquet unik dengan ilustrasi artisan berkualitas tinggi</span></li>
                <li><div class="feature-icon">💌</div> <span>Surat personal dicetak pada kertas premium bergaya kaligrafi</span></li>
                <li><div class="feature-icon">🚀</div> <span>Pengiriman cepat ke seluruh Indonesia dengan packaging cantik</span></li>
                <li><div class="feature-icon">♻️</div> <span>Menggunakan bahan ramah lingkungan dan sustainable</span></li>
                <li><div class="feature-icon">💯</div> <span>Garansi kepuasan 100% atau uang kembali</span></li>
            </ul>
        </div>
        <div class="about-visual">
            <div class="about-card" style="background:linear-gradient(135deg,#FCE4EC,#FFF8F0)">
                <div class="icon">🌸</div><h4>11+ Bunga</h4><p>Berbagai pilihan bunga dengan makna unik</p>
            </div>
            <div class="about-card" style="background:linear-gradient(135deg,#EDE7F6,#E8F5E9)">
                <div class="icon">💌</div><h4>Surat Custom</h4><p>Tulis pesan dari hati untuk orang tersayang</p>
            </div>
            <div class="about-card" style="background:linear-gradient(135deg,#E1F5FE,#F3E5F5)">
                <div class="icon">📦</div><h4>Pengiriman</h4><p>Pengemasan premium, aman sampai tujuan</p>
            </div>
            <div class="about-card" style="background:linear-gradient(135deg,#FFF3E0,#FCE4EC)">
                <div class="icon">⭐</div><h4>4.9 Rating</h4><p>Kepercayaan ribuan pelanggan setia</p>
            </div>
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter">
    <h2>🌺 Dapatkan Penawaran Spesial</h2>
    <p>Daftar newsletter dan dapatkan diskon 15% untuk pembelian pertamamu!</p>
    <form class="newsletter-form" onsubmit="subscribe(event)">
        <input type="email" id="subEmail" placeholder="Email kamu..." required>
        <button type="submit">Daftar Gratis</button>
    </form>
    <p id="subMsg" style="margin-top:1rem;opacity:0;transition:opacity .3s"></p>
</section>
@endsection

@push('scripts')
<script>
// Flower builder state
let selectedFlowers = [];
const BASE_PRICE = 80000;
const flowerData = {};

document.querySelectorAll('.flower-card').forEach(el => {
    const slug = el.id.replace('fc-', '');
    const img   = el.querySelector('.flower-img');
    const image = img ? img.src : '';
    const name  = el.querySelector('.flower-name').textContent.trim();
    const priceText = el.querySelector('.flower-price').textContent;
    const price = parseInt(priceText.replace(/[^0-9]/g, ''));
    flowerData[slug] = { image, name, price };
});

function toggleFlower(slug, image, name, price) {
    const idx = selectedFlowers.findIndex(f => f.slug === slug);
    if (idx !== -1) {
        selectedFlowers.splice(idx, 1);
        document.getElementById('fc-' + slug).classList.remove('selected');
    } else {
        if (selectedFlowers.length >= 8) {
            alert('Maksimal 8 bunga per bouquet!');
            return;
        }
        selectedFlowers.push({ slug, image, name, price });
        document.getElementById('fc-' + slug).classList.add('selected');
    }
    updatePreview();
}

function updatePreview() {
    const empty = document.getElementById('preview-empty');
    const bouquet = document.getElementById('preview-bouquet');
    if (selectedFlowers.length === 0) {
        empty.style.display = 'block';
        bouquet.style.display = 'none';
        return;
    }
    empty.style.display = 'none';
    bouquet.style.display = 'block';
    // Render flower images in preview
    document.getElementById('previewFlowers').innerHTML = selectedFlowers.map(f =>
        `<img src="${f.image}" alt="${f.name}" title="${f.name}" style="width:52px;height:52px;object-fit:contain;filter:drop-shadow(0 2px 4px rgba(0,0,0,.2));">`
    ).join('');
    document.getElementById('previewSummary').textContent = selectedFlowers.map(f => f.name).join(', ');
    const total = BASE_PRICE + selectedFlowers.reduce((s, f) => s + f.price, 0);
    document.getElementById('previewPrice').textContent = 'Total: Rp ' + total.toLocaleString('id-ID');
}

document.getElementById('personalLetter').addEventListener('input', function() {
    document.getElementById('letterCount').textContent = this.value.length;
});

async function addCustomToCart() {
    if (selectedFlowers.length === 0) {
        alert('Pilih minimal 1 bunga terlebih dahulu!');
        return;
    }
    const price = BASE_PRICE + selectedFlowers.reduce((s, f) => s + f.price, 0);
    const name  = 'Custom: ' + selectedFlowers.map(f => f.name).join(', ');
    const letter = document.getElementById('personalLetter').value;
    await postToCart(name, selectedFlowers.map(f => f.slug), letter, price);
}

async function addPresetToCart(productName, price) {
    await postToCart(productName, ['rose', 'peony'], '', price);
}

async function postToCart(name, flowerIds, message, price) {
    const btn = document.getElementById('btnAddCart');
    const origText = btn ? btn.innerHTML : '';
    if (btn) { btn.disabled = true; btn.innerHTML = '⏳ Menambahkan...'; }

    try {
        const resp = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_name: name, flower_ids: flowerIds, personal_message: message, price })
        });
        const data = await resp.json();
        if (data.success) {
            document.getElementById('cartCount').textContent = data.count;
            // Reset builder
            selectedFlowers.forEach(f => document.getElementById('fc-' + f.slug)?.classList.remove('selected'));
            selectedFlowers = [];
            document.getElementById('personalLetter').value = '';
            document.getElementById('letterCount').textContent = '0';
            updatePreview();
            showToast('🛒 ' + data.message);
        }
    } catch(e) {
        alert('Gagal menambahkan ke keranjang. Coba lagi.');
    } finally {
        if (btn) { btn.disabled = false; btn.innerHTML = origText; }
    }
}

function showToast(msg) {
    const t = document.createElement('div');
    t.textContent = msg;
    t.style.cssText = 'position:fixed;bottom:2rem;right:2rem;background:#1a1a2e;color:#fff;padding:1rem 1.5rem;border-radius:12px;font-weight:600;z-index:9999;animation:slideUp .3s ease;box-shadow:0 8px 30px rgba(0,0,0,.2)';
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 3000);
}

async function subscribe(e) {
    e.preventDefault();
    const email = document.getElementById('subEmail').value;
    const msg   = document.getElementById('subMsg');
    try {
        const r = await fetch('/subscribe', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
            body: JSON.stringify({ email })
        });
        const d = await r.json();
        msg.textContent = d.success ? '🎉 Berhasil! Cek email kamu ya.' : 'Gagal subscribe.';
        msg.style.opacity = '1';
        document.getElementById('subEmail').value = '';
    } catch(e) { msg.textContent = 'Terjadi kesalahan.'; msg.style.opacity = '1'; }
}
</script>
@endpush