@extends('layouts.app')

@section('title', $product->name . ' - Agriculture Equipment')
@section('description', $product->short_description ?? $product->description)

@section('content')
<div class="container-lg py-3">
    @php
        $mainImageUrl = \App\Helpers\ImageHelper::productImageUrl($product);
    @endphp
    <div class="row g-4 product-detail-row">
        <!-- Product Images (sticky left) -->
        <div class="col-lg-6 product-images-col">
            <div class="product-image-main mb-3">
                <div class="image-wrapper">
                    @auth
                    <form action="{{ route('agriculture.wishlist.add') }}" method="POST" class="wishlist-form-image">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="wishlist-btn-image" title="Add to Wishlist">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                            </svg>
                        </button>
                    </form>
                    @endauth
                    <img id="mainProductImage" src="{{ $mainImageUrl }}" 
                         alt="{{ $product->name }}" class="img-fluid">
                    @if($product->sale_price)
                    <span class="sale-badge">Sale</span>
                    @endif
                </div>
            </div>
            
            @php
                // Get gallery images (handle both array and JSON)
                $galleryImages = is_array($product->gallery_images)
                    ? $product->gallery_images
                    : (json_decode($product->gallery_images ?? '[]', true) ?? []);
                
                // Also check for primary image to include in gallery
                $allImages = [];
                if ($product->primary_image) {
                    $allImages[] = $product->primary_image;
                }
                $allImages = array_merge($allImages, $galleryImages);
            @endphp
            
            @if(!empty($allImages) && count($allImages) > 0)
            <div class="product-thumbnails">
                <div class="thumbnail-grid">
                    @foreach($allImages as $index => $image)
                    @php
                        $thumbUrl = \App\Helpers\ImageHelper::imageUrl($image);
                    @endphp
                    <div class="thumbnail-item">
                        <img src="{{ $thumbUrl }}" 
                             alt="{{ $product->name }}" 
                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                             data-image-url="{{ $thumbUrl }}"
                             onclick="changeMainImage(this)">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('agriculture.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('agriculture.categories.show', $product->category) }}">{{ $product->category->name }}</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </nav>
                
                <h1 class="product-title mb-2">{{ $product->name }}</h1>
                
                <div class="product-price mb-3">
                    <div class="price-wrapper">
                        <span class="current-price">{{ $currencySymbol ?? '₹' }}{{ number_format($product->current_price, 2) }}</span>
                        @if($product->sale_price)
                        <span class="old-price">{{ $currencySymbol ?? '₹' }}{{ number_format($product->price, 2) }}</span>
                        <span class="discount-badge">{{ $product->discount_percentage }}% OFF</span>
                        @endif
                    </div>
                </div>

                @php
                    $shortDescLines = $product->short_description
                        ? array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $product->short_description)))
                        : [];
                @endphp
                @if(!empty($shortDescLines))
                <div class="product-short-description mb-3">
                    <h6 class="section-title">Short Description</h6>
                    <ul class="short-description-list">
                        @foreach($shortDescLines as $line)
                        <li>{{ $line }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @php
                    $specifications = $product->specifications ?? [];
                    if (is_string($specifications)) {
                        $specifications = json_decode($specifications, true) ?? [];
                    }
                    // Normalize: ensure each spec has 'key' and 'value' (support legacy 'name' for key)
                    if (is_array($specifications)) {
                        $specifications = array_values(array_filter(array_map(function ($spec) {
                            if (!is_array($spec)) return null;
                            $key = trim($spec['key'] ?? $spec['name'] ?? '');
                            $value = trim($spec['value'] ?? '');
                            if ($key === '') return null;
                            return ['key' => $key, 'value' => $value];
                        }, $specifications)));
                    }
                @endphp
                @if(!empty($specifications) && is_array($specifications))
                <div class="product-specifications-card mb-3">
                    <h6 class="section-title">Specifications</h6>
                    <ul class="specifications-list">
                        @foreach($specifications as $spec)
                        <li><strong>{{ $spec['key'] }}:</strong> {{ $spec['value'] ?? '' }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($product->description)
                <div class="product-description-card mb-3">
                    <h6 class="section-title">Description</h6>
                    <div class="description-text">{!! $product->description !!}</div>
                </div>
                @endif

                @if($product->youtube_video_url)
                <div class="product-youtube-button-wrap mb-3">
                    <h6 class="section-title">Product Video</h6>
                    <a href="{{ $product->youtube_video_url }}" target="_blank" rel="noopener noreferrer" class="btn-youtube">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        Watch on YouTube
                    </a>
                </div>
                @endif
                
                <div class="product-actions mb-3">
                    @if($product->in_stock)
                    <form action="{{ route('agriculture.cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="quantity-wrapper">
                            <label for="quantity" class="quantity-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="quantity-input">
                        </div>
                        <button type="submit" class="btn-add-cart">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="me-2">
                                <path d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z"/>
                            </svg>
                            Add to Cart
                        </button>
                    </form>
                    @else
                    <div class="out-of-stock-alert">
                        <strong>Out of Stock</strong> - This product is currently unavailable.
                    </div>
                    @endif
                </div>
                
                <div class="product-features">
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon success">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <strong>Quality Guaranteed</strong>
                                <small>Premium equipment</small>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <strong>Expert Support</strong>
                                <small>Professional guidance</small>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon warning">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <strong>Fast Delivery</strong>
                                <small>Quick shipping</small>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon info">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <strong>Warranty Included</strong>
                                <small>Standard warranty</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products (same card design as shop page for aligned layout) -->
    @if($relatedProducts->count() > 0)
    <div class="related-products-section mt-4">
        <div class="section-header mb-3">
            <h4 class="section-heading">Related Products</h4>
        </div>
        <div class="related-products-grid row g-3">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-6 col-md-4 col-lg-3">
                <x-product-card :product="$relatedProduct" />
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
/* Product Image Section - Fixed Size */
.product-image-main {
    position: relative;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.image-wrapper {
    position: relative;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    /* Fixed aspect ratio container */
    height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wishlist-form-image {
    position: absolute;
    top: 16px;
    left: 16px;
    z-index: 10;
}

.wishlist-btn-image {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.95);
    color: #6c757d;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.25s ease;
}

.wishlist-btn-image:hover {
    background: #fff;
    color: #dc3545;
    transform: scale(1.08);
    box-shadow: 0 4px 14px rgba(220, 53, 69, 0.25);
}

.image-wrapper img {
    border-radius: 8px;
    max-width: 100%;
    max-height: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    display: block;
}

.sale-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px rgba(238, 90, 111, 0.3);
    z-index: 10;
}

/* Thumbnails */
.product-thumbnails {
    margin-top: 12px;
}

.thumbnail-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.thumbnail-item {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}

.thumbnail-item:hover {
    border-color: #28a745;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}

.thumbnail {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 6px;
    transition: all 0.3s ease;
}

.thumbnail.active {
    background: #f8faf8;
}

.thumbnail-item:has(.active) {
    border-color: #28a745;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.1);
}

/* Breadcrumb */
.breadcrumb-nav {
    font-size: 0.85rem;
}

.breadcrumb-nav .breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-nav .breadcrumb-item a:hover {
    color: #28a745;
}

/* Product Title */
.product-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.5rem;
    line-height: 1.3;
    margin-bottom: 0.75rem;
}

/* Price Section */
.product-price {
    margin-bottom: 1rem;
}

.price-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.current-price {
    font-size: 1.75rem;
    font-weight: 700;
    color: #28a745;
    letter-spacing: -0.5px;
}

.old-price {
    font-size: 1rem;
    color: #adb5bd;
    text-decoration: line-through;
}

.discount-badge {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* Short Description */
.product-short-description {
    background: #fff;
    border-radius: 10px;
    padding: 16px;
    border: 1px solid #e9ecef;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.short-description-list {
    margin: 0;
    padding-left: 1.25rem;
    color: #495057;
    font-size: 0.9rem;
    line-height: 1.7;
}

.short-description-list li {
    margin-bottom: 6px;
}

.short-description-list li:last-child {
    margin-bottom: 0;
}

/* Description Card */
.product-description-card {
    background: #fff;
    border-radius: 10px;
    padding: 16px;
    border: 1px solid #e9ecef;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

/* Specifications Card */
.product-specifications-card {
    background: #fff;
    border-radius: 10px;
    padding: 16px;
    border: 1px solid #e9ecef;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.specifications-list {
    margin: 0;
    padding-left: 1.25rem;
    list-style: disc;
    color: #495057;
    font-size: 0.9rem;
    line-height: 1.75;
}

.specifications-list li {
    margin-bottom: 6px;
}

.specifications-list li:last-child {
    margin-bottom: 0;
}

.specifications-list strong {
    color: #2c3e50;
    font-weight: 600;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 8px;
}

.description-text {
    color: #495057;
    font-size: 0.9rem;
    line-height: 1.65;
    margin: 0;
}

.description-text p {
    margin-bottom: 0.75rem;
}

.description-text p:last-child {
    margin-bottom: 0;
}

/* Sticky left column: product images stay in place while right side scrolls */
@media (min-width: 992px) {
    .product-detail-row {
        align-items: flex-start;
    }
    .product-images-col {
        position: sticky;
        top: 90px;
    }
}

/* YouTube button (link only, no embed) */
.product-youtube-button-wrap {
    background: #fff;
    border-radius: 10px;
    padding: 16px;
    border: 1px solid #e9ecef;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.btn-youtube {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 20px;
    background: #ff0000;
    color: #fff !important;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background 0.2s, transform 0.2s;
    border: none;
}

.btn-youtube:hover {
    background: #cc0000;
    color: #fff !important;
    transform: translateY(-1px);
}

.btn-youtube svg {
    flex-shrink: 0;
}

/* Add to Cart */
.product-actions {
    margin-bottom: 1rem;
}

.add-to-cart-form {
    display: flex;
    gap: 12px;
    align-items: flex-end;
    flex-wrap: wrap;
}

.quantity-wrapper {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.quantity-label {
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
    margin: 0;
}

.quantity-input {
    width: 70px;
    padding: 8px 10px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    font-size: 0.9rem;
    text-align: center;
    transition: all 0.2s;
}

.quantity-input:focus {
    outline: none;
    border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
}

.btn-add-cart {
    flex: 1;
    min-width: 160px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
}

.btn-add-cart:active {
    transform: translateY(0);
}

.out-of-stock-alert {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 0.9rem;
}

/* Features */
.product-features {
    margin-top: 1rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: #28a745;
}

.feature-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.feature-icon.success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #28a745;
}

.feature-icon.primary {
    background: linear-gradient(135deg, #cfe2ff 0%, #b6d4fe 100%);
    color: #0d6efd;
}

.feature-icon.warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
    color: #ffc107;
}

.feature-icon.info {
    background: linear-gradient(135deg, #cff4fc 0%, #b6effb 100%);
    color: #0dcaf0;
}

.feature-content {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.feature-content strong {
    font-size: 0.85rem;
    color: #2c3e50;
    font-weight: 600;
}

.feature-content small {
    font-size: 0.75rem;
    color: #6c757d;
}

/* Related Products - uses same product card as shop page for aligned design */
.related-products-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.related-products-section .section-header {
    margin-bottom: 1.5rem;
}

.related-products-section .section-heading {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.25rem;
    margin: 0;
}

.related-products-grid .pcard {
    height: 100%;
}

/* Responsive */
@media (max-width: 992px) {
    .image-wrapper {
        height: 400px;
    }
}

@media (max-width: 768px) {
    .image-wrapper {
        height: 350px;
        padding: 16px;
    }
    
    .product-title {
        font-size: 1.25rem;
    }
    
    .current-price {
        font-size: 1.5rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .add-to-cart-form {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-add-cart {
        width: 100%;
    }
    
    .section-heading {
        font-size: 1.1rem;
    }
    
    .thumbnail-item {
        flex: 0 0 calc(25% - 7.5px);
    }
}

@media (max-width: 480px) {
    .image-wrapper {
        height: 280px;
        padding: 12px;
    }
    
    .thumbnail-item {
        flex: 0 0 calc(33.33% - 6.67px);
    }
}
</style>

<script>
function changeMainImage(thumbnail) {
    const mainImage = document.getElementById('mainProductImage');
    const imageUrl = thumbnail.getAttribute('data-image-url');
    
    if (mainImage && imageUrl) {
        mainImage.src = imageUrl;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        thumbnail.classList.add('active');
    }
}
</script>
@endsection
