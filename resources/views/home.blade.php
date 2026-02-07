@extends('layouts.app')

@section('content')

{{-- Main Layout with Sidebar --}}
<div class="home-layout-container">
  <div class="container-fluid px-3 px-lg-4">
    <div class="row g-0">

      {{-- Left Sidebar with Categories --}}
      <div class="col-lg-3 sidebar-wrapper">
        <div class="categories-sidebar">
          <div class="sidebar-header">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="7" height="7"></rect>
              <rect x="14" y="3" width="7" height="7"></rect>
              <rect x="14" y="14" width="7" height="7"></rect>
              <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span class="sidebar-title">Categories</span>
          </div>
          <div class="sidebar-content">
            @if(isset($allCategories) && $allCategories->count() > 0)
            <ul class="category-list">
              @foreach($allCategories as $category)
              <li class="category-item" data-category-id="{{ $category->id }}">
                <a href="{{ route('agriculture.categories.show', $category) }}" class="category-link">
                  <div class="category-icon-wrap">
                    @php
                    $categoryImageUrl = $category->image
                    ? \App\Helpers\ImageHelper::imageUrl($category->image)
                    : asset('assets/organic/images/category-placeholder.jpg');
                    @endphp
                    <img src="{{ $categoryImageUrl }}" alt="{{ $category->name }}" class="category-icon">
                  </div>
                  <span class="category-name">{{ $category->name }}</span>
                  @if($category->subcategories->count() > 0)
                  <svg class="arrow-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                  </svg>
                  @endif
                </a>

                {{-- Subcategories Dropdown --}}
                @if($category->subcategories->count() > 0)
                <div class="subcategories-dropdown">
                  <ul class="subcategory-list">
                    @foreach($category->subcategories as $subcategory)
                    <li class="subcategory-item">
                      <a href="{{ route('agriculture.products.index', ['subcategory' => $subcategory->id]) }}" class="subcategory-link">
                        <span class="subcategory-bullet"></span>
                        {{ $subcategory->name }}
                      </a>
                    </li>
                    @endforeach
                  </ul>
                </div>
                @endif
              </li>
              @endforeach
            </ul>
            @else
            <p class="text-muted text-center py-4">No categories available</p>
            @endif
          </div>
        </div>
      </div>

      {{-- Right Content Area --}}
      <div class="col-lg-9 content-wrapper">
        {{-- Hero Banner Section --}}
        <section class="hero-banner">
          <div class="hero-overlay"></div>
          <div class="hero-content">
            <div class="hero-text">
              <h1 class="hero-title">
                Premium Agriculture
                <span class="highlight">Equipment</span>
                & Products
              </h1>
              <p class="hero-description">
                Transform your farming with world-class, innovative, and affordable agricultural solutions.
                Empowering farmers with smart tools for smarter agriculture.
              </p>
              <div class="hero-actions">
                <a href="{{ route('agriculture.products.index') }}" class="btn-hero-primary">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  Shop Now
                </a>
                <a href="{{ route('dealer.registration') }}" class="btn-hero-secondary">
                  Become a Dealer
                </a>
              </div>
            </div>
          </div>
        </section>

        {{-- Categories with Subcategories Sections --}}
        @if(isset($categories) && $categories->count() > 0)
        @foreach($categories as $category)
        <section class="category-section {{ $loop->even ? 'bg-alt' : '' }}">
          <div class="section-header-bar">
            <div class="section-title-wrap">
              <h2 class="section-main-title">{{ strtoupper($category->name) }}</h2>
              <div class="title-underline"></div>
            </div>
            <a href="{{ route('agriculture.categories.show', $category) }}" class="view-all-link">
              View All
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>

          <div class="subcategory-grid">
            @if($category->subcategories && $category->subcategories->count() > 0)
              @foreach($category->subcategories as $subcategory)
              <a href="{{ route('agriculture.products.index', ['subcategory' => $subcategory->id]) }}" class="subcategory-card">
                <div class="subcat-image-wrap">
                  @php
                  $subcategoryImageUrl = $subcategory->image
                  ? \App\Helpers\ImageHelper::imageUrl($subcategory->image)
                  : asset('assets/organic/images/category-placeholder.jpg');
                  @endphp
                  <img src="{{ $subcategoryImageUrl }}" alt="{{ $subcategory->name }}">
                </div>
                <div class="subcat-info">
                  <h4 class="subcat-name">{{ $subcategory->name }}</h4>
                </div>
              </a>
              @endforeach
            @else
              <div class="empty-subcategories">
                <p>No subcategories available for this category.</p>
              </div>
            @endif
          </div>
        </section>
        @endforeach
        @endif

        {{-- Stats Section --}}
        <section class="stats-section">
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon green">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="9" cy="21" r="1"></circle>
                  <circle cx="20" cy="21" r="1"></circle>
                  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
              </div>
              <div class="stat-content">
                <span class="stat-number">{{ $stats['total_products'] ?? 0 }}+</span>
                <span class="stat-label">Quality Products</span>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon blue">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="3" width="7" height="7"></rect>
                  <rect x="14" y="3" width="7" height="7"></rect>
                  <rect x="14" y="14" width="7" height="7"></rect>
                  <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
              </div>
              <div class="stat-content">
                <span class="stat-number">{{ $stats['total_categories'] ?? 0 }}+</span>
                <span class="stat-label">Categories</span>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon orange">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </div>
              <div class="stat-content">
                <span class="stat-number">{{ $stats['total_customers'] ?? 0 }}+</span>
                <span class="stat-label">Happy Farmers</span>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon purple">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
              </div>
              <div class="stat-content">
                <span class="stat-number">100%</span>
                <span class="stat-label">Secure Payment</span>
              </div>
            </div>
          </div>
        </section>

        {{-- Best Selling Products --}}
        <section class="products-section">
          <div class="section-header-bar">
            <div class="section-title-wrap">
              <h2 class="section-main-title">BEST SELLING PRODUCTS</h2>
              <div class="title-underline"></div>
            </div>
            <a href="{{ route('agriculture.products.index') }}" class="view-all-link">
              View All
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>
          <div class="products-grid">
            @forelse($bestSellers as $product)
            <div class="product-item">
              @include('components.product-card', ['product' => $product])
            </div>
            @empty
            <div class="empty-products">
              <p>No products available at the moment.</p>
              <a href="{{ route('agriculture.products.index') }}" class="btn-primary-sm">Browse All Products</a>
            </div>
            @endforelse
          </div>
        </section>

        {{-- Featured Products --}}
        <section class="products-section bg-alt">
          <div class="section-header-bar">
            <div class="section-title-wrap">
              <h2 class="section-main-title">FEATURED PRODUCTS</h2>
              <div class="title-underline"></div>
            </div>
            <a href="{{ route('agriculture.products.index') }}" class="view-all-link">
              View All
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>
          <div class="products-grid">
            @forelse($featuredProducts as $product)
            <div class="product-item">
              @include('components.product-card', ['product' => $product])
            </div>
            @empty
            <div class="empty-products">
              <p>No featured products available.</p>
            </div>
            @endforelse
          </div>
        </section>

        {{-- Promotional Banner --}}
        <section class="promo-banner">
          <div class="promo-content">
            <div class="promo-text">
              <h2 class="promo-title">Get Special Discounts on Your First Purchase!</h2>
              <p class="promo-description">Sign up now and enjoy exclusive deals on agricultural equipment and products.</p>
            </div>
            <a href="{{ route('auth.register') }}" class="promo-btn">
              Register Now
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>
        </section>

        {{-- New Arrivals --}}
        <section class="products-section">
          <div class="section-header-bar">
            <div class="section-title-wrap">
              <h2 class="section-main-title">JUST ARRIVED</h2>
              <div class="title-underline"></div>
            </div>
            <a href="{{ route('agriculture.products.index') }}" class="view-all-link">
              View All
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </a>
          </div>
          <div class="products-grid">
            @forelse($newArrivals as $product)
            <div class="product-item">
              @include('components.product-card', ['product' => $product])
            </div>
            @empty
            <div class="empty-products">
              <p>No new arrivals at the moment.</p>
            </div>
            @endforelse
          </div>
        </section>

        {{-- Features Strip --}}
        <section class="features-strip">
          <div class="feature-item-strip">
            <div class="feature-strip-icon">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="1" y="3" width="15" height="13"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
              </svg>
            </div>
            <div class="feature-strip-text">
              <h5>Free Delivery</h5>
              <p>On orders above ₹5,000</p>
            </div>
          </div>
          <div class="feature-item-strip">
            <div class="feature-strip-icon">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
            </div>
            <div class="feature-strip-text">
              <h5>Secure Payment</h5>
              <p>100% protected transactions</p>
            </div>
          </div>
          <div class="feature-item-strip">
            <div class="feature-strip-icon">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
              </svg>
            </div>
            <div class="feature-strip-text">
              <h5>Quality Guarantee</h5>
              <p>Certified products only</p>
            </div>
          </div>
          <div class="feature-item-strip">
            <div class="feature-strip-icon">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
            </div>
            <div class="feature-strip-text">
              <h5>24/7 Support</h5>
              <p>Dedicated customer service</p>
            </div>
          </div>
        </section>

      </div>
    </div>
  </div>
