<header class="gl-navbar">
  <div class="container-fluid px-3 px-lg-4">
    <!-- Single row: logo + links + search + actions -->
    <div class="gl-navbar__row">
      <a class="gl-navbar__brand" href="{{ route('agriculture.home') }}" aria-label="Greenleaf home">
        <img src="{{ asset('assets/logo/logo.png') }}" alt="Greenleaf" class="gl-navbar__logo">
      </a>

      <div class="gl-navbar__links d-none d-lg-flex" aria-label="Primary">
        <a class="gl-navlink {{ request()->routeIs('agriculture.home') ? 'active' : '' }}" href="{{ route('agriculture.home') }}">Home</a>
        <a class="gl-navlink {{ request()->routeIs('agriculture.products.*') ? 'active' : '' }}" href="{{ route('agriculture.products.index') }}">Shop</a>
        <a class="gl-navlink {{ request()->routeIs('agriculture.categories.*') ? 'active' : '' }}" href="{{ route('agriculture.categories.index') }}">Categories</a>
        <a class="gl-navlink {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
        <a class="gl-navlink {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
      </div>

      <form class="gl-navbar__search" action="{{ route('agriculture.products.search') }}" method="GET" role="search">
        <svg class="gl-navbar__searchIcon" width="18" height="18"><use xlink:href="#search"></use></svg>
        <input type="text" name="q" class="gl-navbar__searchInput" placeholder="Search products…" value="{{ request('q') }}">
        <button class="gl-navbar__searchBtn" type="submit">Search</button>
      </form>

      <div class="gl-navbar__actions d-none d-lg-flex">
        <a
          href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isDealer() ? route('dealer.dashboard') : route('customer.profile'))) : route('auth.login') }}"
          class="gl-icon-btn"
          aria-label="{{ auth()->check() ? 'My account' : 'Login' }}"
          title="{{ auth()->check() ? 'My Account' : 'Login' }}"
        >
          <svg width="22" height="22"><use xlink:href="#user"></use></svg>
        </a>
        <a href="{{ auth()->check() ? route('agriculture.wishlist.index') : route('auth.login') }}" class="gl-icon-btn" aria-label="Wishlist" title="Wishlist">
          <svg width="22" height="22"><use xlink:href="#heart"></use></svg>
          @if(($wishlistCount ?? 0) > 0)
            <span class="gl-badge">{{ $wishlistCount }}</span>
          @endif
        </a>
        <a href="#" class="gl-icon-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" aria-label="Cart" title="Shopping Cart">
          <svg width="22" height="22"><use xlink:href="#cart"></use></svg>
          @if(($cartCount ?? 0) > 0)
            <span class="gl-badge">{{ $cartCount }}</span>
          @endif
        </a>
      </div>

      <div class="d-flex align-items-center gap-2 d-lg-none">
        <a href="{{ auth()->check() ? route('agriculture.wishlist.index') : route('auth.login') }}" class="gl-icon-btn" aria-label="Wishlist">
          <svg width="22" height="22"><use xlink:href="#heart"></use></svg>
          @if(($wishlistCount ?? 0) > 0)
            <span class="gl-badge">{{ $wishlistCount }}</span>
          @endif
        </a>
        <a href="#" class="gl-icon-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart" aria-label="Cart">
          <svg width="22" height="22"><use xlink:href="#cart"></use></svg>
          @if(($cartCount ?? 0) > 0)
            <span class="gl-badge">{{ $cartCount }}</span>
          @endif
        </a>
        <button class="gl-navbar__menuBtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#glNavOffcanvas" aria-controls="glNavOffcanvas" aria-label="Menu">
          <svg width="22" height="22"><use xlink:href="#menu"></use></svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile offcanvas menu -->
  <div class="offcanvas offcanvas-end gl-nav-offcanvas" tabindex="-1" id="glNavOffcanvas" aria-labelledby="glNavOffcanvasLabel">
    <div class="offcanvas-header">
      <div class="d-flex align-items-center gap-2">
        <img src="{{ asset('assets/logo/logo.png') }}" alt="Greenleaf" class="gl-nav-offcanvas__logo">
        <strong id="glNavOffcanvasLabel">Menu</strong>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <form class="gl-nav-offcanvas__search" action="{{ route('agriculture.products.search') }}" method="GET" role="search">
        <input type="text" name="q" class="form-control" placeholder="Search products…" value="{{ request('q') }}">
        <button class="btn btn-primary" type="submit">Search</button>
      </form>

      <div class="list-group list-group-flush mt-3">
        <a class="list-group-item list-group-item-action {{ request()->routeIs('agriculture.home') ? 'active' : '' }}" href="{{ route('agriculture.home') }}">Home</a>
        <a class="list-group-item list-group-item-action {{ request()->routeIs('agriculture.products.*') ? 'active' : '' }}" href="{{ route('agriculture.products.index') }}">Shop</a>
        <a class="list-group-item list-group-item-action {{ request()->routeIs('agriculture.categories.*') ? 'active' : '' }}" href="{{ route('agriculture.categories.index') }}">Categories</a>
        <a class="list-group-item list-group-item-action {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
        <a class="list-group-item list-group-item-action {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
        <a class="list-group-item list-group-item-action" href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isDealer() ? route('dealer.dashboard') : route('customer.profile'))) : route('auth.login') }}">
          {{ auth()->check() ? 'My Account' : 'Login' }}
        </a>
      </div>
    </div>
  </div>

  <!-- Category chips bar (products + categories pages) -->
  @php
    $headerCategories = \App\Models\AgricultureCategory::where('is_active', true)->orderBy('name')->take(12)->get();
    $showCategoriesNav = request()->routeIs('agriculture.products.*') || request()->routeIs('agriculture.categories.*');
  @endphp
  @if($headerCategories->count() > 0 && $showCategoriesNav)
    <div class="gl-catbar">
      <div class="container-fluid px-3 px-lg-4">
        <div class="gl-catbar__scroll">
          <a href="{{ route('agriculture.products.index') }}" class="gl-chip {{ !request('category') && request()->routeIs('agriculture.products.index') ? 'active' : '' }}">All</a>
          @foreach($headerCategories as $cat)
            <a href="{{ route('agriculture.products.index', ['category' => $cat->id]) }}" class="gl-chip {{ request('category') == $cat->id ? 'active' : '' }}">
              {{ $cat->name }}
            </a>
          @endforeach
          @if(\App\Models\AgricultureCategory::where('is_active', true)->count() > 12)
            <a href="{{ route('agriculture.categories.index') }}" class="gl-chip gl-chip--link">View all</a>
          @endif
        </div>
      </div>
    </div>
  @endif
</header>

