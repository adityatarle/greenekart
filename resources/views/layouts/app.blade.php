<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Greenleaf - Premium Agriculture Equipment & Farming Solutions')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="@yield('keywords', 'agriculture, equipment, machinery, farming, tractors, irrigation, harvesting')">
    <meta name="description" content="@yield('description', 'Premium agriculture equipment and farming machinery for modern farmers')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/organic/css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/organic/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/organic/style.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('styles')
    
    <!-- Modern Custom Styles -->
    <style>
        :root {
            --primary-color: #6BB252;
            --primary-dark: #4a8a3a;
            --primary-light: #8bc34a;
            --secondary-color: #2c3e50;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --border-color: #e9ecef;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Global Styles */
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Nunito', 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-dark);
            line-height: 1.45;
            background-color: #ffffff;
            font-size: 0.95rem;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-dark);
        }
        
        a {
            text-decoration: none;
            transition: var(--transition);
        }
        
        /* Buttons */
        .btn {
            border-radius: 8px;
            padding: 7px 16px;
            font-weight: 600;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        /* Compact global tuning (to avoid “big-big” UI) */
        .container-lg, .container {
            --bs-gutter-x: 1.25rem;
        }
        .form-control, .form-select {
            padding: 0.45rem 0.75rem;
            font-size: 0.9rem;
        }
        .breadcrumb {
            font-size: 0.85rem;
        }
        .badge {
            font-weight: 600;
        }
        .display-5 {
            font-size: calc(1.25rem + 1.2vw);
        }
        .lead {
            font-size: 1rem;
        }
        .py-5 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
        .py-4 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }
        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
        .g-4, .gy-4, .gx-4 {
            --bs-gutter-x: 1.25rem;
            --bs-gutter-y: 1.25rem;
        }
        .g-3, .gy-3, .gx-3 {
            --bs-gutter-x: 1rem;
            --bs-gutter-y: 1rem;
        }
        .g-2, .gy-2, .gx-2 {
            --bs-gutter-x: 0.75rem;
            --bs-gutter-y: 0.75rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Modern Header Styling */
        .main-header {
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #e9ecef;
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            gap: 20px;
        }

        /* Logo */
        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .logo-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: transform 0.2s ease;
        }

        .logo-link:hover {
            transform: scale(1.02);
        }

        .logo-text {
            font-weight: 800;
            font-size: 1.75rem;
            background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .logo-img {
            max-height: 45px;
            width: auto;
        }

        .mobile-menu-toggle {
            background: none;
            border: none;
            padding: 8px;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Search Bar */
        .header-search {
            flex: 1;
            max-width: 600px;
            margin: 0 20px;
        }

        .search-form {
            width: 100%;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            padding: 10px 16px;
            transition: all 0.3s ease;
        }

        .search-input-wrapper:focus-within {
            border-color: #6BB252;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(107, 178, 82, 0.1);
        }

        .search-icon {
            color: #6c757d;
            margin-right: 12px;
            flex-shrink: 0;
            fill: currentColor;
        }

        .search-input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.95rem;
            color: #333;
        }

        .search-input::placeholder {
            color: #adb5bd;
        }

        .search-submit {
            background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 8px;
        }

        .search-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(107, 178, 82, 0.3);
        }

        /* Navigation */
        .header-nav {
            flex-shrink: 0;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 30px;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 18px;
            color: #495057;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        /* .nav-link:hover {
            color: #6BB252;
            background: #f8f9fa;
        } */

        .nav-link.active {
            color: #6BB252;
            background: rgba(107, 178, 82, 0.1);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
            border-radius: 2px;
        }

        /* Action Icons */
        .header-actions {
            flex-shrink: 0;
        }

        .action-icons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .action-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: #495057;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .action-icon svg {
            fill: currentColor;
        }

        .action-icon:hover {
            color: #6BB252;
            background: #f8f9fa;
            transform: translateY(-2px);
        }

        .icon-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            padding: 0 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Responsive Header */
        @media (max-width: 991px) {
            .header-wrapper {
                flex-wrap: wrap;
            }

            .header-search {
                order: 3;
                width: 100%;
                margin: 12px 0 0 0;
            }

            .header-logo {
                flex: 1;
            }

            .header-actions {
                margin-left: auto;
            }
        }

        @media (max-width: 767px) {
            .header-wrapper {
                padding: 12px 0;
            }

            .search-input-wrapper {
                padding: 8px 12px;
            }

            .search-submit {
                padding: 6px 16px;
                font-size: 0.8rem;
            }

            .action-icon {
                width: 36px;
                height: 36px;
            }
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.5;
        }
        
        .hero-section > * {
            position: relative;
            z-index: 1;
        }
        
        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            margin-bottom: 24px;
            line-height: 1.1;
        }
        
        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            margin-bottom: 32px;
            opacity: 0.95;
            line-height: 1.6;
        }
        
        /* Product Cards */
        /* Product card styles are now in product-card.blade.php component */
        .product-card-wrapper {
            height: 100%;
        }
        
        /* Ensure consistent card heights in grid layouts */
        .row.g-3 > [class*="col-"] {
            display: flex;
        }
        
        .row.g-3 > [class*="col-"] > .product-card-wrapper {
            width: 100%;
        }
        
        .product-category {
            color: var(--primary-color);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .product-name a {
            color: var(--text-dark);
            transition: var(--transition);
        }
        
        .product-name a:hover {
            color: var(--primary-color);
        }
        
        .current-price {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 700;
            margin: 12px 0;
        }
        
        .old-price {
            color: var(--text-muted);
            text-decoration: line-through;
            font-size: 1rem;
            margin-left: 8px;
        }
        
        /* Category Cards */
        .category-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }
        
        .category-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }
        
        .category-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .category-card:hover img {
            transform: scale(1.1);
        }
        
        /* Section Headers */
        .section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 800;
            margin-bottom: 16px;
            color: var(--text-dark);
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            border-radius: 2px;
        }
        
        .section-header {
            margin-bottom: 40px;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: var(--shadow-md);
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-bottom: 2px solid var(--border-color);
            padding: 20px;
            border-radius: 16px 16px 0 0 !important;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 700;
            color: var(--text-dark);
        }
        
        /* Forms */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            transition: var(--transition);
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(107, 178, 82, 0.15);
        }
        
        /* Checkboxes - ensure visibility everywhere */
        .form-check-input,
        input[type="checkbox"] {
            width: 1.2em !important;
            height: 1.2em !important;
            min-width: 1.2em !important;
            min-height: 1.2em !important;
            margin-top: 0.15em !important;
            border: 2px solid #adb5bd !important;
            background-color: #fff !important;
            cursor: pointer !important;
            flex-shrink: 0 !important;
        }
        .form-check-input:checked,
        input[type="checkbox"]:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(107, 178, 82, 0.25) !important;
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            color: rgba(255,255,255,0.9);
            padding: 60px 0 30px;
        }
        
        footer .widget-title {
            color: var(--primary-light);
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.125rem;
        }
        
        footer .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 6px 0;
            transition: var(--transition);
        }
        
        footer .nav-link:hover {
            color: var(--primary-light);
            padding-left: 8px;
        }
        
        #footer-bottom {
            background: rgba(0,0,0,0.2);
            padding: 20px 0;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        /* Spacing */
        section {
            padding: 80px 0;
        }
        
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            section {
                padding: 50px 0;
            }
            
            .hero-section {
                padding: 60px 0 40px;
            }
            
            .product-card .card-img-top,
            .product-card img {
                height: 180px;
            }
            
            .header-bottom .navbar-nav .nav-link {
                padding: 8px 16px !important;
                font-size: 0.9rem;
            }
        }
        
        /* Utilities */
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%) !important;
        }
        
        .shadow-sm {
            box-shadow: var(--shadow-sm) !important;
        }
        
        .shadow-md {
            box-shadow: var(--shadow-md) !important;
        }
        
        .shadow-lg {
            box-shadow: var(--shadow-lg) !important;
        }
    </style>
