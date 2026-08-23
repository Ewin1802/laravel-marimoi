<div class="dashboard-header">

    {{-- =====================================================
         TITLE
    ====================================================== --}}

    <div>

        <h1>
            Dashboard
        </h1>

        <p>
            Selamat datang kembali.
            Berikut ringkasan performa Marimoi Cafe hari ini.
        </p>

    </div>


    {{-- =====================================================
         DATE
    ====================================================== --}}

    <div class="dashboard-date-card">

        <div class="date-icon">

            <i data-lucide="calendar-days"></i>

        </div>

        <div>

            <div class="date-title">

                {{ now()->translatedFormat('l') }}

            </div>

            <div class="date-subtitle">

                {{ now()->translatedFormat('d F Y') }}

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     HIGHLIGHT
========================================================= --}}

<div class="dashboard-highlight">


    {{-- =====================================================
         1. PENDAPATAN
    ====================================================== --}}

    <div class="highlight-card green">

        <div class="highlight-title">

            Pendapatan Bulan Ini

        </div>

        <div class="highlight-value">

            Rp {{ number_format($monthRevenue ?? 0, 0, ',', '.') }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="trending-up"></i>

            <span>

                {{ number_format($monthOrders ?? 0) }}

                transaksi

            </span>

        </div>

    </div>



    {{-- =====================================================
         2. PENGELUARAN
    ====================================================== --}}

    <div class="highlight-card brown">

        <div class="highlight-title">

            Pengeluaran Bulan Ini

        </div>

        <div class="highlight-value">

            Rp {{ number_format($monthExpense ?? 0, 0, ',', '.') }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="trending-down"></i>

            <span>

                {{ number_format($expensePercent ?? 0, 1) }}%

                dari pendapatan

            </span>

        </div>

    </div>



    {{-- =====================================================
         3. LABA BERSIH
    ====================================================== --}}

    <div class="highlight-card profit">

        <div class="highlight-title">

            Laba Bersih Bulan Ini

        </div>

        <div class="highlight-value">

            Rp {{ number_format($monthNetIncome ?? 0, 0, ',', '.') }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="badge-dollar-sign"></i>

            <span>

                Margin

                {{ number_format($netIncomePercent ?? 0, 1) }}%

            </span>

        </div>

    </div>



    {{-- =====================================================
         4. RATA-RATA TRANSAKSI
    ====================================================== --}}

    <div class="highlight-card orange">

        <div class="highlight-title">

            Rata-rata Transaksi

        </div>

        <div class="highlight-value">

            Rp {{ number_format($averageOrder ?? 0, 0, ',', '.') }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="wallet"></i>

            <span>

                Nilai rata-rata transaksi

            </span>

        </div>

    </div>


</div>
