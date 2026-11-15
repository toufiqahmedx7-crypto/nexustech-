<?php
/** NexusTech admin — dashboard. */
$ADMIN_TITLE  = 'Dashboard';
$ADMIN_ACTIVE = 'index.php';
require_once __DIR__ . '/includes/admin-header.php';

$stats = admin_stats();
?>
<?php if (isset($_GET['welcome'])): ?>
  <div class="flash flash-success">Welcome back, <?= e($_SESSION['admin'] ?? 'admin') ?>!</div>
<?php endif; ?>

<div class="stat-grid">
  <div class="stat-card glass">
    <div class="stat-label">Products</div>
    <div class="stat-value"><?= (int)$stats['products'] ?></div>
  </div>
  <div class="stat-card glass">
    <div class="stat-label">Categories</div>
    <div class="stat-value"><?= (int)$stats['categories'] ?></div>
  </div>
  <div class="stat-card glass">
    <div class="stat-label">Orders</div>
    <div class="stat-value"><?= (int)$stats['orders'] ?></div>
  </div>
  <div class="stat-card glass">
    <div class="stat-label">Revenue</div>
    <div class="stat-value accent"><?= money($stats['revenue']) ?></div>
  </div>
</div>

<div class="panel glass">
  <div class="panel-head">
    <h2>Recent orders</h2>
    <a class="btn btn-ghost btn-sm" href="orders.php">View all</a>
  </div>
  <?php if (!$stats['recent']): ?>
    <p class="cell-muted">No orders yet — place a test order from the store's checkout page.</p>
  <?php else: ?>
    <div class="table-wrap">
      <table class="admin-table">
        <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($stats['recent'] as $o): ?>
          <tr>
            <td class="cell-strong"><?= e($o['order_no']) ?></td>
            <td><?= e($o['customer_name']) ?></td>
            <td class="num"><?= (int)$o['items_count'] ?></td>
            <td class="num"><?= money((float)$o['total']) ?></td>
            <td><span class="status-badge status-<?= e($o['status']) ?>"><?= e($o['status']) ?></span></td>
            <td class="cell-muted"><?= e(date('M j, g:i a', strtotime($o['created_at']))) ?></td>
            <td><a class="btn btn-ghost btn-sm" href="order-view.php?id=<?= (int)$o['id'] ?>">View</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<div class="panel glass">
  <div class="panel-head">
    <h2>Low stock (&le; 5 left)</h2>
    <a class="btn btn-ghost btn-sm" href="products.php">Manage products</a>
  </div>
  <?php if (!$stats['low_stock']): ?>
    <p class="cell-muted">All products are well stocked. 🎉</p>
  <?php else: ?>
    <div class="table-wrap">
      <table class="admin-table">
        <thead><tr><th>Product</th><th>Brand</th><th>Stock</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($stats['low_stock'] as $p): ?>
          <tr>
            <td class="cell-strong"><?= e($p['name']) ?></td>
            <td class="cell-muted"><?= e($p['brand']) ?></td>
            <td class="num <?= (int)$p['stock'] === 0 ? 'stock-low' : '' ?>"><?= (int)$p['stock'] ?></td>
            <td><a class="btn btn-ghost btn-sm" href="product-form.php?id=<?= (int)$p['id'] ?>">Edit</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
