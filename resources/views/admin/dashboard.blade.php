@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- STAT CARDS --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff0f6"><img src="{{ asset('images/icons/icons8-package-64.png') }}" alt="Pesanan"></div>
        <div class="stat-info">
            <p>Total Pesanan</p>
            <h3>{{ number_format($stats['total_orders']) }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff8e1"><img src="{{ asset('images/icons/icons8-hourglass-64.png') }}" alt="Pending"></div>
        <div class="stat-info">
            <p>Pesanan Pending</p>
            <h3>{{ number_format($stats['pending_orders']) }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e8f5e9"><img src="{{ asset('images/icons/icons8-money-64.png') }}" alt="Pendapatan"></div>
        <div class="stat-info">
            <p>Total Pendapatan</p>
            <h3 style="font-size:1.15rem">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e3f2fd"><img src="{{ asset('images/icons/icons8-users-64.png') }}" alt="Pelanggan"></div>
        <div class="stat-info">
            <p>Total Pelanggan</p>
            <h3>{{ number_format($stats['total_users']) }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fce4ec"><img src="{{ asset('images/icons/icons8-flower-100.png') }}" alt="Bunga"></div>
        <div class="stat-info">
            <p>Jenis Bunga</p>
            <h3>{{ number_format($stats['total_flowers']) }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f3e5f5"><img src="{{ asset('images/icons/icons8-subscribe-to-channel-100.png') }}" alt="Subscriber"></div>
        <div class="stat-info">
            <p>Subscriber</p>
            <h3>{{ number_format($stats['total_subscribers']) }}</h3>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

    {{-- RECENT ORDERS --}}
    <div class="card">
        <div class="card-header">
            <h3>Pesanan Terbaru</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-pink">Lihat Semua</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bayar</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>
                            <div style="font-weight:600">{{ $order->customer_name }}</div>
                            <div style="font-size:.78rem;color:#888">{{ $order->customer_email }}</div>
                        </td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            @php
                            $statusIcons = [
                                'pending'    => 'icons8-hourglass-64.png',
                                'processing' => 'icons8-setting-64.png',
                                'shipped'    => 'icons8-shipped-64.png',
                                'delivered'  => 'icons8-check-64.png',
                                'cancelled'  => 'icons8-cancel-64.png',
                            ];
                            $statusMap = ['pending'=>'warning','processing'=>'info','shipped'=>'purple','delivered'=>'success','cancelled'=>'danger'];
                            $cls = $statusMap[$order->status] ?? 'secondary';
                            $ico = $statusIcons[$order->status] ?? null;
                            @endphp
                            <span class="badge badge-{{ $cls }}">@if($ico)<img src="{{ asset('images/icons/'.$ico) }}" style="width:12px;height:12px;vertical-align:middle;margin-right:3px;">@endif {{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            @php $payMap = ['unpaid'=>'warning','paid'=>'success','refunded'=>'danger']; @endphp
                            <span class="badge badge-{{ $payMap[$order->payment_status] ?? 'secondary' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td style="font-size:.8rem;color:#888">{{ $order->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-secondary">Detail</a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:#aaa">Belum ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- QUICK LINKS --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem">
        <div class="card">
            <div class="card-header"><h3>⚡ Akses Cepat</h3></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.75rem">
                <a href="{{ route('admin.flowers.create') }}" class="btn btn-pink" style="justify-content:center">
                    <img src="{{ asset('images/icons/icons8-flower-100.png') }}" style="width:16px;height:16px;vertical-align:middle;"> Tambah Bunga Baru
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-secondary" style="justify-content:center">
                    <img src="{{ asset('images/icons/icons8-user-64.png') }}" style="width:16px;height:16px;vertical-align:middle;"> Tambah Pengguna
                </a>
                <a href="{{ route('admin.orders.index') }}?status=pending" class="btn btn-warning" style="justify-content:center">
                    <img src="{{ asset('images/icons/icons8-hourglass-64.png') }}" style="width:16px;height:16px;vertical-align:middle;"> Pesanan Pending
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-success" style="justify-content:center">
                    <img src="{{ asset('images/icons/icons8-store-64.png') }}" style="width:16px;height:16px;vertical-align:middle;"> Lihat Toko
                </a>
            </div>
        </div>

        {{-- STATUS SUMMARY --}}
        <div class="card">
            <div class="card-header"><h3><img src="{{ asset('images/icons/icons8-dashboard-64.png') }}" style="width:18px;height:18px;vertical-align:middle;margin-right:5px;"> Ringkasan Status</h3></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem">
                @php
                $statuses = [
                    'pending'    => ['warning', 'icons8-hourglass-64.png', 'Pending'],
                    'processing' => ['info',    'icons8-setting-64.png',   'Diproses'],
                    'shipped'    => ['purple',  'icons8-shipped-64.png',   'Dikirim'],
                    'delivered'  => ['success', 'icons8-check-64.png',     'Terkirim'],
                    'cancelled'  => ['danger',  'icons8-cancel-64.png',    'Dibatalkan'],
                ];
                @endphp
                @foreach($statuses as $key => [$cls, $ico, $label])
                @php $count = \App\Models\Order::where('status', $key)->count(); @endphp
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span><img src="{{ asset('images/icons/'.$ico) }}" style="width:14px;height:14px;vertical-align:middle;margin-right:4px;"> {{ $label }}</span>
                    <span class="badge badge-{{ $cls }}">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
