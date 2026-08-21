<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Marimoi Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <main class="auth-page">
        <section class="auth-showcase">
            <div class="showcase-pattern"></div>
            <div class="showcase-orb showcase-orb-one"></div>
            <div class="showcase-orb showcase-orb-two"></div>

            <div class="showcase-inner">
                <a href="/" class="brand">
                    <span class="brand-mark">
                        <i data-lucide="coffee"></i>
                    </span>
                    <span class="brand-copy">
                        <strong>Marimoi Cafe</strong>
                        <small>Coffee • Eat • Gather</small>
                    </span>
                </a>

                <div class="showcase-content">
                    <span class="showcase-kicker">
                        <i data-lucide="user-plus"></i>
                        JOIN MARIMOI CAFE
                    </span>

                    <h1>
                        Satu akun.<br>
                        <em>Satu ruang kerja.</em>
                    </h1>

                    <p>
                        Buat akun untuk membantu mengelola menu, transaksi,
                        stok, pelanggan, dan laporan Marimoi Cafe.
                    </p>

                    <div class="showcase-features">
                        <div class="feature">
                            <span><i data-lucide="coffee"></i></span>
                            <div>
                                <strong>Kelola Menu</strong>
                                <small>Kopi, makanan, dan snack.</small>
                            </div>
                        </div>

                        <div class="feature">
                            <span><i data-lucide="receipt-text"></i></span>
                            <div>
                                <strong>Transaksi</strong>
                                <small>Penjualan lebih cepat dan rapi.</small>
                            </div>
                        </div>

                        <div class="feature">
                            <span><i data-lucide="users"></i></span>
                            <div>
                                <strong>Pelanggan</strong>
                                <small>Data pelanggan terorganisir.</small>
                            </div>
                        </div>

                        <div class="feature">
                            <span><i data-lucide="chart-no-axes-combined"></i></span>
                            <div>
                                <strong>Laporan</strong>
                                <small>Pantau performa cafe.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="showcase-footer">
                    <span class="online">
                        <i></i> SYSTEM ONLINE
                    </span>
                    <span>MARIMOI CAFE</span>
                </div>
            </div>
        </section>

        <section class="auth-form-area">
            <div class="auth-card">
                <div class="mobile-brand">
                    <span class="brand-mark"><i data-lucide="coffee"></i></span>
                    <span class="brand-copy">
                        <strong>Marimoi Cafe</strong>
                        <small>Coffee • Eat • Gather</small>
                    </span>
                </div>

                <header class="form-header">
                    <span class="form-eyebrow">
                        <i data-lucide="user-plus"></i>
                        REGISTRASI AKUN
                    </span>

                    <h2>Buat Akun</h2>

                    <p>
                        Lengkapi data berikut untuk membuat
                        akun Marimoi Cafe.
                    </p>
                </header>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i data-lucide="circle-alert"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="user"></i>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="mail"></i>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="lock"></i>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-target="password"
                                aria-label="Tampilkan password"
                            >
                                <i data-lucide="eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="shield-check"></i>

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                data-target="password_confirmation"
                                aria-label="Tampilkan password"
                            >
                                <i data-lucide="eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="registerButton" class="submit-button">
                        <span class="btn-text">Buat Akun</span>
                        <i data-lucide="arrow-right"></i>
                    </button>
                </form>

                <div class="switch-auth">
                    <span>Sudah memiliki akun?</span>
                    <a href="{{ route('login') }}">Login</a>
                </div>

                <div class="security-note">
                    <span><i data-lucide="shield-check"></i></span>
                    <div>
                        <strong>Keamanan Akun</strong>
                        <p>Gunakan email aktif dan password yang kuat untuk menjaga akun Anda.</p>
                    </div>
                </div>

                <footer class="form-footer">
                    <span>© {{ date('Y') }} Marimoi Cafe</span>
                    <i></i>
                    <span>Coffee • Eat • Gather</span>
                </footer>
            </div>
        </section>
    </main>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.querySelectorAll('.password-toggle').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(this.dataset.target);
                if (!input) return;

                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';

                this.innerHTML = show
                    ? '<i data-lucide="eye-off"></i>'
                    : '<i data-lucide="eye"></i>';

                lucide.createIcons();
            });
        });

        const registerForm = document.getElementById('registerForm');
        const registerButton = document.getElementById('registerButton');

        if (registerForm && registerButton) {
            registerForm.addEventListener('submit', function () {
                registerButton.classList.add('loading');
                registerButton.disabled = true;
            });
        }
    </script>
</body>

</html>
