@extends('layouts.app')

@section('title', 'Agriculture Products - Greenleaf')
@section('description', 'Browse our comprehensive collection of agriculture equipment, machinery, and farming supplies')

@section('content')
<div class="products-page">
    <div class="container-fluid px-lg-5">
        <div class="row">
            <!-- Products - Full Width -->
            <div class="col-12">
                <!-- Inline Filters Bar -->
                <div class="inline-filters-bar">
                    <form method="GET" action="{{ route('agriculture.products.index') }}" id="filter-form" class="filters-form">
                        <div class="filters-row">
                            <!-- Search -->
                            <div class="filter-item search-filter">
                                <div class="search-box">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.35-4.35"></path>
                                    </svg>
                                    <input type="text" name="search" class="search-input" value="{{ request('search') }}" placeholder="Search products...">
                                </div>
                            </div>
                            
                            <!-- Brand Filter -->
                            @if($brands->count() > 0)
                            <div class="filter-item">
                                <select name="brand" class="filter-select" onchange="this.form.submit()">
                                    <option value="">All Brands</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                        {{ $brand }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            
                            <!-- Price Range -->
                            <div class="filter-item price-filter">
                                <div class="price-range-inline">
                                    <span class="price-label">₹</span>
                                    <input type="number" name="min_price" class="price-input" value="{{ request('min_price') }}" placeholder="Min">
                                    <span class="price-separator">-</span>
                                    <input type="number" name="max_price" class="price-input" value="{{ request('max_price') }}" placeholder="Max">
                                </div>
                            </div>
                            
                            <!-- Apply Button -->
                            <div class="filter-item">
                                <button type="submit" class="btn-filter-apply">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                    </svg>
                                    Filter
                                </button>
                            </div>
                            
                            <!-- Clear Filters -->
                            @if(request()->hasAny(['search', 'category', 'brand', 'power_source', 'min_price', 'max_price']))
                            <div class="filter-item">
                                <a href="{{ route('agriculture.products.index') }}" class="btn-clear-filters">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                    Clear
                                </a>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
                <!-- Page Header -->
                <div class="products-header">
                    <div class="header-left">
                        <h1 class="page-title">All Products</h1>
                        <p class="results-count">
                            Showing <span class="highlight">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> 
                            of <span class="highlight">{{ $products->total() }}</span> products
                        </p>
                    </div>
                    <div class="header-right">
                        <div class="view-options">
                            <button class="view-btn active" data-view="grid" title="Grid View">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </button>
                            <button class="view-btn" data-view="list" title="List View">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                    <line x1="8" y1="6" x2="21" y2="6" stroke="currentColor" stroke-width="2"></line>
                                    <line x1="8" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="2"></line>
                                    <line x1="8" y1="18" x2="21" y2="18" stroke="currentColor" stroke-width="2"></line>
                                    <circle cx="4" cy="6" r="2"></circle>
                                    <circle cx="4" cy="12" r="2"></circle>
                                    <circle cx="4" cy="18" r="2"></circle>
                                </svg>
                            </button>
                        </div>
                        <form method="GET" action="{{ route('agriculture.products.index') }}" id="sort-form">
                            @foreach(request()->except('sort') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="sort-wrapper">
                                <label class="sort-label">Sort by:</label>
                                <select name="sort" class="sort-select" onchange="document.getElementById('sort-form').submit();">
                                    <option value="name" {{ request('sort') == 'name' || !request('sort') ? 'selected' : '' }}>Name A-Z</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low → High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High → Low</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Active Filters -->
                @if(request()->hasAny(['search', 'category', 'brand', 'power_source', 'min_price', 'max_price']))
                <div class="active-filters">
                    @if(request('search'))
                        <span class="filter-tag">
                            Search: {{ request('search') }}
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    @if(request('category'))
                        <span class="filter-tag">
                            Category: {{ $categories->find(request('category'))->name ?? '' }}
                            <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                    @if(request('brand'))
                        <span class="filter-tag">
                            Brand: {{ request('brand') }}
                            <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="remove-filter">×</a>
                        </span>
                    @endif
                </div>
                @endif
                
                <!-- Products Grid -->
                <div class="products-grid" id="products-grid">
                    @forelse($products as $product)
                        <div class="product-grid-item">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.35-4.35"></path>
                                </svg>
                            </div>
                            <h3 class="empty-title">No products found</h3>
                            <p class="empty-text">Try adjusting your filters or search terms</p>
                            <a href="{{ route('agriculture.products.index') }}" class="btn-reset">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                                View All Products
                            </a>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Products Page Layout */
.products-page {
    background: linear-gradient(180deg, #f8faf8 0%, #ffffff 100%);
    min-height: 100vh;
    padding: 24px 0;
}

/* Inline Filters Bar */
.inline-filters-bar {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid #e8efe8;
}

.filters-form {
    width: 100%;
}

.filters-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-item {
    flex-shrink: 0;
}

.filter-item.search-filter {
    flex: 1;
    min-width: 200px;
    max-width: 300px;
}

.search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8faf8;
    border: 1.5px solid #e0e8e0;
    border-radius: 8px;
    padding: 8px 14px;
    transition: all 0.2s;
}

.search-box:focus-within {
    border-color: #6BB252;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(107, 178, 82, 0.1);
}

.search-box svg {
    color: #999;
    flex-shrink: 0;
}

.search-box .search-input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 0.875rem;
    color: #333;
}

.search-box .search-input::placeholder {
    color: #999;
}

.filter-select {
    padding: 10px 32px 10px 14px;
    border: 1.5px solid #e0e8e0;
    border-radius: 8px;
    font-size: 0.875rem;
    color: #333;
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") right 10px center no-repeat;
    appearance: none;
    cursor: pointer;
    min-width: 140px;
    transition: all 0.2s;
}

.filter-select:focus {
    outline: none;
    border-color: #6BB252;
    box-shadow: 0 0 0 3px rgba(107, 178, 82, 0.1);
}

.price-filter {
    min-width: 180px;
}

.price-range-inline {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f8faf8;
    border: 1.5px solid #e0e8e0;
    border-radius: 8px;
    padding: 6px 12px;
}

.price-range-inline:focus-within {
    border-color: #6BB252;
    background: #ffffff;
}

.price-label {
    color: #666;
    font-weight: 500;
    font-size: 0.875rem;
}

.price-range-inline .price-input {
    width: 70px;
    border: none;
    background: transparent;
    outline: none;
    font-size: 0.875rem;
    color: #333;
    text-align: center;
}

.price-range-inline .price-input::placeholder {
    color: #999;
}

.price-separator {
    color: #ccc;
    font-size: 0.875rem;
}

.btn-filter-apply {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 18px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-filter-apply:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(107, 178, 82, 0.3);
}

.btn-clear-filters {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 10px 14px;
    background: #fff5f5;
    color: #dc3545;
    border: 1px solid #ffcdd2;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-clear-filters:hover {
    background: #ffebee;
    color: #c62828;
}

@media (max-width: 768px) {
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-item {
        width: 100%;
    }
    
    .filter-item.search-filter {
        max-width: none;
    }
    
    .filter-select {
        width: 100%;
    }
    
    .price-filter {
        min-width: auto;
    }
    
    .price-range-inline {
        justify-content: center;
    }
    
    .price-range-inline .price-input {
        flex: 1;
    }
}

/* Products Header */
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e8efe8;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0 0 4px 0;
}

