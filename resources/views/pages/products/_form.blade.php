<div class="card">

    <div class="card-header">

        <div>

            <h3>Informasi Produk</h3>

            <p>
                Lengkapi informasi produk di bawah ini.
            </p>

        </div>

    </div>

    <div class="card-body">

        <div class="form-grid">

            {{-- Nama Produk --}}
            <div class="form-group">

                <label>
                    Nama Produk
                    <span class="text-danger">*</span>
                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $product->name ?? '') }}" placeholder="Masukkan nama produk">

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Kategori --}}
            <div class="form-group">

                <label>
                    Kategori
                    <span class="text-danger">*</span>
                </label>

                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">

                    <option value="">

                        -- Pilih Kategori --

                    </option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>

                            {{ $category->name }}

                        </option>
                    @endforeach

                </select>

                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Harga --}}
            <div class="form-group">

                <label>
                    Harga
                    <span class="text-danger">*</span>
                </label>

                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price', $product->price ?? '') }}" min="0" step="1" placeholder="0">

                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Stok --}}
            <div class="form-group">

                <label>
                    Stok Awal
                    <span class="text-danger">*</span>
                </label>

                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                    value="{{ old('stock', $product->stock ?? 0) }}" min="0">

                @error('stock')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Satuan Dasar --}}
            <div class="form-group">

                <label>
                    Satuan Dasar
                    <span class="text-danger">*</span>
                </label>

                <select name="base_unit" class="form-control @error('base_unit') is-invalid @enderror">

                    <option value="PCS" @selected(old('base_unit', $product->base_unit ?? 'PCS') == 'PCS')>
                        PCS (Per Unit/Paket/Cup)
                    </option>

                    <option value="GR" @selected(old('base_unit', $product->base_unit ?? '') == 'GR')>
                        Gram (gr)
                    </option>

                    <option value="CM" @selected(old('base_unit', $product->base_unit ?? '') == 'CM')>
                        Sentimeter (cm)
                    </option>

                    <option value="ML" @selected(old('base_unit', $product->base_unit ?? '') == 'ML')>
                        Mililiter (ml)
                    </option>

                </select>
                <small class="text-muted">

                    Contoh:
                    PCS = TV, Kulkas, Kursi<br>
                    GR = Paku, Beras, Gula<br>
                    CM = Kabel, Selang<br>
                    ML = Cat, Oli, Cairan

                </small>

                @error('base_unit')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Status --}}
            <div class="form-group">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="1" @selected(old('status', $product->status ?? 1) == 1)>

                        Aktif

                    </option>

                    <option value="0" @selected(old('status', $product->status ?? 1) == 0)>

                        Nonaktif

                    </option>

                </select>

            </div>

            {{-- Favorite --}}
            <div class="form-group">

                <label>Favorite</label>

                <select name="is_favorite" class="form-control">

                    <option value="0" @selected(old('is_favorite', $product->is_favorite ?? 0) == 0)>

                        Tidak

                    </option>

                    <option value="1" @selected(old('is_favorite', $product->is_favorite ?? 0) == 1)>

                        Ya

                    </option>

                </select>

            </div>

        </div>

        {{-- Deskripsi --}}
        <div class="form-group mt-4">

            <label>
                Deskripsi
                <span class="text-danger">*</span>
            </label>

            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                placeholder="Masukkan deskripsi produk">{{ old('description', $product->description ?? '') }}</textarea>

            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        {{-- Upload Gambar --}}
        <div class="form-group mt-4">

            <label>

                Gambar Produk

                @isset($product)
                    <small>(Kosongkan jika tidak ingin mengganti gambar)</small>
                @endisset

            </label>

            <input type="file" name="image" id="image" class="form-control" accept="image/*">

            @error('image')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            <div class="image-preview mt-3">

                @if (isset($product) && $product->image)
                    <img id="preview-image" src="{{ asset($product->image) }}" class="preview-image">
                @else
                    <img id="preview-image" class="preview-image d-none">
                @endif

            </div>

        </div>

    </div>

    <div class="card-footer">

        <button class="btn btn-primary" type="submit">

            <i data-lucide="save"></i>

            {{ isset($product) ? 'Update Produk' : 'Simpan Produk' }}

        </button>

        <a href="{{ route('products.index') }}" class="btn btn-light">

            Batal

        </a>

    </div>

</div>

@once

    @push('scripts')
        <script>
            const imageInput = document.getElementById('image');

            if (imageInput) {

                imageInput.addEventListener('change', function(e) {

                    const file = e.target.files[0];

                    if (!file) return;

                    const reader = new FileReader();

                    reader.onload = function(event) {

                        const preview = document.getElementById('preview-image');

                        preview.src = event.target.result;

                        preview.classList.remove('d-none');

                    }

                    reader.readAsDataURL(file);

                });

            }
        </script>
    @endpush

@endonce
