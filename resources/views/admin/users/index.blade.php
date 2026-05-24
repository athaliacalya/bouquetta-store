@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="card">
    <div class="card-header">
        <h3> Daftar Pengguna</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-pink">+ Tambah Pengguna</a>
    </div>
    <div class="card-body" style="padding-bottom:.5rem">
        <form method="GET" class="search-bar" style="margin-bottom:1.25rem">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama atau email…" style="max-width:300px">
            <select name="role">
                <option value="">Semua Role</option>
                <option value="admin"    {{ request('role')==='admin'    ? 'selected' : '' }}> Admin</option>
                <option value="customer" {{ request('role')==='customer' ? 'selected' : '' }}> Customer</option>
            </select>
            <button type="submit" class="btn btn-pink"> Filter</button>
            @if(request()->hasAny(['search','role']))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">✕ Reset</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Telepon</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:.75rem">
                            <div style="width:38px;height:38px;border-radius:50%;background:{{ $user->role==='admin' ? 'var(--pink)' : '#6c757d' }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600">{{ $user->name }}</div>
                                <div style="font-size:.78rem;color:#888">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color:#555">{{ $user->phone ?: '-' }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-purple"> Admin</span>
                        @else
                            <span class="badge badge-secondary"> Customer</span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge badge-success"> Aktif</span>
                        @else
                            <span class="badge badge-danger"> Nonaktif</span>
                        @endif
                    </td>
                    <td style="font-size:.8rem;color:#888">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:.4rem">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"> Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><img src="{{ asset('images/icons/icons8-trash-100.png') }}" style="width:14px;height:14px;"></button>
                            </form>
                            @else
                            <span class="btn btn-sm btn-secondary" style="opacity:.5;cursor:default"><img src="{{ asset('images/icons/icons8-trash-100.png') }}" style="width:14px;height:14px;"></span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2.5rem;color:#aaa">
                        Belum ada pengguna ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-body">{{ $users->links() }}</div>
    @endif
</div>
@endsection