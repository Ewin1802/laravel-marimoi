<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | Marimoi Cafe</title>
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
                        <i data-lucide="shield-check"></i>
                        PEMULIHAN AKUN
                    </span>

                    <h1>
                        Lupa password?<br>
                        <em>Tenang saja.</em>
                    </h1>

                    <p>
                        Masukkan email dan nomor HP yang terdaftar untuk
                        mengatur ulang password akun Anda ke password
                        default.
                    </p>
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
                        <i data-lucide="key-round"></i>
                        RESET PASSWORD
                    </span>

                    <h2>Lupa Password</h2>

                    <p>
                        Masukkan email dan nomor HP yang sama persis
                        seperti saat Anda mendaftar, lalu tentukan
                        password baru Anda.
                    </p>
                </header>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i data-lucide="circle-alert"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.reset.default') }}">
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
                        <label for="phone_number">Nomor HP</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="phone"></i>
                            <input id="phone_number" type="text" name="phone_number"
                                value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx" autocomplete="tel"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Baru</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="lock"></i>
                            <input id="password" type="password" name="password" placeholder="Minimal 6 karakter"
                                autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>

                        <div class="input-wrap">
                            <i class="field-icon" data-lucide="lock"></i>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                placeholder="Ulangi password baru" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="security-note">
                        <span><i data-lucide="info"></i></span>
                        <div>
                            <strong>Setelah berhasil</strong>
                            <p>Password lama Anda akan digantikan sepenuhnya oleh password baru ini. Pastikan Anda
                                mengingatnya.</p>
                        </div>
                    </div>

                    <button type="submit" class="submit-button">
                        <span class="btn-text">Reset Password</span>
                        <i data-lucide="arrow-right"></i>
                    </button>
                </form>

                <footer class="form-footer">
                    <a href="{{ route('login') }}"
                        style="display:flex;align-items:center;gap:8px;justify-content:center;width:100%;">
                        <i data-lucide="arrow-left"></i>
                        <span>Kembali ke halaman Login</span>
                    </a>
                </footer>
            </div>
        </section>
    </main>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
