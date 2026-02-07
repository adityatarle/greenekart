@extends('layouts.app')

@section('content')

{{-- Main Layout with Sidebar --}}
<div class="home-layout-container">
  <div class="container-fluid px-3 px-lg-4">
    <div class="row g-0">

      {{-- Left Sidebar with Categories --}}
      <div class="col-lg-3 col-md-4 sidebar-wrapper">
        <div class="categories-sidebar">
          <div class="sidebar-header">
            <p class="fw-bold text-white m-0">Categories</p>
          </div>
          <div class="sidebar-content">
            @if(isset($allCategories) && $allCategories->count() > 0)
            <ul class="category-list">
              @foreach($allCategories as $category)
              <li class="category-item" data-category-id="{{ $category->id }}">
                <a href="{{ route('agriculture.categories.show', $category) }}" class="category-link">
                  @php
                  $categoryImageUrl = $category->image
                  ? \App\Helpers\ImageHelper::imageUrl($category->image)
                  : asset('assets/organic/images/category-placeholder.jpg');
                  @endphp
                  <img src="{{ $categoryImageUrl }}" alt="{{ $category->name }}" class="category-icon">
                  <span class="category-name">{{ $category->name }}</span>
                  @if($category->subcategories->count() > 0)
                  <svg class="arrow-icon" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
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

      {{-- Right Content Area with Category Sections --}}
      <div class="col-lg-9 col-md-8 content-wrapper">
        {{-- Hero Banner Section --}}
        <section class="hero-section position-relative overflow-hidden"
          style="background: linear-gradient(135deg, rgba(107, 178, 82, 0.6) 0%, rgba(74, 138, 58, 0.65) 100%), url('{{ asset('assets/organic/images/banner-1.jpg') }}');
                 background-repeat: no-repeat;
                 background-size: cover;
                 background-position: center;
                 min-height: 40vh;
                 display: flex;
                 align-items: center;
                 padding: 50px 0 50px;">
          <div class="container-lg position-relative" style="z-index: 2;">
            <div class="row align-items-center">
              <div class="col-lg-7">
                <div class="fade-in-up">
                  <h2 class="text-white mb-4">Premium Agriculture <span class="fw-bold text-white" style="background: rgba(255,255,255,0.2); padding: 0 12px; border-radius: 8px; display: inline-block;">Equipment</span> & Products</h2>
                  <small class="text-white mb-4 col-12">
                    Transform your farming with world-class, innovative, and affordable agricultural solutions.
                    Empowering farmers with smart tools for smarter agriculture.
                  </small>
                  <div class="d-flex flex-wrap gap-3 mt-5">
                    <a href="http://127.0.0.1:8000/products" class="btn btn-light btn-sm px-4 py-2" style="font-weight: 700; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                      <svg width="20" height="20" style="margin-right: 8px; vertical-align: middle;">
                        <use xlink:href="#cart"></use>
                      </svg>
                      Shop Now
                    </a>
                    <a href="http://127.0.0.1:8000/dealer/registration"
                      class="btn btn-sm px-4 py-2 fw-bold text-white border border-2 border-white bg-transparent">
                      Become a Dealer
                    </a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- ******************** -->
        {{-- Categories with Subcategories Sections --}}
        @if(isset($categories) && $categories->count() > 0)
        @foreach($categories as $category)
        <section class="category-section py-5 {{ $loop->even ? 'bg-light' : '' }}">
          <div class="container-lg">
            <div class="section-header mb-4">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h2 class="section-title mb-2">{{ $category->name }}</h2>
                  <p class="text-muted mb-0">{{ $category->products_count ?? 0 }} products available</p>
                </div>
                <a href="{{ route('agriculture.categories.show', $category) }}" class="btn btn-outline-primary">
                  View All
                </a>
              </div>
            </div>

            {{-- Subcategories with Products --}}
            @if($category->subcategories->count() > 0)
            @foreach($category->subcategories as $subcategory)
            <div class="subcategory-section mb-5">
              <div class="subcategory-header mb-3">
                <h3 class="subcategory-title">
                  <a href="{{ route('agriculture.products.index', ['subcategory' => $subcategory->id]) }}" class="subcategory-title-link">
                    {{ $subcategory->name }}
                  </a>
                </h3>
              </div>

              {{-- Products for this Subcategory --}}
              @php
              $subcategoryProducts = \App\Models\AgricultureProduct::active()
              ->inStock()
              ->bySubcategory($subcategory->id)
              ->with('category')
              ->take(6)
              ->get()
              ->map(function($product) {
              if (empty($product->slug) && !empty($product->name)) {
              $product->slug = \Illuminate\Support\Str::slug($product->name);
              $product->saveQuietly();
              }
              return $product;
              });
              @endphp

              @if($subcategoryProducts->count() > 0)
              <div class="subcategory-products">
                <div class="row g-3">
                  @foreach($subcategoryProducts as $product)
                  <div class="col-6 col-sm-4 col-md-3">
                    @include('components.product-card', ['product' => $product])
                  </div>
                  @endforeach
                </div>
                @if($subcategoryProducts->count() >= 6)
                <div class="text-center mt-3">
                  <a href="{{ route('agriculture.products.index', ['subcategory' => $subcategory->id]) }}" class="btn btn-outline-primary">
                    View All {{ $subcategory->name }} Products
                  </a>
                </div>
                @endif
              </div>
              @else
              <p class="text-muted">No products available in this subcategory.</p>
              @endif
            </div>
            @endforeach
            @else
            {{-- If no subcategories, show category products --}}
            @if(isset($category->featured_products) && $category->featured_products->count() > 0)
            <div class="category-products">
              <div class="row g-3">
                @foreach($category->featured_products as $product)
                <div class="col-6 col-sm-4 col-md-3">
                  @include('components.product-card', ['product' => $product])
                </div>
                @endforeach
              </div>
            </div>
            @endif
            @endif
          </div>
        </section>
        @endforeach
        @endif
        <!-- ******************** -->

        {{-- Feature Cards Section --}}
        <section class="features-section py-5">
          <div class="container-lg">
            <div class="row g-4 justify-content-center">
              <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                  <div class="feature-icon-wrapper">
                    <div class="feature-icon">
                      <svg width="32" height="32" fill="currentColor">
                        <use xlink:href="#fresh"></use>
                      </svg>
                    </div>
                  </div>
                  <div class="feature-content">
                    <h4 class="feature-title">Quality Products</h4>
                    <p class="feature-description">Top-quality equipment sourced from trusted global manufacturers</p>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                  <div class="feature-icon-wrapper">
                    <div class="feature-icon">
                      <svg width="32" height="32" fill="currentColor">
                        <use xlink:href="#organic"></use>
                      </svg>
                    </div>
                  </div>
                  <div class="feature-content">
                    <h4 class="feature-title">Smart Solutions</h4>
                    <p class="feature-description">Innovative tools and solutions for sustainable farming practices</p>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-4">
                <div class="feature-card">
                  <div class="feature-icon-wrapper">
                    <div class="feature-icon">
                      <svg width="32" height="32" fill="currentColor">
                        <use xlink:href="#delivery"></use>
                      </svg>
                    </div>
                  </div>
                  <div class="feature-content">
                    <h4 class="feature-title">Fast Delivery</h4>
                    <p class="feature-description">Reliable nationwide delivery network for all your farming needs</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        {{-- Stats Section --}}
        <section id="company-services" class="py-5 bg-light">
          <div class="container">
            <div class="row g-4">
              <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: linear-gradient(135deg, #6BB252, #4a8a3a); color: #ffffff;">
                      <svg width="35" height="35" fill="white">
                        <use xlink:href="#cart"></use>
                      </svg>
                    </div>
                  </div>
                  <h3 class="fw-bold text-dark mb-2" style="font-size: 2.5rem;">{{ $stats['total_products'] ?? 0 }}+</h3>
                  <p class="text-muted mb-0">Quality Products</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: linear-gradient(135deg, #28a745, #20c997); color: #ffffff;">
                      <svg width="35" height="35" fill="white">
                        <use xlink:href="#quality"></use>
                      </svg>
                    </div>
                  </div>
                  <h3 class="fw-bold text-dark mb-2" style="font-size: 2.5rem;">{{ $stats['total_categories'] ?? 0 }}+</h3>
                  <p class="text-muted mb-0">Categories</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: linear-gradient(135deg, #fd7e14, #dc3545); color: #ffffff;">
                      <svg width="35" height="35" fill="white">
                        <use xlink:href="#user"></use>
                      </svg>
                    </div>
                  </div>
                  <h3 class="fw-bold text-dark mb-2" style="font-size: 2.5rem;">{{ $stats['total_customers'] ?? 0 }}+</h3>
                  <p class="text-muted mb-0">Happy Farmers</p>
                </div>
              </div>
              <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 70px; height: 70px; background: linear-gradient(135deg, #007bff, #0056b3); color: #ffffff;">
                      <svg width="35" height="35" fill="white">
                        <use xlink:href="#secure"></use>
                      </svg>
                    </div>
                  </div>
                  <h3 class="fw-bold text-dark mb-2" style="font-size: 2.5rem;">100%</h3>
                  <p class="text-muted mb-0">Secure Payment</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        {{-- Best Selling Products --}}
        <section id="best-selling" class="py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                  <h2 class="section-title">Best Selling Products</h2>
                  <div class="d-flex align-items-center">
                    <a href="{{ route('agriculture.products.index') }}" class="btn btn-primary rounded-1">View All</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row g-3">
              @forelse($bestSellers as $product)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                @include('components.product-card', ['product' => $product])
              </div>
              @empty
              <div class="col-12 text-center py-5">
                <p class="text-muted">No products available at the moment.</p>
                <a href="{{ route('agriculture.products.index') }}" class="btn btn-primary">Browse All Products</a>
              </div>
              @endforelse
            </div>
          </div>
        </section>

        {{-- Featured Products --}}
        <section id="featured-products" class="py-5 bg-light">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                  <h2 class="section-title">Featured Products</h2>
                  <div class="d-flex align-items-center">
                    <a href="{{ route('agriculture.products.index') }}" class="btn btn-primary rounded-1">View All</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row g-3">
              @forelse($featuredProducts as $product)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                @include('components.product-card', ['product' => $product])
              </div>
              @empty
              <div class="col-12 text-center py-5">
                <p class="text-muted">No featured products available.</p>
              </div>
              @endforelse
            </div>
          </div>
        </section>

        {{-- Promotional Banner --}}
        <section class="py-5" style="background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h2 class="text-white mb-3 fw-bold" style="font-size: clamp(1.75rem, 4vw, 2.25rem);">Get Special Discounts on Your First Purchase!</h2>
                <p class="text-white-50 mb-0 lead">Sign up now and enjoy exclusive deals on agricultural equipment and products.</p>
              </div>
              <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('auth.register') }}" class="btn btn-light btn-lg px-5 fw-bold">Register Now</a>
              </div>
            </div>
          </div>
        </section>

        {{-- Just Arrived (New Products) --}}
        <section id="new-arrivals" class="py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="section-header d-flex flex-wrap justify-content-between my-4">
                  <h2 class="section-title">Just Arrived</h2>
                  <div class="d-flex align-items-center">
                    <a href="{{ route('agriculture.products.index') }}" class="btn btn-primary rounded-1">View All</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row g-3">
              @forelse($newArrivals as $product)
              <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                @include('components.product-card', ['product' => $product])
              </div>
              @empty
              <div class="col-12 text-center py-5">
                <p class="text-muted">No new arrivals at the moment.</p>
              </div>
              @endforelse
            </div>
          </div>
        </section>

        {{-- Features Section --}}
        <section class="py-5 bg-light">
          <div class="container">
            <div class="row g-4">
              <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white; transition: all 0.3s ease;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: linear-gradient(135deg, #6BB252, #4a8a3a);">
                      <svg width="40" height="40" fill="white">
                        <use xlink:href="#package"></use>
                      </svg>
                    </div>
                  </div>
                  <h5 class="card-title fw-bold mb-2">Free Delivery</h5>
                  <p class="card-text text-muted mb-0">On orders above ₹5,000</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white; transition: all 0.3s ease;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: linear-gradient(135deg, #007bff, #0056b3);">
                      <svg width="40" height="40" fill="white">
                        <use xlink:href="#secure"></use>
                      </svg>
                    </div>
                  </div>
                  <h5 class="card-title fw-bold mb-2">Secure Payment</h5>
                  <p class="card-text text-muted mb-0">Your money is safe with us</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4" style="border-radius: 16px; background: white; transition: all 0.3s ease;">
                  <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745, #20c997);">
                      <svg width="40" height="40" fill="white">
                        <use xlink:href="#quality"></use>
                      </svg>
                    </div>
                  </div>
                  <h5 class="card-title fw-bold mb-2">Quality Guarantee</h5>
                  <p class="card-text text-muted mb-0">Certified products only</p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>

<style>
  /* Home Layout Styles */
  .home-layout-container {
    min-height: 100vh;
    background: #f8f9fa;
  }

  /* Sidebar Styles */
  .sidebar-wrapper {
    background: transparent;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    padding: 20px 15px 20px 20px;
  }

  .categories-sidebar {
    background: #ffffff;
    border-right: 1px solid #e9ecef;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    height: calc(100vh - 40px);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .sidebar-header {
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    padding: 12px;
    position: sticky;
    top: 0;
    z-index: 10;
  }

  .sidebar-content {
    padding: 0;
    overflow-y: auto;
    flex: 1;
  }

  .category-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .category-item {
    position: relative;
    border-bottom: 1px solid #f0f0f0;
  }

  .category-item:last-child {
    border-bottom: none;
  }

  .category-link {
    display: flex;
    align-items: center;
    padding: 7px 7px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    position: relative;
  }

  .category-link:hover {
    background: #f8f9fa;
    color: #6BB252;
    text-decoration: none;
  }

  .category-icon {
    width: 32px;
    height: 32px;
    object-fit: cover;
    border-radius: 6px;
    margin-right: 12px;
    flex-shrink: 0;
  }

  .category-name {
    flex: 1;
    font-weight: 500;
    font-size: 11px;
  }

  .arrow-icon {
    margin-left: auto;
    transition: transform 0.3s ease;
    color: #6c757d;
  }

  .category-item:hover .arrow-icon {
    transform: translateX(4px);
    color: #6BB252;
  }

  /* Subcategories Dropdown */
  .subcategories-dropdown {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background: #f8f9fa;
  }

  .category-item:hover .subcategories-dropdown {
    max-height: 500px;
  }

  .subcategory-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .subcategory-item {
    border-top: 1px solid #e9ecef;
  }

  .subcategory-link {
    display: block;
    padding: 10px 8px 10px 45px;
    text-decoration: none;
    color: #555;
    font-size: 11px;
    transition: all 0.2s ease;
  }

  .subcategory-link:hover {
    background: #ffffff;
    color: #6BB252;
    padding-left: 56px;
    text-decoration: none;
  }

  /* Content Wrapper */
  .content-wrapper {
    background: #ffffff;
    padding: 20px 20px 20px 15px;
  }

  /* Category Section Styles */
  .category-section {
    border-bottom: 1px solid #e9ecef;
  }

  .section-header {
    margin-bottom: 2rem;
  }

  .section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
  }

  /* Subcategory Section */
  .subcategory-section {
    margin-bottom: 3rem;
  }

  .subcategory-header {
    border-bottom: 2px solid #6BB252;
    padding-bottom: 10px;
  }

  .subcategory-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin: 0;
  }

  .subcategory-title-link {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .subcategory-title-link:hover {
    color: #6BB252;
    text-decoration: none;
  }

  .subcategory-products {
    margin-top: 1.5rem;
  }

  /* Feature Cards Section */
  .features-section {
    background: #ffffff;
    margin-top: 0;
    position: relative;
    z-index: 3;
  }

  .feature-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    border: 1px solid #f0f0f0;
    position: relative;
    overflow: hidden;
  }

  .feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #6BB252 0%, #4a8a3a 100%);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
  }

  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 40px rgba(107, 178, 82, 0.15);
    border-color: #6BB252;
  }

  .feature-card:hover::before {
    transform: scaleX(1);
  }

  .feature-icon-wrapper {
    margin-bottom: 24px;
    display: flex;
    justify-content: center;
  }

  .feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(107, 178, 82, 0.1) 0%, rgba(74, 138, 58, 0.1) 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6BB252;
    transition: all 0.4s ease;
    position: relative;
  }

  .feature-card:hover .feature-icon {
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    color: white;
    transform: scale(1.1) rotate(5deg);
  }

  .feature-content {
    position: relative;
  }

  .feature-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 12px;
    transition: color 0.3s ease;
  }

  .feature-card:hover .feature-title {
    color: #6BB252;
  }

  .feature-description {
    font-size: 0.95rem;
    color: #6c757d;
    line-height: 1.6;
    margin: 0;
  }

  /* Mobile Toggle for Subcategories */
  @media (max-width: 991px) {
    .sidebar-wrapper {
      position: relative;
      height: auto;
      padding: 15px;
    }

    .categories-sidebar {
      border-right: none;
      border-bottom: 1px solid #e9ecef;
      border-radius: 8px;
      height: auto;
      max-height: 400px;
    }

    .sidebar-header {
      position: relative;
    }

    .subcategories-dropdown {
      max-height: 0 !important;
      transition: max-height 0.3s ease;
    }

    .category-item.active .subcategories-dropdown {
      max-height: 500px !important;
    }

    .category-item:hover .subcategories-dropdown {
      max-height: 0 !important;
    }

    .category-link {
      cursor: pointer;
    }
  }

  @media (max-width: 768px) {
    .hero-section {
      min-height: 35vh !important;
    }

    .content-wrapper {
      padding: 15px;
    }

    .section-title {
      font-size: 1.5rem;
    }

    .subcategory-title {
      font-size: 1.3rem;
    }

    .feature-card {
      padding: 30px 24px;
    }

    .feature-icon {
      width: 70px;
      height: 70px;
    }

    .feature-title {
      font-size: 1.3rem;
    }
  }

  /* Scrollbar Styles for Sidebar */
  .sidebar-wrapper::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  .sidebar-wrapper::-webkit-scrollbar-thumb {
    background: #6BB252;
    border-radius: 3px;
  }

  .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
    background: #4a8a3a;
  }

  /* Ensure consistent product card heights in grid */
  .row.g-3>[class*="col-"] {
    display: flex;
  }

  .row.g-3>[class*="col-"]>* {
    width: 100%;
  }
</style>

<script>
  // Mobile subcategory toggle functionality
  document.addEventListener('DOMContentLoaded', function() {
    const categoryItems = document.querySelectorAll('.category-item');

    categoryItems.forEach(function(item) {
      const categoryLink = item.querySelector('.category-link');
      const hasSubcategories = item.querySelector('.subcategories-dropdown');

      if (hasSubcategories) {
        categoryLink.addEventListener('click', function(e) {
          // On mobile, toggle subcategories instead of navigating
          if (window.innerWidth <= 991) {
            e.preventDefault();
            e.stopPropagation();

            // Close other open categories
            categoryItems.forEach(function(otherItem) {
              if (otherItem !== item) {
                otherItem.classList.remove('active');
              }
            });

            // Toggle current category
            item.classList.toggle('active');
          }
          // On desktop, allow normal navigation (hover will show subcategories)
        });
      }
    });

    // Close subcategories when clicking outside on mobile
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