<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1d120d">

    <title>Riwayat Transaksi — {{ $setting?->store_name ?? 'Marimoi Cafe' }}</title>

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
            padding: 30px 16px 50px;
        }

        .wrap {
            max-width: 480px;
            margin: 0 auto;
        }

        .top-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .top-bar a {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #fff;
            display: grid;
            place-items: center;
            color: var(--coffee);
            text-decoration: none;
            box-shadow: 0 6px 18px rgba(29, 18, 13, .06);
        }

        .top-bar h1 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
            color: var(--ink);
        }

        .card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 20px 60px rgba(29, 18, 13, .08);
            overflow: hidden;
        }

        .order-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--line);
        }

        .order-item:last-child {
            border-bottom: 0;
        }

        .order-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .order-top b {
            font-size: 13px;
        }

        .order-top span {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--coffee);
        }

        .order-bottom {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--muted);
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 34px;
            margin-bottom: 12px;
            display: block;
            opacity: .35;
        }

        .pagination-wrap {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrap nav>div {
            font-size: 11px;
        }

        .pagination-wrap a,
        .pagination-wrap span {
            display: inline-block;
            padding: 6px 11px;
            margin: 0 2px;
            border-radius: 8px;
            font-size: 11px;
            text-decoration: none;
            color: var(--coffee);
            background: #fff;
        }
    </style>
</head>

<body>

    <div class="wrap">

        <div class="top-bar">
            <a href="{{ route('member.portal') }}"><i class="fa-solid fa-arrow-left"></i></a>
            <h1>Riwayat Transaksi</h1>
        </div>

        <div class="card">

            @forelse ($orders as $order)
                <div class="order-item">
                    <div class="order-top">
                        <b>INV{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</b>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="order-bottom">
                        <span>{{ \Illuminate\Support\Carbon::parse($order->transaction_time)->translatedFormat('d M Y, H:i') }}</span>
                        <span>{{ $order->total_item }} item</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fa-solid fa-receipt"></i>
                    Belum ada transaksi.
                </div>
            @endforelse

        </div>

        @if ($orders->hasPages())
            <div class="pagination-wrap">
                {{ $orders->links() }}
            </div>
        @endif

    </div>

</body>

</html>
