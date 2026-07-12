<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Crypto Dashboard')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="dash-root">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <div class="main flex-grow-1">

        {{-- Topbar --}}
        @include('partials.topbar')

        {{-- Page Content --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

</div>

<script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>