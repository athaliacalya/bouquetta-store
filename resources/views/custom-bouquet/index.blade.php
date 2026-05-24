{{-- resources/views/custom-bouquet/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Buat Bouquet Custom — Bouquetta')

@push('styles')
<style>
    /* ── Google Fonts ─────────────────────────────────────────── */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500;600&display=swap');

    /* ── CSS Variables ────────────────────────────────────────── */
    :root {
        --pink:        #e91e8c;
        --pink-light:  #fce4f3;
        --pink-hover:  #c7157a;
        --dark:        #1a1a2e;
        --gray:        #6b7280;
        --gray-light:  #f3f4f6;
        --white:       #ffffff;
        --border:      #e5e7eb;
        --success:     #10b981;
        --warning:     #f59e0b;
        --danger:      #ef4444;
        --shadow-sm:   0 1px 3px rgba(0,0,0,.08);
        --shadow-md:   0 4px 16px rgba(0,0,0,.10);
        --shadow-pink: 0 8px 32px rgba(233,30,140,.18);
        --radius:      16px;
        --radius-sm:   10px;
    }

    body { font-family: 'DM Sans', sans-serif; }

    /* ── Page Layout ──────────────────────────────────────────── */
    .builder-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 24px 80px;
    }

    .builder-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(28px, 4vw, 42px);
        color: var(--dark);
        margin-bottom: 4px;
    }

    .builder-subtitle {
        color: var(--gray);
        font-size: 15px;
        margin-bottom: 40px;
    }

    /* ── Two-column grid ──────────────────────────────────────── */
    .builder-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 32px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .builder-grid { grid-template-columns: 1fr; }
    }

    /* ── Section cards ────────────────────────────────────────── */
    .card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        color: var(--dark);
        margin: 0;
    }

    .card-header .badge {
        background: var(--pink-light);
        color: var(--pink);
        font-size: 12px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        margin-left: auto;
    }

    /* ── Bouquet Name Input ───────────────────────────────────── */
    .name-input-wrap {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
    }

    .name-input-wrap label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .name-input-wrap input {
        width: 100%;
        padding: 10px 16px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--dark);
        transition: border-color .2s;
        box-sizing: border-box;
    }

    .name-input-wrap input:focus {
        outline: none;
        border-color: var(--pink);
    }

    /* ── Flower List ──────────────────────────────────────────── */
    .flower-list { padding: 16px 24px 24px; }

    .flower-row {
        display: grid;
        grid-template-columns: auto 1fr auto auto;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: var(--radius-sm);
        border: 1.5px solid transparent;
        margin-bottom: 10px;
        transition: all .2s ease;
        background: var(--gray-light);
        cursor: pointer;
        position: relative;
    }

    .flower-row:last-child { margin-bottom: 0; }

    .flower-row.selected {
        background: var(--pink-light);
        border-color: var(--pink);
    }

    .flower-row.selected .flower-name { color: var(--pink); }

    /* Flower checkbox (hidden, we use custom UI) */
    .flower-row input[type="checkbox"] { display: none; }

    /* Flower icon / emoji */
    .flower-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .flower-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Flower info */
    .flower-info { flex: 1; }
    .flower-name { font-weight: 600; font-size: 14px; color: var(--dark); }
    .flower-price { font-size: 12px; color: var(--gray); margin-top: 2px; }

    /* Qty counter */
    .qty-control {
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s;
    }

    .flower-row.selected .qty-control {
        opacity: 1;
        pointer-events: all;
    }

    .qty-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1.5px solid var(--pink);
        background: var(--white);
        color: var(--pink);
        font-size: 18px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all .15s;
        line-height: 1;
        flex-shrink: 0;
    }

    .qty-btn:hover {
        background: var(--pink);
        color: var(--white);
        transform: scale(1.1);
    }

    .qty-btn:active { transform: scale(.95); }

    .qty-display {
        min-width: 28px;
        text-align: center;
        font-weight: 700;
        font-size: 16px;
        color: var(--dark);
    }

    /* Hidden input for quantity */
    .qty-hidden { display: none; }

    /* Subtotal per row */
    .row-subtotal {
        font-size: 13px;
        font-weight: 600;
        color: var(--pink);
        min-width: 72px;
        text-align: right;
        opacity: 0;
        transition: opacity .2s;
    }

    .flower-row.selected .row-subtotal { opacity: 1; }

    /* Select indicator */
    .select-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s;
        flex-shrink: 0;
    }

    .flower-row.selected .select-indicator {
        background: var(--pink);
        border-color: var(--pink);
    }

    .select-indicator::after {
        content: '';
        width: 6px;
        height: 6px;
        background: white;
        border-radius: 50%;
        opacity: 0;
        transition: opacity .2s;
    }

    .flower-row.selected .select-indicator::after { opacity: 1; }

    /* ── Summary panel (sticky) ───────────────────────────────── */
    .summary-panel {
        position: sticky;
        top: 24px;
    }

    .summary-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
    }

    .summary-header h3 {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        color: var(--dark);
        margin: 0 0 4px;
    }

    .stems-progress {
        margin-top: 12px;
    }

    .stems-label {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 6px;
    }

    .stems-label strong { color: var(--dark); }

    .progress-bar {
        height: 6px;
        background: var(--border);
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 99px;
        background: var(--pink);
        transition: width .3s ease;
        width: 0%;
    }

    .progress-fill.full { background: var(--success); }

    /* Error message for stems */
    .stems-error {
        display: none;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--radius-sm);
        padding: 10px 14px;
        font-size: 13px;
        color: var(--danger);
        margin-top: 12px;
        align-items: center;
        gap: 8px;
    }

    .stems-error.show { display: flex; }

    /* Summary items list */
    .summary-items {
        padding: 16px 24px;
        min-height: 80px;
        border-bottom: 1px solid var(--border);
    }

    .summary-empty {
        text-align: center;
        color: var(--gray);
        font-size: 13px;
        padding: 20px 0;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 8px;
        animation: fadeIn .2s ease;
    }

    .summary-item:last-child { margin-bottom: 0; }

    .summary-item .item-name { color: var(--gray); }
    .summary-item .item-price { font-weight: 600; color: var(--dark); }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: none; } }

    /* Summary totals */
    .summary-totals {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 8px;
        color: var(--gray);
    }

    .total-row.grand {
        font-size: 18px;
        font-weight: 700;
        color: var(--pink);
        margin-bottom: 0;
    }

    .total-row span:last-child { font-weight: 600; color: var(--dark); }
    .total-row.grand span:last-child { color: var(--pink); }

    /* CTA button */
    .summary-cta {
        padding: 20px 24px;
    }

    .btn-add-cart {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 15px 24px;
        background: var(--pink);
        color: var(--white);
        border: none;
        border-radius: 50px;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        box-shadow: var(--shadow-pink);
        text-decoration: none;
    }

    .btn-add-cart:hover:not(:disabled) {
        background: var(--pink-hover);
        transform: translateY(-1px);
        box-shadow: 0 12px 40px rgba(233,30,140,.28);
    }

    .btn-add-cart:disabled {
        background: var(--border);
        color: var(--gray);
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-add-cart:active:not(:disabled) {
        transform: translateY(0);
    }

    /* ── Validation error banner ──────────────────────────────── */
    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        color: var(--danger);
        font-size: 14px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 24px;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        color: var(--success);
        font-size: 14px;
        margin-bottom: 24px;
    }

    /* ── Tip chip ─────────────────────────────────────────────── */
    .tip-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff8e1;
        border: 1px solid #fde68a;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 12px;
        color: #92400e;
        margin-bottom: 20px;
    }

    /* Empty state if no flowers */
    .no-flowers {
        text-align: center;
        padding: 40px 24px;
        color: var(--gray);
    }
</style>
@endpush

@section('content')
<div class="builder-wrap">

    {{-- Page heading --}}
    <h1 class="builder-title d-flex align-items-center gap-2">
    <img 
        src="{{ asset('images/icons/icons8-flower-100.png') }}" 
        width="40"
    >
    Buat Bouquet Custom
</h1>
    <p class="builder-subtitle">Pilih bunga favoritmu dan tentukan jumlah batangnya. Minimal 3 batang untuk satu bouquet.</p>

    {{-- Success flash --}}
    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Validation errors (dari server) --}}
    @if($errors->any())
        <div class="alert-error">
            <span>⚠️</span>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Tip --}}
    <div class="tip-chip">
        Klik bunga untuk memilih, lalu atur jumlah batangnya dengan tombol + / −
    </div>

    <form id="bouquetForm" method="POST" action="{{ route('custom-bouquet.store') }}">
        @csrf

        <div class="builder-grid">
            {{-- ── LEFT: Flower Selector ─────────────────────────── --}}
            <div>
                <div class="card">
                    <div class="card-header">
                        <span>💐</span>
                        <h2>Pilih Bunga</h2>
                        <span class="badge" id="selectedCount">0 dipilih</span>
                    </div>

                    {{-- Optional: custom bouquet name --}}
                    <div class="name-input-wrap">
                        <label for="bouquet_name">Nama Bouquet (opsional)</label>
                        <input
                            type="text"
                            id="bouquet_name"
                            name="bouquet_name"
                            placeholder="cth: Bouquet Ulang Tahun Mama 🌷"
                            value="{{ old('bouquet_name') }}"
                            maxlength="100"
                        >
                    </div>

                    <div class="flower-list">
                        @forelse($flowers as $flower)
                            @php
                                $oldQty = 0;
                                $oldSelected = false;
                                if (old('flowers')) {
                                    foreach (old('flowers') as $idx => $f) {
                                        if ($f['flower_id'] == $flower->id) {
                                            $oldQty = (int) $f['qty'];
                                            $oldSelected = $oldQty > 0;
                                        }
                                    }
                                }
                            @endphp

                            <div
                                class="flower-row {{ $oldSelected ? 'selected' : '' }}"
                                data-flower-id="{{ $flower->id }}"
                                data-price="{{ $flower->price }}"
                                data-name="{{ $flower->name }}"
                                onclick="toggleFlower(this)"
                                role="button"
                                tabindex="0"
                                onkeydown="if(event.key==='Enter'||event.key===' ')toggleFlower(this)"
                            >
                                {{-- Select indicator --}}
                                <div class="select-indicator"></div>

                                {{-- Flower image / emoji --}}
