<?php
/** NexusTech admin — single order detail. */
require_once __DIR__ . '/../config.php';

$id    = (int)($_GET['id'] ?? 0);
$order = order_by_id($id);

$ADMIN_ACTIVE = 'orders.php';
$ADMIN_TITLE  = $order ? 'Order ' . $order['order_no'] : 'Order';
require_once __DIR__ . '/includes/admin-header.php';

if (!$order) {
    echo '<div class="flash flash-error">Order not found.</div>';
    require_once __DIR__ . '/includes/admin-footer.php';
    exit;
}

$items = order_items_for($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'status' && csrf_ok()) {
    order_set_status($id, (string)($_POST['status'] ?? ''));
    header('Location: order-view.php?id=' . $id . '&updated=1');
    exit;
}
?>
<?php if (isset($_GET['updated'])): ?>
  <div class="flash flash-success">Order status updated.</div>
<?php endif; ?>

<div class="panel glass">
  <div class="panel-head">
    <h2><?= e($order['order_no']) ?>
      <span class="status-badge status-<?= e($order['status']) ?>"><?= e($order['status']) ?></span>
    </h2>
    <a class="btn btn-ghost btn-sm" href="orders.php">&larr; All orders</a>
  </div>

  <div class="meta-grid">
    <div class="meta-item"><div class="k">Customer</div><div class="v"><?= e($order['customer_name']) ?></div></div>
    <div class="meta-item"><div class="k">Phone</div><div class="v"><?= e($order['phone']) ?></div></div>
    <div class="meta-item"><div class="k">Placed</div><div class="v"><?= e(date('M j, Y, g:i a', strtotime($order['created_at']))) ?></div></div>
    <div class="meta-item"><div class="k">Payment</div><div class="v"><?= e(strtoupper($order['payment'])) ?></div></div>
    <div class="meta-item"><div class="k">Total</div><div class="v"><?= money((float)$order['total']) ?></div></div>
    <div class="meta-item"><div class="k">Items</div><div class="v"><?= (int)$order['items_count'] ?></div></div>
  </div>
  <p style="margin:1rem 0 0" class="cell-muted"><strong style="color:var(--text)">Delivery address:</strong> <?= e($order['address']) ?></p>
</div>

<div class="panel glass">
  <h2>Items</h2>
  <div class="table-wrap">
    <table class="admin-table">
      <thead><tr><th>#</th><th>Product</th><th>Unit price</th><th>Qty</th><th>Line total</th></tr></thead>
      <tbody>
      <?php foreach ($items as $n => $it): ?>
        <tr>
          <td class="cell-muted num"><?= $n + 1 ?></td>
          <td>
            <div class="cell-strong"><?= e($it['name']) ?></div>
            <?php if ($it['product_id']): ?>
              <div class="cell-muted">product #<?= (int)$it['product_id'] ?></div>
            <?php endif; ?>
          </td>
          <td class="num"><?= money((float)$it['price']) ?></td>
          <td class="num"><?= (int)$it['qty'] ?></td>
          <td class="num"><?= money((float)$it['price'] * (int)$it['qty']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<form method="post" class="panel glass">
  <h2>Update status</h2>
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="status">
  <div class="form-actions">
    <select name="status">
      <?php foreach (ORDER_STATUSES as $s): ?>
        <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
    <button class="btn btn-primary" type="submit">Save</button>
  </div>
</form>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
