<?php
/** NexusTech admin — product list + delete. */
$ADMIN_TITLE  = 'Products';
$ADMIN_ACTIVE = 'products.php';
require_once __DIR__ . '/includes/admin-header.php';

$notice = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    if (!csrf_ok()) {
        $notice = ['error', 'Session expired — nothing was deleted.'];
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $stmt = db()->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $notice = ['success', 'Product deleted.'];
    }
}

$products    = products_all();
$catLabels   = [];
foreach (categories_all() as $c) $catLabels[(int)$c['id']] = $c['label'];
?>
<?php if (isset($_GET['saved'])): ?>
  <div class="flash flash-success">Product saved.</div>
<?php endif; ?>
<?php if ($notice): ?>
  <div class="flash flash-<?= $notice[0] ?>"><?= e($notice[1]) ?></div>
<?php endif; ?>

<div class="panel glass">
  <div class="panel-head">
    <h2>All products (<?= count($products) ?>)</h2>
    <a class="btn btn-primary btn-sm" href="product-form.php">+ Add product</a>
  </div>
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr><th>ID</th><th></th><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Badge</th><th>Actions</th></tr>
      </thead>
      <tbody>
      <?php foreach ($products as $p): $imgs = product_images($p); ?>
        <tr>
          <td class="cell-muted num">#<?= (int)$p['id'] ?></td>
          <td><img class="thumb" src="<?= e($imgs[0]) ?>" alt=""></td>
          <td>
            <div class="cell-strong"><?= e($p['name']) ?></div>
            <div class="cell-muted"><?= e($p['brand']) ?> · <?= e($p['slug']) ?></div>
          </td>
          <td class="cell-muted"><?= e($catLabels[(int)$p['category_id']] ?? '—') ?></td>
          <td class="num"><?= money((float)$p['price']) ?></td>
          <td class="num <?= (int)$p['stock'] <= 5 ? 'stock-low' : 'stock-ok' ?>"><?= (int)$p['stock'] ?></td>
          <td><?= $p['badge'] ? '<span class="mini-badge">' . e($p['badge']) . '</span>' : '<span class="cell-muted">—</span>' ?></td>
          <td>
            <div class="inline-form">
              <a class="btn btn-ghost btn-sm" href="product-form.php?id=<?= (int)$p['id'] ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Delete &quot;<?= e($p['name']) ?>&quot;?');">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
