<?php
require_once __DIR__ . '/config.php';

$active = isset($_GET['category']) ? max(0, (int)$_GET['category']) : 0;
$q      = trim($_GET['q'] ?? '');

if ($q !== '') {
    $results = products_search($q, $active > 0 ? $active : null);
    $groups  = [['category' => null, 'products' => $results]];
} else {
    $cats = $active > 0
        ? array_filter(categories_all(), fn ($c) => (int)$c['id'] === $active)
        : categories_all();
    $groups = [];
    foreach ($cats as $c) {
        $groups[] = ['category' => $c, 'products' => products_by_category((int)$c['id'])];
    }
}
$groups  = array_values(array_filter($groups, fn ($g) => count($g['products']) > 0));
$total   = array_sum(array_map(fn ($g) => count($g['products']), $groups));

$PAGE_TITLE = 'All Products — NexusTech';
require __DIR__ . '/includes/header.php';
?>

<section class="section page-head">
  <div class="container">
    <div class="reveal">
      <span class="section-eyebrow">Page 03 — Catalog</span>
      <h1>All products</h1>
      <p>The complete NexusTech lineup — 24 devices across six categories.</p>
    </div>
  </div>
</section>

<section class="section tight">
  <div class="container">
    <div class="catalog-controls reveal">
      <div class="chip-row" role="tablist" aria-label="Category filter">
        <a href="products.php<?= $q !== '' ? '?q=' . urlencode($q) : '' ?>" class="chip<?= $active === 0 ? ' active' : '' ?>" role="tab" aria-selected="<?= $active === 0 ? 'true' : 'false' ?>">All</a>
        <?php foreach (categories_all() as $c): ?>
          <a href="products.php?category=<?= (int)$c['id'] ?><?= $q !== '' ? '&q=' . urlencode($q) : '' ?>" class="chip<?= $active === (int)$c['id'] ? ' active' : '' ?>" role="tab" aria-selected="<?= $active === (int)$c['id'] ? 'true' : 'false' ?>">
            <span aria-hidden="true"><?= e($c['icon']) ?></span> <?= e($c['label']) ?>
          </a>
        <?php endforeach; ?>
      </div>

      <form class="search-box" method="get" action="products.php" role="search">
        <?php if ($active > 0): ?><input type="hidden" name="category" value="<?= $active ?>"><?php endif; ?>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="search" name="q" placeholder="Search products, brands…" value="<?= e($q) ?>" aria-label="Search products">
        <?php if ($q !== ''): ?><a class="search-clear" href="products.php<?= $active > 0 ? '?category=' . $active : '' ?>" aria-label="Clear search">×</a><?php endif; ?>
      </form>
    </div>
  </div>
</section>

<section class="section tight">
  <div class="container">
    <?php if ($total === 0): ?>
      <div class="no-results glass">
        <span aria-hidden="true">🔍</span>
        <h3>No matches for “<?= e($q) ?>”</h3>
        <p>Try a different keyword or clear the filters.</p>
        <a href="products.php" class="btn btn-ghost">Reset filters</a>
      </div>
    <?php else: ?>
      <?php foreach ($groups as $g): ?>
        <div class="catalog-group">
          <div class="group-head reveal">
            <h2><span aria-hidden="true"><?= e($g['category']['icon']) ?></span> <?= e($g['category']['label']) ?></h2>
            <span class="group-count"><?= count($g['products']) ?> product<?= count($g['products']) > 1 ? 's' : '' ?></span>
          </div>
          <div class="product-grid">
            <?php foreach ($g['products'] as $i => $p) echo product_card_html($p, $i); ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