</div>

<style>
/* ====== Home Layout ====== */
.home-layout-container {
  min-height: 100vh;
  background: #f5f7f5;
}

/* ====== Sidebar ====== */
.sidebar-wrapper {
  position: sticky;
  top: 80px;
  height: calc(100vh - 80px);
  overflow-y: auto;
  padding: 16px 12px 16px 16px;
  z-index: 100;
}

.categories-sidebar {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
  height: 100%;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  border: 1px solid #e8efe8;
}

.sidebar-header {
  background: linear-gradient(135deg, #2d5a27 0%, #3d7a35 100%);
  padding: 14px 16px;
  display: flex;
  align-items: center;
  gap: 10px;
  color: #ffffff;
}

.sidebar-title {
  font-size: 0.95rem;
  font-weight: 700;
  letter-spacing: 0.3px;
}

.sidebar-content {
  flex: 1;
  overflow-y: auto;
}

.category-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.category-item {
  border-bottom: 1px solid #f0f5f0;
}

.category-item:last-child {
  border-bottom: none;
}

.category-link {
  display: flex;
  align-items: center;
  padding: 12px 16px;
  text-decoration: none;
  color: #2c3e2c;
  transition: all 0.25s ease;
  gap: 14px;
}

.category-link:hover {
  background: linear-gradient(90deg, #f0f7ed 0%, #ffffff 100%);
  color: #2d5a27;
}

.category-icon-wrap {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  overflow: hidden;
  flex-shrink: 0;
  background: #f8faf8;
  border: 1px solid #e8efe8;
}

.category-icon {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.category-name {
  flex: 1;
  font-size: 0.9rem;
  font-weight: 500;
  line-height: 1.3;
}

.arrow-icon {
  color: #a0b8a0;
  transition: all 0.25s ease;
  flex-shrink: 0;
}

.category-item:hover .arrow-icon {
  transform: translateX(3px);
  color: #2d5a27;
}

/* Subcategories */
.subcategories-dropdown {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease;
  background: #f8faf8;
}

.category-item:hover .subcategories-dropdown {
  max-height: 400px;
}

.subcategory-list {
  list-style: none;
  padding: 8px 0;
  margin: 0;
}

.subcategory-link {
  display: flex;
  align-items: center;
  padding: 8px 16px 8px 24px;
  text-decoration: none;
  color: #5a6a5a;
  font-size: 0.8rem;
  transition: all 0.2s ease;
  gap: 8px;
}

.subcategory-bullet {
  width: 5px;
  height: 5px;
  background: #c0d0c0;
  border-radius: 50%;
  flex-shrink: 0;
  transition: all 0.2s;
}

.subcategory-link:hover {
  color: #2d5a27;
  background: #ffffff;
}

.subcategory-link:hover .subcategory-bullet {
  background: #2d5a27;
  transform: scale(1.3);
}

/* ====== Content Area ====== */
.content-wrapper {
  padding: 16px;
  background: #ffffff;
  min-height: 100vh;
}

/* ====== Hero Banner ====== */
.hero-banner {
  position: relative;
  background: url('{{ asset('assets/organic/images/banner-1.jpg') }}') center/cover no-repeat;
  border-radius: 16px;
  overflow: hidden;
  min-height: 320px;
  display: flex;
  align-items: center;
  margin-bottom: 24px;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(45, 90, 39, 0.85) 0%, rgba(61, 122, 53, 0.75) 50%, rgba(107, 178, 82, 0.6) 100%);
}

.hero-content {
  position: relative;
  z-index: 2;
  padding: 40px;
  max-width: 600px;
}

.hero-title {
  font-size: 2rem;
  font-weight: 700;
  color: #ffffff;
  line-height: 1.2;
  margin: 0 0 16px 0;
}

.hero-title .highlight {
  background: rgba(255, 255, 255, 0.2);
  padding: 2px 12px;
  border-radius: 6px;
  display: inline-block;
}

.hero-description {
  font-size: 0.95rem;
  color: rgba(255, 255, 255, 0.9);
  line-height: 1.6;
  margin: 0 0 24px 0;
}

.hero-actions {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.btn-hero-primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 24px;
  background: #ffffff;
  color: #2d5a27;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.btn-hero-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  color: #2d5a27;
}

.btn-hero-secondary {
  padding: 12px 24px;
  background: transparent;
  color: #ffffff;
  border: 2px solid rgba(255, 255, 255, 0.8);
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-hero-secondary:hover {
  background: rgba(255, 255, 255, 0.15);
  border-color: #ffffff;
  color: #ffffff;
}

/* ====== Section Header Bar ====== */
.section-header-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 12px;
  border-bottom: 1px solid #e8efe8;
}

.section-title-wrap {
  position: relative;
}

.section-main-title {
  font-size: 1rem;
  font-weight: 700;
  color: #1a2e1a;
  margin: 0;
  letter-spacing: 0.5px;
}

.title-underline {
  width: 50px;
  height: 3px;
  background: linear-gradient(90deg, #6BB252 0%, #2d5a27 100%);
  border-radius: 2px;
  margin-top: 6px;
}

.view-all-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border: 1.5px solid #6BB252;
  color: #6BB252;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.25s ease;
}

.view-all-link:hover {
  background: #6BB252;
  color: #ffffff;
}

/* ====== Category Sections ====== */
.category-section {
  padding: 24px 0;
  border-bottom: 1px solid #e8efe8;
}

.category-section:last-of-type {
  border-bottom: none;
}

.category-section.bg-alt {
  background: #f8faf8;
  margin: 0 -16px;
  padding: 24px 16px;
}

.subcategory-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 16px;
}

.subcategory-card {
  background: #ffffff;
  border-radius: 12px;
  overflow: hidden;
  text-decoration: none;
  border: 1px solid #e8efe8;
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
}

.subcategory-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 25px rgba(107, 178, 82, 0.15);
  border-color: #6BB252;
}