</head>
<body>

    <!-- SVG Icons -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="facebook" viewBox="0 0 24 24"><path fill="currentColor" d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="twitter" viewBox="0 0 24 24"><path fill="currentColor" d="M22.991 3.95a1 1 0 0 0-1.51-.86a7.48 7.48 0 0 1-1.874.794a5.152 5.152 0 0 0-3.374-1.242a5.232 5.232 0 0 0-5.223 5.063a11.032 11.032 0 0 1-6.814-3.924a1.012 1.012 0 0 0-.857-.365a.999.999 0 0 0-.785.5a5.276 5.276 0 0 0-.242 4.769l-.002.001a1.041 1.041 0 0 0-.496.89a3.042 3.042 0 0 0 .027.439a5.185 5.185 0 0 0 1.568 3.312a.998.998 0 0 0-.066.77a5.204 5.204 0 0 0 2.362 2.922a7.465 7.465 0 0 1-3.59.448A1 1 0 0 0 1.45 19.3a12.942 12.942 0 0 0 7.01 2.061a12.788 12.788 0 0 0 12.465-9.363a12.822 12.822 0 0 0 .535-3.646l-.001-.2a5.77 5.77 0 0 0 1.532-4.202Zm-3.306 3.212a.995.995 0 0 0-.234.702c.01.165.009.331.009.488a10.824 10.824 0 0 1-.454 3.08a10.685 10.685 0 0 1-10.546 7.93a10.938 10.938 0 0 1-2.55-.301a9.48 9.48 0 0 0 2.942-1.564a1 1 0 0 0-.602-1.786a3.208 3.208 0 0 1-2.214-.935q.224-.042.445-.105a1 1 0 0 0-.08-1.943a3.198 3.198 0 0 1-2.25-1.726a5.3 5.3 0 0 0 .545.046a1.02 1.02 0 0 0 .984-.696a1 1 0 0 0-.4-1.137a3.196 3.196 0 0 1-1.425-2.673c0-.066.002-.133.006-.198a13.014 13.014 0 0 0 8.21 3.48a1.02 1.02 0 0 0 .817-.36a1 1 0 0 0 .206-.867a3.157 3.157 0 0 1-.087-.729a3.23 3.23 0 0 1 3.226-3.226a3.184 3.184 0 0 1 2.345 1.02a.993.993 0 0 0 .921.298a9.27 9.27 0 0 0 1.212-.322a6.681 6.681 0 0 1-1.026 1.524Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="youtube" viewBox="0 0 24 24"><path fill="currentColor" d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="instagram" viewBox="0 0 24 24"><path fill="currentColor" d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="menu" viewBox="0 0 24 24"><path fill="currentColor" d="M2 6a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m0 6.032a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m1 5.033a1 1 0 1 0 0 2h18a1 1 0 0 0 0-2z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24"><path fill="currentColor" d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24"><path fill="currentColor" d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="9" r="3"/><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5"/></g></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24"><path fill="currentColor" d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24"><path fill="currentColor" d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24"><path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z"/></symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15"><path fill="currentColor" d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z"/></symbol>
        </defs>
    </svg>

    <!-- Preloader -->
    <div class="preloader-wrapper">
        <div class="preloader"></div>
    </div>

    <!-- Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your cart</span>
                    <span class="badge bg-primary rounded-pill" id="cart-count">
                        @php
                            $cartCount = 0;
                            if(session('cart')) {
                                foreach(session('cart') as $item) {
                                    $cartCount += $item['quantity'];
                                }
                            }
                        @endphp
                        {{ $cartCount }}
                    </span>
                </h4>
                <div id="cart-items">
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $item)
                            @php
                                $product = \App\Models\AgricultureProduct::find($item['product_id']);
                            @endphp
                            @if($product)
                                <div class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $product->name }}</h6>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                    </div>
                                    <span class="text-muted">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-muted">Your cart is empty</p>
                    @endif
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Total (INR)</span>
                            <strong id="cart-total">
                                @php
                                    $cartTotal = 0;
                                    if(session('cart')) {
                                        foreach(session('cart') as $item) {
                                            $cartTotal += $item['price'] * $item['quantity'];
                                        }
                                    }
                                @endphp
                                ₹{{ number_format($cartTotal, 2) }}
                            </strong>
                        </div>
                        <a href="{{ route('agriculture.cart.index') }}" class="btn btn-primary w-100 mt-3">View Cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/organic/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/organic/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/organic/js/script.js') }}"></script>
    
    <!-- CSRF Token for AJAX -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };

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

        // Handle validation errors (skip on login/auth pages - they show errors inline)
        @php
            $isAuthPage = request()->routeIs('admin.login') || 
                          request()->routeIs('auth.login') || 
                          request()->routeIs('auth.register') ||
                          request()->is('*/login') ||
                          request()->is('*/register');
        @endphp
        @if($errors->any() && !$isAuthPage)
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


