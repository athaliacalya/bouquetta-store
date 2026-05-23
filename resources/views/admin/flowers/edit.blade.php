@extends('layouts.admin')
@section('title', 'Edit Bunga – ' . $flower->name)
@section('page-title', 'Edit Bunga: ' . $flower->name)

@section('content')
<div style="max-width:760px">
    <div class="card">
        <div class="card-header">
            <h3>✏️ Edit Bunga</h3>
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

            {{-- PREVIEW --}}
            <div style="background:#fafafa;border-radius:12px;padding:1rem 1.5rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:1rem">
                @if($flower->image_path)
                    <img id="previewImg" src="{{ $flower->image_path }}" alt="{{ $flower->name }}"
                         style="width:60px;height:60px;object-fit:contain;border-radius:10px;background:#fff;padding:4px;border:1px solid #eee">
                @else
                    <div id="previewColor" style="width:60px;height:60px;border-radius:12px;background:linear-gradient(135deg,{{ $flower->color_primary }},{{ $flower->color_secondary }})"></div>
                @endif
                <div>
                    <strong style="font-size:1rem">{{ $flower->name }}</strong>
                    <div style="font-size:.8rem;color:#888">Slug: {{ $flower->slug }}</div>
                </div>
            </div>

            <form action="{{ route('admin.flowers.update', $flower) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Bunga <span style="color:red">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $flower->name) }}" required
                               class="{{ $errors->has('name') ? 'input-error' : '' }}">
                        @error('name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Harga Tambahan (Rp) <span style="color:red">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $flower->price) }}"
                               required min="0" step="1000"
                               class="{{ $errors->has('price') ? 'input-error' : '' }}">
                        @error('price')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Makna / Deskripsi Singkat <span style="color:red">*</span></label>
                    <input type="text" name="meaning" value="{{ old('meaning', $flower->meaning) }}" required
                           class="{{ $errors->has('meaning') ? 'input-error' : '' }}">
                    @error('meaning')<div class="error-msg">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label>Path Gambar (image_path)</label>
                    <input type="text" name="image_path" id="imagePathInput"
                           value="{{ old('image_path', $flower->image_path) }}"
                           placeholder="/images/flowers/namabunga.webp"
                           oninput="updatePreview(this.value)">
                    <div style="font-size:.78rem;color:#888;margin-top:.3rem">
                        File .webp tersedia: anemonen, carnationn, daisyn, rosen, sunflowern, tulipn, orchidn, peonyn, lilyns, ranunculusn
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Warna Utama</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="color_primary" id="cpPicker"
                                   value="{{ old('color_primary', $flower->color_primary) }}"
                                   style="width:48px;height:38px;padding:2px;border-radius:6px;cursor:pointer">
                            <input type="text" id="cp_text"
                                   value="{{ old('color_primary', $flower->color_primary) }}"
                                   oninput="document.getElementById('cpPicker').value=this.value"
                                   style="flex:1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Warna Sekunder</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="color_secondary" id="csPicker"
                                   value="{{ old('color_secondary', $flower->color_secondary) }}"
                                   style="width:48px;height:38px;padding:2px;border-radius:6px;cursor:pointer">
                            <input type="text" id="cs_text"
                                   value="{{ old('color_secondary', $flower->color_secondary) }}"
                                   oninput="document.getElementById('csPicker').value=this.value"
                                   style="flex:1">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $flower->sort_order) }}" min="0">
                    </div>
                    <div class="form-group" style="display:flex;align-items:center;padding-top:1.5rem">
                        <label class="form-check" style="margin:0;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $flower->is_active) ? 'checked' : '' }}>
                            <span style="font-weight:500">Bunga aktif</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi (opsional)</label>
                    <textarea name="description" rows="3">{{ old('description', $flower->description) }}</textarea>
                </div>

                <div style="display:flex;gap:1rem;margin-top:.5rem">
                    <button type="submit" class="btn btn-pink">💾 Perbarui</button>
                    <a href="{{ route('admin.flowers.index') }}" class="btn btn-secondary">Batal</a>
                    <form action="{{ route('admin.flowers.destroy', $flower) }}" method="POST" style="margin-left:auto"
                          onsubmit="return confirm('Hapus bunga {{ $flower->name }}? Data tidak bisa dikembalikan.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑️ Hapus</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('cpPicker').addEventListener('input', function() {
    document.getElementById('cp_text').value = this.value;
});
document.getElementById('csPicker').addEventListener('input', function() {
    document.getElementById('cs_text').value = this.value;
});

function updatePreview(path) {
    const img = document.getElementById('previewImg');
    if (img && path) img.src = path;
}
</script>
@endpush
@endsection
