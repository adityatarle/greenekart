@extends('layouts.app')

@section('title', 'Checkout - Agriculture Equipment')
@section('description', 'Complete your agriculture equipment purchase')

@section('content')
<div class="checkout-page">
    <div class="container checkout-container">
        <div class="checkout-header">
            <a href="{{ route('agriculture.cart.index') }}" class="checkout-back"><i class="fas fa-arrow-left"></i> Back to cart</a>
            <h1 class="checkout-title">Checkout</h1>
            <p class="checkout-subtitle">Complete your details to place your order</p>
        </div>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="checkout-card checkout-form-card">
                    <div class="checkout-card-header">
                        <span class="checkout-card-icon"><i class="fas fa-user-edit"></i></span>
                        <div>
                            <h2 class="checkout-card-title">Billing &amp; shipping</h2>
                            <p class="checkout-card-desc">We'll use this to contact you and deliver your order.</p>
                        </div>
                    </div>
                    <div class="checkout-card-body">
                        <form action="{{ route('agriculture.checkout.process') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="checkout-form-section">
                                <span class="checkout-section-label">Contact</span>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="customer_name" class="checkout-label">Full name <span class="text-danger">*</span></label>
                                        <input type="text" class="checkout-input form-control @error('customer_name') is-invalid @enderror"
                                               id="customer_name" name="customer_name" value="{{ old('customer_name', optional(Auth::user())->name) }}" required placeholder="Your full name">
                                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="customer_email" class="checkout-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="checkout-input form-control @error('customer_email') is-invalid @enderror"
                                               id="customer_email" name="customer_email" value="{{ old('customer_email', optional(Auth::user())->email) }}" required placeholder="you@example.com">
                                        @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="customer_phone" class="checkout-label">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="checkout-input form-control @error('customer_phone') is-invalid @enderror"
                                           id="customer_phone" name="customer_phone" value="{{ old('customer_phone', optional(Auth::user())->phone) }}" required placeholder="10-digit mobile number">
                                    @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="checkout-hint">We'll contact you on this number to confirm your order.</small>
                                </div>
                            </div>
                            <div class="checkout-form-section">
                                <span class="checkout-section-label">Address</span>
                                <div class="mb-3">
                                    <label for="billing_address" class="checkout-label">Billing address <span class="text-danger">*</span></label>
                                    <textarea class="checkout-input form-control @error('billing_address') is-invalid @enderror"
                                              id="billing_address" name="billing_address" rows="3" required placeholder="Street, city, state, pincode">{{ old('billing_address') }}</textarea>
                                    @error('billing_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label for="shipping_address" class="checkout-label">Shipping address</label>
                                    <textarea class="checkout-input form-control @error('shipping_address') is-invalid @enderror"
                                              id="shipping_address" name="shipping_address" rows="3" placeholder="Same as billing if left blank">{{ old('shipping_address') }}</textarea>
                                    @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="checkout-hint">Leave blank to use billing address.</small>
                                </div>
                            </div>
                            <div class="checkout-form-section">
                                <label for="notes" class="checkout-label">Order notes (optional)</label>
                                <textarea class="checkout-input form-control @error('notes') is-invalid @enderror"
                                          id="notes" name="notes" rows="2" placeholder="Delivery instructions, special requests…">{{ old('notes') }}</textarea>
                                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="checkout-form-section checkout-terms">
                                <label class="checkout-checkbox">
                                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                    <span>I agree to the <a href="{{ route('terms') }}" target="_blank">Terms and Conditions</a></span>
                                </label>
                            </div>
                            <button type="submit" class="checkout-submit-btn">
                                <i class="fas fa-paper-plane me-2"></i> Place order
                            </button>
                            <p class="checkout-disclaimer"><i class="fas fa-info-circle me-1"></i> We'll contact you to confirm order details before processing.</p>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="checkout-summary-wrap">
                    <div class="checkout-card checkout-summary-card">
                        <div class="checkout-card-header checkout-summary-header">
                            <h2 class="checkout-card-title mb-0">Order summary</h2>
                        </div>
                        <div class="checkout-card-body">
                            @php
                                $cart = session('cart', []);
                                $subtotal = 0;
                                $user = Auth::user();
                            @endphp
                            <div class="checkout-summary-items">
                                @foreach($cart as $item)
                                    @php
                                        $product = \App\Models\AgricultureProduct::find($item['product_id']);
                                        $price = $item['price'] ?? $product->getPriceForUser($user);
                                        $itemTotal = round($price * $item['quantity'], 2);
                                        $subtotal += $itemTotal;
                                        $imgUrl = \App\Helpers\ImageHelper::productImageUrl($product);
                                    @endphp
                                    <div class="checkout-summary-item">
                                        <div class="checkout-summary-item-img">
                                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                                            @if($item['quantity'] > 1)
                                                <span class="checkout-summary-qty">{{ $item['quantity'] }}</span>
                                            @endif
                                        </div>
                                        <div class="checkout-summary-item-detail">
                                            <div class="checkout-summary-item-name">{{ Str::limit($product->name, 45) }}</div>
                                            <div class="checkout-summary-item-price">{{ $currencySymbol ?? '₹' }}{{ number_format($itemTotal, 2) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @php
                                $subtotal = round($subtotal, 2);
                                $shippingCost = 25;
                                $totalAmount = round($subtotal + $shippingCost, 2);
                            @endphp
                            <div class="checkout-summary-totals">
                                <div class="checkout-summary-row">
                                    <span>Subtotal</span>
                                    <span>{{ $currencySymbol ?? '₹' }}{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="checkout-summary-row">
                                    <span>Shipping</span>
                                    <span>{{ $currencySymbol ?? '₹' }}{{ number_format($shippingCost, 2) }}</span>
                                </div>
                                <div class="checkout-summary-row checkout-summary-total">
                                    <span>Total</span>
                                    <span>{{ $currencySymbol ?? '₹' }}{{ number_format($totalAmount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-secure">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <strong>Secure checkout</strong>
                            <span>Your information is protected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="checkout-empty">
            <div class="checkout-empty-icon"><i class="fas fa-shopping-cart"></i></div>
            <h2 class="checkout-empty-title">Your cart is empty</h2>
            <p class="checkout-empty-text">Add agriculture equipment to your cart, then return here to checkout.</p>
            <a href="{{ route('agriculture.products.index') }}" class="checkout-empty-btn">
                <i class="fas fa-arrow-left me-2"></i> Continue shopping
            </a>
        </div>
    @endif
    </div>
</div>

@push('styles')
<style>
.checkout-page { background: linear-gradient(180deg, #f0f7ee 0%, #f8faf8 120px); min-height: 80vh; padding: 2rem 0 4rem; }
.checkout-container { max-width: 1100px; }
.checkout-header { margin-bottom: 2rem; padding-top: 0.5rem; }
.checkout-back { display: inline-flex; align-items: center; gap: 0.5rem; color: #5a9a45; font-size: 0.9rem; font-weight: 500; text-decoration: none; margin-bottom: 0.75rem; }
.checkout-back:hover { color: #4a8a3a; }
.checkout-title { font-size: 1.75rem; font-weight: 700; color: #1a2e1a; margin: 0 0 0.25rem 0; }
.checkout-subtitle { font-size: 1rem; color: #64748b; margin: 0; }
.checkout-card { background: #fff; border-radius: 14px; border: 1px solid #e5ebe5; box-shadow: 0 4px 20px rgba(0,0,0,0.06); overflow: hidden; }
.checkout-card-header { padding: 1.25rem 1.5rem; background: #f8faf8; border-bottom: 1px solid #e8efe8; display: flex; align-items: flex-start; gap: 1rem; }
.checkout-card-icon { width: 44px; height: 44px; border-radius: 10px; background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.checkout-card-title { font-size: 1.15rem; font-weight: 700; color: #1a2e1a; margin: 0; }
.checkout-card-desc { font-size: 0.85rem; color: #64748b; margin: 0.35rem 0 0 0; }
.checkout-card-body { padding: 1.5rem; }
.checkout-form-section { margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f0f0f0; }
.checkout-form-section:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.checkout-section-label { display: block; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #6BB252; margin-bottom: 0.75rem; }
.checkout-label { display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 0.4rem; }
.checkout-input { border-radius: 10px; border: 1px solid #e2e8e2; padding: 0.6rem 0.9rem; font-size: 0.95rem; transition: border-color 0.2s, box-shadow 0.2s; }
.checkout-input:focus { border-color: #6BB252; box-shadow: 0 0 0 3px rgba(107, 178, 82, 0.15); outline: none; }
.checkout-input::placeholder { color: #94a3b8; }
.checkout-hint { font-size: 0.8rem; color: #64748b; margin-top: 0.35rem; display: block; }
.checkout-terms { margin-top: 1rem; }
.checkout-checkbox { display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.9rem; color: #475569; cursor: pointer; }
.checkout-checkbox a { color: #6BB252; font-weight: 500; }
.checkout-checkbox a:hover { text-decoration: underline; }
.checkout-submit-btn { width: 100%; margin-top: 1.25rem; padding: 0.9rem 1.5rem; background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%); color: #fff; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s, box-shadow 0.2s; }
.checkout-submit-btn:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(107, 178, 82, 0.35); }
.checkout-disclaimer { text-align: center; font-size: 0.8rem; color: #64748b; margin: 1rem 0 0 0; }
.checkout-summary-wrap { position: sticky; top: 100px; }
.checkout-summary-header { padding: 1rem 1.25rem; }
.checkout-summary-card .checkout-card-body { padding: 1rem 1.25rem; }
.checkout-summary-items { max-height: 280px; overflow-y: auto; margin-bottom: 1rem; }
.checkout-summary-item { display: flex; gap: 0.75rem; padding: 0.6rem 0; border-bottom: 1px solid #f0f0f0; }
.checkout-summary-item:last-child { border-bottom: none; }
.checkout-summary-item-img { position: relative; width: 56px; height: 56px; border-radius: 10px; overflow: hidden; background: #f1f5f1; flex-shrink: 0; }
.checkout-summary-item-img img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }
.checkout-summary-qty { position: absolute; bottom: 2px; right: 2px; background: #1a2e1a; color: #fff; font-size: 0.65rem; font-weight: 700; padding: 1px 5px; border-radius: 4px; }
.checkout-summary-item-detail { min-width: 0; }
.checkout-summary-item-name { font-size: 0.8rem; font-weight: 500; color: #334155; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.checkout-summary-item-price { font-size: 0.9rem; font-weight: 600; color: #1a2e1a; margin-top: 2px; }
.checkout-summary-totals { padding-top: 1rem; border-top: 1px solid #e5ebe5; }
.checkout-summary-row { display: flex; justify-content: space-between; font-size: 0.9rem; color: #64748b; margin-bottom: 0.5rem; }
.checkout-summary-total { margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #e5ebe5; font-size: 1.1rem; font-weight: 700; color: #1a2e1a; }
.checkout-summary-total span:last-child { color: #2d6a2d; }
.checkout-secure { display: flex; align-items: center; gap: 0.75rem; padding: 1rem 1.25rem; background: #f0f7ee; border-radius: 12px; margin-top: 1rem; border: 1px solid #dcebda; }
.checkout-secure i { font-size: 1.5rem; color: #5a9a45; }
.checkout-secure strong { display: block; font-size: 0.9rem; color: #1a2e1a; }
.checkout-secure span { font-size: 0.8rem; color: #64748b; }
.checkout-empty { text-align: center; padding: 4rem 2rem; background: #fff; border-radius: 14px; border: 1px solid #e5ebe5; }
.checkout-empty-icon { width: 80px; height: 80px; margin: 0 auto 1.5rem; border-radius: 50%; background: #f1f5f1; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 2rem; }
.checkout-empty-title { font-size: 1.35rem; font-weight: 700; color: #1a2e1a; margin: 0 0 0.5rem 0; }
.checkout-empty-text { font-size: 0.95rem; color: #64748b; margin: 0 0 1.5rem 0; }
.checkout-empty-btn { display: inline-flex; align-items: center; padding: 0.65rem 1.25rem; background: #6BB252; color: #fff; border-radius: 10px; font-weight: 600; text-decoration: none; transition: background 0.2s; }
.checkout-empty-btn:hover { color: #fff; background: #5a9a45; }
@media (max-width: 991px) { .checkout-summary-wrap { position: static; } }
</style>
@endpush
@endsection
