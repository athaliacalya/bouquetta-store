@extends('layouts.app')
@section('title', 'Checkout – Bouquetta')

@push('styles')
<style>
.checkout-page { padding: 3rem 5%; max-width: 1100px; margin: 0 auto; }
.checkout-page h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 2rem; }
.checkout-layout { display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start; }
.checkout-form-card { background: #fff; border-radius: 16px; padding: 2rem; box-shadow: 0 2px 16px rgba(0,0,0,.06); margin-bottom: 1.5rem; }
.checkout-form-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--pink); }
.form-group { margin-bottom: 1.25rem; }
label { display: block; font-size: .87rem; font-weight: 600; color: #333; margin-bottom: .4rem; }
input, select, textarea { width: 100%; padding: .75rem 1rem; border: 1.5px solid #e9ecef; border-radius: 10px; font-size: .9rem; font-family: inherit; transition: border-color .2s; }
input:focus, select:focus, textarea:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 3px rgba(233,30,99,.1); }
.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.error-msg { color: #dc3545; font-size: .8rem; margin-top: .3rem; }
.payment-options { display: flex; gap: 1rem; flex-wrap: wrap; }
.pay-opt { flex: 1; min-width: 120px; }
.pay-opt input[type=radio] { display: none; }
.pay-opt label { border: 2px solid #e9ecef; border-radius: 12px; padding: 1rem; text-align: center; cursor: pointer; transition: all .2s; display: block; }
.pay-opt input:checked + label { border-color: var(--pink); background: #FFF8F0; color: var(--pink); }
.pay-opt label:hover { border-color: var(--rose); }
.letter-textarea { min-height: 150px; font-style: italic; line-height: 1.8; resize: vertical; }
.order-summary-sticky { position: sticky; top: 90px; }
.order-summary-card { background: #fff; border-radius: 16px; padding: 1.75rem; box-shadow: 0 2px 16px rgba(0,0,0,.06); }
.order-summary-card h3 { font-family: 'Playfair Display', serif; font-size: 1.2rem; margin-bottom: 1.25rem; }
.order-item { display: flex; gap: 1rem; align-items: center; padding: .75rem 0; border-bottom: 1px solid #f5f5f5; }
.order-item:last-of-type { border-bottom: none; }
.order-item-icon { width: 48px; height: 48px; border-radius: 10px; background: linear-gradient(135deg,#FCE4EC,#EDE7F6); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
.order-item-name { font-size: .87rem; font-weight: 600; }
.order-item-price { font-size: .87rem; color: var(--pink); font-weight: 600; margin-left: auto; white-space: nowrap; }
.summary-divider { border: none; border-top: 1px solid #f0e0e8; margin: 1rem 0; }
.sum-row { display: flex; justify-content: space-between; font-size: .9rem; margin-bottom: .65rem; }
.sum-row.total { font-weight: 700; font-size: 1.05rem; color: var(--pink); }
.btn-place-order { width: 100%; padding: 1rem; background: var(--pink); color: #fff; border: none; border-radius: 50px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .25s; margin-top: 1rem; }
.btn-place-order:hover { background: var(--pink-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(233,30,99,.3); }
@media(max-width:768px) { .checkout-layout { grid-template-columns: 1fr; } .order-summary-sticky { position:static; } .form-row-2 { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="checkout-page">
    <h1>🛍 Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-layout">
            <div>
                <!-- Data Penerima -->
                <div class="checkout-form-card">
                    <h3><img src="{{ asset('images/icons/icons8-package-64.png') }}" style="width:18px;height:18px;vertical-align:middle;margin-right:5px;"> Data Pengiriman</h3>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" required placeholder="Nama penerima">
                            @error('customer_name')<p class="error-msg">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label>Nomor HP *</label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone', $user->phone ?? '') }}" required placeholder="08xxxxxxxxxx">
                            @error('customer_phone')<p class="error-msg">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" required placeholder="email@contoh.com">
                        @error('customer_email')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap *</label>
                        <textarea name="delivery_address" required placeholder="Jl. Nama Jalan No. XX, RT/RW, Kelurahan, Kecamatan" style="min-height:90px">{{ old('delivery_address', $user->address ?? '') }}</textarea>
                        @error('delivery_address')<p class="error-msg">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Kota *</label>
                            <input type="text" name="delivery_city" value="{{ old('delivery_city') }}" required placeholder="Bandung">
                            @error('delivery_city')<p class="error-msg">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label>Catatan Pengiriman</label>
                            <input type="text" name="delivery_notes" value="{{ old('delivery_notes') }}" placeholder="Contoh: Depan gang ke-2">
                        </div>
                    </div>
                </div>

                <!-- Surat Personal -->
                <div class="checkout-form-card">
                    <h3><img src="{{ asset('images/icons/icons8-subscribe-to-channel-100.png') }}" style="width:18px;height:18px;vertical-align:middle;margin-right:5px;"> Surat Personal (opsional)</h3>
                    <p style="font-size:.88rem;color:#888;margin-bottom:1rem">Tulis surat yang akan kami cetak dengan indah dan sertakan bersama bouquet.</p>
                    <textarea name="personal_letter" class="letter-textarea" placeholder="Dear kamu yang aku sayangi...&#10;&#10;Bouquet ini aku kirimkan sebagai tanda kasih dan cintaku yang tiada habisnya..." maxlength="2000">{{ old('personal_letter') }}</textarea>
                    @error('personal_letter')<p class="error-msg">{{ $message }}</p>@enderror
                </div>

                <!-- Pembayaran -->
                <div class="checkout-form-card">
                    <h3>💳 Metode Pembayaran</h3>
                    <div class="payment-options">
                        <div class="pay-opt">
                            <input type="radio" name="payment_method" id="pay_transfer" value="transfer" checked>
                            <label for="pay_transfer">🏦<br><strong>Transfer Bank</strong><br><small>BCA / Mandiri / BRI</small></label>
                        </div>
                        <div class="pay-opt">
                            <input type="radio" name="payment_method" id="pay_qris" value="qris">
                            <label for="pay_qris">📱<br><strong>QRIS</strong><br><small>Semua e-wallet</small></label>
                        </div>
                        <div class="pay-opt">
                            <input type="radio" name="payment_method" id="pay_cod" value="cod">
                            <label for="pay_cod">🚪<br><strong>COD</strong><br><small>Bayar di tempat</small></label>
                        </div>
                    </div>
                    @error('payment_method')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="order-summary-sticky">
                <div class="order-summary-card">
                    <h3>📋 Ringkasan Pesanan</h3>
                    @foreach($cartItems as $item)
                    <div class="order-item">
                        <div class="order-item-icon"><img src="{{ asset('images/icons/icons8-flower-100.png') }}" style="width:28px;height:28px;object-fit:contain;"></div>
                        <span class="order-item-name">{{ Str::limit($item->product_name, 30) }}</span>
                        <span class="order-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <hr class="summary-divider">
                    <div class="sum-row"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    <div class="sum-row"><span>Ongkos Kirim</span><span>Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span></div>
                    <div class="sum-row total"><span>Total Bayar</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                    <button type="submit" class="btn-place-order"><img src="{{ asset('images/icons/icons8-checkout-100.png') }}" style="width:18px;height:18px;vertical-align:middle;margin-right:6px;"> Buat Pesanan →</button>
                    <a href="{{ route('cart.index') }}" style="display:block;text-align:center;margin-top:.75rem;font-size:.85rem;color:#888">← Kembali ke keranjang</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection