@extends('layouts.admin')
@section('title', 'Tambah Bunga')
@section('page-title', 'Tambah Bunga Baru')

@section('content')
<div style="max-width:760px">
    <div class="card">
        <div class="card-header">
            <h3>Form Tambah Bunga</h3>
            <a href="{{ route('admin.flowers.index') }}" class="btn btn-sm btn-secondary">← Kembali</a>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:1rem">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.flowers.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Bunga <span style="color:red">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="Contoh: Rose" class="{{ $errors->has('name') ? 'input-error' : '' }}">
                        @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Harga Tambahan (Rp) <span style="color:red">*</span></label>
                        <input type="number" name="price" value="{{ old('price', 25000) }}" required
                               min="0" step="1000" class="{{ $errors->has('price') ? 'input-error' : '' }}">
                        @error('price')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Makna / Deskripsi Singkat <span style="color:red">*</span></label>
                    <input type="text" name="meaning" value="{{ old('meaning') }}" required
                           placeholder="Contoh: Love & admiration" class="{{ $errors->has('meaning') ? 'input-error' : '' }}">
                    @error('meaning')<div class="error-msg">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Path Gambar (image_path)</label>
                    <input type="text" name="image_path" value="{{ old('image_path') }}"
                           placeholder="/images/flowers/namabunga.webp">
                    <div style="font-size:.78rem;color:#888;margin-top:.3rem">
                        File .webp tersedia: anemonen, carnationn, daisyn, rosen, sunflowern, tulipn, orchidn, peonyn, lilyns, ranunculusn
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Warna Utama</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="color_primary" value="{{ old('color_primary', '#FCE4EC') }}"
                                   style="width:48px;height:38px;padding:2px;border-radius:6px;cursor:pointer">
                            <input type="text" id="cp_text" value="{{ old('color_primary', '#FCE4EC') }}"
                                   oninput="document.querySelector('[name=color_primary]').value=this.value"
                                   placeholder="#FCE4EC" style="flex:1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Warna Sekunder</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="color_secondary" value="{{ old('color_secondary', '#F8BBD0') }}"
                                   style="width:48px;height:38px;padding:2px;border-radius:6px;cursor:pointer">
                            <input type="text" id="cs_text" value="{{ old('color_secondary', '#F8BBD0') }}"
                                   oninput="document.querySelector('[name=color_secondary]').value=this.value"
                                   placeholder="#F8BBD0" style="flex:1">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div class="form-group" style="display:flex;align-items:center;padding-top:1.5rem">
                        <label class="form-check" style="margin:0;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', '1') ? 'checked' : '' }}>
                            <span style="font-weight:500">Aktifkan bunga ini</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi (opsional)</label>
                    <textarea name="description" rows="3" placeholder="Deskripsi tambahan…">{{ old('description') }}</textarea>
                </div>

                <div style="display:flex;gap:1rem;margin-top:.5rem">
                    <button type="submit" class="btn btn-pink">Simpan Bunga</button>
                    <a href="{{ route('admin.flowers.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Sync color pickers ↔ text inputs
document.querySelector('[name=color_primary]').addEventListener('input', function() {
    document.getElementById('cp_text').value = this.value;
});
document.querySelector('[name=color_secondary]').addEventListener('input', function() {
    document.getElementById('cs_text').value = this.value;
});
</script>
@endpush
@endsection
