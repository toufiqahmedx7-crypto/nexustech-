<?php
require_once __DIR__ . '/config.php';

$slides = [
    ['eyebrow' => 'New flagship',      'title' => 'Nova X9 Pro',         'subtitle' => 'Titanium. 200MP AI camera. The brightest display we have ever made.', 'slug' => 'nova-x9-pro',        'image' => seed_img('photo-1592750475338-74b7b21085ab', 1400), 'price' => 'From $1,099'],
    ['eyebrow' => 'Workstation class', 'title' => 'AeroBook Pro 16',     'subtitle' => 'Mini-LED brilliance and 22 hours of battery in 2.1 kg.',              'slug' => 'aerobook-pro-16',    'image' => seed_img('photo-1517336714731-489689fd1ca8', 1400), 'price' => 'From $2,399'],
    ['eyebrow' => 'Silence the noise', 'title' => 'Sonic Max ANC',       'subtitle' => 'Reference-grade sound. Adaptive noise cancellation. 40h battery.',    'slug' => 'sonic-max-anc',      'image' => seed_img('photo-1505740420928-5e560c06d30e', 1400), 'price' => 'From $399'],
    ['eyebrow' => 'Built for extremes','title' => 'Chrono Watch Ultra',  'subtitle' => 'Titanium adventure watch with dual-band GPS and 3000-nit display.',   'slug' => 'chrono-watch-ultra', 'image' => seed_img('photo-1523275335684-37898b6baf30', 1400), 'price' => 'From $799'],
];

$categories = categories_all();
$trending   = array_slice(products_featured(8), 0, 4);

$trustStrip = [
    ['🛡️', '2-Year Warranty'], ['🚀', 'Free Fast Delivery'], ['↩️', '30-Day Easy Returns'],
    ['💬', '24/7 Support'], ['🔒', '100% Secure Payments'],
];

$PAGE_TITLE = 'NexusTech — Premium Electronics & Gadgets';
require __DIR__ . '/includes/header.php';
?>

<section class="hero" aria-label="Featured promotions">
  <div class="hero-viewport" id="hero">
    <?php foreach ($slides as $i => $s): ?>
    <div class="hero-slide<?= $i === 0 ? ' active' : '' ?>" data-slide="<?= $i ?>">
      <div class="hero-media"><img src="<?= e($s['image']) ?>" alt="<?= e($s['title']) ?>"></div>
      <div class="container hero-content">
        <span class="hero-eyebrow"><?= e($s['eyebrow']) ?></span>
        <h1><?= e($s['title']) ?></h1>
        <p><?= e($s['subtitle']) ?></p>
        <div class="hero-cta">
          <a href="product.php?slug=<?= e($s['slug']) ?>" class="btn btn-primary btn-lg">Shop Now</a>
          <a href="products.php" class="btn btn-ghost btn-lg">Explore catalog</a>
          <span class="hero-price"><?= e($s['price']) ?></span>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <button class="hero-arrow prev" id="hero-prev" aria-label="Previous slide">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
    <button class="hero-arrow next" id="hero-next" aria-label="Next slide">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
    </button>

    <div class="hero-dots" id="hero-dots" role="tablist" aria-label="Slides">
      <?php foreach ($slides as $i => $s): ?>
        <button class="hero-dot<?= $i === 0 ? ' active' : '' ?>" data-goto="<?= $i ?>" role="tab" aria-label="Go to slide <?= $i + 1 ?>"></button>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section trust-strip">
  <div class="container trust-grid">
    <?php foreach ($trustStrip as $i => $t): ?>
      <div class="trust-chip glass reveal" style="--d: <?= $i * 60 ?>ms">
        <span class="trust-chip-icon" aria-hidden="true"><?= $t[0] ?></span>
        <strong><?= e($t[1]) ?></strong>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="section-eyebrow">Shop by category</span>
      <h2>Find your next device</h2>
      <p>Six curated categories, one obsessive standard of quality.</p>
    </div>
    <div class="category-grid">
      <?php foreach ($categories as $i => $c): ?>
        <div class="reveal" style="--d: <?= $i * 50 ?>ms">
          <a href="products.php?category=<?= (int)$c['id'] ?>" class="category-card glass">
            <span class="category-icon" aria-hidden="true"><?= e($c['icon']) ?></span>
            <h3><?= e($c['label']) ?></h3>
            <p><?= e($c['tagline']) ?></p>
            <span class="category-arrow" aria-hidden="true">→</span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="section-eyebrow">Trending now</span>
      <h2>This week's hottest gear</h2>
      <p>Hand-picked by our team, loved by thousands of customers.</p>
    </div>
    <div class="product-grid">
      <?php foreach ($trending as $i => $p) echo product_card_html($p, $i); ?>
    </div>
    <div class="center-cta reveal">
      <a href="featured.php" class="btn btn-ghost btn-lg">View all featured</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="promo-banner glass reveal">
      <div>
        <span class="section-eyebrow">Limited time</span>
        <h2>Up to 25% off audio &amp; wearables</h2>
        <p>Deals refresh every Monday. Members get first access.</p>
      </div>
      <a href="products.php" class="btn btn-primary btn-lg">Grab the deals</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
