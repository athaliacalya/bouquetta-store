@extends('layouts.admin')
@section('title', 'Edit Pengguna – ' . $user->name)
@section('page-title', 'Edit Pengguna')

@section('content')
<div style="max-width:680px">
    <div class="card">
        <div class="card-header">
            <h3>
                <div style="display:flex;align-items:center;gap:.75rem">
                    <div style="width:38px;height:38px;border-radius:50%;background:{{ $user->role==='admin'?'var(--pink)':'#6c757d' }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                    ✏️ {{ $user->name }}
                </div>
            </h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">← Kembali</a>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:1rem">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span style="color:red">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="{{ $errors->has('name') ? 'input-error' : '' }}">
                        @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Role <span style="color:red">*</span></label>
                        <select name="role" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="customer" {{ old('role', $user->role)==='customer' ? 'selected' : '' }}>👤 Customer</option>
                            <option value="admin"    {{ old('role', $user->role)==='admin'    ? 'selected' : '' }}>👑 Admin</option>
                        </select>
                        @if($user->id === auth()->id())
                            <input type="hidden" name="role" value="{{ $user->role }}">
                            <div style="font-size:.78rem;color:#888;margin-top:.3rem">⚠️ Tidak bisa mengubah role akun sendiri.</div>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label>Email <span style="color:red">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="{{ $errors->has('email') ? 'input-error' : '' }}">
                    @error('email')<div class="error-msg">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                               placeholder="08123456789">
                    </div>
                    <div class="form-group">
                        <label>Password Baru <span style="color:#888;font-weight:400">(kosongkan jika tidak diganti)</span></label>
                        <input type="password" name="password" placeholder="Min. 6 karakter"
                               class="{{ $errors->has('password') ? 'input-error' : '' }}">
                        @error('password')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-check" style="cursor:pointer">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                               {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <span style="font-weight:500">Akun aktif</span>
                    </label>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="is_active" value="1">
                        <div style="font-size:.78rem;color:#888;margin-top:.2rem">⚠️ Tidak bisa menonaktifkan akun sendiri.</div>
                    @endif
                </div>

                <div style="display:flex;gap:1rem;margin-top:.5rem">
                    <button type="submit" class="btn btn-pink">💾 Perbarui</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="margin-left:auto"
                          onsubmit="return confirm('Hapus pengguna {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑️ Hapus Akun</button>
                    </form>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- USER STATS --}}
    <div class="card" style="margin-top:1.5rem">
        <div class="card-header"><h3>📊 Info Akun</h3></div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;text-align:center">
                <div>
                    <div style="font-size:1.4rem;font-weight:700;color:var(--pink)">
                        {{ \App\Models\Order::where('user_id', $user->id)->count() }}
                    </div>
                    <div style="font-size:.8rem;color:#888">Total Pesanan</div>
                </div>
                <div>
                    <div style="font-size:1.4rem;font-weight:700;color:var(--pink)">
                        {{ $user->is_active ? '✅' : '🚫' }}
                    </div>
                    <div style="font-size:.8rem;color:#888">Status</div>
                </div>
                <div>
                    <div style="font-size:1rem;font-weight:600;color:#333">
                        {{ $user->created_at->format('d M Y') }}
                    </div>
                    <div style="font-size:.8rem;color:#888">Bergabung</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
