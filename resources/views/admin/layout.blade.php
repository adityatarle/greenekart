<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agriculture Equipment Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css"
          rel="stylesheet"
          crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery (required for Summernote on product forms) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 240px;
            --header-height: 56px;
            --admin-bg: #f1f5f9;
            --admin-sidebar: #0f172a;
            --admin-sidebar-hover: rgba(255,255,255,0.06);
            --admin-sidebar-active: rgba(107, 178, 82, 0.18);
            --admin-accent: #6BB252;
            --admin-accent-dark: #4d8a3a;
            --admin-text: #1e293b;
            --admin-text-muted: #64748b;
            --admin-border: #e2e8f0;
            --admin-card: #ffffff;
        }
        
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-size: 0.9375rem;
            line-height: 1.5;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--admin-sidebar);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease;
        }
        
        .sidebar-header {
            padding: 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        
        .sidebar-header img {
            max-height: 36px;
            width: auto;
            border-radius: 6px;
        }
        
        .sidebar-header .sidebar-title {
            color: rgba(255,255,255,0.95);
            margin: 0;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: -0.02em;
        }
        
        .sidebar-nav {
            padding: 12px 10px;
            overflow-y: auto;
            flex: 1;
        }
        
        .sidebar-nav .nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .sidebar-nav .nav-item {
            margin: 0;
        }
        
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.72);
            padding: 10px 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
        }
        
        .sidebar-nav .nav-link i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .sidebar-nav .nav-link:hover {
            color: #fff;
            background: var(--admin-sidebar-hover);
        }
        
        .sidebar-nav .nav-link.active {
            color: #fff;
            background: var(--admin-sidebar-active);
            color: #86efac;
        }
        
        .sidebar-nav .nav-link.active i {
            color: #86efac;
        }
        
        .sidebar-nav .nav-item-external {
            margin-top: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            height: var(--header-height);
            background: var(--admin-card);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
        }
        
        .header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--admin-text);
        }
        
        .header .dropdown .btn {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            border-color: var(--admin-border);
            color: var(--admin-text);
        }
        
        .header .dropdown .btn:hover {
            background: var(--admin-bg);
            border-color: var(--admin-border);
            color: var(--admin-text);
        }
        
        .content {
            padding: 24px;
            flex: 1;
        }
        
        .card {
            border: 1px solid var(--admin-border);
            border-radius: 10px;
            background: var(--admin-card);
            box-shadow: none;
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--admin-border);
            padding: 14px 18px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--admin-text);
        }
        
        .card-header .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0;
        }
        
        .card-body {
            padding: 18px;
        }
        
        .stat-card {
            border-left: 3px solid var(--admin-accent);
            transition: box-shadow 0.2s;
        }
        
        .stat-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .stat-card .card-body {
            padding: 18px;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2px;
            color: var(--admin-text);
            letter-spacing: -0.02em;
        }
        
        .stat-label {
            font-size: 0.8125rem;
            color: var(--admin-text-muted);
            font-weight: 500;
        }
        
        .stat-card .text-muted,
        .stat-card small {
            font-size: 0.75rem;
            color: var(--admin-text-muted);
        }
        
        .table {
            font-size: 0.875rem;
            border: none;
        }
        
        .table thead th {
            background: var(--admin-bg);
            border-bottom: 1px solid var(--admin-border);
            color: var(--admin-text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 10px 14px;
        }
        
        .table td {
            padding: 12px 14px;
            vertical-align: middle;
        }
        
        .table-hover tbody tr:hover {
            background: var(--admin-bg);
        }
        
        .btn-primary {
            background: var(--admin-accent);
            border-color: var(--admin-accent);
            color: #fff;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            background: var(--admin-accent-dark);
            border-color: var(--admin-accent-dark);
            color: #fff;
        }
        
        .btn-outline-primary {
            color: var(--admin-accent);
            border-color: var(--admin-border);
            font-size: 0.875rem;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
        }
        
        .btn-outline-primary:hover {
            background: rgba(107, 178, 82, 0.08);
            border-color: var(--admin-accent);
            color: var(--admin-accent-dark);
        }
        
        .btn-sm {
            font-size: 0.8125rem;
            padding: 4px 10px;
        }
        
        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .chart-container {
            position: relative;
            height: 260px;
        }
        
        .border-left-primary { border-left-color: #64748b !important; }
        .border-left-success { border-left-color: #22c55e !important; }
        .border-left-info { border-left-color: #0ea5e9 !important; }
        .border-left-warning { border-left-color: #f59e0b !important; }
        .border-left-danger { border-left-color: #ef4444 !important; }
        
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .alert-danger { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        
        .form-check-input,
        input[type="checkbox"] {
            width: 1.15em !important;
            height: 1.15em !important;
            min-width: 1.15em !important;
            min-height: 1.15em !important;
            margin-top: 0.15em !important;
            border: 2px solid #cbd5e1 !important;
            background-color: #fff !important;
            cursor: pointer !important;
        }
        .form-check-input:checked, input[type="checkbox"]:checked {
            background-color: var(--admin-accent) !important;
            border-color: var(--admin-accent) !important;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(107, 178, 82, 0.2) !important;
        }
        
        .text-success { color: #22c55e !important; }
        .text-warning { color: #f59e0b !important; }
        .text-danger { color: #ef4444 !important; }
        .text-info { color: #0ea5e9 !important; }
        
        .bg-warning.text-dark { background: #fef3c7 !important; color: #92400e !important; }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .content { padding: 16px; }
        }
    </style>
    
    @if(request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit'))
    <style>
    .note-toolbar { display: flex !important; flex-wrap: wrap !important; }
    .note-editor.note-frame { display: block !important; }
    </style>
    @endif
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('assets/logo/logo.png') }}" alt="Greenleaf">
            <span class="sidebar-title">Admin</span>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-list"></i>
                        Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}" href="{{ route('admin.subcategories.index') }}">
                        <i class="fas fa-list-alt"></i>
                        Subcategories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-tractor"></i>
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                        <i class="fas fa-tag"></i>
                        Brands
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}" href="{{ route('admin.offers.index') }}">
                        <i class="fas fa-tags"></i>
                        Offers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dealers.*') ? 'active' : '' }}" href="{{ route('admin.dealers.index') }}">
                        <i class="fas fa-user-tie"></i>
                        Dealer Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                        <i class="fas fa-users"></i>
                        Customer Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}" href="{{ route('admin.contact-messages.index') }}">
                        <i class="fas fa-envelope"></i>
                        Contact Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                        <i class="fas fa-chart-bar"></i>
                        Reports & Analytics
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item nav-item-external">
                    <a class="nav-link" href="{{ route('agriculture.home') }}">
                        <i class="fas fa-external-link-alt"></i>
                        View Website
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary d-md-none" id="sidebarToggle" type="button">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>Admin
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('auth.logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Summernote JS (after jQuery + Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"
            crossorigin="anonymous"></script>
    @if(request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit'))
    <script>
    (function() {
        function initSummernote() {
            try {
                if (typeof jQuery === 'undefined') return;
                if (!jQuery.fn.summernote) {
                    setTimeout(initSummernote, 250);
                    return;
                }
                var el = document.getElementById('description');
                if (!el) return;
                if (el.nextElementSibling && el.nextElementSibling.classList && el.nextElementSibling.classList.contains('note-editor')) return;
                jQuery('#description').summernote({
                    height: 200,
                    tooltip: false,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link']],
                        ['view', ['codeview']]
                    ]
                });
            } catch (e) {
                console.error('Summernote init error:', e);
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() { setTimeout(initSummernote, 150); });
        } else {
            setTimeout(initSummernote, 150);
        }
        window.addEventListener('load', function() {
            if (document.getElementById('description') && !document.querySelector('#description + .note-editor')) initSummernote();
        });
    })();
    </script>
    @endif
    <script>
        (function() {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            if (toggle && sidebar) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        })();

        // SweetAlert2 for session messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: '{{ session('warning') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });
        @endif

        @if(session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: '{{ session('info') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Handle validation errors
        @if($errors->any())
            const errorMessages = @json($errors->all());
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: '<ul style="text-align: left; margin: 10px 0;"><li>' + errorMessages.join('</li><li>') + '</li></ul>',
                confirmButtonText: 'OK'
            });
        @endif

        // Helper function for SweetAlert (replaces alert())
        window.showAlert = function(message, type = 'info', title = null) {
            const config = {
                icon: type,
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: type === 'error' ? 4000 : 3000,
                timerProgressBar: true
            };
            
            if (title) {
                config.title = title;
            } else {
                config.title = type.charAt(0).toUpperCase() + type.slice(1) + '!';
            }
            
            Swal.fire(config);
        };

        // Replace native alert with SweetAlert
        window.alert = function(message) {
            Swal.fire({
                icon: 'info',
                title: 'Notice',
                text: message,
                confirmButtonText: 'OK'
            });
        };
    </script>
    
    @stack('scripts')
</body>
</html>
