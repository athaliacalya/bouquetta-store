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

/* PAYMENT OPTIONS */
.payment-options { display: flex; gap: 1rem; flex-wrap: wrap; }
.pay-opt { flex: 1; min-width: 120px; }
.pay-opt input[type=radio] { display: none; }
.pay-opt label { border: 2px solid #e9ecef; border-radius: 12px; padding: 1rem; text-align: center; cursor: pointer; transition: all .2s; display: block; }
.pay-opt input:checked + label { border-color: var(--pink); background: #FFF8F0; color: var(--pink); }
.pay-opt label:hover { border-color: var(--rose); }

/* PAYMENT DETAIL PANELS */
.payment-detail { display: none; margin-top: 1.5rem; border-radius: 12px; overflow: hidden; border: 1.5px solid #f0d0de; }
.payment-detail.active { display: block; }
.payment-detail-header { background: linear-gradient(135deg, var(--pink), var(--pink-dark, #c2185b)); color: #fff; padding: .85rem 1.25rem; font-weight: 700; font-size: .95rem; display: flex; align-items: center; gap: .5rem; }

/* BANK TRANSFER */
.bank-list { padding: 1rem 1.25rem; display: flex; flex-direction: column; gap: .75rem; }
.bank-item { display: flex; align-items: center; gap: 1rem; padding: .85rem 1rem; background: #fafafa; border-radius: 10px; border: 1px solid #f0e0e8; cursor: pointer; transition: background .2s; }
.bank-item:hover { background: #fff5f8; }
.bank-logo { width: 52px; height: 30px; object-fit: contain; }
.bank-logo-placeholder { width: 52px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: .65rem; font-weight: 800; color: #fff; flex-shrink: 0; }
.bank-info { flex: 1; }
.bank-name { font-weight: 700; font-size: .9rem; color: #333; }
.bank-account { font-size: .82rem; color: #666; margin-top: .15rem; }
.bank-an { font-size: .78rem; color: #999; }
.btn-copy { background: var(--pink); color: #fff; border: none; border-radius: 8px; padding: .35rem .85rem; font-size: .78rem; font-weight: 700; cursor: pointer; white-space: nowrap; transition: opacity .2s; }
.btn-copy:hover { opacity: .85; }
.btn-copy.copied { background: #28a745; }
.transfer-note { background: #fff9f0; border-left: 3px solid #f4c430; padding: .85rem 1rem; margin: 0 1.25rem 1.25rem; border-radius: 0 8px 8px 0; font-size: .82rem; color: #666; line-height: 1.6; }

/* QRIS */
.qris-body { padding: 1.5rem; text-align: center; }
.qris-img-wrap { width: 200px; height: 200px; margin: 0 auto 1rem; border-radius: 12px; border: 2px dashed #f0d0de; display: flex; align-items: center; justify-content: center; background: #fff; overflow: hidden; }
.qris-img-wrap img { width: 100%; height: 100%; object-fit: contain; }
.qris-placeholder { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .5rem; color: #ccc; }
.qris-placeholder span { font-size: 3.5rem; }
.qris-placeholder p { font-size: .78rem; color: #bbb; }
.qris-merchant { font-weight: 700; font-size: .95rem; color: #333; margin-bottom: .25rem; }
.qris-desc { font-size: .82rem; color: #888; margin-bottom: 1rem; line-height: 1.6; }
.qris-steps { text-align: left; background: #f9f9f9; border-radius: 10px; padding: 1rem; font-size: .82rem; color: #555; line-height: 1.8; }
.qris-steps ol { padding-left: 1.2rem; margin: 0; }

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

@media(max-width:768px) {
    .checkout-layout { grid-template-columns: 1fr; }
    .order-summary-sticky { position:static; }
    .form-row-2 { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="checkout-page">
    <h1>Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="checkout-layout">
            <div>
                <!-- Data Pengiriman -->
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

                <!-- Metode Pembayaran -->
                <div class="checkout-form-card">
                    <h3>💳 Metode Pembayaran</h3>
                    <div class="payment-options">
                        <div class="pay-opt">
                            <input type="radio" name="payment_method" id="pay_transfer" value="transfer"
                                {{ old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' }}>
                            <label for="pay_transfer">🏦<br><strong>Transfer Bank</strong><br><small>BCA / Mandiri / BRI</small></label>
                        </div>
                        <div class="pay-opt">
                            <input type="radio" name="payment_method" id="pay_qris" value="qris"
                                {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
                            <label for="pay_qris">📱<br><strong>QRIS</strong><br><small>Semua e-wallet</small></label>
                        </div>
                        <div class="pay-opt">
                            <input type="radio" name="payment_method" id="pay_cod" value="cod"
                                {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                            <label for="pay_cod">🛵<br><strong>COD</strong><br><small>Bayar di tempat</small></label>
                        </div>
                    </div>
                    @error('payment_method')<p class="error-msg">{{ $message }}</p>@enderror

                    {{-- PANEL: Transfer Bank --}}
                    <div class="payment-detail" id="panel-transfer">
                        <div class="payment-detail-header">Pilih Rekening Tujuan Transfer</div>
                        <div class="bank-list">
                            {{-- BCA --}}
                            <div class="bank-item">
                                <div class="bank-logo-placeholder" style="background:#005BAC;">BCA</div>
                                <div class="bank-info">
                                    <div class="bank-name">Bank BCA</div>
                                    <div class="bank-account" id="bca-number">1234567890</div>
                                    <div class="bank-an">a.n. Bouquetta Store</div>
                                </div>
                                <button type="button" class="btn-copy" onclick="copyNumber('bca-number', this)">Salin</button>
                            </div>
                            {{-- Mandiri --}}
                            <div class="bank-item">
                                <div class="bank-logo-placeholder" style="background:#003D79;">MDR</div>
                                <div class="bank-info">
                                    <div class="bank-name">Bank Mandiri</div>
                                    <div class="bank-account" id="mandiri-number">1400012345678</div>
                                    <div class="bank-an">a.n. Bouquetta Store</div>
                                </div>
                                <button type="button" class="btn-copy" onclick="copyNumber('mandiri-number', this)">Salin</button>
                            </div>
                            {{-- BRI --}}
                            <div class="bank-item">
                                <div class="bank-logo-placeholder" style="background:#003E7E;">BRI</div>
                                <div class="bank-info">
                                    <div class="bank-name">Bank BRI</div>
                                    <div class="bank-account" id="bri-number">123401012345678</div>
                                    <div class="bank-an">a.n. Bouquetta Store</div>
                                </div>
                                <button type="button" class="btn-copy" onclick="copyNumber('bri-number', this)">Salin</button>
                            </div>
                        </div>
                        <div class="transfer-note">
                            ⚠️ <strong>Penting:</strong> Transfer sesuai nominal total pesanan. Setelah transfer, konfirmasi pembayaran melalui WhatsApp ke <strong>0895-3227-27065</strong> dengan mengirimkan bukti transfer dan nomor pesananmu.
                        </div>
                    </div>

                    {{-- PANEL: QRIS --}}
                    <div class="payment-detail" id="panel-qris">
                        <div class="payment-detail-header">📱 Scan QRIS untuk Pembayaran</div>
                        <div class="qris-body">
                            <div class="qris-img-wrap">
                                {{-- Ganti src dengan path QR code QRIS kamu --}}
                                @if(file_exists(public_path('images/qris.png')))
                                    <img src="{{ asset('images/qris.png') }}" alt="QRIS Bouquetta">
                                @else
                                    <div class="qris-placeholder">
                                        <span>▣</span>
                                        <p>Taruh file <code>qris.png</code><br>di <code>public/images/</code></p>
                                    </div>
                                @endif
                            </div>
                            <p class="qris-merchant">Bouquetta Store</p>
                            <p class="qris-desc">
                                Scan QR di atas menggunakan aplikasi e-wallet atau mobile banking apapun.<br>
                                Total yang harus dibayar: <strong style="color:var(--pink)">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                            </p>
                            <div class="qris-steps">
                                <ol>
                                    <li>Buka aplikasi GoPay / OVO / Dana / ShopeePay / m-Banking</li>
                                    <li>Pilih menu <strong>Scan QR / QRIS</strong></li>
                                    <li>Arahkan kamera ke QR code di atas</li>
                                    <li>Pastikan nominal sesuai, lalu konfirmasi pembayaran</li>
                                    <li>Screenshot bukti pembayaran dan kirim ke WhatsApp kami</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL: COD --}}
                    <div class="payment-detail" id="panel-cod">
                        <div class="payment-detail-header">🛵 Bayar di Tempat (COD)</div>
                        <div style="padding:1rem 1.25rem;font-size:.87rem;color:#555;line-height:1.8;">
                            Siapkan uang pas sebesar <strong style="color:var(--pink)">Rp {{ number_format($total, 0, ',', '.') }}</strong> saat kurir tiba.<br>
                            Kurir kami akan menghubungi kamu sebelum pengiriman.
                        </div>
                    </div>
                </div>
            </div>

            <!-- ORDER SUMMARY -->
            <div class="order-summary-sticky">
                <div class="order-summary-card">
                    <h3>📋 Ringkasan Pesanan</h3>
                    @foreach($cartItems as $item)
                    <div class="order-item">
                        <div class="order-item-icon">
                            <img src="{{ asset('images/icons/icons8-flower-100.png') }}" style="width:28px;height:28px;object-fit:contain;">
                        </div>
                        <span class="order-item-name">{{ Str::limit($item->product_name, 30) }}</span>
                        <span class="order-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <hr class="summary-divider">
                    <div class="sum-row"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    <div class="sum-row"><span>Ongkos Kirim</span><span>Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span></div>
                    <div class="sum-row total"><span>Total Bayar</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                    <button type="submit" class="btn-place-order">
                        <img src="{{ asset('images/icons/icons8-checkout-100.png') }}" style="width:18px;height:18px;vertical-align:middle;margin-right:6px;">
                        Buat Pesanan →
                    </button>
                    <a href="{{ route('cart.index') }}" style="display:block;text-align:center;margin-top:.75rem;font-size:.85rem;color:#888">← Kembali ke keranjang</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Tampilkan panel sesuai metode pembayaran yang dipilih
function showPaymentPanel(method) {
    document.querySelectorAll('.payment-detail').forEach(el => el.classList.remove('active'));
    const panel = document.getElementById('panel-' + method);
    if (panel) panel.classList.add('active');
}

// Init saat halaman load
document.addEventListener('DOMContentLoaded', function () {
    const checked = document.querySelector('input[name="payment_method"]:checked');
    if (checked) showPaymentPanel(checked.value);

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function () {
            showPaymentPanel(this.value);
        });
    });
});

// Salin nomor rekening ke clipboard
function copyNumber(elementId, btn) {
    const text = document.getElementById(elementId).textContent.trim();
    navigator.clipboard.writeText(text).then(() => {
        const orig = btn.textContent;
        btn.textContent = '✓ Tersalin!';
        btn.classList.add('copied');
        setTimeout(() => {
            btn.textContent = orig;
            btn.classList.remove('copied');
        }, 2000);
    }).catch(() => {
        // fallback untuk browser lama
        const el = document.createElement('textarea');
        el.value = text;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        btn.textContent = '✓ Tersalin!';
        btn.classList.add('copied');
        setTimeout(() => { btn.textContent = 'Salin'; btn.classList.remove('copied'); }, 2000);
    });
}
</script>
@endpush