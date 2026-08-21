<aside class="sidebar">

    {{-- Logo --}}
    <div class="logo">

        <h2>Marimoi Cafe</h2>

        <span>Point Of Sales</span>

    </div>

    {{-- Menu --}}
    <nav class="sidebar-menu">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="layout-dashboard"></i>
            </span>

            <span class="menu-title">
                Dashboard
            </span>

        </a>

        {{-- Category --}}
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="layers-3"></i>
            </span>

            <span class="menu-title">
                Kategori
            </span>

        </a>

        {{-- Product --}}
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="package"></i>
            </span>

            <span class="menu-title">
                Produk
            </span>

        </a>

        {{-- Discount --}}
        <a href="{{ route('discounts.index') }}" class="{{ request()->routeIs('discounts.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="badge-percent"></i>
            </span>

            <span class="menu-title">
                Diskon
            </span>

        </a>

        {{-- User --}}
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="users"></i>
            </span>

            <span class="menu-title">
                User
            </span>

        </a>

        {{-- Order --}}
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="receipt-text"></i>
            </span>

            <span class="menu-title">
                Laporan Transaksi
            </span>

        </a>

    </nav>

    {{-- Footer --}}
    <div class="sidebar-footer">

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button type="submit" class="sidebar-logout">

                <span class="menu-icon">
                    <i data-lucide="log-out"></i>
                </span>

                <span class="menu-title">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>
