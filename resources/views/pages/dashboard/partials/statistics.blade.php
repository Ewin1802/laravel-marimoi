<div class="dashboard-grid">

    {{-- =====================================================
         PENDAPATAN HARI INI
    ====================================================== --}}

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

                {{ number_format($todayOrders) }}
                transaksi

            </div>

        </div>

    </div>


    {{-- =====================================================
         PENGELUARAN HARI INI
    ====================================================== --}}

    <div class="stat-card">

        <div class="stat-icon red">

            <i data-lucide="wallet-minimal"></i>

        </div>

        <div class="stat-content">

            <div class="stat-title">
                Pengeluaran Hari Ini
            </div>

            <div class="stat-number">

                Rp {{ number_format($todayExpense, 0, ',', '.') }}

            </div>

            <div class="stat-desc">

                <i data-lucide="arrow-down-right"></i>

                Pengeluaran operasional

            </div>

        </div>

    </div>


    {{-- =====================================================
         CASH HARI INI
    ====================================================== --}}

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

                    <div class="progress-bar green" style="width: {{ min($cashPercent, 100) }}%"></div>

                </div>

                <small>
                    {{ $cashPercent }}%
                </small>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TRANSFER HARI INI
    ====================================================== --}}

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

                    <div class="progress-bar blue" style="width: {{ min($transferPercent, 100) }}%"></div>

                </div>

                <small>
                    {{ $transferPercent }}%
                </small>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUK
    ====================================================== --}}

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


    {{-- =====================================================
         KATEGORI
    ====================================================== --}}

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


    {{-- =====================================================
         USER
    ====================================================== --}}

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


    {{-- =====================================================
         INVENTORY
    ====================================================== --}}

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

                {{ number_format($totalStock) }}
                item

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUK FAVORIT
    ====================================================== --}}

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


    {{-- =====================================================
         LABA BERSIH HARI INI
    ====================================================== --}}

    <div class="stat-card net-income-card">

        <div class="stat-icon brown">

            <i data-lucide="chart-no-axes-combined"></i>

        </div>

        <div class="stat-content">

            <div class="stat-title">
                Laba Bersih Hari Ini
            </div>

            <div class="stat-number">

                Rp {{ number_format($todayNetIncome, 0, ',', '.') }}

            </div>

            <div class="stat-desc">

                Pendapatan - pengeluaran

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     RINGKASAN KEUANGAN BULAN INI
========================================================= --}}

<div class="financial-summary">

    {{-- Pendapatan --}}

    <div class="financial-card revenue">

        <div class="financial-icon">

            <i data-lucide="trending-up"></i>

        </div>

        <div>

            <span>
                Pendapatan Bulan Ini
            </span>

            <strong>

                Rp {{ number_format($monthRevenue, 0, ',', '.') }}

            </strong>

        </div>

    </div>


    {{-- Pengeluaran --}}

    <div class="financial-card expense">

        <div class="financial-icon">

            <i data-lucide="trending-down"></i>

        </div>

        <div>

            <span>
                Pengeluaran Bulan Ini
            </span>

            <strong>

                Rp {{ number_format($monthExpense, 0, ',', '.') }}

            </strong>

        </div>

    </div>


    {{-- Laba Bersih --}}

    <div class="financial-card profit">

        <div class="financial-icon">

            <i data-lucide="badge-dollar-sign"></i>

        </div>

        <div>

            <span>
                Laba Bersih Bulan Ini
            </span>

            <strong>

                Rp {{ number_format($monthNetIncome, 0, ',', '.') }}

            </strong>

        </div>

    </div>

</div>


{{-- =========================================================
     RINCIAN PENGELUARAN
========================================================= --}}

<div class="expense-summary-card">

    <div class="expense-summary-header">

        <div>

            <h3>
                Pengeluaran Bulan Ini
            </h3>

            <p>
                Rincian biaya operasional Marimoi Cafe.
            </p>

        </div>

        <a href="{{ route('expenses.index') }}" class="expense-summary-link">

            Lihat Pengeluaran

            <i data-lucide="arrow-up-right"></i>

        </a>

    </div>


    <div class="expense-summary-grid">

        {{-- Gaji --}}

        <div class="expense-category">

            <div class="expense-category-icon salary">

                <i data-lucide="users-round"></i>

            </div>

            <div class="expense-category-content">

                <span>
                    Gaji
                </span>

                <strong>

                    Rp {{ number_format($expenseGaji, 0, ',', '.') }}

                </strong>

            </div>

        </div>


        {{-- Dapur --}}

        <div class="expense-category">

            <div class="expense-category-icon kitchen">

                <i data-lucide="utensils"></i>

            </div>

            <div class="expense-category-content">

                <span>
                    Pengeluaran Dapur
                </span>

                <strong>

                    Rp {{ number_format($expenseDapur, 0, ',', '.') }}

                </strong>

            </div>

        </div>


        {{-- Listrik --}}

        <div class="expense-category">

            <div class="expense-category-icon electricity">

                <i data-lucide="zap"></i>

            </div>

            <div class="expense-category-content">

                <span>
                    Listrik
                </span>

                <strong>

                    Rp {{ number_format($expenseListrik, 0, ',', '.') }}

                </strong>

            </div>

        </div>


        {{-- Tak Terduga --}}

        <div class="expense-category">

            <div class="expense-category-icon unexpected">

                <i data-lucide="triangle-alert"></i>

            </div>

            <div class="expense-category-content">

                <span>
                    Tak Terduga
                </span>

                <strong>

                    Rp {{ number_format($expenseTakTerduga, 0, ',', '.') }}

                </strong>

            </div>

        </div>

    </div>


    {{-- Total --}}

    <div class="expense-total">

        <div>

            <span>
                Total Pengeluaran
            </span>

            <strong>

                Rp {{ number_format($monthExpense, 0, ',', '.') }}

            </strong>

        </div>

        <div class="expense-percentage">

            {{ $expensePercent }}%

            <small>
                dari pendapatan
            </small>

        </div>

    </div>

</div>
