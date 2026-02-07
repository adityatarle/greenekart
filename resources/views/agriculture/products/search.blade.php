@extends('layouts.app')

@section('title', 'Search: ' . $searchTerm . ' - Greenleaf')
@section('description', 'Search results for ' . $searchTerm)

@section('content')
<div class="products-page search-results-page">
    <div class="container-fluid px-lg-5">
        <div class="row">
            <div class="col-12">
                <!-- Compact Header - Amazon/Flipkart style -->
                <div class="products-header">
                    <div class="header-left">
                        <h1 class="page-title">"{{ $searchTerm }}"</h1>
                        <p class="results-count">
                            @if($products->count() > 0)
                                Showing <span class="highlight">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span>
                                of <span class="highlight">{{ $products->total() }}</span> results
                            @else
                                <span class="highlight">0</span> results for "{{ $searchTerm }}"
                            @endif
                        </p>
                    </div>
                    <div class="header-right">
                        @if($products->count() > 0)
                        <form method="GET" action="{{ route('agriculture.products.search') }}" id="sort-form">
                            <input type="hidden" name="q" value="{{ $searchTerm }}">
                            @foreach(request()->except(['q', 'sort', 'page']) as $key => $value)
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
                        @endif
                    </div>
                </div>

                <!-- Search filter tag - removable -->
                <div class="active-filters">
                    <span class="filter-tag">
                        Search: {{ $searchTerm }}
                        <a href="{{ route('agriculture.products.index') }}" class="remove-filter" title="Clear search">×</a>
                    </span>
                </div>

                <!-- Products Grid - Direct display like Amazon/Flipkart -->
                <div class="products-grid" id="products-grid">
                    @forelse($products as $product)
                        <div class="product-grid-item">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @empty
                        {{-- No results: show suggested products instead of empty state --}}
                        @if($suggestedProducts->count() > 0)
                            <div class="no-results-banner">
                                <p class="no-results-text">No exact matches for "<strong>{{ $searchTerm }}</strong>". Here are some products you might like:</p>
                            </div>
                            @foreach($suggestedProducts as $product)
                                <div class="product-grid-item">
                                    @include('components.product-card', ['product' => $product])
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <p class="empty-text">No products found for "{{ $searchTerm }}". Try different keywords.</p>
                                <a href="{{ route('agriculture.products.index') }}" class="btn-reset">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="1 4 1 10 7 10"></polyline>
                                        <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                    </svg>
                                    View All Products
                                </a>
                            </div>
                        @endif
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Products page layout */
.products-page {
    background: linear-gradient(180deg, #f8faf8 0%, #ffffff 100%);
    min-height: 100vh;
    padding: 24px 0;
}
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
.products-header .page-title { font-size: 1.35rem; font-weight: 600; color: #1a2e1a; margin: 0 0 4px 0; }
.results-count { font-size: 0.875rem; color: #666; margin: 0; }
.results-count .highlight { color: #2d5a27; font-weight: 600; }
.sort-wrapper { display: flex; align-items: center; gap: 10px; }
.sort-label { font-size: 0.875rem; color: #666; white-space: nowrap; }
.sort-select {
    padding: 10px 36px 10px 14px;
    border: 1.5px solid #e0e8e0;
    border-radius: 10px;
    font-size: 0.875rem;
    color: #333;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") right 12px center no-repeat;
    appearance: none; cursor: pointer; min-width: 160px;
}
.sort-select:focus { outline: none; border-color: #6BB252; box-shadow: 0 0 0 3px rgba(107,178,82,0.1); }
.active-filters { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
.filter-tag {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 6px 12px;
    background: linear-gradient(135deg, #e8f5e3 0%, #d4edcf 100%);
    color: #2d5a27; border-radius: 20px; font-size: 0.8rem; font-weight: 500;
}
.remove-filter {
    width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;
    background: rgba(45,90,39,0.15); color: #2d5a27; border-radius: 50%;
    text-decoration: none; font-size: 1rem; transition: all 0.2s;
}
.remove-filter:hover { background: #2d5a27; color: #fff; }
.products-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
}
@media (max-width: 1600px) { .products-grid { grid-template-columns: repeat(5, 1fr); } }
@media (max-width: 1400px) { .products-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 1100px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) { .products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } }
@media (max-width: 400px) { .products-grid { grid-template-columns: 1fr; } }
.product-grid-item { height: 100%; }
.products-grid .pcard-image-wrap { padding: 10px; }
.products-grid .pcard-content { padding: 12px; }
.products-grid .pcard-title { font-size: 0.8rem; min-height: 2.2em; }
.products-grid .price-now { font-size: 1rem; }
.products-grid .pcard-cart-btn { padding: 8px 12px; font-size: 0.75rem; }
.pagination-wrapper { display: flex; justify-content: center; margin-top: 32px; padding-top: 24px; border-top: 1px solid #e8efe8; }
.empty-state {
    grid-column: 1 / -1; text-align: center; padding: 60px 20px;
    background: #fff; border-radius: 16px; border: 2px dashed #e0e8e0;
}
.empty-text { font-size: 0.95rem; color: #666; margin: 0 0 20px 0; }
.btn-reset {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #fff; border-radius: 10px; font-size: 0.875rem; font-weight: 600;
    text-decoration: none; transition: all 0.3s;
}
.btn-reset:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(107,178,82,0.4); color: #fff; }
.no-results-banner {
    grid-column: 1 / -1;
    padding: 12px 20px;
    background: linear-gradient(135deg, #fff8e7 0%, #fff3e0 100%);
    border-radius: 10px;
    border-left: 4px solid #ff9800;
    margin-bottom: 8px;
}
.no-results-text { margin: 0; font-size: 0.95rem; color: #5d4e37; }
.no-results-text strong { color: #e65100; }
</style>
@endpush
@endsection
