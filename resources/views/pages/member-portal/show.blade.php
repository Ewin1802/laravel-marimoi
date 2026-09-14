<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1d120d">

    <title>Kartu Member Saya — {{ $setting?->store_name ?? 'Marimoi Cafe' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    @if ($setting?->favicon)
        <link rel="icon" href="{{ $setting->favicon_url }}" type="image/png">
    @endif

    <style>
        :root {
            --espresso: #1d120d;
            --coffee: #5a3525;
            --caramel: #c98954;
            --cream: #fbf7f0;
            --ink: #241914;
            --muted: #7c7069;
            --line: rgba(36, 25, 20, .10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: var(--cream);
            color: var(--ink);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(29, 18, 13, .12);
            overflow: hidden;
        }

        .card-header {
            padding: 28px 32px 22px;
            background: var(--espresso);
            color: #fff;
            text-align: center;
        }

        .card-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .card-header p {
            font-size: 12px;
            color: rgba(255, 255, 255, .6);
        }

        .card-body {
            padding: 30px 32px;
            text-align: center;
        }

        .qr-box {
            margin-bottom: 20px;
            padding: 18px;
            border-radius: 18px;
            border: 1px dashed var(--line);
            background: var(--cream);
        }

        .qr-box img {
            display: block;
            margin: 0 auto;
            border-radius: 10px;
            background: #fff;
            padding: 8px;
        }

        .member-code {
            margin-bottom: 22px;
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: var(--coffee);
        }

        .stamp-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            padding: 14px 16px;
            border-radius: 14px;
            background: var(--cream);
        }

        .stamp-row div:first-child {
            text-align: left;
        }

        .stamp-row small {
            display: block;
            font-size: 10.5px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stamp-row strong {
            font-size: 18px;
            color: var(--coffee);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .status-badge.active {
            background: rgba(47, 125, 74, .10);
            color: #2f7d4a;
        }

        .status-badge.inactive {
            background: rgba(192, 57, 43, .10);
            color: #c0392b;
        }

        .btn-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 46px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: transparent;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn-logout:hover {
            border-color: var(--caramel);
            color: var(--caramel);
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="card-header">
            <h1>Kartu Member Saya</h1>
            <p>{{ $user->name }}</p>
        </div>

        <div class="card-body">

            <div class="qr-box">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=8&data={{ urlencode($member->code) }}"
                    alt="QR Code Member" width="220" height="220" loading="lazy">
            </div>

            <div class="member-code">{{ $member->code }}</div>

            <div class="stamp-row">
                <div>
                    <small>Stamp Terkumpul</small>
                    <strong>{{ $member->stamp_count }} / {{ $member->stamp_target }}</strong>
                </div>

                <span class="status-badge {{ $member->is_active ? 'active' : 'inactive' }}">
                    <i class="fa-solid {{ $member->is_active ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                    {{ $member->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>

        </div>

    </div>

</body>

</html>
