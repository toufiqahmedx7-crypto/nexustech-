<?php
require_once __DIR__ . '/config.php';

$PAGE_TITLE = 'Why NexusTech — Trust & Service Promises';
require __DIR__ . '/includes/header.php';

$slogans = ['Tech you can trust.', 'Premium gear. Zero compromise.', 'Built for people who notice the details.'];
$tags    = ['#NexusTech', '#PremiumGear', '#FreeReturns', '#2YearWarranty', '#FastShipping'];
$items   = [
    ['🛡️', '2-Year Warranty',      'Every device covered, parts and labor, no fine print.'],
    ['🚀', 'Free Fast Delivery',   'Free express shipping on all orders over $50.'],
    ['↩️', '30-Day Easy Returns',  'Changed your mind? Send it back, no questions asked.'],
    ['💬', '24/7 Support',         'Real humans, any hour, on chat email or phone.'],
    ['🔒', '100% Secure Payments', '256-bit encryption and PCI-DSS certified checkout.'],
    ['✅', 'Genuine Products',     'Authorized retailer for every brand we carry.'],
];
?>

<section class="section page-head">
  <div class="container">
    <div class="reveal">
      <span class="section-eyebrow">Page 05 — Why NexusTech</span>
      <h1>Shop with total confidence</h1>
      <p>A great product is only half the story. Here is everything we promise before, during and after every single order.</p>
    </div>
  </div>
</section>

<section class="section tight">
  <div class="container">
    <div class="slogan-band glass reveal">
      <?php foreach ($slogans as $s): ?><span><?= e($s) ?></span><?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section tight">
  <div class="container">
    <div class="trust-box glass">
      <div class="trust-box-head reveal">
        <h2>Our service promises</h2>
        <p>Standard on every order — not an upgrade, not an extra fee.</p>
      </div>
      <div class="trust-cards">
        <?php foreach ($items as $i => $t): ?>
          <div class="trust-card reveal" style="--d: <?= ($i % 3) * 80 ?>ms">
            <span class="trust-icon" aria-hidden="true"><?= $t[0] ?></span>
            <h3><?= e($t[1]) ?></h3>
            <p><?= e($t[2]) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="trust-tags">
        <?php foreach ($tags as $t): ?><span class="chip static"><?= e($t) ?></span><?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container center-cta reveal">
    <h2 class="cta-title">Ready when you are.</h2>
    <a href="products.php" class="btn btn-primary btn-lg">Start shopping</a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
