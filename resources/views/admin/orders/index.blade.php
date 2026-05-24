@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('page-title', 'Manajemen Pesanan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Daftar Pesanan</h3>
        <span style="font-size:.85rem;color:#888">Total: {{ $orders->total() }} pesanan</span>
    </div>
    <div class="card-body" style="padding-bottom:.5rem">
        <form method="GET" class="search-bar" style="margin-bottom:1.25rem">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari no. pesanan, nama, atau email…" style="max-width:300px">
            <select name="status">
                <option value="">Semua Status</option>
                @foreach(['pending'=>'⏳ Pending','processing'=>'⚙️ Diproses','shipped'=>'🚚 Dikirim','delivered'=>'✅ Terkirim','cancelled'=>'❌ Dibatalkan'] as $val=>$label)
                    <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-pink">Filter</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Kota</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                $statusMap = [
                    'pending'    => ['warning',   '⏳'],
                    'processing' => ['info',      '⚙️'],
                    'shipped'    => ['purple',    '🚚'],
                    'delivered'  => ['success',   '✅'],
                    'cancelled'  => ['danger',    '❌'],
                ];
                $payMap = ['unpaid'=>'warning','paid'=>'success','refunded'=>'danger'];
                [$sCls, $sIco] = $statusMap[$order->status] ?? ['secondary','❓'];
                @endphp
                <tr>
                    <td><strong style="font-family:monospace">{{ $order->order_number }}</strong></td>
                    <td>
                        <div style="font-weight:600">{{ $order->customer_name }}</div>
                        <div style="font-size:.78rem;color:#888">{{ $order->customer_email }}</div>
                        <div style="font-size:.78rem;color:#888">{{ $order->customer_phone }}</div>
                    </td>
                    <td style="color:#555">{{ $order->delivery_city ?: '-' }}</td>
                    <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                    <td><span class="badge badge-{{ $sCls }}">{{ $sIco }} {{ ucfirst($order->status) }}</span></td>
                    <td>
                        <span class="badge badge-{{ $payMap[$order->payment_status] ?? 'secondary' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td style="font-size:.8rem;color:#888">
                        {{ $order->created_at->format('d M Y') }}<br>
                        <span style="color:#bbb">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-pink">Detail</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                  onsubmit="return confirm('Hapus pesanan {{ $order->order_number }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2.5rem;color:#aaa">
                        Belum ada pesanan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-body">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
