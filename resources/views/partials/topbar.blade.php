<div class="topbar">

    <div class="topbar-left">

    <button class="menu-toggle" id="menuToggle">
            <i class="ti ti-menu-2"></i>
        </button>

        <div>
           <div class="page-title">
    @yield('title', 'Dashboard')
</div>
        </div>

       

    </div>

    <div class="topbar-right">

        <div class="icon-btn">
            <i class="ti ti-bell"></i>
        </div>

        <div class="user-btn">

            <div class="user-avatar">
    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
</div>

<span class="user-btn-name">
    {{ auth()->user()->name }}
</span>

        </div>

    </div>

</div>