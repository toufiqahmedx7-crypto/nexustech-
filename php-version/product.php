<?php
require_once __DIR__ . '/config.php';

$slug    = $_GET['slug'] ?? '';
$product = product_by_slug($slug);

if (!$product) {
    http_response_code(404);
    $PAGE_TITLE = 'Product not found — NexusTech';
    require __DIR__ . '/includes/header.php';
    echo '<div class="page container section"><div class="no-results glass"><h2>Product not found</h2><p>The product you are looking for does not exist.</p><a href="products.php" class="btn btn-primary">Back to catalog</a></div></div>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$category = category_by_id((int)$product['category_id']);
$images   = product_images($product);
$colors   = product_colors($product);
$specs    = product_specs($product);
$related  = products_related($product, 4);

$PAGE_TITLE = $product['name'] . ' — NexusTech';
require __DIR__ . '/includes/header.php';
?>

<section class="section tight">
  <div class="container">
    <div class="breadcrumbs reveal">
      <a href="index.php">Home</a><span aria-hidden="true">/</span>
      <a href="products.php?category=<?= (int)$product['category_id'] ?>"><?= e($category['label']) ?></a><span aria-hidden="true">/</span>
      <span><?= e($product['name']) ?></span>
    </div>

    <div class="detail-layout">
      <div class="gallery">
        <div class="gallery-main glass">
          <img id="gallery-main-img" src="<?= e($images[0]) ?>" alt="<?= e($product['name']) ?> view 1">
        </div>
        <div class="gallery-thumbs" id="gallery-thumbs">
          <?php foreach ($images as $i => $src): ?>
            <button class="gallery-thumb<?= $i === 0 ? ' active' : '' ?>" data-src="<?= e($src) ?>" aria-label="View image <?= $i + 1 ?>">
              <img src="<?= e($src) ?>" alt="" loading="lazy">
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="detail-info">
        <div class="detail-badges">
          <span class="chip static"><?= e($category['icon']) ?> <?= e($category['label']) ?></span>
          <?= badge_html($product['badge']) ?>
        </div>

        <h1><?= e($product['name']) ?></h1>
        <p class="detail-short"><?= e($product['short_desc']) ?></p>
        <div class="rating"><?= stars_html((float)$product['rating']) ?>
          <span class="rating-value"><?= number_format((float)$product['rating'], 1) ?></span>
          <span class="rating-count">(<?= number_format((int)$product['reviews']) ?>)</span>
        </div>

        <div class="price-group detail-price">
          <span class="price"><?= money((float)$product['price']) ?></span>
          <?php if ($product['old_price']): ?>
            <span class="price-old"><?= money((float)$product['old_price']) ?></span>
            <span class="save-pill">Save <?= money((float)$product['old_price'] - (float)$product['price']) ?></span>
          <?php endif; ?>
        </div>

        <div class="stock-row">
          <span class="stock-dot <?= (int)$product['stock'] > 0 ? 'in' : 'out' ?>"></span>
          <span class="<?= (int)$product['stock'] > 0 ? 'stock-in' : 'stock-out' ?>">
            <?= (int)$product['stock'] > 0 ? 'In stock — ' . (int)$product['stock'] . ' units ready to ship' : 'Out of stock' ?>
          </span>
        </div>

        <?php if ($colors): ?>
        <div class="option-group">
          <span class="option-label">Finish</span>
          <div class="color-row" id="color-row">
            <?php foreach ($colors as $i => $c): ?>
              <button class="color-swatch<?= $i === 0 ? ' active' : '' ?>" data-color="<?= $i ?>" style="background: <?= e($c) ?>" aria-label="Color option <?= $i + 1 ?>" aria-pressed="<?= $i === 0 ? 'true' : 'false' ?>"></button>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <div class="buy-row">
          <div class="qty-stepper">
            <button type="button" id="qty-minus" aria-label="Decrease quantity">−</button>
            <span id="qty-value">1</span>
            <button type="button" id="qty-plus" aria-label="Increase quantity">+</button>
          </div>
          <button class="btn btn-primary btn-lg add-to-cart" id="detail-add"
                  data-id="<?= (int)$product['id'] ?>" data-qty="1" data-color="0"
                  <?= (int)$product['stock'] > 0 ? '' : 'disabled' ?>>
            Add to Cart — <?= money((float)$product['price']) ?>
          </button>
        </div>

        <p class="detail-description"><?= e($product['description']) ?></p>

        <?php if ($specs): ?>
        <div class="specs glass">
          <h3>Full specifications</h3>
          <dl>
            <?php foreach ($specs as $k => $v): ?>
              <div class="spec-row"><dt><?= e($k) ?></dt><dd><?= e($v) ?></dd></div>
            <?php endforeach; ?>
          </dl>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <span class="section-eyebrow">You may also like</span>
      <h2>Recommended for you</h2>
    </div>
    <div class="product-grid">
      <?php foreach ($related as $i => $p) echo product_card_html($p, $i); ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
