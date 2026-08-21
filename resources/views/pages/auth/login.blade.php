<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Marimoi Cafe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

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
                        <i data-lucide="sparkles"></i>
                        CAFE MANAGEMENT
                    </span>

                    <h1>
                        Kelola cafe.<br>
                        <em>Lebih sederhana.</em>
                    </h1>

                    <p>
                        Satu ruang untuk mengelola menu, stok, transaksi,
                        pelanggan, dan laporan penjualan Marimoi Cafe.
                    </p>

                    <div class="showcase-features">
                        <div class="feature">
                            <span><i data-lucide="coffee"></i></span>
                            <div>
                                <strong>Menu & Produk</strong>
                                <small>Atur kopi, makanan, dan snack.</small>
                            </div>
                        </div>

                        <div class="feature">
                            <span><i data-lucide="receipt-text"></i></span>
                            <div>
                                <strong>Transaksi Cafe</strong>
                                <small>Penjualan lebih cepat dan rapi.</small>
                            </div>
                        </div>

                        <div class="feature">
                            <span><i data-lucide="users"></i></span>
                            <div>
                                <strong>Pelanggan</strong>
                                <small>Data pelanggan lebih terorganisir.</small>
                            </div>
                        </div>

                        <div class="feature">
                            <span><i data-lucide="chart-no-axes-combined"></i></span>
                            <div>
                                <strong>Laporan</strong>
                                <small>Pantau performa usaha dengan mudah.</small>
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
                        <i data-lucide="lock-keyhole"></i>
                        AREA ADMINISTRATOR
                    </span>

                    <h2>Selamat Datang</h2>

                    <p>
                        Login untuk mengakses dashboard
                        dan mengelola operasional Marimoi Cafe.
                    </p>
                </header>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i data-lucide="circle-alert"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="mail"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="nama@email.com" autocomplete="email" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="lock"></i>

                            <input id="password" type="password" name="password" placeholder="Masukkan password"
                                autocomplete="current-password" required>

                            <button type="button" id="togglePassword" class="password-toggle"
                                aria-label="Tampilkan password">
                                <i data-lucide="eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="auth-options">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" id="loginButton" class="submit-button">
                        <span class="btn-text">Masuk ke Dashboard</span>
                        <i data-lucide="arrow-right"></i>
                    </button>

                    <div class="security-note">
                        <span><i data-lucide="shield-check"></i></span>
                        <div>
                            <strong>Akses aman untuk administrator</strong>
                            <p>Akun dan hak akses dikelola oleh administrator Marimoi Cafe.</p>
                        </div>
                    </div>
                </form>

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

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function() {
                const show = password.type === 'password';
                password.type = show ? 'text' : 'password';

                this.innerHTML = show ?
                    '<i data-lucide="eye-off"></i>' :
                    '<i data-lucide="eye"></i>';

                lucide.createIcons();
            });
        }

        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');

        if (loginForm && loginButton) {
            loginForm.addEventListener('submit', function() {
                loginButton.classList.add('loading');
                loginButton.disabled = true;
            });
        }
    </script>
</body>

</html>
