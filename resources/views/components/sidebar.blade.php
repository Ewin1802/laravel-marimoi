<aside class="sidebar">

    {{-- Logo --}}
    <div class="logo">
        <img src="{{ asset('images/logo-icon.png') }}" alt="Marimoi" class="logo-icon">
        <h2>Marimoi</h2>
        <span>Manajemen</span>
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

        {{-- User --}}
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="users"></i>
            </span>

            <span class="menu-title">
                User
            </span>

        </a>

        {{-- Member --}}
        <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="users"></i>
            </span>

            <span class="menu-title">
                Member
            </span>

            @if (($totalMembers ?? 0) > 0)
                <span class="menu-badge">
                    {{ $totalMembers }}
                </span>
            @endif

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
        {{-- <a href="{{ route('discounts.index') }}" class="{{ request()->routeIs('discounts.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="badge-percent"></i>
            </span>

            <span class="menu-title">
                Diskon
            </span>

        </a> --}}

        {{-- Order --}}
        <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="receipt-text"></i>
            </span>

            <span class="menu-title">
                Uang Masuk
            </span>

        </a>

        {{-- Pengeluaran --}}
        <a href="{{ route('expenses.index') }}" class="{{ request()->routeIs('expenses.*') ? 'active' : '' }}">
            <span class="menu-icon">
                <i data-lucide="wallet"></i>
            </span>

            <span class="menu-title">
                Pengeluaran
            </span>
        </a>

        {{-- Settings --}}
        <a href="{{ route('settings.edit') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">

            <span class="menu-icon">
                <i data-lucide="settings"></i>
            </span>

            <span class="menu-title">
                Pengaturan
            </span>

        </a>

        {{-- Buat Pengumuman --}}
        <a href="{{ route('announcements.index') }}"
            class="{{ request()->routeIs('announcements.*') ? 'active' : '' }}">
            <span class="menu-icon">
                <i data-lucide="megaphone"></i>
            </span>
            <span class="menu-title">
                Buat Pengumuman
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
