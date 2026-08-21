<div class="card">

    <div class="card-header">

        <div>

            <h3>Informasi User</h3>

            <p>Lengkapi seluruh data pengguna.</p>

        </div>

    </div>

    <div class="card-body">

        <div class="form-grid">

            {{-- Nama --}}
            <div class="form-group">

                <label>
                    Nama Lengkap
                    <span class="text-danger">*</span>
                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name ?? '') }}" placeholder="Masukkan nama lengkap">

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Email --}}
            <div class="form-group">

                <label>
                    Email
                    <span class="text-danger">*</span>
                </label>

                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email ?? '') }}" placeholder="Masukkan email">

                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Role --}}
            <div class="form-group">

                <label>
                    Role
                    <span class="text-danger">*</span>
                </label>

                <select name="role" class="form-control @error('role') is-invalid @enderror">

                    <option value="">-- Pilih Role --</option>

                    <option value="admin" @selected(old('role', $user->role ?? '') == 'admin')>
                        Admin
                    </option>

                    <option value="kasir" @selected(old('role', $user->role ?? '') == 'kasir')>
                        Kasir
                    </option>

                    <option value="owner" @selected(old('role', $user->role ?? '') == 'owner')>
                        Owner
                    </option>

                </select>

                @error('role')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Status --}}
            <div class="form-group">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="aktif" @selected(old('status', $user->status ?? 'aktif') == 'aktif')>

                        Aktif

                    </option>

                    <option value="nonaktif" @selected(old('status', $user->status ?? 'aktif') == 'nonaktif')>

                        Non Aktif

                    </option>

                </select>

            </div>

            {{-- Password --}}
            <div class="form-group">

                <label>

                    Password

                    @isset($user)
                        <small>(Kosongkan jika tidak ingin mengubah)</small>
                    @endisset

                </label>

                <div class="password-input">

                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password">

                    <button class="toggle-password" type="button" data-target="password">

                        <i data-lucide="eye"></i>

                    </button>

                </div>

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group">

                <label>

                    Konfirmasi Password

                </label>

                <div class="password-input">

                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        placeholder="Ulangi password">

                    <button class="toggle-password" type="button" data-target="password_confirmation">

                        <i data-lucide="eye"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div class="card-footer">

        <button type="submit" class="btn btn-primary">

            <i data-lucide="save"></i>

            {{ isset($user) ? 'Update User' : 'Simpan User' }}

        </button>

        <a href="{{ route('users.index') }}" class="btn btn-light">

            Batal

        </a>

    </div>

</div>

@once

    @push('scripts')
        <script>
            document.querySelectorAll('.toggle-password').forEach(button => {

                button.addEventListener('click', function() {

                    const target = document.getElementById(this.dataset.target);

                    if (target.type === 'password') {

                        target.type = 'text';

                        this.innerHTML = '<i data-lucide="eye-off"></i>';

                    } else {

                        target.type = 'password';

                        this.innerHTML = '<i data-lucide="eye"></i>';

                    }

                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }

                });

            });
        </script>
    @endpush

@endonce
