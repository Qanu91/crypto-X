<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — CryptoX</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Dashboard CSS (shared styles: sidebar, topbar, layout) -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

    <style>
        /* Admin sidebar accent — dark red instead of blue */
        .admin-panel .sidebar { background: #1a0a0a; }
        .admin-panel .sidebar .nav-item.active { background: #dc2626; color: #fff; }
        .admin-panel .logo-text span { color: #dc2626; }
        .admin-panel .logo-icon { background: #dc2626; }

        /* Admin content tables */
        .admin-panel .content .table thead th { background: #f8fafc; font-size: 13px; color: #64748b; }
        .admin-panel .content .card { border-radius: 15px; border: 1px solid #e2e8f0; }
        .admin-panel .content .card-header { background: white; border-bottom: 1px solid #e2e8f0; border-radius: 15px 15px 0 0 !important; }
        .admin-panel .content .card-header h4 { font-size: 18px; font-weight: 700; margin: 0; }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="dash-root admin-panel">

    {{-- Admin Sidebar --}}
    @include('partials.admin-sidebar')

    {{-- Main Content --}}
    <div class="main flex-grow-1">

        {{-- Topbar (reused — shows logged-in admin name) --}}
        @include('partials.topbar')

        {{-- Flash messages --}}
        <div class="content pb-0 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

</div>

<!-- Bootstrap JS (for alert dismiss) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
