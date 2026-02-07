@extends('layouts.app')

@section('title', 'Shopping Cart - Greenleaf')
@section('description', 'Review your selected agriculture equipment and proceed to checkout')

@section('content')
<div class="cart-page py-4">
    <div class="container-lg">
        <h1 class="page-title mb-4">Shopping Cart</h1>
        
        @if(count($cartItems) > 0)
        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-items-section">
                <div class="cart-card">
                    @foreach($cartItems as $index => $item)
                    <div class="cart-item" data-product-id="{{ $item['product']->id }}">
                        <!-- Product Image -->
                        <a href="{{ route('agriculture.products.show', $item['product']) }}" class="cart-item-image">
                            <img src="{{ \App\Helpers\ImageHelper::productImageUrl($item['product']) }}" 
                                 alt="{{ $item['product']->name }}">
                        </a>
                        
                        <!-- Product Details -->
                        <div class="cart-item-details">
                            <a href="{{ route('agriculture.products.show', $item['product']) }}" class="item-name">
                                {{ $item['product']->name }}
                            </a>
                            <div class="item-meta">
                                @if($item['product']->category)
                                <span class="item-category">{{ $item['product']->category->name }}</span>
                                @endif
                                @if($item['product']->brand)
                                <span class="item-brand">Brand: {{ $item['product']->brand }}</span>
                                @endif
                            </div>
                            <div class="item-price-mobile">₹{{ number_format($item['price'], 0) }}</div>
                        </div>
                        
                        <!-- Quantity -->
                        <div class="cart-item-quantity">
                            <div class="quantity-control">
                                <button type="button" class="qty-btn qty-minus" data-action="decrease">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                                <input type="number" class="qty-input" value="{{ $item['quantity'] }}" min="1" max="99" data-product-id="{{ $item['product']->id }}" data-price="{{ $item['price'] }}">
                                <button type="button" class="qty-btn qty-plus" data-action="increase">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="cart-item-price">
                            <span class="item-subtotal">₹{{ number_format($item['subtotal'], 0) }}</span>
                        </div>
                        
                        <!-- Remove -->
                        <div class="cart-item-remove">
                            <form action="{{ route('agriculture.cart.remove') }}" method="POST" class="remove-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                <button type="submit" class="btn-remove" title="Remove item">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Cart Actions -->
                    <div class="cart-actions">
                        <a href="{{ route('agriculture.products.index') }}" class="btn-continue">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Continue Shopping
                        </a>
                        <form action="{{ route('agriculture.cart.clear') }}" method="POST" class="clear-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-clear" onclick="return confirm('Are you sure you want to clear your entire cart?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Clear Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="cart-summary-section">
                <div class="summary-card">
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="summary-subtotal">₹{{ number_format($total, 0) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span class="text-muted">Calculated at checkout</span>
                    </div>
                    <div class="summary-row">
                        <span>Tax</span>
                        <span class="text-muted">Calculated at checkout</span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="total-amount">₹{{ number_format($total, 0) }}</span>
                    </div>
                    
                    <a href="{{ route('agriculture.checkout.index') }}" class="btn-checkout">
                        Proceed to Checkout
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                    
                    <div class="secure-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Secure checkout
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="empty-cart">
            <div class="empty-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
            </div>
            <h3>Your cart is empty</h3>
            <p>Add some agriculture equipment to get started!</p>
            <a href="{{ route('agriculture.products.index') }}" class="btn-shop">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Browse Products
            </a>
        </div>
        @endif
    </div>
</div>

<style>
.cart-page {
    background: linear-gradient(180deg, #f8faf8 0%, #ffffff 100%);
    min-height: 60vh;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a2e1a;
}

/* Cart Layout */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 24px;
    align-items: start;
}

@media (max-width: 1200px) {
    .cart-layout {
        grid-template-columns: 1fr 300px;
        gap: 20px;
    }
}

@media (max-width: 992px) {
    .cart-layout {
        grid-template-columns: 1fr;
    }
}

/* Cart Items Card */
.cart-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
}

/* Cart Item */
.cart-item {
    display: grid;
    grid-template-columns: 90px 1fr auto auto auto;
    gap: 16px;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #f0f0f0;
}

.cart-item:last-of-type {
    border-bottom: none;
}

@media (max-width: 1200px) {
    .cart-item {
        grid-template-columns: 80px 1fr;
        grid-template-rows: auto auto;
        gap: 12px;
        padding: 16px;
    }
    
    .cart-item-details {
        grid-column: 2;
    }
    
    .cart-item-quantity {
        grid-column: 2;
        grid-row: 2;
        justify-self: start;
    }
    
    .cart-item-price {
        grid-column: 2;
        grid-row: 2;
        justify-self: center;
        display: flex !important;
    }
    
    .cart-item-remove {
        grid-column: 2;
        grid-row: 2;
        justify-self: end;
    }
    
    .cart-item-image {
        grid-row: span 2;
    }
}

@media (max-width: 576px) {
    .cart-item {
        grid-template-columns: 70px 1fr;
        gap: 10px;
        padding: 14px;
    }
}

/* Product Image */
.cart-item-image {
    width: 90px;
    height: 90px;
    background: #f8faf8;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
}

.cart-item-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

@media (max-width: 1200px) {
    .cart-item-image {
        width: 80px;
        height: 80px;
    }
}

@media (max-width: 576px) {
    .cart-item-image {
        width: 70px;
        height: 70px;
    }
}

/* Product Details */
.cart-item-details {
    min-width: 0;
}

.item-name {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1a2e1a;
    text-decoration: none;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 4px;
}

.item-name:hover {
    color: #6BB252;
}

.item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    font-size: 0.8rem;
    color: #666;
}

