@extends('layouts.app')

@section('title', $category->name . ' Products - Greenleaf Agriculture')

@section('content')
<div class="category-page">
    <!-- Category Hero -->
    <div class="category-hero">
        <div class="container-fluid px-lg-5">
            <div class="hero-content">
                <!-- Breadcrumb -->
                <nav class="category-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ route('agriculture.home') }}">Home</a>
                    <span class="separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </span>
                    <a href="{{ route('agriculture.categories.index') }}">Categories</a>
                    <span class="separator">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </span>
                    <span class="current">{{ $category->name }}</span>
                </nav>
                
                <div class="hero-info">
                    <div class="hero-text">
                        <h1 class="category-title">{{ $category->name }}</h1>
                        @if($category->description)
                            <p class="category-desc">{{ $category->description }}</p>
                        @endif
                        <div class="category-stats">
                            <div class="stat-item">
                                <span class="stat-number">{{ $products->total() }}</span>
                                <span class="stat-label">Products</span>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $products->where('in_stock', true)->count() }}</span>
                                <span class="stat-label">In Stock</span>
                            </div>
                        </div>
                    </div>
                    @if($category->image)
                    <div class="hero-image">
                        @php
                            $categoryImageUrl = \App\Helpers\ImageHelper::imageUrl($category->image);
                        @endphp
                        <img src="{{ $categoryImageUrl }}" alt="{{ $category->name }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Section -->
    <div class="products-section">
        <div class="container-fluid px-lg-5">
            @if($products->count() > 0)
                <!-- Section Header -->
                <div class="section-header">
                    <div class="header-left">
                        <h2 class="section-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            All {{ $category->name }} Products
                        </h2>
                        <p class="section-subtitle">
                            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                        </p>
                    </div>
                    <a href="{{ route('agriculture.products.index') }}" class="view-all-btn">
                        View All Products
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </div>
                
                <!-- Products Grid -->
                <div class="products-grid">
                    @foreach($products as $product)
                        <div class="product-item">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M16 16s-1.5-2-4-2-4 2-4 2"></path>
                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                    </div>
                    <h3 class="empty-title">No Products Available</h3>
                    <p class="empty-text">There are currently no products in this category. Check back soon!</p>
                    <div class="empty-actions">
                        <a href="{{ route('agriculture.categories.index') }}" class="btn-secondary-outline">Browse Categories</a>
                        <a href="{{ route('agriculture.products.index') }}" class="btn-primary-solid">View All Products</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Other Categories -->
    @php
        $otherCategories = \App\Models\AgricultureCategory::active()
            ->where('id', '!=', $category->id)
            ->ordered()
            ->limit(6)
            ->get();
    @endphp
    @if($otherCategories->count() > 0)
    <div class="other-categories">
        <div class="container-fluid px-lg-5">
            <div class="section-header centered">
                <h2 class="section-title">Explore Other Categories</h2>
                <p class="section-subtitle">Browse more product categories</p>
            </div>
            
            <div class="categories-grid">
                @foreach($otherCategories as $otherCategory)
                    <a href="{{ route('agriculture.categories.show', $otherCategory) }}" class="category-card">
                        <div class="card-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            </svg>
                        </div>
                        <h4 class="card-title">{{ $otherCategory->name }}</h4>
                        <p class="card-count">{{ $otherCategory->products_count ?? $otherCategory->products->count() }} Products</p>
                        <span class="card-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
/* Category Page */
.category-page {
    background: #ffffff;
}

/* Category Hero */
.category-hero {
    background: linear-gradient(135deg, #f0f7ed 0%, #e8f5e3 50%, #dcefd5 100%);
    padding: 24px 0 32px;
    border-bottom: 1px solid #d4edcf;
}

.hero-content {
    max-width: 100%;
}

/* Breadcrumb */
.category-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 0.85rem;
}

.category-breadcrumb a {
    color: #5a8a52;
    text-decoration: none;
    transition: color 0.2s;
}

.category-breadcrumb a:hover {
    color: #3d6a35;
}

