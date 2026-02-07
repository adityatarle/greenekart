@php
    $user = Auth::user();
    $isDealer = $user && $user->canAccessDealerPricing();
    $originalPrice = $isDealer ? ($product->dealer_price ?? 0) : ($product->price ?? 0);
    $salePrice = $isDealer ? ($product->dealer_sale_price ?? null) : ($product->sale_price ?? null);
    $currentPrice = $salePrice ?: $originalPrice;
    $discount = ($salePrice && $originalPrice && $salePrice < $originalPrice) ? round((($originalPrice - $salePrice) / $originalPrice) * 100) : 0;
    
    // Use ImageHelper to get image URL with automatic cache buster
    $imageUrl = \App\Helpers\ImageHelper::productImageUrl($product);
@endphp

<div class="pcard">
    <div class="pcard-inner">
        <!-- Image Section -->
        <a href="{{ route('agriculture.products.show', $product) }}" class="pcard-image-link">
            <div class="pcard-image-wrap">
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="pcard-image" loading="lazy">
                
                <!-- Badges -->
                <div class="pcard-badges">
                    @if($discount > 0)
                        <span class="pcard-badge badge-discount">-{{ $discount }}%</span>
                    @endif
                    @if($product->is_featured)
                        <span class="pcard-badge badge-featured">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                            Featured
                        </span>
                    @endif
                </div>
                
                <!-- Quick Actions (on hover) -->
                <div class="pcard-quick-actions">
                    <a href="{{ route('agriculture.products.show', $product) }}" class="quick-action-btn" title="Quick View">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </a>
                    @auth
                        <form action="{{ route('agriculture.wishlist.add') }}" method="POST" class="quick-action-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="quick-action-btn" title="Add to Wishlist">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.login') }}" class="quick-action-btn" title="Login to add to wishlist">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </a>
        
        <!-- Content Section -->
        <div class="pcard-content">
            @if($product->category)
                <a href="{{ route('agriculture.categories.show', $product->category) }}" class="pcard-category">
                    {{ $product->category->name }}
                </a>
            @endif
            
            <a href="{{ route('agriculture.products.show', $product) }}" class="pcard-title-link">
                <h3 class="pcard-title">{{ Str::limit($product->name, 55) }}</h3>
            </a>
            
            <!-- Rating (placeholder - can be dynamic later) -->
            <div class="pcard-rating">
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="{{ $i <= 4 ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    @endfor
                </div>
                <span class="rating-count">(4.0)</span>
            </div>
            
            <!-- Price -->
            <div class="pcard-price">
                @if($discount > 0)
                    <span class="price-old">₹{{ number_format($originalPrice, 0) }}</span>
                @endif
                <span class="price-now">₹{{ number_format($currentPrice, 0) }}</span>
                @if($discount > 0)
                    <span class="price-save">Save ₹{{ number_format($originalPrice - $currentPrice, 0) }}</span>
                @endif
            </div>
            
            @if($product->brand)
                <div class="pcard-brand">
                    <span class="brand-label">Brand:</span>
                    <span class="brand-value">{{ $product->brand }}</span>
                </div>
            @endif
            
            <!-- Add to Cart -->
            <form action="{{ route('agriculture.cart.add') }}" method="POST" class="pcard-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="pcard-cart-btn">
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

<style>
/* Product Card - Premium Style */
.pcard {
    height: 100%;
}

.pcard-inner {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #e8efe8;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.pcard-inner:hover {
    border-color: #6BB252;
    box-shadow: 0 12px 40px rgba(107, 178, 82, 0.15);
    transform: translateY(-6px);
}

/* Image Section */
.pcard-image-link {
    display: block;
    text-decoration: none;
}

.pcard-image-wrap {
    position: relative;
    aspect-ratio: 1;
    background: linear-gradient(135deg, #f8faf8 0%, #f0f5f0 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.pcard-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.pcard-inner:hover .pcard-image {
    transform: scale(1.08);
}

/* Badges */
.pcard-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    right: 12px;
    display: flex;
    justify-content: space-between;
    pointer-events: none;
    z-index: 3;
}

.pcard-badge {
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-discount {
    background: linear-gradient(135deg, #e53935 0%, #c62828 100%);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(229, 57, 53, 0.3);
}

.badge-featured {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
    margin-left: auto;
}

/* Quick Actions */
.pcard-quick-actions {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 4;
}

.pcard-inner:hover .pcard-quick-actions {
    opacity: 1;
}

.quick-action-btn {
    width: 42px;
    height: 42px;
    background: #ffffff;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #333;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    text-decoration: none;
}

.quick-action-btn:hover {
    background: #6BB252;
    color: #ffffff;
    transform: scale(1.1);
}

.quick-action-form {
    margin: 0;
}

/* Content Section */
.pcard-content {
    padding: 16px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.pcard-category {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 600;
    color: #6BB252;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 8px;
    text-decoration: none;
    transition: color 0.2s;
}

.pcard-category:hover {
    color: #4a8a3a;
}

.pcard-title-link {
    text-decoration: none;
    display: block;
    margin-bottom: 8px;
}

.pcard-title {
    font-size: 0.9rem;
    font-weight: 500;
    color: #1a2e1a;
    margin: 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.5em;
    transition: color 0.2s;
}

.pcard-title-link:hover .pcard-title {
    color: #6BB252;
}

/* Rating */
.pcard-rating {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
}

.stars {
    display: flex;
    gap: 2px;
    color: #ffc107;
}

.stars svg:last-child {
    color: #ddd;
}

.rating-count {
    font-size: 0.75rem;
    color: #999;
}

/* Price */
.pcard-price {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 10px;
}

.price-old {
    font-size: 0.85rem;
    color: #999;
    text-decoration: line-through;
}

.price-now {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a2e1a;
}

.price-save {
    font-size: 0.7rem;
    color: #ffffff;
    background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: 500;
}

/* Brand */
.pcard-brand {
    font-size: 0.8rem;
    margin-bottom: 12px;
    color: #666;
}

.brand-label {
    color: #999;
}

.brand-value {
    font-weight: 500;
    color: #333;
}

/* Add to Cart Button */
.pcard-cart-form {
    margin-top: auto;
}

.pcard-cart-btn {
    width: 100%;
    padding: 11px 16px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(107, 178, 82, 0.25);
}

.pcard-cart-btn:hover {
    background: linear-gradient(135deg, #5a9a45 0%, #4a8a3a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.35);
}

.pcard-cart-btn:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .pcard-image-wrap {
        aspect-ratio: 4/3;
        padding: 12px;
    }
    
    .pcard-content {
        padding: 12px;
    }
    
    .pcard-title {
        font-size: 0.85rem;
    }
    
    .price-now {
        font-size: 1rem;
    }
    
    .pcard-cart-btn {
        padding: 10px 14px;
        font-size: 0.8rem;
    }
    
    .pcard-quick-actions {
        display: none;
    }
}
</style>
