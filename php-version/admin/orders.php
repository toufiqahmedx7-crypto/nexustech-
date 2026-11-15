<?php
/** NexusTech admin — orders list + status update. */
$ADMIN_TITLE  = 'Orders';
$ADMIN_ACTIVE = 'orders.php';
require_once __DIR__ . '/includes/admin-header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'status') {
    if (csrf_ok()) {
        order_set_status((int)($_POST['id'] ?? 0), (string)($_POST['status'] ?? ''));
    }
    header('Location: orders.php?updated=1');
    exit;
}

$orders = orders_all();
?>
<?php if (isset($_GET['updated'])): ?>
  <div class="flash flash-success">Order status updated.</div>
<?php endif; ?>

<div class="panel glass">
  <div class="panel-head">
    <h2>All orders (<?= count($orders) ?>)</h2>
  </div>
  <?php if (!$orders): ?>
    <p class="cell-muted">No orders yet — place a test order from the store's checkout page.</p>
  <?php else: ?>
    <div class="table-wrap">
      <table class="admin-table">
        <thead><tr><th>Order</th><th>Date</th><th>Customer</th><th>Phone</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td class="cell-strong"><?= e($o['order_no']) ?></td>
            <td class="cell-muted"><?= e(date('M j, g:i a', strtotime($o['created_at']))) ?></td>
            <td><?= e($o['customer_name']) ?></td>
            <td class="cell-muted"><?= e($o['phone']) ?></td>
            <td class="num"><?= (int)$o['items_count'] ?></td>
            <td class="num"><?= money((float)$o['total']) ?></td>
            <td class="cell-muted"><?= e(strtoupper($o['payment'])) ?></td>
            <td>
              <form method="post" class="inline-form">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="status">
                <input type="hidden" name="id" value="<?= (int)$o['id'] ?>">
                <select name="status" onchange="this.form.submit()">
                  <?php foreach (ORDER_STATUSES as $s): ?>
                    <option value="<?= $s ?>" <?= $o['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                  <?php endforeach; ?>
                </select>
              </form>
            </td>
            <td><a class="btn btn-ghost btn-sm" href="order-view.php?id=<?= (int)$o['id'] ?>">View</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
