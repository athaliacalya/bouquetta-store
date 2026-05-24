@extends('layouts.admin')
@section('title', 'Detail Pesanan – ' . $order->order_number)
@section('page-title', 'Detail Pesanan')

@section('content')
@php
$statusMap = [
    'pending'    => ['warning', 'icons8-hourglass-64.png'],
    'processing' => ['info',    'icons8-setting-64.png'],
    'shipped'    => ['purple',  'icons8-shipped-64.png'],
    'delivered'  => ['success', 'icons8-check-64.png'],
    'cancelled'  => ['danger',  'icons8-cancel-64.png'],
];
$payMap = ['unpaid'=>'warning','paid'=>'success','refunded'=>'danger'];
[$sCls, $sIco] = $statusMap[$order->status] ?? ['secondary', null];

$flowerImgMap = [
    'anemone'    => '/images/flowers/anemonen.webp',
    'carnation'  => '/images/flowers/carnationn.webp',
    'daisy'      => '/images/flowers/daisyn.webp',
    'rose'       => '/images/flowers/rosen.webp',
    'sunflower'  => '/images/flowers/sunflowern.webp',
    'tulip'      => '/images/flowers/tulipn.webp',
    'orchid'     => '/images/flowers/orchidn.webp',
    'peony'      => '/images/flowers/peonyn.webp',
    'lily'       => '/images/flowers/lilyns.webp',
    'ranunculus' => '/images/flowers/ranunculusn.webp',
];
@endphp

