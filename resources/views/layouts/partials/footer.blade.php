    <footer class="bg-dark footer-compact" style="background-color: #0d3d2e !important;">
      <div class="container-lg">
        <div class="row">

          <!-- First column - Greenleaf logo + description + social icons -->
          <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">
            <div class="footer-menu">
              <a href="{{ route('agriculture.home') }}" class="d-inline-flex align-items-center mb-3">
                <img src="{{ asset('assets/logo/logo.png') }}" alt="Greenleaf" style="max-height: 72px; width: auto;">
              </a>

              <!-- Short company description -->
              <p class="text-white-75 small mt-2 mb-4" style="line-height: 1.5;">
                Your trusted partner for premium farm & garden tools and equipment in India.
              </p>

              <!-- Social icons using Font Awesome Brands -->
                    <div class="social-links d-flex gap-4">
                        <a href="#" class="text-success fs-4 hover-opacity" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-success fs-4 hover-opacity" aria-label="X (Twitter)">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" class="text-success fs-4 hover-opacity" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-success fs-4 hover-opacity" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-success fs-4 hover-opacity" aria-label="Amazon">
                            <i class="fab fa-amazon"></i>
                        </a>
                    </div>
            </div>
          </div>

          <!-- Company -->
          <div class="col-md-2 col-sm-6 mb-4 mb-md-0">
            <div class="footer-menu">
              <h5 class="widget-title text-success mb-4">Company</h5>
              <ul class="menu-list list-unstyled small text-white-75">
                <li class="menu-item mb-2">
                  <a href="{{ route('about') }}" class="nav-link text-reset text-decoration-none">About Us</a>
                </li>
                <li class="menu-item mb-2">
                  <a href="{{ route('contact') }}" class="nav-link text-reset text-decoration-none">Contact</a>
                </li>
                <li class="menu-item mb-2">
                  <a href="{{ route('terms') }}" class="nav-link text-reset text-decoration-none">Terms of Service</a>
                </li>
                <li class="menu-item mb-2">
                  <a href="{{ route('privacy') }}" class="nav-link text-reset text-decoration-none">Privacy Policy</a>
                </li>
                <li class="menu-item mb-2">
                  <a href="{{ route('refund') }}" class="nav-link text-reset text-decoration-none">Refund & Cancellation</a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Shop -->
          <div class="col-md-2 col-sm-6 mb-4 mb-md-0">
            <div class="footer-menu">
              <h5 class="widget-title text-success mb-4">Shop</h5>
              <ul class="menu-list list-unstyled small text-white-75">
                <li class="menu-item mb-2"><a href="{{ route('agriculture.products.index') }}" class="nav-link text-reset text-decoration-none">All Products</a></li>
                <li class="menu-item mb-2"><a href="{{ route('agriculture.categories.index') }}" class="nav-link text-reset text-decoration-none">Categories</a></li>
                <li class="menu-item mb-2"><a href="{{ route('agriculture.products.index', ['filter' => 'featured']) }}" class="nav-link text-reset text-decoration-none">Featured Products</a></li>
                <li class="menu-item mb-2"><a href="{{ route('agriculture.products.index', ['sort' => 'new_arrivals']) }}" class="nav-link text-reset text-decoration-none">New Arrivals</a></li>
                <li class="menu-item mb-2"><a href="{{ route('agriculture.products.index', ['sort' => 'best_selling']) }}" class="nav-link text-reset text-decoration-none">Best Sellers</a></li>
              </ul>
            </div>
          </div>

          <!-- Account -->
          <div class="col-md-2 col-sm-6 mb-4 mb-md-0">
            <div class="footer-menu">
              <h5 class="widget-title text-success mb-4">Account</h5>
              <ul class="menu-list list-unstyled small text-white-75">
                @auth
                @if(auth()->user()->role === 'admin')
                <li class="menu-item mb-2"><a href="{{ route('admin.dashboard') }}" class="nav-link text-reset text-decoration-none">Admin Dashboard</a></li>
                @elseif(auth()->user()->role === 'dealer')
                <li class="menu-item mb-2"><a href="{{ route('dealer.dashboard') }}" class="nav-link text-reset text-decoration-none">Dealer Dashboard</a></li>
                @else
                <li class="menu-item mb-2"><a href="{{ route('customer.dashboard') }}" class="nav-link text-reset text-decoration-none">My Dashboard</a></li>
                @endif
                <li class="menu-item mb-2"><a href="{{ route('agriculture.wishlist.index') }}" class="nav-link text-reset text-decoration-none">My Wishlist</a></li>
                <li class="menu-item mb-2"><a href="{{ route('agriculture.cart.index') }}" class="nav-link text-reset text-decoration-none">Shopping Cart</a></li>
                <li class="menu-item mb-2">
                  <form action="{{ route('auth.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link p-0 text-start text-reset text-decoration-none">Logout</button>
                  </form>
                </li>
                @else
                <li class="menu-item mb-2"><a href="{{ route('auth.login') }}" class="nav-link text-reset text-decoration-none">Login</a></li>
                <li class="menu-item mb-2"><a href="{{ route('auth.register') }}" class="nav-link text-reset text-decoration-none">Register</a></li>
                <li class="menu-item mb-2"><a href="{{ route('dealer.register') }}" class="nav-link text-reset text-decoration-none">Become a Dealer</a></li>
                @endauth
              </ul>
            </div>
          </div>

          <!-- Get In Touch -->
          <div class="col-lg-3 col-md-6 col-sm-6 mb-4 mb-lg-0">
            <div class="footer-menu">
              <h5 class="widget-title text-primary mb-4">Get In Touch</h5>
              <p class="small text-white-75">Have questions? Contact our support team for assistance with your orders and products.</p>
              <div class="mt-3">
                <a href="{{ route('contact') }}" class="btn btn-outline-success w-100">Contact Support</a>
              </div>
              <div class="mt-4 small text-white-75">
                <p class="mb-1 fw-bold">Admin Login</p>
                <a href="{{ route('admin.login') }}" class="text-success text-decoration-none">Access Admin Panel →</a>
              </div>
            </div>
          </div>

        </div>

        <!-- Copyright -->
        <div class="footer-bottom text-center text-white-50 border-top border-secondary small">
          <div class="row">
            <div class="col-md-12 copyright text-center">
              <p class="mb-0">© {{ date('Y') }} <a href="#" class="text-white">Greenleaf</a> All rights reserved. | Developed by <a href="https://nexusdigisolutions.in/" target="_blank" rel="noopener noreferrer" class="text-white">Nexus Digi Solutions</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <style>
    .footer-compact { padding: 32px 0 0 0 !important; }
    .footer-bottom { margin-top: 24px; padding: 16px 0 !important; }
    </style>
    <script src="{{ asset('assets/organic/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/organic/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/organic/js/script.js') }}"></script>
    </body>

    </html>