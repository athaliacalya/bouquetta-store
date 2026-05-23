@extends('layouts.app')
@section('title', 'Keranjang Belanja – Bouquetta')

@push('styles')
<style>
.cart-page { padding: 3rem 5%; max-width: 1100px; margin: 0 auto; }
.cart-page h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 2rem; }
.cart-layout { display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start; }
.cart-item { background: #fff; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 16px rgba(0,0,0,.06); margin-bottom: 1rem; display: flex; gap: 1.5rem; align-items: flex-start; }
.item-visual { width: 80px; height: 80px; border-radius: 12px; background: linear-gradient(135deg, #FCE4EC, #EDE7F6); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; flex-shrink: 0; }
.item-info { flex: 1; }
.item-info h3 { font-size: 1rem; font-weight: 700; margin-bottom: .4rem; }
.item-info p { font-size: .85rem; color: #888; line-height: 1.5; }
.item-message { font-size: .82rem; color: #555; font-style: italic; background: #fafafa; padding: .5rem .75rem; border-radius: 8px; margin-top: .5rem; border-left: 3px solid var(--pink); }
.item-actions { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; }
.item-price { font-weight: 700; font-size: 1.05rem; color: var(--pink); }
.btn-remove { background: #fee; color: var(--danger); border: 1px solid #fcc; padding: .4rem .9rem; border-radius: 50px; font-size: .82rem; cursor: pointer; font-weight: 600; transition: all .2s; }
.btn-remove:hover { background: var(--danger); color: #fff; }
.order-summary { background: #fff; border-radius: 16px; padding: 1.75rem; box-shadow: 0 2px 16px rgba(0,0,0,.06); position: sticky; top: 90px; }
.order-summary h3 { font-family: 'Playfair Display', serif; font-size: 1.3rem; margin-bottom: 1.5rem; }
.summary-row { display: flex; justify-content: space-between; margin-bottom: .85rem; font-size: .9rem; }
.summary-row.total { font-weight: 700; font-size: 1.05rem; border-top: 1px solid #f0e0e8; padding-top: 1rem; margin-top: .5rem; color: var(--pink); }
.btn-checkout { width: 100%; padding: 1rem; background: var(--pink); color: #fff; border: none; border-radius: 50px; font-size: 1rem; font-weight: 700; cursor: pointer; margin-top: 1rem; transition: all .25s; }
.btn-checkout:hover { background: var(--pink-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,30,99,.3); }
.empty-cart { text-align: center; padding: 5rem 2rem; }
.empty-cart p { font-size: 5rem; margin-bottom: 1rem; }
.empty-cart h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: .75rem; }
.empty-cart .sub { color: #888; margin-bottom: 2rem; }
@media(max-width:768px) { .cart-layout { grid-template-columns: 1fr; } .order-summary { position: static; } }
</style>
@endpush

@section('content')
<div class="cart-page">
    <h1>🛒 Keranjang Belanja</h1>

    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <p>🛒</p>
            <h2>Keranjangmu masih kosong</h2>
            <p class="sub">Yuk, buat bouquet cantik untuk orang spesialmu!</p>
            <a href="{{ route('home') }}#builder" class="btn btn-pink">🌸 Buat Bouquet Sekarang</a>
        </div>
    @else
        <div class="cart-layout">
            <div class="cart-items">
                @foreach($cartItems as $item)
                <div class="cart-item" id="item-{{ $item->id }}">
                    <div class="item-visual" style="display:flex;flex-wrap:wrap;gap:2px;align-items:center;justify-content:center;">
                        @php
                        $flowerImgMap = [
                            'anemone'=>'/images/flowers/anemonen.webp','carnation'=>'/images/flowers/carnationn.webp',
                            'daisy'=>'/images/flowers/daisyn.webp','rose'=>'/images/flowers/rosen.webp',
                            'sunflower'=>'/images/flowers/sunflowern.webp','tulip'=>'/images/flowers/tulipn.webp',
                            'orchid'=>'/images/flowers/orchidn.webp','peony'=>'/images/flowers/peonyn.webp',
                            'lily'=>'/images/flowers/lilyns.webp','ranunculus'=>'/images/flowers/ranunculusn.webp',
                        ];
                        $flowerIds = $item->flower_ids ?? [];
                        @endphp
                        @if(count($flowerIds) > 0)
                            @foreach(array_slice($flowerIds, 0, 4) as $fid)
                                @if(isset($flowerImgMap[$fid]))
                                    <img src="{{ $flowerImgMap[$fid] }}" alt="{{ $fid }}" style="width:32px;height:32px;object-fit:contain;">
                                @endif
                            @endforeach
                        @else
                            🌸
                        @endif
                    </div>
                    <div class="item-info">
                        <h3>{{ $item->product_name }}</h3>
                        <p>{{ count($item->flower_ids ?? []) }} jenis bunga dipilih</p>
                        @if($item->personal_message)
                            <div class="item-message">💌 "{{ Str::limit($item->personal_message, 80) }}"</div>
                        @endif
                        <div class="item-actions">
                            <span class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.remove', $item) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus item ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-remove">🗑 Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="order-summary">
                <h3>Ringkasan Pesanan</h3>
                <div class="summary-row"><span>Subtotal ({{ $cartItems->count() }} item)</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                <div class="summary-row"><span>Ongkos Kirim</span><span>Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span></div>
                <div class="summary-row total"><span>Total</span><span>Rp {{ number_format($total + $deliveryFee, 0, ',', '.') }}</span></div>
                @auth
                    <a href="{{ route('checkout.index') }}"><button class="btn-checkout">Lanjut ke Checkout →</button></a>
                @else
                    <a href="{{ route('login') }}?redirect=checkout"><button class="btn-checkout">Login untuk Checkout →</button></a>
                    <p style="text-align:center;font-size:.8rem;color:#888;margin-top:.75rem">Belum punya akun? <a href="{{ route('register') }}" style="color:var(--pink);font-weight:600">Daftar gratis</a></p>
                @endauth
                <a href="{{ route('home') }}#builder" style="display:block;text-align:center;margin-top:1rem;font-size:.85rem;color:var(--pink);">+ Tambah bouquet lagi</a>
            </div>
        </div>
    @endif
</div>
@endsection