.category-breadcrumb .separator {
    color: #a0c498;
    display: flex;
    align-items: center;
}

.category-breadcrumb .current {
    color: #2d5a27;
    font-weight: 600;
}

/* Hero Info */
.hero-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
}

.hero-text {
    flex: 1;
}

.category-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0 0 12px 0;
    line-height: 1.2;
}

.category-desc {
    font-size: 1rem;
    color: #4a6a45;
    margin: 0 0 20px 0;
    line-height: 1.6;
    max-width: 600px;
}

.category-stats {
    display: flex;
    align-items: center;
    gap: 24px;
}

.stat-item {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2d5a27;
}

.stat-label {
    font-size: 0.8rem;
    color: #6a8a65;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: #c4dcc0;
}

.hero-image {
    width: 280px;
    height: 180px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(45, 90, 39, 0.15);
    flex-shrink: 0;
}

.hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Products Section */
.products-section {
    padding: 32px 0 48px;
    background: linear-gradient(180deg, #ffffff 0%, #f8faf8 100%);
}

/* Section Header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e8efe8;
}

.section-header.centered {
    flex-direction: column;
    text-align: center;
    border-bottom: none;
    margin-bottom: 32px;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title svg {
    color: #6BB252;
}

.section-subtitle {
    font-size: 0.875rem;
    color: #666;
    margin: 4px 0 0 0;
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(107, 178, 82, 0.25);
}

.view-all-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.35);
    color: #ffffff;
}

/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}

@media (max-width: 1400px) {
    .products-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
}

@media (max-width: 480px) {
    .products-grid {
        grid-template-columns: 1fr;
    }
}

.product-item {
    height: 100%;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
    padding-top: 24px;
    border-top: 1px solid #e8efe8;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: #ffffff;
    border-radius: 20px;
    border: 2px dashed #d4edcf;
}

.empty-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #f0f7ed 0%, #e8f5e3 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    color: #6BB252;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 12px 0;
}

.empty-text {
    font-size: 1rem;
    color: #666;
    margin: 0 0 24px 0;
}

.empty-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.btn-secondary-outline {
    padding: 12px 24px;
    border: 2px solid #6BB252;
    color: #6BB252;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-secondary-outline:hover {
    background: #6BB252;
    color: #ffffff;
}

.btn-primary-solid {
    padding: 12px 24px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-primary-solid:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.35);
    color: #ffffff;
}

/* Other Categories */
.other-categories {
    padding: 48px 0;
    background: linear-gradient(135deg, #f8faf8 0%, #f0f5f0 100%);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
}

@media (max-width: 1200px) {
    .categories-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.category-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px 16px;
    text-align: center;
    text-decoration: none;
    border: 1px solid #e8efe8;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.category-card:hover {
    border-color: #6BB252;
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(107, 178, 82, 0.15);
}

.card-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #e8f5e3 0%, #d4edcf 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6BB252;
    margin-bottom: 12px;
}

.category-card:hover .card-icon {
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
}

.card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a2e1a;
    margin: 0 0 4px 0;
}

.card-count {
    font-size: 0.8rem;
    color: #666;
    margin: 0;
}

.card-arrow {
    margin-top: 12px;
    color: #6BB252;
    opacity: 0;
    transform: translateX(-8px);
    transition: all 0.3s;
}

.category-card:hover .card-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Responsive */
@media (max-width: 991px) {
    .hero-info {
        flex-direction: column;
        text-align: center;
        gap: 24px;
    }
    
    .category-desc {
        max-width: 100%;
    }
    
    .category-stats {
        justify-content: center;
    }
    
    .hero-image {
        width: 100%;
        max-width: 400px;
        height: 200px;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}

@media (max-width: 576px) {
    .category-hero {
        padding: 16px 0 24px;
    }
    
    .category-title {
        font-size: 1.5rem;
    }
    
    .category-desc {
        font-size: 0.9rem;
    }
    
    .stat-number {
        font-size: 1.5rem;
    }
}
</style>
@endsection
