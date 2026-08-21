<div class="card">

    <div class="card-header">

        <div>

            <h3>Informasi Diskon</h3>

            <p>
                Lengkapi informasi diskon di bawah ini.
            </p>

        </div>

    </div>

    <div class="card-body">

        <div class="form-grid">

            {{-- Nama --}}
            <div class="form-group">

                <label>

                    Nama Diskon

                    <span class="text-danger">*</span>

                </label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $discount->name ?? '') }}"
                    placeholder="Contoh : Member Silver">

                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            {{-- Nilai --}}
            <div class="form-group">

                <label>

                    Nilai Diskon (%)

                    <span class="text-danger">*</span>

                </label>

                <div class="input-group">

                    <input
                        type="number"
                        name="value"
                        min="0"
                        max="100"
                        class="form-control @error('value') is-invalid @enderror"
                        value="{{ old('value', $discount->value ?? '') }}"
                        placeholder="0">

                    <span class="input-group-text">

                        %

                    </span>

                </div>

                @error('value')
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

                <span class="text-danger">*</span>

            </label>

            <textarea
                rows="5"
                name="description"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Masukkan deskripsi diskon">{{ old('description', $discount->description ?? '') }}</textarea>

            @error('description')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror

        </div>

    </div>

    <div class="card-footer">

        <button
            type="submit"
            class="btn btn-primary">

            <i data-lucide="save"></i>

            {{ isset($discount) ? 'Update Diskon' : 'Simpan Diskon' }}

        </button>

        <a
            href="{{ route('discounts.index') }}"
            class="btn btn-light">

            Batal

        </a>

    </div>

</div>
