<div class="sidebar" id="sidebar">

    <button class="sidebar-close" id="sidebarClose">
        <i class="ti ti-x"></i>
    </button>

    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="ti ti-shield-check"></i>
        </div>
        <div class="logo-text">
            Admin<span>X</span>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="sidebar-section-label">Overview</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="ti ti-layout-dashboard"></i>
            <span>Dashboard</span>
        </a>

        <div class="sidebar-section-label">Orders</div>

        <a href="{{ route('admin.deposits') }}"
           class="nav-item {{ request()->routeIs('admin.deposits') ? 'active' : '' }}">
            <i class="ti ti-download"></i>
            <span>Deposits</span>
        </a>

        <a href="{{ route('admin.withdrawals') }}"
           class="nav-item {{ request()->routeIs('admin.withdrawals') ? 'active' : '' }}">
            <i class="ti ti-upload"></i>
            <span>Withdrawals</span>
        </a>

        <a href="{{ route('admin.buy-orders') }}"
           class="nav-item {{ request()->routeIs('admin.buy-orders') ? 'active' : '' }}">
            <i class="ti ti-shopping-cart"></i>
            <span>Buy Orders</span>
        </a>

        <a href="{{ route('admin.sell-orders') }}"
           class="nav-item {{ request()->routeIs('admin.sell-orders') ? 'active' : '' }}">
            <i class="ti ti-tag"></i>
            <span>Sell Orders</span>
        </a>

        <div class="sidebar-section-label">Settings</div>

        <a href="{{ route('admin.exchange-rates') }}"
           class="nav-item {{ request()->routeIs('admin.exchange-rates') ? 'active' : '' }}">
            <i class="ti ti-currency-dollar"></i>
            <span>Exchange Rates</span>
        </a>

        <div class="sidebar-section-label">Account</div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item logout-btn">
                <i class="ti ti-logout"></i>
                <span>Logout</span>
            </button>
        </form>

    </nav>

</div>
