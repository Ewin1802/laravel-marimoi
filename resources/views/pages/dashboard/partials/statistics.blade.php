<div class="dashboard-grid">

    {{-- Pendapatan Hari Ini --}}
    <div class="stat-card">

        <div class="stat-icon emerald">
            <i data-lucide="wallet"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">
                Pendapatan Hari Ini
            </div>

            <div class="stat-number">
                Rp {{ number_format($todayRevenue, 0, ',', '.') }}
            </div>

            <div class="stat-desc">

                <i data-lucide="trending-up"></i>

                {{ number_format($todayOrders) }} transaksi

            </div>

        </div>

    </div>

    {{-- Cash --}}
    <div class="stat-card">

        <div class="stat-icon green">
            <i data-lucide="banknote"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">
                Cash Hari Ini
            </div>

            <div class="stat-number">
                Rp {{ number_format($todayCash, 0, ',', '.') }}
            </div>

            <div class="stat-progress">

                <div class="progress">

                    <div class="progress-bar green" style="width:{{ $cashPercent }}%">
                    </div>

                </div>

                <small>{{ $cashPercent }}%</small>

            </div>

        </div>

    </div>

    {{-- Transfer --}}
    <div class="stat-card">

        <div class="stat-icon blue">
            <i data-lucide="landmark"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">
                Transfer Hari Ini
            </div>

            <div class="stat-number">
                Rp {{ number_format($todayTransfer, 0, ',', '.') }}
            </div>

            <div class="stat-progress">

                <div class="progress">

                    <div class="progress-bar blue" style="width:{{ $transferPercent }}%">
                    </div>

                </div>

                <small>{{ $transferPercent }}%</small>

            </div>

        </div>

    </div>

    {{-- Produk --}}
    <div class="stat-card">

        <div class="stat-icon orange">
            <i data-lucide="package"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">

                Total Produk

            </div>

            <div class="stat-number">

                {{ number_format($totalProducts) }}

            </div>

            <div class="stat-desc">

                {{ $activeProducts }} aktif
                •
                {{ $inactiveProducts }} nonaktif

            </div>

        </div>

    </div>

    {{-- Kategori --}}
    <div class="stat-card">

        <div class="stat-icon purple">
            <i data-lucide="layout-grid"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">

                Kategori

            </div>

            <div class="stat-number">

                {{ number_format($totalCategories) }}

            </div>

            <div class="stat-desc">

                Master kategori produk

            </div>

        </div>

    </div>

    {{-- User --}}
    <div class="stat-card">

        <div class="stat-icon cyan">
            <i data-lucide="users"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">

                Pengguna

            </div>

            <div class="stat-number">

                {{ number_format($totalUsers) }}

            </div>

            <div class="stat-desc">

                Total akun sistem

            </div>

        </div>

    </div>

    {{-- Nilai Inventory --}}
    <div class="stat-card">

        <div class="stat-icon yellow">
            <i data-lucide="warehouse"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">

                Nilai Inventory

            </div>

            <div class="stat-number">

                Rp {{ number_format($stockValue, 0, ',', '.') }}

            </div>

            <div class="stat-desc">

                {{ number_format($totalStock) }} item

            </div>

        </div>

    </div>

    {{-- Produk Favorit --}}
    <div class="stat-card">

        <div class="stat-icon red">
            <i data-lucide="heart"></i>
        </div>

        <div class="stat-content">

            <div class="stat-title">

                Produk Favorit

            </div>

            <div class="stat-number">

                {{ number_format($favoriteProductsCount) }}

            </div>

            <div class="stat-desc">

                Ditampilkan di Landing Page

            </div>

        </div>

    </div>

</div>
