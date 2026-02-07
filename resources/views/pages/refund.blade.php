@extends('layouts.app')

@section('title', 'Refund & Cancellation Policy - Greenleaf')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="h2 fw-bold text-dark mb-3">Refund & Cancellation Policy</h1>
                <p class="text-muted mb-4">Last updated: {{ date('F j, Y') }}</p>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h5 fw-bold text-dark mb-3">Cancellation by Customer</h2>
                        <p class="text-muted mb-4">
                            You may cancel your order before it has been shipped. To cancel, please contact us as soon as possible via the Contact page or email with your order number. Once the order has been dispatched, we cannot guarantee cancellation; in such cases our Returns policy will apply.
                        </p>

                        <h2 class="h5 fw-bold text-dark mb-3">Cancellation by Greenleaf</h2>
                        <p class="text-muted mb-4">
                            We reserve the right to cancel any order due to unavailability of stock, pricing errors, or for any other reason. If we cancel your order, we will notify you and any payment already made will be refunded in full within 7–10 business days to the original payment method.
                        </p>

                        <h2 class="h5 fw-bold text-dark mb-3">Refund Policy</h2>
                        <p class="text-muted mb-4">
                            Refunds are processed in the following cases:
                        </p>
                        <ul class="text-muted mb-4">
                            <li><strong>Order cancelled by you</strong> (before dispatch): Full refund to the original payment method.</li>
                            <li><strong>Order cancelled by us</strong>: Full refund to the original payment method.</li>
                            <li><strong>Return of defective or damaged goods</strong>: After we receive and verify the product, a full refund or replacement will be issued as per your choice.</li>
                            <li><strong>Wrong item shipped</strong>: We will arrange pickup of the wrong item and send the correct product, or process a full refund if you prefer.</li>
                        </ul>
                        <p class="text-muted mb-4">
                            Refunds are processed within 7–10 business days after we approve the refund. The amount will be credited to the same payment method used at the time of purchase (e.g. card, UPI, net banking via Razorpay). The exact time to reflect in your account may vary as per your bank or payment provider.
                        </p>

                        <h2 class="h5 fw-bold text-dark mb-3">Returns</h2>
                        <p class="text-muted mb-4">
                            If you wish to return a product (subject to our return eligibility criteria), please contact us within the return window mentioned on the product or as per our general policy. Returns must be in original condition and packaging where applicable. We will provide return instructions and, once the item is received and verified, the refund will be processed as per this policy.
                        </p>

                        <h2 class="h5 fw-bold text-dark mb-3">Payment Gateway</h2>
                        <p class="text-muted mb-4">
                            Payments on this website are processed securely through Razorpay. All refunds are initiated through the same channel and will be subject to Razorpay’s and your bank’s processing times. We do not store your card or full payment details on our servers.
                        </p>

                        <h2 class="h5 fw-bold text-dark mb-3">Contact for Refunds & Cancellations</h2>
                        <p class="text-muted mb-0">
                            For any questions regarding cancellations or refunds, please contact us via the <a href="{{ route('contact') }}">Contact</a> page or email. Please quote your order number for faster resolution.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
