    <footer class="site-footer">
      <div class="container-lg">
        <div class="footer-grid">

          <div class="footer-brand">
            <a href="{{ route('agriculture.home') }}" class="footer-logo">
              <img src="{{ asset('assets/logo/logo.png') }}" alt="Greenleaf">
            </a>
            <p class="footer-tagline">
              Your trusted partner for premium farm & garden tools and equipment in India.
            </p>
            <div class="footer-social">
              <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
              <a href="#" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
              <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
              <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
              <a href="#" aria-label="Amazon"><i class="fab fa-amazon"></i></a>
            </div>
          </div>

          <div class="footer-col">
            <h6 class="footer-heading">Company</h6>
            <ul class="footer-links">
              <li><a href="{{ route('about') }}">About Us</a></li>
              <li><a href="{{ route('contact') }}">Contact</a></li>
              <li><a href="{{ route('terms') }}">Terms of Service</a></li>
              <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
              <li><a href="{{ route('refund') }}">Refund & Cancellation</a></li>
            </ul>
          </div>

          <div class="footer-col">
            <h6 class="footer-heading">Shop</h6>
            <ul class="footer-links">
              <li><a href="{{ route('agriculture.products.index') }}">All Products</a></li>
              <li><a href="{{ route('agriculture.categories.index') }}">Categories</a></li>
              <li><a href="{{ route('agriculture.products.index', ['filter' => 'featured']) }}">Featured</a></li>
              <li><a href="{{ route('agriculture.products.index', ['sort' => 'new_arrivals']) }}">New Arrivals</a></li>
              <li><a href="{{ route('agriculture.products.index', ['sort' => 'best_selling']) }}">Best Sellers</a></li>
            </ul>
          </div>

          <div class="footer-col">
            <h6 class="footer-heading">Account</h6>
            <ul class="footer-links">
              @auth
              @if(auth()->user()->role === 'admin')
              <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
              @elseif(auth()->user()->role === 'dealer')
              <li><a href="{{ route('dealer.dashboard') }}">Dealer Dashboard</a></li>
              @else
              <li><a href="{{ route('customer.dashboard') }}">My Dashboard</a></li>
              @endif
              <li><a href="{{ route('agriculture.wishlist.index') }}">Wishlist</a></li>
              <li><a href="{{ route('agriculture.cart.index') }}">Cart</a></li>
              <li>
                <form action="{{ route('auth.logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="footer-link-btn">Logout</button>
                </form>
              </li>
              @else
              <li><a href="{{ route('auth.login') }}">Login</a></li>
              <li><a href="{{ route('auth.register') }}">Register</a></li>
              <li><a href="{{ route('dealer.register') }}">Become a Dealer</a></li>
              @endauth
            </ul>
          </div>

          <div class="footer-col footer-cta">
            <h6 class="footer-heading">Get In Touch</h6>
            <p class="footer-desc">Questions? We’re here to help with orders and products.</p>
            <a href="{{ route('contact') }}" class="footer-btn">Contact Support</a>
            <p class="footer-admin">
              <a href="{{ route('admin.login') }}">Admin Panel →</a>
            </p>
          </div>

        </div>

        <div class="footer-bar">
          <p>© {{ date('Y') }} <a href="{{ route('agriculture.home') }}">Greenleaf</a> · Developed by <a href="https://nexusdigisolutions.in/" target="_blank" rel="noopener noreferrer">Nexus Digi Solutions</a></p>
        </div>
      </div>
    </footer>
    <style>
    .site-footer {
      background: linear-gradient(180deg, #0f3328 0%, #0a241c 100%);
      color: rgba(255,255,255,0.85);
      padding: 28px 0 0;
      border-top: 1px solid rgba(107, 178, 82, 0.15);
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 1.4fr 1fr 1fr 1fr 1.2fr;
      gap: 28px 24px;
      padding-bottom: 20px;
    }
    @media (max-width: 992px) {
      .footer-grid { grid-template-columns: 1fr 1fr 1fr; }
    }
    @media (max-width: 576px) {
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 20px 16px; }
    }
    .footer-brand .footer-logo {
      display: inline-block;
      margin-bottom: 8px;
    }
    .footer-brand .footer-logo img {
      max-height: 38px;
      width: auto;
      opacity: 0.95;
    }
    .footer-tagline {
      font-size: 0.8rem;
      line-height: 1.45;
      color: rgba(255,255,255,0.65);
      margin: 0 0 14px 0;
      max-width: 240px;
    }
    .footer-social {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .footer-social a {
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(107, 178, 82, 0.9);
      font-size: 0.9rem;
      border-radius: 6px;
      background: rgba(255,255,255,0.06);
      transition: background 0.2s, color 0.2s;
    }
    .footer-social a:hover {
      background: rgba(107, 178, 82, 0.2);
      color: #8bc34a;
    }
    .footer-heading {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: rgba(107, 178, 82, 0.95);
      margin: 0 0 10px 0;
    }
    .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .footer-links li { margin-bottom: 6px; }
    .footer-links a,
    .footer-link-btn {
      font-size: 0.825rem;
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
      transition: color 0.2s, padding-left 0.2s;
    }
    .footer-links a:hover,
    .footer-link-btn:hover {
      color: #8bc34a;
    }
    .footer-links a:hover { padding-left: 4px; }
    .footer-cta .footer-desc {
      font-size: 0.8rem;
      color: rgba(255,255,255,0.65);
      margin: 0 0 12px 0;
      line-height: 1.4;
    }
    .footer-btn {
      display: inline-block;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 6px 14px;
      border: 1px solid rgba(107, 178, 82, 0.6);
      color: #8bc34a;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.2s, color 0.2s, border-color 0.2s;
    }
    .footer-btn:hover {
      background: rgba(107, 178, 82, 0.15);
      color: #9ccc65;
      border-color: #8bc34a;
    }
    .footer-admin { margin: 12px 0 0; font-size: 0.8rem; }
    .footer-admin a {
      color: rgba(107, 178, 82, 0.9);
      text-decoration: none;
    }
    .footer-admin a:hover { color: #9ccc65; text-decoration: underline; }
    .footer-bar {
      padding: 12px 0;
      border-top: 1px solid rgba(255,255,255,0.08);
      text-align: center;
    }
    .footer-bar p {
      margin: 0;
      font-size: 0.75rem;
      color: rgba(255,255,255,0.5);
    }
    .footer-bar a {
      color: rgba(255,255,255,0.7);
      text-decoration: none;
    }
    .footer-bar a:hover { color: #8bc34a; }
    </style>
    <script src="{{ asset('assets/organic/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/organic/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/organic/js/script.js') }}"></script>
    </body>

    </html>