.item-category {
    color: #6BB252;
    font-weight: 500;
}

.item-price-mobile {
    display: none;
    font-weight: 600;
    color: #1a2e1a;
    margin-top: 8px;
}

/* Quantity Control */
.cart-item-quantity {
    display: flex;
    align-items: center;
}

.quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
}

.qty-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: #f8f8f8;
    color: #333;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.qty-btn:hover {
    background: #6BB252;
    color: #fff;
}

.qty-input {
    width: 50px;
    height: 36px;
    border: none;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
    -moz-appearance: textfield;
}

.qty-input::-webkit-outer-spin-button,
.qty-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

@media (max-width: 576px) {
    .qty-btn {
        width: 32px;
        height: 32px;
    }
    
    .qty-input {
        width: 40px;
        height: 32px;
    }
}

/* Price */
.cart-item-price {
    text-align: right;
    min-width: 80px;
}

.item-subtotal {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a2e1a;
}

@media (max-width: 1200px) {
    .item-subtotal {
        font-size: 1rem;
    }
}

/* Remove Button */
.cart-item-remove {
    display: flex;
    justify-content: center;
}

.btn-remove {
    width: 40px;
    height: 40px;
    border: 1px solid #ffcdd2;
    background: #fff5f5;
    color: #dc3545;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.btn-remove:hover {
    background: #dc3545;
    color: #fff;
    border-color: #dc3545;
}

@media (max-width: 576px) {
    .btn-remove {
        width: 36px;
        height: 36px;
    }
}

/* Cart Actions */
.cart-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #fafafa;
    border-top: 1px solid #f0f0f0;
}

.btn-continue {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #fff;
    border: 1px solid #6BB252;
    color: #6BB252;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.btn-continue:hover {
    background: #6BB252;
    color: #fff;
}

.btn-clear {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #fff;
    border: 1px solid #dc3545;
    color: #dc3545;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-clear:hover {
    background: #dc3545;
    color: #fff;
}

@media (max-width: 576px) {
    .cart-actions {
        flex-direction: column;
        gap: 12px;
    }
    
    .btn-continue, .btn-clear {
        width: 100%;
        justify-content: center;
    }
}

/* Summary Card */
.summary-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 24px;
    position: sticky;
    top: 100px;
}

@media (max-width: 1200px) {
    .summary-card {
        padding: 20px;
    }
}

@media (max-width: 992px) {
    .summary-card {
        position: static;
    }
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a2e1a;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #f0f0f0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 0.95rem;
}

.summary-subtotal {
    font-weight: 600;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    margin: 16px 0;
    border-top: 2px solid #f0f0f0;
    border-bottom: 2px solid #f0f0f0;
}

.summary-total span:first-child {
    font-size: 1.1rem;
    font-weight: 700;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
    color: #6BB252;
}

.btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(107, 178, 82, 0.3);
}

.btn-checkout:hover {
    background: linear-gradient(135deg, #5a9a45 0%, #4a8a3a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.4);
    color: #fff;
}

.secure-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 16px;
    font-size: 0.85rem;
    color: #6BB252;
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.empty-icon {
    margin-bottom: 20px;
    opacity: 0.6;
}

.empty-cart h3 {
    color: #1a2e1a;
    margin-bottom: 8px;
}

.empty-cart p {
    color: #666;
    margin-bottom: 24px;
}

.btn-shop {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #fff;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-shop:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.4);
    color: #fff;
}

/* Loading state */
.cart-item.updating {
    opacity: 0.6;
    pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity buttons
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const container = this.closest('.quantity-control');
            const input = container.querySelector('.qty-input');
            let value = parseInt(input.value) || 1;
            
            if (this.dataset.action === 'increase') {
                value = Math.min(99, value + 1);
            } else {
                value = Math.max(1, value - 1);
            }
            
            input.value = value;
            updateCart(input);
        });
    });
    
    // Direct input change
    document.querySelectorAll('.qty-input').forEach(input => {
        let timeout;
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                let value = parseInt(this.value) || 1;
                value = Math.max(1, Math.min(99, value));
                this.value = value;
                updateCart(this);
            }, 500); // Wait 500ms after user stops typing
        });
    });
    
    function updateCart(input) {
        const productId = input.dataset.productId;
        const quantity = input.value;
        const price = parseFloat(input.dataset.price);
        const cartItem = input.closest('.cart-item');
        
        // Add loading state
        cartItem.classList.add('updating');
        
        // Update via AJAX
        fetch('{{ route("agriculture.cart.update") }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            // Update subtotal display
            const subtotal = price * quantity;
            const subtotalEl = cartItem.querySelector('.item-subtotal');
            if (subtotalEl) {
                subtotalEl.textContent = '₹' + subtotal.toLocaleString('en-IN');
            }
            
            // Update totals
            if (data.total !== undefined) {
                document.querySelectorAll('.summary-subtotal, .total-amount').forEach(el => {
                    el.textContent = '₹' + parseInt(data.total).toLocaleString('en-IN');
                });
            }
            
            // Update cart count in header
            if (data.cartCount !== undefined) {
                document.querySelectorAll('.icon-badge').forEach(badge => {
                    badge.textContent = data.cartCount;
                });
            }
            
            cartItem.classList.remove('updating');
        })
        .catch(error => {
            console.error('Error:', error);
            cartItem.classList.remove('updating');
            // Reload page on error to sync state
            location.reload();
        });
    }
});
</script>
@endsection