.results-count {
    font-size: 0.875rem;
    color: #666;
    margin: 0;
}

.results-count .highlight {
    color: #2d5a27;
    font-weight: 600;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 16px;
}

.view-options {
    display: flex;
    gap: 4px;
    padding: 4px;
    background: #f0f5f0;
    border-radius: 10px;
}

.view-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
    color: #999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.view-btn:hover {
    color: #6BB252;
}

.view-btn.active {
    background: #ffffff;
    color: #6BB252;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.sort-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-label {
    font-size: 0.875rem;
    color: #666;
    white-space: nowrap;
}

.sort-select {
    padding: 10px 36px 10px 14px;
    border: 1.5px solid #e0e8e0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #333;
    background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") right 12px center no-repeat;
    appearance: none;
    cursor: pointer;
    min-width: 160px;
    transition: all 0.2s;
}

.sort-select:focus {
    outline: none;
    border-color: #6BB252;
    box-shadow: 0 0 0 3px rgba(107, 178, 82, 0.1);
}

/* Active Filters */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    background: linear-gradient(135deg, #e8f5e3 0%, #d4edcf 100%);
    color: #2d5a27;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.remove-filter {
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(45, 90, 39, 0.15);
    color: #2d5a27;
    border-radius: 50%;
    text-decoration: none;
    font-size: 1rem;
    line-height: 1;
    transition: all 0.2s;
}

.remove-filter:hover {
    background: #2d5a27;
    color: #ffffff;
}

/* Products Grid - Full Width Layout - 6 columns */
.products-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
}

@media (max-width: 1600px) {
    .products-grid {
        grid-template-columns: repeat(5, 1fr);
    }
}

@media (max-width: 1400px) {
    .products-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 1100px) {
    .products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
}

@media (max-width: 400px) {
    .products-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
}

/* Smaller Product Cards */
.products-grid .pcard-image-wrap {
    padding: 10px;
}

.products-grid .pcard-content {
    padding: 12px;
}

.products-grid .pcard-category {
    font-size: 0.65rem;
    margin-bottom: 4px;
}

.products-grid .pcard-title {
    font-size: 0.8rem;
    min-height: 2.2em;
    margin-bottom: 4px;
}

.products-grid .pcard-rating {
    margin-bottom: 6px;
}

.products-grid .pcard-rating .stars svg {
    width: 10px;
    height: 10px;
}

.products-grid .pcard-rating .rating-count {
    font-size: 0.7rem;
}

.products-grid .pcard-price {
    margin-bottom: 6px;
    gap: 4px;
}

.products-grid .price-old {
    font-size: 0.75rem;
}

.products-grid .price-now {
    font-size: 1rem;
}