<div class="flower-icon">
    @php
        $flowerImages = [
            'Anemone'     => 'anemonen.webp',
            'Carnation'   => 'carnationn.webp',
            'Daisy'       => 'daisyn.webp',
            'Lily'        => 'lilyns.webp',
            'Orchid'      => 'orchidn.webp',
            'Peony'       => 'peonyn.webp',
            'Ranunculus'  => 'ranunculusn.webp',
            'Rose'        => 'rosen.webp',
            'Sunflower'   => 'sunflowern.webp',
            'Tulip'       => 'tulipn.webp',
        ];

        $image = $flowerImages[$flower->name] ?? null;
    @endphp

    <img src="{{ asset('images/flowers/' . $image) }}">
</div>

                                {{-- Info --}}
                                <div class="flower-info">
                                    <div class="flower-name">{{ $flower->name }}</div>
                                    <div class="flower-price">Rp {{ number_format($flower->price, 0, ',', '.') }} / batang</div>
                                </div>

                                {{-- Qty controls --}}
                                <div class="qty-control" onclick="event.stopPropagation()">
                                    <button type="button" class="qty-btn minus-btn" onclick="changeQty(this, -1)">−</button>
                                    <span class="qty-display">{{ $oldQty > 0 ? $oldQty : 1 }}</span>
                                    <button type="button" class="qty-btn plus-btn" onclick="changeQty(this, 1)">+</button>
                                </div>

                                {{-- Subtotal per row --}}
                                <div class="row-subtotal">
                                    Rp {{ $oldSelected ? number_format($flower->price * $oldQty, 0, ',', '.') : '0' }}
                                </div>

                                {{-- Hidden inputs (ditambah/dihapus oleh JS) --}}
                                @if($oldSelected)
                                    <input type="hidden" name="flowers[{{ $loop->index }}][flower_id]" value="{{ $flower->id }}" class="qty-hidden flower-id-input">
                                    <input type="hidden" name="flowers[{{ $loop->index }}][qty]"       value="{{ $oldQty }}"     class="qty-hidden flower-qty-input">
                                @endif
                            </div>
                        @empty
                            <div class="no-flowers">
                                Belum ada bunga tersedia. Cek lagi nanti ya!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: Summary panel ──────────────────────────── --}}
            <div class="summary-panel">
                <div class="card">
                    {{-- Header + progress --}}
                    <div class="summary-header">
                        <h3>Ringkasan Bouquet</h3>

                        <div class="stems-progress">
                            <div class="stems-label">
                                <span>Total batang bunga</span>
                                <strong id="stemsCount">0 / min. 3</strong>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="progressFill"></div>
                            </div>
                        </div>

                        <div class="stems-error" id="stemsError">
                            ⚠️ Minimal 3 bunga untuk membuat bouquet.
                        </div>
                    </div>

                    {{-- Item list --}}
                    <div class="summary-items" id="summaryItems">
                        <div class="summary-empty" id="summaryEmpty">
                            Belum ada bunga dipilih
                        </div>
                    </div>

                    {{-- Totals --}}
                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span id="subtotalDisplay">Rp 0</span>
                        </div>
                        <div class="total-row">
                            <span>Ongkos Kirim</span>
                            <span>Rp 25.000</span>
                        </div>
                        <div class="total-row grand">
                            <span>Total</span>
                            <span id="totalDisplay">Rp 25.000</span>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="summary-cta">
                        <button type="submit" class="btn-add-cart" id="submitBtn" disabled>
                            <span>🛒</span>
                            <span>Tambah ke Keranjang</span>
                            <span>→</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>{{-- /builder-grid --}}
    </form>

