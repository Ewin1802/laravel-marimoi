<div class="dashboard-header">

    <div>

        <h1>

            Dashboard

        </h1>

        <p>

            Selamat datang kembali.
            Berikut ringkasan performa cafe hari ini.

        </p>

    </div>

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

<div class="dashboard-highlight">

    <div class="highlight-card green">

        <div class="highlight-title">

            Pendapatan Bulan Ini

        </div>

        <div class="highlight-value">

            Rp {{ number_format($monthRevenue, 0, ',', '.') }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="trending-up"></i>

            Total transaksi bulan berjalan

        </div>

    </div>

    <div class="highlight-card blue">

        <div class="highlight-title">

            Order Bulan Ini

        </div>

        <div class="highlight-value">

            {{ number_format($monthOrders) }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="shopping-bag"></i>

            Total transaksi berhasil

        </div>

    </div>

    <div class="highlight-card orange">

        <div class="highlight-title">

            Rata-rata Transaksi

        </div>

        <div class="highlight-value">

            Rp {{ number_format($averageOrder, 0, ',', '.') }}

        </div>

        <div class="highlight-footer">

            <i data-lucide="wallet"></i>

            Nilai rata-rata setiap transaksi

        </div>

    </div>

</div>
