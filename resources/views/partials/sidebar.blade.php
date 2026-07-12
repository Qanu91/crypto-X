<div class="sidebar"  id="sidebar">

<button class="sidebar-close" id="sidebarClose">
    <i class="ti ti-x"></i>
</button>

    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="ti ti-currency-bitcoin"></i>
        </div>

        <div class="logo-text">
            Crypto<span>X</span>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="sidebar-section-label">Main</div>

        <a href="{{ route('dashboard') }}"
class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="ti ti-layout-dashboard"></i>
    <span>Dashboard</span>
</a>

        <a href="{{ route('buy.index') }}"
class="nav-item {{ request()->routeIs('buy.*') ? 'active' : '' }}">
    <i class="ti ti-shopping-cart"></i>
    <span>Buy Crypto</span>
</a>

<a href="{{ route('sell.index') }}"
class="nav-item {{ request()->routeIs('sell.*') ? 'active' : '' }}">
    <i class="ti ti-tag"></i>
    <span>Sell Crypto</span>
</a>

        <div class="sidebar-section-label">Funds</div>

        <a href="{{ route('deposit.index') }}"
class="nav-item {{ request()->routeIs('deposit.*') ? 'active' : '' }}">
    <i class="ti ti-download"></i>
    <span>Deposit</span>
</a>

        <a href="{{ route('withdrawal.index') }}"
class="nav-item {{ request()->routeIs('withdrawal.*') ? 'active' : '' }}">
    <i class="ti ti-upload"></i>
    <span>Withdraw</span>
</a>

<a href="{{ route('transactions.index') }}"
class="nav-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
    <i class="ti ti-history"></i>
    <span>Transactions</span>
</a> 

       <a href="{{ route('wallet.index') }}"
class="nav-item {{ request()->routeIs('wallet.*') ? 'active' : '' }}">
    <i class="ti ti-wallet"></i>
    <span>Wallet</span>
</a>

<form action="{{ route('logout') }}" method="POST">
    @csrf

    <button type="submit" class="nav-item logout-btn">
        <i class="ti ti-logout"></i>
        <span>Logout</span>
    </button>
</form>

    </nav>

</div>