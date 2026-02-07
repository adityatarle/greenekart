@extends('layouts.app')

@section('title', $product->name . ' - Agriculture Equipment')
@section('description', $product->short_description ?? $product->description)

@section('content')
<div class="container-lg py-3">
    @php
        $mainImageUrl = \App\Helpers\ImageHelper::productImageUrl($product);
    @endphp
    <div class="row g-4">
        <!-- Product Images -->
        <div class="col-lg-6">
            <div class="product-image-main mb-3">
                <div class="image-wrapper">
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
                
                <div class="product-specs-card mb-3">
                    @if($product->brand || $product->model)
                    <div class="specs-grid">
                        @if($product->brand)
                        <div class="spec-item">
                            <span class="spec-label">Brand</span>
                            <span class="spec-value">{{ $product->brand }}</span>
                        </div>
                        @endif
                        @if($product->model)
                        <div class="spec-item">
                            <span class="spec-label">Model</span>
                            <span class="spec-value">{{ $product->model }}</span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                
                @if($product->description)
                <div class="product-description-card mb-3">
                    <h6 class="section-title">Description</h6>
                    <p class="description-text">{{ $product->description }}</p>
                </div>
                @endif
                
                @php
                    $specifications = $product->specifications ?? [];
                    if (is_string($specifications)) {
                        $specifications = json_decode($specifications, true) ?? [];
                    }
                @endphp
                @if(!empty($specifications) && is_array($specifications))
                <div class="product-specifications-card mb-3">
                    <h6 class="section-title">Specifications</h6>
                    <div class="specifications-table-wrapper">
                        <table class="specifications-table">
                            <tbody>
                                @foreach($specifications as $spec)
                                @if(!empty($spec['key']) && !empty($spec['value']))
                                <tr>
                                    <td class="spec-key-cell">{{ $spec['key'] }}</td>
                                    <td class="spec-value-cell">{{ $spec['value'] }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

/* Specs Card */
.product-specs-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 14px;
    border: 1px solid #e9ecef;
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
}

.spec-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.spec-label {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.spec-value {
    font-size: 0.9rem;
    color: #2c3e50;
    font-weight: 500;
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

.specifications-table-wrapper {
    margin-top: 12px;
}

.specifications-table {
    width: 100%;
    border-collapse: collapse;
}

.specifications-table tbody tr {
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.2s;
}

.specifications-table tbody tr:last-child {
    border-bottom: none;
}

.specifications-table tbody tr:hover {
    background-color: #f8f9fa;
}

.spec-key-cell {
    padding: 10px 12px;
    font-weight: 600;
    color: #495057;
    width: 40%;
    vertical-align: top;
    font-size: 0.9rem;
}

.spec-value-cell {
    padding: 10px 12px;
    color: #6c757d;
    width: 60%;
    vertical-align: top;
    font-size: 0.9rem;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.description-text {
    color: #495057;
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
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
