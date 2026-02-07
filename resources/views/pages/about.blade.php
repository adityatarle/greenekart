@extends('layouts.app')

@section('title', 'About Us - Greenleaf')

@section('content')
<div class="about-page">
    <!-- Hero with icon -->
    <section class="about-hero">
        <div class="container-lg">
            <div class="about-hero-inner">
                <div class="about-hero-icon-wrap">
                    <i class="fas fa-leaf about-hero-icon" aria-hidden="true"></i>
                </div>
                <div class="about-hero-accent" aria-hidden="true"></div>
                <div class="about-hero-content">
                    <h1 class="about-page-title">About Greenleaf</h1>
                    <p class="about-lead">
                        Empowering farmers with smart, innovative, and affordable agricultural solutions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision card with icon -->
    <section class="about-section about-section--default">
        <div class="container-lg">
            <div class="about-vision-card">
                <div class="about-vision-header">
                    <div class="about-vision-icon-wrap">
                        <i class="fas fa-eye about-vision-icon" aria-hidden="true"></i>
                    </div>
                    <h2 class="about-section-title about-section-title--card">Our Vision</h2>
                </div>
                <div class="about-vision-body">
                    <p class="about-text about-text--lead">
                        To transform the lives of farmers by making agriculture smarter, easier, and more profitable through world-class, innovative, and affordable agricultural products.
                    </p>
                    <p class="about-text about-text--last">
                        We empower farmers with modern solutions that simplify their work, increase productivity, and support sustainable farming practices—leading to long-term growth and self-reliance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission - 4 cards with strong icons -->
    <section class="about-section about-section--alt">
        <div class="container-lg">
            <div class="about-section-head text-center mb-4">
                <div class="about-section-icon-wrap mx-auto mb-3">
                    <i class="fas fa-bullseye" aria-hidden="true"></i>
                </div>
                <h2 class="about-section-title mb-0">Our Mission</h2>
            </div>
            <div class="row g-4 about-mission-row">
                <div class="col-md-6 col-lg-3">
                    <div class="about-mission-card">
                        <div class="about-mission-card-icon about-mission-card-icon--quality">
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <h3 class="about-mission-title">Global Quality</h3>
                        <p class="about-mission-desc">Import high-quality, globally trusted agricultural products and make them accessible to farmers across India.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="about-mission-card">
                        <div class="about-mission-card-icon about-mission-card-icon--network">
                            <i class="fas fa-network-wired" aria-hidden="true"></i>
                        </div>
                        <h3 class="about-mission-title">Reliable Network</h3>
                        <p class="about-mission-desc">Deliver products efficiently through a strong and reliable retailer network.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="about-mission-card">
                        <div class="about-mission-card-icon about-mission-card-icon--solutions">
                            <i class="fas fa-tools" aria-hidden="true"></i>
                        </div>
                        <h3 class="about-mission-title">Farmer Solutions</h3>
                        <p class="about-mission-desc">Help farmers reduce manual effort, lower costs, and improve crop yield and quality.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="about-mission-card">
                        <div class="about-mission-card-icon about-mission-card-icon--sustainable">
                            <i class="fas fa-seedling" aria-hidden="true"></i>
                        </div>
                        <h3 class="about-mission-title">Sustainable Agriculture</h3>
                        <p class="about-mission-desc">Promote simple, smart, and sustainable farming and build long-term, trust-based relationships.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Who We Are - feature list with icons -->
    <section class="about-section about-section--default">
        <div class="container-lg">
            <div class="about-section-head text-center mb-4">
                <div class="about-section-icon-wrap about-section-icon-wrap--dark mx-auto mb-3">
                    <i class="fas fa-building" aria-hidden="true"></i>
                </div>
                <h2 class="about-section-title mb-0">Who We Are</h2>
            </div>
            <div class="about-who-grid row g-4">
                <div class="col-md-4">
                    <div class="about-who-item">
                        <div class="about-who-icon"><i class="fas fa-globe-asia" aria-hidden="true"></i></div>
                        <h4 class="about-who-title">Agriculture-Focused</h4>
                        <p class="about-who-desc">We are dedicated to empowering farmers with smart, innovative, and affordable solutions through globally trusted products.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-who-item">
                        <div class="about-who-icon"><i class="fas fa-truck-fast" aria-hidden="true"></i></div>
                        <h4 class="about-who-title">Strong Delivery</h4>
                        <p class="about-who-desc">We deliver world-class products efficiently through a strong retailer network to reduce effort and improve productivity.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-who-item">
                        <div class="about-who-icon"><i class="fas fa-handshake" aria-hidden="true"></i></div>
                        <h4 class="about-who-title">Trusted Partner</h4>
                        <p class="about-who-desc">We strive to be a dependable growth partner in India's agricultural ecosystem with long-term, sustainable practices.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CEO Message - card with quote icon -->
    <section class="about-section about-section--alt">
        <div class="container-lg">
            <div class="about-ceo-card">
                <div class="about-ceo-header">
                    <div class="about-ceo-icon-wrap">
                        <i class="fas fa-quote-left" aria-hidden="true"></i>
                    </div>
                    <h2 class="about-section-title about-section-title--card mb-0">Message from the CEO</h2>
                </div>
                <blockquote class="about-quote">
                    <p class="about-quote-text">"At the heart of our company lies a simple belief — when farmers grow, the nation grows."</p>
                    <footer class="about-quote-footer"><i class="fas fa-user-tie me-2" aria-hidden="true"></i>CEO, Greenleaf</footer>
                </blockquote>
                <div class="about-text-block">
                    <p class="about-text">Agriculture is not just a profession; it is a way of life for millions across India. Our vision is to make farming smarter, easier, and more profitable by providing world-class, innovative, and affordable agricultural solutions.</p>
                    <p class="about-text">We carefully select globally trusted products that meet international quality standards and adapt them to the real needs of Indian farmers. Through a strong retailer network, we ensure these solutions reach farmers efficiently. Trust, transparency, and long-term relationships guide everything we do.</p>
                    <p class="about-text about-text--last">Together, we aim to empower farmers, strengthen rural communities, and contribute meaningfully to the future of Indian agriculture.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA with icon -->
    <section class="about-cta">
        <div class="container-lg">
            <div class="about-cta-inner">
                <div class="about-cta-icon-wrap">
                    <i class="fas fa-shopping-basket" aria-hidden="true"></i>
                </div>
                <div class="about-cta-text">
                    <h2 class="about-cta-title">Ready to Transform Your Farming Experience?</h2>
                    <p class="about-cta-desc">Explore our range of agricultural products and solutions designed to make farming smarter and more profitable.</p>
                </div>
                <div class="about-cta-action">
                    <a href="{{ route('agriculture.products.index') }}" class="about-cta-btn">
                        <i class="fas fa-arrow-right me-2" aria-hidden="true"></i>Browse Products
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
.about-page {
    font-family: inherit;
    color: var(--text-dark, #1a1a1a);
}

/* Hero */
.about-hero {
    padding: 2.5rem 0 3rem;
    background: linear-gradient(160deg, #e8f5e9 0%, #f1f8f1 40%, #fff 100%);
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(circle, rgba(107,178,82,0.08) 0%, transparent 70%);
    pointer-events: none;
}

.about-hero-inner {
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    max-width: 42rem;
    position: relative;
}

.about-hero-icon-wrap {
    flex-shrink: 0;
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(107, 178, 82, 0.35);
}

.about-hero-icon {
    font-size: 1.75rem;
}

.about-hero-accent {
    flex-shrink: 0;
    width: 5px;
    height: 64px;
    border-radius: 3px;
    background: var(--primary-color, #6BB252);
}

.about-hero-content { flex: 1; }

.about-page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-dark, #1a1a1a);
    margin: 0 0 0.5rem 0;
    line-height: 1.25;
}

.about-lead {
    font-size: 1.0625rem;
    line-height: 1.55;
    color: var(--text-muted, #6c757d);
    margin: 0;
}

/* Sections */
.about-section {
    padding: 3rem 0;
}

.about-section--default { background: #fff; }
.about-section--alt { background: #f8faf8; }

.about-section-head .about-section-title {
    color: var(--text-dark, #1a1a1a);
}

.about-section-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(107,178,82,0.15) 0%, rgba(107,178,82,0.08) 100%);
    color: var(--primary-color, #6BB252);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.about-section-icon-wrap--dark {
    background: linear-gradient(135deg, #1a2e1a 0%, #0d3d2e 100%);
    color: #fff;
}

/* Vision card */
.about-vision-card {
    max-width: 48rem;
    margin: 0 auto;
    background: #fff;
    border-radius: 16px;
    padding: 2rem 2rem 2rem 2rem;
    border: 1px solid #e8efe8;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    align-items: flex-start;
}

.about-vision-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-shrink: 0;
}

.about-vision-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}

.about-vision-body { flex: 1; min-width: 0; }

.about-section-title--card {
    margin: 0;
    color: var(--text-dark, #1a1a1a);
    font-size: 1.25rem;
}

.about-text {
    font-size: 1rem;
    line-height: 1.65;
    color: var(--text-dark, #1a1a1a);
    margin: 0 0 1rem 0;
}

.about-text--lead {
    font-size: 1.0625rem;
    font-weight: 500;
}

.about-text--last { margin-bottom: 0; }

/* Mission cards */
.about-mission-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.75rem;
    height: 100%;
    border: 1px solid #e8efe8;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    text-align: center;
}

.about-mission-card:hover {
    transform: translateY(-4px);
    border-color: rgba(107, 178, 82, 0.4);
    box-shadow: 0 12px 32px rgba(107, 178, 82, 0.15);
}

.about-mission-card-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    margin: 0 auto 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
}

.about-mission-card-icon--quality {
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    box-shadow: 0 6px 20px rgba(107, 178, 82, 0.3);
}

.about-mission-card-icon--network {
    background: linear-gradient(135deg, #0d3d2e 0%, #1a5c45 100%);
    box-shadow: 0 6px 20px rgba(13, 61, 46, 0.3);
}

.about-mission-card-icon--solutions {
    background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
    box-shadow: 0 6px 20px rgba(46, 125, 50, 0.3);
}

.about-mission-card-icon--sustainable {
    background: linear-gradient(135deg, #558b2f 0%, #33691e 100%);
    box-shadow: 0 6px 20px rgba(85, 139, 47, 0.3);
}

.about-mission-title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--text-dark, #1a1a1a);
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.about-mission-desc {
    font-size: 0.9375rem;
    line-height: 1.55;
    color: var(--text-muted, #6c757d);
    margin: 0;
}

/* Who We Are */
.about-who-item {
    background: #fff;
    border-radius: 16px;
    padding: 1.75rem;
    height: 100%;
    border: 1px solid #e8efe8;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    transition: box-shadow 0.25s ease, border-color 0.25s ease;
}

.about-who-item:hover {
    border-color: rgba(107, 178, 82, 0.3);
    box-shadow: 0 8px 24px rgba(107, 178, 82, 0.1);
}

.about-who-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(107,178,82,0.15) 0%, rgba(107,178,82,0.08) 100%);
    color: var(--primary-color, #6BB252);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

.about-who-title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--text-dark, #1a1a1a);
    margin: 0 0 0.5rem 0;
}

.about-who-desc {
    font-size: 0.9375rem;
    line-height: 1.55;
    color: var(--text-muted, #6c757d);
    margin: 0;
}

/* CEO card */
.about-ceo-card {
    max-width: 48rem;
    margin: 0 auto;
    background: #fff;
    border-radius: 16px;
    padding: 2rem;
    border: 1px solid #e8efe8;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}

.about-ceo-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.about-ceo-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}

.about-quote {
    margin: 0 0 1.5rem 0;
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #f8faf8 0%, #f0f5f0 100%);
    border-left: 4px solid var(--primary-color, #6BB252);
    border-radius: 0 12px 12px 0;
}

.about-quote-text {
    font-size: 1.0625rem;
    font-weight: 600;
    font-style: italic;
    color: var(--text-dark, #1a1a1a);
    margin: 0 0 0.5rem 0;
    line-height: 1.5;
}

.about-quote-footer {
    font-size: 0.875rem;
    color: var(--text-muted, #6c757d);
    font-style: normal;
}

.about-quote-footer i { color: var(--primary-color, #6BB252); }

.about-text-block { margin: 0; }

/* CTA */
.about-cta {
    padding: 2.5rem 0;
    background: linear-gradient(135deg, #6BB252 0%, #4a8a3a 100%);
    color: #fff;
    position: relative;
}

.about-cta-inner {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.5rem;
    position: relative;
}

.about-cta-icon-wrap {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.about-cta-text { flex: 1; min-width: 200px; }

.about-cta-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 0.35rem 0;
    line-height: 1.3;
}

.about-cta-desc {
    font-size: 0.9375rem;
    line-height: 1.5;
    color: rgba(255,255,255,0.92);
    margin: 0;
}

.about-cta-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: #fff;
    color: var(--primary-color, #6BB252);
    font-weight: 600;
    font-size: 0.9375rem;
    border-radius: 8px;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.about-cta-btn:hover {
    color: #4a8a3a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.about-section-title {
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--primary-color, #6BB252);
    margin: 0 0 1.25rem 0;
    line-height: 1.3;
}

@media (max-width: 768px) {
    .about-hero { padding: 1.75rem 0 2rem; }
    .about-hero-icon-wrap { width: 52px; height: 52px; font-size: 1.35rem; }
    .about-hero-accent { height: 52px; }
    .about-page-title { font-size: 1.5rem; }
    .about-section { padding: 2rem 0; }
    .about-vision-card,
    .about-ceo-card { padding: 1.5rem; }
    .about-cta-inner { flex-direction: column; text-align: center; }
    .about-cta-icon-wrap { margin: 0 auto; }
    .about-cta-btn { width: 100%; justify-content: center; }
}
</style>
@endpush
@endsection
