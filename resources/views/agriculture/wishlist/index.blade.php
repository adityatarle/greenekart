@extends('layouts.app')

@section('title', 'My Wishlist - Greenleaf')

@section('content')
<div class="wishlist-page py-4">
    <div class="container-lg">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title mb-1">My Wishlist</h1>
                <p class="text-muted mb-0">{{ $items->count() }} {{ Str::plural('item', $items->count()) }} saved</p>
            </div>
            @if($items->count())
            <form action="{{ route('agriculture.wishlist.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your entire wishlist?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Clear All
                </button>
            </form>
            @endif
        </div>

        @if(!$items->count())
            <!-- Empty State -->
            <div class="empty-wishlist text-center py-5">
                <div class="empty-icon mb-4">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>
                <h3 class="text-muted mb-3">Your wishlist is empty</h3>
                <p class="text-muted mb-4">Save items you love by clicking the heart icon on any product.</p>
                <a href="{{ route('agriculture.products.index') }}" class="btn btn-primary btn-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        @else
            <!-- Wishlist Grid -->
            <div class="wishlist-grid">
                @foreach($items as $item)
                    @php 
                        $product = $item->product;
                        $user = Auth::user();
                        $isDealer = $user && $user->canAccessDealerPricing();
                        $originalPrice = $isDealer ? ($product->dealer_price ?? null) : ($product->price ?? null);
                        $salePrice = $isDealer ? ($product->dealer_sale_price ?? null) : ($product->sale_price ?? null);
                        $current = $salePrice ?: $originalPrice;
                        $discount = ($salePrice && $originalPrice && $salePrice < $originalPrice) ? round((($originalPrice - $salePrice) / $originalPrice) * 100) : 0;
                        $imageUrl = \App\Helpers\ImageHelper::productImageUrl($product);
                    @endphp
                    <div class="wishlist-item">
                        <div class="wishlist-card">
                            <!-- Remove Button -->
                            <form action="{{ route('agriculture.wishlist.remove') }}" method="POST" class="remove-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="btn-remove" title="Remove from wishlist">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </form>
                            
                            <!-- Product Image -->
                            <a href="{{ route('agriculture.products.show', $product) }}" class="wishlist-image">
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                @if($discount > 0)
                                    <span class="discount-badge">-{{ $discount }}%</span>
                                @endif
                            </a>
                            
                            <!-- Product Info -->
                            <div class="wishlist-content">
                                @if($product->category)
                                    <a href="{{ route('agriculture.categories.show', $product->category) }}" class="product-category">
                                        {{ $product->category->name }}
                                    </a>
                                @endif
                                
                                <h3 class="product-name">
                                    <a href="{{ route('agriculture.products.show', $product) }}">{{ $product->name }}</a>
                                </h3>
                                
                                <div class="product-price">
                                    @if($discount > 0)
                                        <span class="price-old">₹{{ number_format($originalPrice, 0) }}</span>
                                    @endif
                                    <span class="price-current">₹{{ number_format($current, 0) }}</span>
                                </div>
                                
                                <!-- Add to Cart -->
                                <form action="{{ route('agriculture.cart.add') }}" method="POST" class="add-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-cart">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
.wishlist-page {
    background: linear-gradient(180deg, #f8faf8 0%, #ffffff 100%);
    min-height: 60vh;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0;
}

/* Empty State */
.empty-wishlist {
    background: #fff;
    border-radius: 16px;
    padding: 60px 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.empty-icon {
    opacity: 0.6;
}

/* Wishlist Grid */
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}

@media (max-width: 1400px) {
    .wishlist-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 1100px) {
    .wishlist-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .wishlist-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .wishlist-grid {
        grid-template-columns: 1fr;
    }
}

/* Wishlist Card */
.wishlist-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e8efe8;
    transition: all 0.3s ease;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.wishlist-card:hover {
    border-color: #6BB252;
    box-shadow: 0 8px 24px rgba(107, 178, 82, 0.15);
    transform: translateY(-4px);
}

/* Remove Button */
.remove-form {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
}

.btn-remove {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.9);
    color: #999;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-remove:hover {
    background: #dc3545;
    color: #fff;
}

/* Product Image */
.wishlist-image {
    display: block;
    position: relative;
    padding: 16px;
    background: linear-gradient(135deg, #f8faf8 0%, #f0f5f0 100%);
    aspect-ratio: 1;
}

.wishlist-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.wishlist-card:hover .wishlist-image img {
    transform: scale(1.05);
}

.discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #e53935 0%, #c62828 100%);
    color: #fff;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 700;
}

/* Product Content */
.wishlist-content {
    padding: 14px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-category {
    font-size: 0.7rem;
    font-weight: 600;
    color: #6BB252;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    margin-bottom: 6px;
}

.product-category:hover {
    color: #4a8a3a;
}

.product-name {
    font-size: 0.85rem;
    font-weight: 500;
    margin: 0 0 10px 0;
    line-height: 1.4;
}

.product-name a {
    color: #1a2e1a;
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-name a:hover {
    color: #6BB252;
}

/* Price */
.product-price {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.price-old {
    font-size: 0.8rem;
    color: #999;
    text-decoration: line-through;
}

.price-current {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a2e1a;
}

/* Add to Cart Button */
.add-cart-form {
    margin-top: auto;
}

.btn-add-cart {
    width: 100%;
    padding: 10px 16px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-add-cart:hover {
    background: linear-gradient(135deg, #5a9a45 0%, #4a8a3a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(107, 178, 82, 0.3);
}

/* Responsive */
@media (max-width: 576px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .wishlist-content {
        padding: 12px;
    }
    
    .product-name {
        font-size: 0.8rem;
    }
    
    .price-current {
        font-size: 1rem;
    }
}
</style>
@endsection