</div>
@endsection

@push('scripts')
<script>
/**
 * Custom Bouquet Builder — Interactive Logic
 * ------------------------------------------
 * Mengelola:
 *   - Pemilihan bunga (toggle selected state)
 *   - Qty +/- per bunga
 *   - Sinkronisasi hidden input untuk form submission
 *   - Kalkulasi harga real-time
 *   - Validasi minimal 3 batang
 */

const SHIPPING  = 25000;
const MIN_STEMS = 3;

/** Ambil semua baris bunga ---------------------------------------------- */
const allRows = () => document.querySelectorAll('.flower-row');

/** Format Rupiah --------------------------------------------------------- */
const fmtRp = (n) =>
    'Rp ' + new Intl.NumberFormat('id-ID').format(n);

/** Toggle pilih / batal pilih bunga ------------------------------------- */
function toggleFlower(row) {
    const isSelected = row.classList.toggle('selected');

    if (isSelected) {
        // Pastikan qty minimal 1
        const display = row.querySelector('.qty-display');
        if (parseInt(display.textContent) < 1) display.textContent = '1';
        syncHiddenInputs(row);
    } else {
        removeHiddenInputs(row);
    }

    recalculate();
}

/** Ubah quantity +/- ---------------------------------------------------- */
function changeQty(btn, delta) {
    const row     = btn.closest('.flower-row');
    const display = row.querySelector('.qty-display');
    let qty = parseInt(display.textContent) + delta;
    if (qty < 1) qty = 1;
    if (qty > 50) qty = 50;

    display.textContent = qty;

    if (row.classList.contains('selected')) {
        syncHiddenInputs(row);
    }

    recalculate();
}

/** Sinkronisasi hidden inputs ------------------------------------------- */
let inputIndex = 0;

