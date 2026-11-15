</main>

<footer class="footer">
  <div class="footer-glow" aria-hidden="true"></div>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand-col">
        <a href="index.php" class="brand">
          <span class="brand-mark small">
            <svg viewBox="0 0 32 32" width="22" height="22" aria-hidden="true">
              <rect x="2" y="2" width="28" height="28" rx="8" fill="none" stroke="#38bdf8" stroke-width="2.5"/>
              <path d="M10 22V10l12 12V10" fill="none" stroke="#38bdf8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span class="brand-name">Nexus<span>Tech</span></span>
        </a>
        <p class="footer-tagline">Premium electronics and gadgets, curated for people who care about the details.</p>
        <div class="socials">
          <a href="#" aria-label="X"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
          <a href="#" aria-label="Instagram"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 5.838a6 6 0 1 0 0 12 6 6 0 0 0 0-12zm0 9.895a3.895 3.895 0 1 1 0-7.79 3.895 3.895 0 0 1 0 7.79zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg></a>
          <a href="#" aria-label="YouTube"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
          <a href="#" aria-label="LinkedIn"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.125 2.062 2.062 0 0 1 0 4.125zM7.119 20.452H3.554V9h3.565v11.452z"/></svg></a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Shop</h4>
        <ul>
          <li><a href="products.php">All Products</a></li>
          <li><a href="featured.php">Featured</a></li>
          <li><a href="products.php">New Arrivals</a></li>
          <li><a href="featured.php">Best Sellers</a></li>
          <li><a href="products.php">Deals</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Categories</h4>
        <ul>
          <?php foreach (categories_all() as $c): ?>
            <li><a href="products.php?category=<?= (int)$c['id'] ?>"><?= e($c['label']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Support</h4>
        <ul>
          <li><a href="trust.php">Help Center</a></li>
          <li><a href="trust.php">Track Order</a></li>
          <li><a href="trust.php">Shipping Info</a></li>
          <li><a href="trust.php">Returns</a></li>
          <li><a href="trust.php">Warranty</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>About</h4>
        <ul>
          <li><a href="trust.php">Our Story</a></li>
          <li><a href="trust.php">Careers</a></li>
          <li><a href="trust.php">Press</a></li>
          <li><a href="trust.php">Sustainability</a></li>
          <li><a href="trust.php">Affiliates</a></li>
        </ul>
      </div>

      <div class="footer-col footer-news">
        <h4>Stay in the loop</h4>
        <p>Early drops, exclusive deals. No spam, ever.</p>
        <form class="newsletter" id="newsletter-form">
          <input type="email" placeholder="you@email.com" aria-label="Email address" required>
          <button class="btn btn-primary" type="submit">Join</button>
        </form>
        <div class="payments" aria-label="Accepted payment methods">
          <span>Visa</span><span>Mastercard</span><span>Amex</span><span>PayPal</span><span>Apple Pay</span><span>G Pay</span>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© <?= date('Y') ?> NexusTech. All rights reserved.</span>
      <div class="footer-legal">
        <a href="trust.php">Privacy</a>
        <a href="trust.php">Terms</a>
        <a href="trust.php">Cookies</a>
        <a href="admin/login.php">Admin</a>
      </div>
    </div>
  </div>
</footer>

<div class="cart-overlay" id="cart-overlay" hidden></div>
<aside class="mini-cart" id="mini-cart" role="dialog" aria-label="Shopping cart" hidden>
  <div class="mini-cart-head">
    <h3>Your Cart <span class="cart-count-pill" id="cart-pill">0</span></h3>
    <button class="icon-button" id="cart-close" aria-label="Close cart">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <div class="mini-cart-body" id="cart-body"></div>
  <div class="mini-cart-foot" id="cart-foot" hidden>
    <div class="cart-total-row">
      <span>Subtotal</span>
      <span id="cart-total">$0</span>
    </div>
    <p class="cart-note">Free express shipping on orders over $50.</p>
    <a href="checkout.php" class="btn btn-primary btn-block">Checkout securely</a>
  </div>
</aside>

<script src="assets/js/main.js"></script>
</body>
</html>
