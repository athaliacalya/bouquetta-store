@extends('layouts.admin')
@section('title', 'Manajemen Bunga')
@section('page-title', 'Manajemen Bunga')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>🌸 Daftar Bunga</h3>
        <a href="{{ route('admin.flowers.create') }}" class="btn btn-pink">+ Tambah Bunga</a>
    </div>
    <div class="card-body" style="padding-bottom:.5rem">
        {{-- SEARCH --}}
        <form method="GET" class="search-bar" style="margin-bottom:1.25rem">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau makna bunga…" style="max-width:340px">
            <button type="submit" class="btn btn-pink">🔍 Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.flowers.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th width="60">Gambar</th>
                    <th>Nama</th>
                    <th>Makna</th>
                    <th>Harga</th>
                    <th>Warna</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flowers as $flower)
                <tr>
                    <td>
                        @if($flower->image_path)
                            <img src="{{ $flower->image_path }}" alt="{{ $flower->name }}"
                                 style="width:44px;height:44px;object-fit:contain;border-radius:8px;background:#fce4ec;padding:4px">
                        @else
                            <div style="width:44px;height:44px;border-radius:8px;background:linear-gradient(135deg,{{ $flower->color_primary }},{{ $flower->color_secondary }})"></div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $flower->name }}</strong>
                        <div style="font-size:.75rem;color:#888;font-family:monospace">{{ $flower->slug }}</div>
                    </td>
                    <td style="max-width:220px;color:#555">{{ $flower->meaning }}</td>
                    <td><strong>Rp {{ number_format($flower->price, 0, ',', '.') }}</strong></td>
                    <td>
                        <div style="display:flex;gap:4px;align-items:center">
                            <div style="width:20px;height:20px;border-radius:4px;background:{{ $flower->color_primary }};border:1px solid #ddd" title="{{ $flower->color_primary }}"></div>
                            <div style="width:20px;height:20px;border-radius:4px;background:{{ $flower->color_secondary }};border:1px solid #ddd" title="{{ $flower->color_secondary }}"></div>
                        </div>
                    </td>
                    <td style="text-align:center">{{ $flower->sort_order }}</td>
                    <td>
                        @if($flower->is_active)
                            <span class="badge badge-success">✅ Aktif</span>
                        @else
                            <span class="badge badge-danger">❌ Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            <a href="{{ route('admin.flowers.edit', $flower) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                            <form action="{{ route('admin.flowers.destroy', $flower) }}" method="POST"
                                  onsubmit="return confirm('Hapus bunga {{ $flower->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:2.5rem;color:#aaa">
                        Belum ada data bunga.
                        <a href="{{ route('admin.flowers.create') }}" style="color:var(--pink);font-weight:600">Tambah sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($flowers->hasPages())
    <div class="card-body" style="padding-top:1rem">
        {{ $flowers->links() }}
    </div>
    @endif
</div>
@endsection