function syncHiddenInputs(row) {
    const flowerId = row.dataset.flowerId;
    const qty      = parseInt(row.querySelector('.qty-display').textContent);

    // Cari input yang sudah ada atau buat baru
    let idInput  = row.querySelector('.flower-id-input');
    let qtyInput = row.querySelector('.flower-qty-input');

    if (!idInput) {
        const idx = inputIndex++;
        idInput   = document.createElement('input');
        qtyInput  = document.createElement('input');

        idInput.type  = 'hidden';
        qtyInput.type = 'hidden';
        idInput.classList.add('qty-hidden', 'flower-id-input');
        qtyInput.classList.add('qty-hidden', 'flower-qty-input');
        idInput.name  = `flowers[${idx}][flower_id]`;
        qtyInput.name = `flowers[${idx}][qty]`;

        row.appendChild(idInput);
        row.appendChild(qtyInput);
    }

    idInput.value  = flowerId;
    qtyInput.value = qty;
}

function removeHiddenInputs(row) {
    row.querySelectorAll('.flower-id-input, .flower-qty-input')
       .forEach(el => el.remove());
}

/** Recalculate everything ----------------------------------------------- */
function recalculate() {
    let totalPrice = 0;
    let totalStems = 0;
    const items    = [];

    document.querySelectorAll('.flower-row.selected').forEach(row => {
        const price     = parseInt(row.dataset.price);
        const name      = row.dataset.name;
        const qty       = parseInt(row.querySelector('.qty-display').textContent);
        const subtotal  = price * qty;

        totalStems += qty;
        totalPrice += subtotal;

        items.push({ name, qty, subtotal });

        // Update per-row subtotal
        row.querySelector('.row-subtotal').textContent = fmtRp(subtotal);
    });

    // ── Update progress bar ──────────────────────────────────────────────
    const pct  = Math.min((totalStems / MIN_STEMS) * 100, 100);
    const fill = document.getElementById('progressFill');
    fill.style.width = pct + '%';
    fill.classList.toggle('full', totalStems >= MIN_STEMS);

    document.getElementById('stemsCount').textContent =
        totalStems + ' / min. ' + MIN_STEMS;

    // ── Show/hide stems error ────────────────────────────────────────────
    const stemsError = document.getElementById('stemsError');
    stemsError.classList.toggle('show', totalStems > 0 && totalStems < MIN_STEMS);

    // ── Update selected badge ────────────────────────────────────────────
    const selectedCount = document.querySelectorAll('.flower-row.selected').length;
    document.getElementById('selectedCount').textContent =
        selectedCount + ' dipilih';

    // ── Render summary items ─────────────────────────────────────────────
    const summaryEl = document.getElementById('summaryItems');
    const emptyEl   = document.getElementById('summaryEmpty');

    if (items.length === 0) {
        summaryEl.innerHTML = '<div class="summary-empty" id="summaryEmpty">Belum ada bunga dipilih</div>';
    } else {
        summaryEl.innerHTML = items.map(item => `
            <div class="summary-item">
                <span class="item-name">${item.name} × ${item.qty}</span>
                <span class="item-price">${fmtRp(item.subtotal)}</span>
            </div>
        `).join('');
    }

    // ── Update totals ────────────────────────────────────────────────────
    const grandTotal = totalPrice + SHIPPING;
    document.getElementById('subtotalDisplay').textContent = fmtRp(totalPrice);
    document.getElementById('totalDisplay').textContent    = fmtRp(grandTotal);

    // ── Enable/disable submit button ─────────────────────────────────────
    const submitBtn = document.getElementById('submitBtn');
    const canSubmit = totalStems >= MIN_STEMS;
    submitBtn.disabled = !canSubmit;
}

/** Init: restore old values on page load -------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
    // Re-index hidden inputs properly after page load
    document.querySelectorAll('.flower-row.selected').forEach((row, i) => {
        const idInput  = row.querySelector('.flower-id-input');
        const qtyInput = row.querySelector('.flower-qty-input');
        if (idInput)  idInput.name  = `flowers[${i}][flower_id]`;
        if (qtyInput) qtyInput.name = `flowers[${i}][qty]`;
        inputIndex = Math.max(inputIndex, i + 1);
    });

    recalculate();
});
</script>
@endpush