@extends('layouts.admin')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')

@section('content')
<div style="max-width:680px">
    <div class="card">
        <div class="card-header">
            <h3>Form Tambah Pengguna</h3>
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

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Lengkap <span style="color:red">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Nama lengkap"
                               class="{{ $errors->has('name') ? 'input-error' : '' }}">
                        @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Role <span style="color:red">*</span></label>
                        <select name="role" required>
                            <option value="customer" {{ old('role','customer')==='customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin"    {{ old('role')==='admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Email <span style="color:red">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="email@contoh.com"
                           class="{{ $errors->has('email') ? 'input-error' : '' }}">
                    @error('email')<div class="error-msg">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                               placeholder="08123456789">
                    </div>
                    <div class="form-group">
                        <label>Password <span style="color:red">*</span></label>
                        <input type="password" name="password" required
                               placeholder="Min. 6 karakter"
                               class="{{ $errors->has('password') ? 'input-error' : '' }}">
                        @error('password')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="address" rows="2" placeholder="Alamat lengkap (opsional)">{{ old('address') }}</textarea>
                </div>

                <div style="display:flex;gap:1rem;margin-top:.5rem">
                    <button type="submit" class="btn btn-pink">Simpan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
