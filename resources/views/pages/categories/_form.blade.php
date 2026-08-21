<div class="card">

    <div class="card-header">

        <div>

            <h3>Informasi Kategori</h3>

            <p>
                Lengkapi data kategori di bawah ini.
            </p>

        </div>

    </div>

    <div class="card-body">

        <div class="form-grid">

            {{-- Nama --}}
            <div class="form-group">

                <label>

                    Nama Kategori

                    <span class="text-danger">*</span>

                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name ?? '') }}" placeholder="Masukkan nama kategori">

                @error('name')
                    <small class="text-danger">

                        {{ $message }}

                    </small>
                @enderror

            </div>

        </div>

        {{-- Deskripsi --}}
        <div class="form-group mt-4">

            <label>

                Deskripsi

            </label>

            <textarea rows="5" name="description" class="form-control @error('description') is-invalid @enderror"
                placeholder="Masukkan deskripsi kategori">{{ old('description', $category->description ?? '') }}</textarea>

            @error('description')
                <small class="text-danger">

                    {{ $message }}

                </small>
            @enderror

        </div>

        {{-- Upload --}}
        <div class="form-group mt-4">

            <label>

                Gambar Kategori

                @isset($category)
                    <small>(Kosongkan jika tidak ingin mengganti gambar)</small>
                @endisset

            </label>

            <input type="file" name="image" id="image" accept="image/*"
                class="form-control @error('image') is-invalid @enderror">

            @error('image')
                <small class="text-danger">

                    {{ $message }}

                </small>
            @enderror

            <div class="image-preview mt-3">

                @if (isset($category) && $category->image)
                    <img src="{{ asset($category->image) }}" id="preview-image" class="preview-image">
                @else
                    <img id="preview-image" class="preview-image d-none">
                @endif

            </div>

        </div>

    </div>

    <div class="card-footer">

        <button type="submit" class="btn btn-primary">

            <i data-lucide="save"></i>

            {{ isset($category) ? 'Update Kategori' : 'Simpan Kategori' }}

        </button>

        <a href="{{ route('categories.index') }}" class="btn btn-light">

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

                    reader.onload = function(ev) {

                        const preview = document.getElementById('preview-image');

                        preview.src = ev.target.result;

                        preview.classList.remove('d-none');

                    }

                    reader.readAsDataURL(file);

                });

            }
        </script>
    @endpush

@endonce