.subcat-image-wrap {
  aspect-ratio: 1;
  background: #f8faf8;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  overflow: hidden;
}

.subcat-image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: transform 0.4s ease;
}

.subcategory-card:hover .subcat-image-wrap img {
  transform: scale(1.08);
}

.subcat-info {
  padding: 12px;
  text-align: center;
  background: #ffffff;
}

.subcat-name {
  font-size: 0.85rem;
  font-weight: 600;
  color: #2c3e2c;
  margin: 0;
  line-height: 1.3;
}

.subcategory-card:hover .subcat-name {
  color: #6BB252;
}

/* ====== Stats Section ====== */
.stats-section {
  padding: 24px 0;
  margin-bottom: 8px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

.stat-card {
  background: #ffffff;
  border-radius: 12px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  border: 1px solid #e8efe8;
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-icon.green { background: linear-gradient(135deg, #e8f5e3 0%, #d4edcf 100%); color: #2d5a27; }
.stat-icon.blue { background: linear-gradient(135deg, #e3f0ff 0%, #cfe2ff 100%); color: #1a5fb4; }
.stat-icon.orange { background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); color: #e65100; }
.stat-icon.purple { background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); color: #7b1fa2; }

.stat-content {
  display: flex;
  flex-direction: column;
}

.stat-number {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a2e1a;
  line-height: 1;
}

.stat-label {
  font-size: 0.8rem;
  color: #6a7a6a;
  margin-top: 4px;
}

/* ====== Products Section ====== */
.products-section {
  padding: 24px 0;
}

.products-section.bg-alt {
  background: #f8faf8;
  margin: 0 -16px;
  padding: 24px 16px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}

.product-item {
  height: 100%;
}

.empty-products {
  grid-column: 1 / -1;
  text-align: center;
  padding: 40px;
  color: #6a7a6a;
}

/* ====== Promo Banner ====== */
.promo-banner {
  background: linear-gradient(135deg, #2d5a27 0%, #3d7a35 50%, #6BB252 100%);
  border-radius: 16px;
  padding: 32px;
  margin: 24px 0;
}

.promo-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
  flex-wrap: wrap;
}

.promo-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #ffffff;
  margin: 0 0 8px 0;
}

.promo-description {
  font-size: 0.95rem;
  color: rgba(255, 255, 255, 0.85);
  margin: 0;
}

.promo-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 28px;
  background: #ffffff;
  color: #2d5a27;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.3s ease;
  flex-shrink: 0;
}

.promo-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  color: #2d5a27;
}

/* ====== Features Strip ====== */
.features-strip {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  padding: 24px 0;
  border-top: 1px solid #e8efe8;
  margin-top: 24px;
}

.feature-item-strip {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 16px;
  background: #f8faf8;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.feature-item-strip:hover {
  background: #ffffff;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
}

.feature-strip-icon {
  width: 52px;
  height: 52px;
  background: linear-gradient(135deg, #e8f5e3 0%, #d4edcf 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2d5a27;
  flex-shrink: 0;
}

.feature-strip-text h5 {
  font-size: 0.9rem;
  font-weight: 600;
  color: #1a2e1a;
  margin: 0 0 4px 0;
}

.feature-strip-text p {
  font-size: 0.8rem;
  color: #6a7a6a;
  margin: 0;
}

/* ====== Responsive ====== */
@media (max-width: 1200px) {
  .products-grid {
    grid-template-columns: repeat(3, 1fr);
  }
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .features-strip {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 991px) {
  .sidebar-wrapper {
    position: relative;
    height: auto;
    padding: 12px;
  }

  .categories-sidebar {
    height: auto;
    max-height: 350px;
  }

  .subcategories-dropdown {
    max-height: 0 !important;
  }

  .category-item.active .subcategories-dropdown {
    max-height: 400px !important;
  }

  .hero-banner {
    min-height: 280px;
  }

  .hero-title {
    font-size: 1.5rem;
  }

  .products-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .content-wrapper {
    padding: 12px;
  }

  .hero-content {
    padding: 24px;
  }

  .hero-title {
    font-size: 1.25rem;
  }

  .subcategory-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .stats-grid {
    grid-template-columns: 1fr 1fr;
  }

  .promo-content {
    flex-direction: column;
    text-align: center;
  }

  .features-strip {
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .feature-item-strip {
    flex-direction: column;
    text-align: center;
    padding: 16px 12px;
  }
}

@media (max-width: 576px) {
  .products-grid {
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  .stat-card {
    padding: 16px;
  }

  .stat-number {
    font-size: 1.25rem;
  }
}

/* Scrollbar */
.sidebar-content::-webkit-scrollbar {
  width: 5px;
}

.sidebar-content::-webkit-scrollbar-track {
  background: #f0f5f0;
}

.sidebar-content::-webkit-scrollbar-thumb {
  background: #c0d0c0;
  border-radius: 3px;
}

.sidebar-content::-webkit-scrollbar-thumb:hover {
  background: #6BB252;
}
</style>

<script>
  // Mobile subcategory toggle
  document.addEventListener('DOMContentLoaded', function() {
    const categoryItems = document.querySelectorAll('.category-item');

    categoryItems.forEach(function(item) {
      const categoryLink = item.querySelector('.category-link');
      const hasSubcategories = item.querySelector('.subcategories-dropdown');

      if (hasSubcategories) {
        categoryLink.addEventListener('click', function(e) {
          if (window.innerWidth <= 991) {
            e.preventDefault();
            e.stopPropagation();

            categoryItems.forEach(function(otherItem) {
              if (otherItem !== item) {
                otherItem.classList.remove('active');
              }
            });

            item.classList.toggle('active');
          }
        });
      }
    });

    document.addEventListener('click', function(e) {
      if (window.innerWidth <= 991) {
        if (!e.target.closest('.category-item')) {
          categoryItems.forEach(function(item) {
            item.classList.remove('active');
          });
        }
      }
    });
  });
</script>

@endsection
