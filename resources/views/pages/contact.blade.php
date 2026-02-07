@extends('layouts.app')

@section('title', 'Contact Us - Greenleaf')

@section('content')
<div class="contact-page">
    <div class="container-fluid px-lg-4">
        <!-- Page title -->
        <div class="contact-header mb-4">
            <h1 class="contact-title">Contact Us</h1>
            <p class="contact-subtitle">Have questions? We're here to help. Reach out and we'll respond within 24 hours.</p>
        </div>

        <!-- Main content: Form + Info side by side -->
        <div class="contact-main">
            <div class="contact-grid">
                <!-- Left: Contact info & hours -->
                <div class="contact-info-col">
                    <div class="contact-card">
                        <div class="contact-item">
                            <div class="contact-icon-wrap bg-location">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/></svg>
                            </div>
                            <div>
                                <h4>Visit Our Store</h4>
                                <p>123 Agriculture Street<br>Farm City, FC 12345</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon-wrap bg-phone">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122L9.65 10.5a.678.678 0 0 0-.65-.5H7.5a.5.5 0 0 1-.5-.5V8.15a.678.678 0 0 0-.122-.58L5.594 5.27a.678.678 0 0 0-.122-.58z"/></svg>
                            </div>
                            <div>
                                <h4>Call Us</h4>
                                <p><a href="tel:+15551234567">+1 (555) 123-4567</a></p>
                                <p class="small text-muted">Toll Free: 1-800-AGRICULTURE</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon-wrap bg-email">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825a.5.5 0 0 1-.584 0L5 5.383V13a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V5.383z"/></svg>
                            </div>
                            <div>
                                <h4>Email Us</h4>
                                <p><a href="mailto:info@nexusagriculture.com">info@nexusagriculture.com</a></p>
                                <p class="small text-muted">Support & Sales available</p>
                            </div>
                        </div>
                    </div>
                    <div class="contact-card hours-card">
                        <h4>Business Hours</h4>
                        <div class="hours-grid">
                            <div>
                                <strong>Store</strong>
                                <p>Mon–Fri: 8AM–8PM<br>Sat: 9AM–6PM · Sun: 10AM–5PM</p>
                            </div>
                            <div>
                                <strong>Support</strong>
                                <p>Mon–Fri: 7AM–9PM<br>Sat–Sun: 8AM–7PM</p>
                            </div>
                        </div>
                    </div>
                    <div class="quick-links">
                        <a href="tel:+15551234567" class="quick-link"><i class="fas fa-phone-alt"></i> Call Now</a>
                        <a href="mailto:info@nexusagriculture.com" class="quick-link"><i class="fas fa-envelope"></i> Email Us</a>
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="contact-form-col">
                    <div class="contact-form-card">
                        <h3>Send a Message</h3>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group half">
                                    <label for="name">Full Name *</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Your name">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group half">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="your@email.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject *</label>
                                <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required placeholder="How can we help?">
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="4" required placeholder="Your message...">{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                            <p class="form-note">We respond within 24 hours</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ - compact accordion -->
        <div class="contact-faq-section">
            <h3>Frequently Asked Questions</h3>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h4 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">How do I place an order?</button>
                    </h4>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Browse products, add to cart, and checkout. Or call us to place an order over the phone.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h4 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">What are your delivery options?</button>
                    </h4>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Same-day delivery for local orders, standard shipping elsewhere. Fees vary by location.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h4 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">Do you offer organic products?</button>
                    </h4>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">Yes! Look for the organic label on our product pages.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h4 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">What is your return policy?</button>
                    </h4>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">30-day returns on most products. Fresh produce within 48 hours for quality issues.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.contact-page {
    background: #f8faf8;
    padding: 24px 0 48px;
    min-height: 60vh;
}
.contact-header {
    padding: 0 0 20px;
}
.contact-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0 0 8px 0;
}
.contact-subtitle {
    font-size: 1rem;
    color: #666;
    margin: 0;
}
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 24px;
    align-items: start;
}
@media (max-width: 991px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
}
.contact-info-col {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.contact-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #e8efe8;
}
.contact-item {
    display: flex;
    gap: 14px;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}
.contact-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.contact-item:first-child {
    padding-top: 0;
}
.contact-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #fff;
}
.bg-location { background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%); }
.bg-phone { background: linear-gradient(135deg, #4a8a3a 0%, #3d7632 100%); }
.bg-email { background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); }
.contact-item h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a2e1a;
    margin: 0 0 4px 0;
}
.contact-item p {
    font-size: 0.875rem;
    color: #666;
    margin: 0;
    line-height: 1.5;
}
.contact-item a {
    color: #6BB252;
    text-decoration: none;
    font-weight: 500;
}
.contact-item a:hover { color: #4a8a3a; }
.hours-card h4 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 12px 0;
}
.hours-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.hours-grid strong {
    display: block;
    font-size: 0.8rem;
    color: #6BB252;
    margin-bottom: 4px;
}
.hours-grid p {
    font-size: 0.85rem;
    color: #666;
    margin: 0;
    line-height: 1.5;
}
.quick-links {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.quick-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: #6BB252;
    color: #fff !important;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}
.quick-link:hover {
    background: #5a9a45;
    color: #fff !important;
    transform: translateY(-1px);
}
.contact-form-col {
    position: sticky;
    top: 100px;
}
@media (max-width: 991px) {
    .contact-form-col { position: static; }
}
.contact-form-card {
    background: #fff;
    border-radius: 12px;
    padding: 28px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #e8efe8;
}
.contact-form-card h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0 0 20px 0;
}
.contact-form-card .alert { margin-bottom: 20px; }
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 576px) {
    .form-row { grid-template-columns: 1fr; }
}
.form-group {
    margin-bottom: 16px;
}
.form-group.half { margin-bottom: 16px; }
.form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 6px;
}
.form-group .form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #e0e8e0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.2s;
}
.form-group .form-control:focus {
    outline: none;
    border-color: #6BB252;
    box-shadow: 0 0 0 3px rgba(107,178,82,0.15);
}
.form-group textarea.form-control {
    resize: vertical;
    min-height: 100px;
}
.btn-submit {
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #6BB252 0%, #5a9a45 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.2s;
    margin-top: 8px;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #5a9a45 0%, #4a8a3a 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(107,178,82,0.35);
}
.form-note {
    text-align: center;
    font-size: 0.8rem;
    color: #999;
    margin: 12px 0 0 0;
}
.contact-faq-section {
    margin-top: 40px;
    padding-top: 32px;
    border-top: 1px solid #e8efe8;
}
.contact-faq-section h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a2e1a;
    margin: 0 0 20px 0;
}
.contact-faq-section .accordion-item {
    border: 1px solid #e8efe8;
    border-radius: 8px;
    margin-bottom: 8px;
    overflow: hidden;
}
.contact-faq-section .accordion-button {
    font-size: 0.95rem;
    font-weight: 500;
    padding: 14px 16px;
    background: #f8faf8;
    border: none;
}
.contact-faq-section .accordion-button:not(.collapsed) {
    background: #e8f5e3;
    color: #2d5a27;
}
.contact-faq-section .accordion-body {
    font-size: 0.9rem;
    color: #666;
    padding: 14px 16px;
}
</style>
@endpush
@endsection