<div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">← Kembali</a>
    <h2 style="font-size:1.1rem;font-weight:700;font-family:monospace">{{ $order->order_number }}</h2>
    <span class="badge badge-{{ $sCls }}" style="display:inline-flex;align-items:center;gap:.35rem">
        @if($sIco)
            <img src="{{ asset('images/icons/' . $sIco) }}" style="width:14px;height:14px;object-fit:contain;filter:brightness(0) invert(1)">
        @endif
        {{ ucfirst($order->status) }}
    </span>
    <span class="badge badge-{{ $payMap[$order->payment_status] ?? 'secondary' }}">
        {{ ucfirst($order->payment_status) }}
    </span>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start">

    {{-- LEFT COLUMN --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem">

        {{-- CUSTOMER INFO --}}
        <div class="card">
            <div class="card-header"><h3>Informasi Pelanggan</h3></div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                    <div>
                        <div style="font-size:.78rem;color:#888;margin-bottom:.2rem">Nama</div>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>
                    <div>
                        <div style="font-size:.78rem;color:#888;margin-bottom:.2rem">Email</div>
                        <a href="mailto:{{ $order->customer_email }}" style="color:var(--pink)">{{ $order->customer_email }}</a>
                    </div>
                    <div>
                        <div style="font-size:.78rem;color:#888;margin-bottom:.2rem">Telepon</div>
                        <a href="tel:{{ $order->customer_phone }}" style="color:var(--pink)">{{ $order->customer_phone }}</a>
                    </div>
                    <div>
                        <div style="font-size:.78rem;color:#888;margin-bottom:.2rem">Kota Pengiriman</div>
                        <strong>{{ $order->delivery_city ?: '-' }}</strong>
                    </div>
                </div>
                <div style="margin-top:1rem">
                    <div style="font-size:.78rem;color:#888;margin-bottom:.2rem">Alamat Pengiriman</div>
                    <p style="color:#333;line-height:1.5">{{ $order->delivery_address }}</p>
                </div>
                @if($order->delivery_notes)
                <div style="margin-top:.75rem">
                    <div style="font-size:.78rem;color:#888;margin-bottom:.2rem">Catatan Pengiriman</div>
                    <p style="color:#555;font-style:italic">{{ $order->delivery_notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- BOUQUET DETAIL --}}
        @if($order->bouquet)
        <div class="card">
            <div class="card-header">
                <h3>Detail Bouquet</h3>
                <span style="font-family:monospace;font-size:.8rem;color:#888">{{ $order->bouquet->code }}</span>
            </div>
            <div class="card-body">
                @php $flowerIds = $order->bouquet->flower_ids ?? []; @endphp
                @if(count($flowerIds))
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem">
                    @foreach($flowerIds as $fid)
                    <div style="text-align:center">
                        @if(isset($flowerImgMap[$fid]))
                            <img src="{{ $flowerImgMap[$fid] }}" alt="{{ $fid }}"
                                 style="width:52px;height:52px;object-fit:contain;border-radius:8px;background:#fce4ec;padding:4px">
                        @endif
                        <div style="font-size:.7rem;color:#888;margin-top:2px">{{ ucfirst($fid) }}</div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($order->bouquet->recipient || $order->bouquet->sender)
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:.75rem">
                    @if($order->bouquet->recipient)
                    <div>
                        <div style="font-size:.78rem;color:#888">Untuk</div>
                        <strong>{{ $order->bouquet->recipient }}</strong>
                    </div>
                    @endif
                    @if($order->bouquet->sender)
                    <div>
                        <div style="font-size:.78rem;color:#888">Dari</div>
                        <strong>{{ $order->bouquet->sender }}</strong>
                    </div>
                    @endif
                </div>
                @endif

                @if($order->personal_letter)
                <div style="background:#fff8f0;border-left:3px solid var(--pink);padding:.75rem 1rem;border-radius:0 8px 8px 0">
                    <div style="font-size:.78rem;color:#888;margin-bottom:.3rem">Pesan Personal</div>
                    <p style="font-style:italic;color:#333;line-height:1.6">{{ $order->personal_letter }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div>

    {{-- RIGHT COLUMN --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem">

        {{-- SUMMARY --}}
        <div class="card">
            <div class="card-header"><h3>Ringkasan Harga</h3></div>
            <div class="card-body">
                <div style="display:flex;flex-direction:column;gap:.6rem">
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#555">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between">
                        <span style="color:#555">Ongkir</span>
                        <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                    </div>
                    <div style="border-top:2px solid #eee;padding-top:.6rem;display:flex;justify-content:space-between;font-weight:700;font-size:1.05rem">
                        <span>Total</span>
                        <span style="color:var(--pink)">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div style="margin-top:1rem;font-size:.8rem;color:#888">
                    Metode: <strong>{{ $order->payment_method ?: '-' }}</strong><br>
                    Tanggal: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
                </div>
            </div>
        </div>

        {{-- UPDATE STATUS --}}
        <div class="card">
            <div class="card-header"><h3>Perbarui Status</h3></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Status Pesanan</label>
                        <select name="status">
                            @foreach([
                                'pending'    => 'Pending',
                                'processing' => 'Diproses',
                                'shipped'    => 'Dikirim',
                                'delivered'  => 'Terkirim',
                                'cancelled'  => 'Dibatalkan'
                            ] as $val => $label)
                                <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Pembayaran</label>
                        <select name="payment_status">
                            <option value="unpaid"   {{ $order->payment_status === 'unpaid'   ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="paid"     {{ $order->payment_status === 'paid'     ? 'selected' : '' }}>Lunas</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refund</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-pink" style="width:100%;justify-content:center">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        {{-- LINKED USER --}}
        @if($order->user)
        <div class="card">
            <div class="card-header"><h3>Akun Pelanggan</h3></div>
            <div class="card-body" style="display:flex;gap:1rem;align-items:center">
                <div style="width:44px;height:44px;border-radius:50%;background:var(--pink);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700">
                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                </div>
                <div>
                    <strong>{{ $order->user->name }}</strong>
                    <div style="font-size:.8rem;color:#888">{{ $order->user->email }}</div>
                </div>
                <a href="{{ route('admin.users.edit', $order->user) }}" class="btn btn-sm btn-secondary" style="margin-left:auto">Edit</a>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection