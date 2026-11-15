<?php
require_once __DIR__ . '/config.php';

$active   = isset($_GET['category']) ? max(0, (int)$_GET['category']) : 0;
$featured = $active > 0 ? array_slice(products_by_category($active), 0, 4) : products_featured(8);
$spotlight = $active > 0 ? (products_by_category($active)[0] ?? null) : product_by_slug('nova-x9-pro');
if (!$spotlight) $spotlight = products_featured(1)[0] ?? null;

$PAGE_TITLE = 'Featured — NexusTech';
require __DIR__ . '/includes/header.php';
?>

<section class="section page-head">
  <div class="container">
    <div class="reveal">
      <span class="section-eyebrow">Page 02 — Featured</span>
      <h1>Featured products</h1>
      <p>The best of the best — flagship devices our team actually uses every day.</p>
    </div>
  </div>
</section>

<section class="section tight">
  <div class="container">
    <div class="chip-row reveal" role="tablist" aria-label="Filter featured by category">
      <a href="featured.php" class="chip<?= $active === 0 ? ' active' : '' ?>" role="tab" aria-selected="<?= $active === 0 ? 'true' : 'false' ?>">All</a>
      <?php foreach (categories_all() as $c): ?>
        <a href="featured.php?category=<?= (int)$c['id'] ?>" class="chip<?= $active === (int)$c['id'] ? ' active' : '' ?>" role="tab" aria-selected="<?= $active === (int)$c['id'] ? 'true' : 'false' ?>">
          <span aria-hidden="true"><?= e($c['icon']) ?></span> <?= e($c['label']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if ($spotlight): $sImages = product_images($spotlight); ?>
<section class="section tight">
  <div class="container">
    <article class="spotlight glass reveal">
      <a href="product.php?slug=<?= e($spotlight['slug']) ?>" class="spotlight-media">
        <img src="<?= e($sImages[0]) ?>" alt="<?= e($spotlight['name']) ?>" loading="lazy">
      </a>
      <div class="spotlight-body">
        <span class="section-eyebrow"><?= e($spotlight['badge'] ?: $spotlight['brand']) ?></span>
        <h3><?= e($spotlight['name']) ?></h3>
        <p><?= e($spotlight['short_desc']) ?></p>
        <div class="rating"><?= stars_html((float)$spotlight['rating']) ?>
          <span class="rating-value"><?= number_format((float)$spotlight['rating'], 1) ?></span>
          <span class="rating-count">(<?= number_format((int)$spotlight['reviews']) ?>)</span>
        </div>
        <div class="spotlight-foot">
          <div class="price-group">
            <span class="price"><?= money((float)$spotlight['price']) ?></span>
            <?php if ($spotlight['old_price']): ?><span class="price-old"><?= money((float)$spotlight['old_price']) ?></span><?php endif; ?>
          </div>
          <button class="btn btn-primary add-to-cart" data-id="<?= (int)$spotlight['id'] ?>" data-qty="1" data-color="0">Add to Cart</button>
        </div>
      </div>
    </article>
  </div>
</section>
<?php endif; ?>

<section class="section tight">
  <div class="container">
    <div class="product-grid featured-grid">
      <?php foreach ($featured as $i => $p) echo product_card_html($p, $i); ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container center-cta reveal">
    <a href="products.php" class="btn btn-ghost btn-lg">Browse the full catalog</a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