.products-grid .price-save {
    font-size: 0.6rem;
    padding: 2px 6px;
}

.products-grid .pcard-brand {
    font-size: 0.7rem;
    margin-bottom: 8px;
}

.products-grid .pcard-cart-btn {
    padding: 8px 12px;
    font-size: 0.75rem;
    border-radius: 8px;
}

.products-grid .pcard-cart-btn svg {
    width: 14px;
    height: 14px;
}

.products-grid .pcard-badge {
    padding: 3px 6px;
    font-size: 0.6rem;
}

.products-grid .pcard-quick-actions .quick-action-btn {
    width: 32px;
    height: 32px;
}

.products-grid .pcard-quick-actions .quick-action-btn svg {
    width: 14px;
    height: 14px;
}

.product-grid-item {
    height: 100%;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: #ffffff;
    border-radius: 16px;
    border: 2px dashed #e0e8e0;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #f0f5f0 0%, #e8efe8 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: #999;
}

.empty-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 8px 0;
}

.empty-text {
    font-size: 0.9rem;
    color: #666;
    margin: 0 0 20px 0;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-reset:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.4);
    color: #ffffff;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e8efe8;
}

.pagination-wrapper .pagination {
    gap: 4px;
}

.pagination-wrapper .page-link {
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #666;
    background: #f0f5f0;
    transition: all 0.2s;
}

.pagination-wrapper .page-link:hover {
    background: #6BB252;
    color: #ffffff;
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(107, 178, 82, 0.3);
}

.pagination-wrapper .page-item.disabled .page-link {
    background: #f5f5f5;
    color: #ccc;
}

/* Mobile Responsive */
@media (max-width: 991px) {
    .filter-sidebar {
        position: static;
        margin-bottom: 24px;
    }
    
    .products-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-right {
        width: 100%;
        justify-content: space-between;
    }
}

@media (max-width: 576px) {
    .products-page {
        padding: 16px 0;
    }
    
    .page-title {
        font-size: 1.25rem;
    }
    
    .sort-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }
    
    .sort-select {
        min-width: 100%;
    }
}

/* List View Styles */
.products-grid.list-view {
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.products-grid.list-view .product-grid-item .pcard-inner {
    flex-direction: row;
    align-items: stretch;
}

.products-grid.list-view .product-grid-item .pcard-image-wrap {
    width: 120px;
    min-width: 120px;
    aspect-ratio: auto;
    height: 100%;
    min-height: 120px;
    padding: 8px;
}

.products-grid.list-view .product-grid-item .pcard-content {
    flex: 1;
    padding: 10px 14px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.products-grid.list-view .product-grid-item .pcard-title {
    font-size: 0.85rem;
    -webkit-line-clamp: 2;
    min-height: auto;
    margin-bottom: 4px;
}

.products-grid.list-view .product-grid-item .pcard-category {
    margin-bottom: 2px;
    font-size: 0.6rem;
}

.products-grid.list-view .product-grid-item .pcard-rating {
    margin-bottom: 6px;
}

.products-grid.list-view .product-grid-item .pcard-price {
    margin-bottom: 6px;
}

.products-grid.list-view .product-grid-item .price-now {
    font-size: 1rem;
}

.products-grid.list-view .product-grid-item .pcard-brand {
    margin-bottom: 8px;
    font-size: 0.7rem;
}

.products-grid.list-view .product-grid-item .pcard-cart-form {
    margin-top: 0;
}

.products-grid.list-view .product-grid-item .pcard-cart-btn {
    width: auto;
    max-width: 140px;
    padding: 6px 10px;
    font-size: 0.7rem;
}

/* List view responsive */
@media (max-width: 1400px) {
    .products-grid.list-view {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 900px) {
    .products-grid.list-view {
        grid-template-columns: 1fr;
    }
    
    .products-grid.list-view .product-grid-item .pcard-image-wrap {
        width: 140px;
        min-width: 140px;
        min-height: 140px;
    }
}

@media (max-width: 500px) {
    .products-grid.list-view .product-grid-item .pcard-inner {
        flex-direction: column;
    }
    
    .products-grid.list-view .product-grid-item .pcard-image-wrap {
        width: 100%;
        min-width: 100%;
        aspect-ratio: 4/3;
        min-height: auto;
    }
    
    .products-grid.list-view .product-grid-item .pcard-cart-btn {
        width: 100%;
        max-width: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const productsGrid = document.getElementById('products-grid');
    
    // Load saved view preference from localStorage
    const savedView = localStorage.getItem('productsViewMode') || 'grid';
    setView(savedView);
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const viewMode = this.getAttribute('data-view');
            setView(viewMode);
            // Save preference to localStorage
            localStorage.setItem('productsViewMode', viewMode);
        });
    });
    
    function setView(viewMode) {
        // Update button states
        viewButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-view') === viewMode) {
                btn.classList.add('active');
            }
        });
        
        // Update grid class
        if (viewMode === 'list') {
            productsGrid.classList.add('list-view');
        } else {
            productsGrid.classList.remove('list-view');
        }
    }
});
</script>
@endsection
