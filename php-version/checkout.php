<?php
/** NexusTech — checkout: turns the session cart into a real order. */
require_once __DIR__ . '/config.php';

$PAGE_TITLE = 'Checkout — NexusTech';
require_once __DIR__ . '/includes/header.php';

$done   = null;
$errors = [];
$values = ['name' => '', 'phone' => '', 'address' => '', 'payment' => 'cod'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        $errors[] = 'Session expired — please submit the form again.';
    } else {
        foreach ($values as $k => $_) $values[$k] = trim((string)($_POST[$k] ?? ''));
        if ($values['name'] === '')    $errors[] = 'Please enter your full name.';
        if ($values['phone'] === '')   $errors[] = 'Please enter a phone number.';
        if ($values['address'] === '') $errors[] = 'Please enter a delivery address.';
        if (!in_array($values['payment'], ['cod', 'card', 'bkash', 'paypal'], true)) $values['payment'] = 'cod';

        if (!$errors && cart_count() > 0) {
            $done = orders_create($values['name'], $values['phone'], $values['address'], $values['payment']);
        }
    }
}

$cartEmpty = cart_count() === 0 && !$done;
?>

<?php if ($done): ?>
  <section class="container checkout-wrap">
    <div class="checkout-success glass reveal visible">
      <div class="success-icon">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
      </div>
      <h1>Order placed!</h1>
      <p class="checkout-sub">Thanks, your order is confirmed. We'll contact you shortly to arrange delivery.</p>
      <div class="order-no">Order number: <strong><?= e($done['order_no']) ?></strong></div>
      <div class="checkout-actions">
        <a class="btn btn-primary" href="products.php">Continue shopping</a>
        <a class="btn btn-ghost" href="index.php">Back to home</a>
      </div>
    </div>
  </section>

<?php elseif ($cartEmpty): ?>
  <section class="container checkout-wrap">
    <div class="checkout-success glass reveal visible">
      <div class="success-icon">🛒</div>
      <h1>Your cart is empty</h1>
      <p class="checkout-sub">Add some products first, then come back to check out.</p>
      <div class="checkout-actions">
        <a class="btn btn-primary" href="products.php">Browse products</a>
      </div>
    </div>
  </section>

<?php else: ?>
  <section class="container checkout-wrap">
    <div class="checkout-head reveal">
      <h1>Checkout</h1>
      <p class="cell-muted"><?= cart_count() ?> item(s) · Subtotal <?= money(cart_total()) ?> · Free express shipping over $50</p>
    </div>

    <?php foreach ($errors as $err): ?>
      <div class="flash flash-error"><?= e($err) ?></div>
    <?php endforeach; ?>

    <div class="checkout-grid">
      <form method="post" class="checkout-form glass reveal">
        <?= csrf_field() ?>
        <h2>Delivery details</h2>
        <label class="field">
          <span>Full name *</span>
          <input type="text" name="name" value="<?= e($values['name']) ?>" required>
        </label>
        <label class="field">
          <span>Phone *</span>
          <input type="tel" name="phone" value="<?= e($values['phone']) ?>" required>
        </label>
        <label class="field">
          <span>Delivery address *</span>
          <textarea name="address" rows="3" required><?= e($values['address']) ?></textarea>
        </label>
        <label class="field">
          <span>Payment method</span>
          <select name="payment">
            <option value="cod">Cash on delivery</option>
            <option value="card">Card</option>
            <option value="bkash">bKash</option>
            <option value="paypal">PayPal</option>
          </select>
        </label>
        <button class="btn btn-primary btn-block" type="submit">Place order · <?= money(cart_total()) ?></button>
        <p class="field-hint">This is a demo store — no real payment is processed.</p>
      </form>

      <aside class="checkout-summary glass reveal">
        <h2>Your order</h2>
        <?php foreach (cart_items() as $i): ?>
          <div class="summary-row">
            <img src="<?= e($i['image']) ?>" alt="">
            <div class="summary-info">
              <span class="summary-name"><?= e($i['name']) ?></span>
              <span class="cell-muted">× <?= (int)$i['qty'] ?></span>
            </div>
            <span class="num"><?= money($i['price'] * $i['qty']) ?></span>
          </div>
        <?php endforeach; ?>
        <div class="summary-total">
          <span>Subtotal</span>
          <span class="num"><?= money(cart_total()) ?></span>
        </div>
        <div class="summary-total">
          <span>Shipping</span>
          <span class="num"><?= cart_total() >= 50 ? 'Free' : '$9' ?></span>
        </div>
        <div class="summary-total grand">
          <span>Total</span>
          <span class="num"><?= money(cart_total() + (cart_total() >= 50 ? 0 : 9)) ?></span>
        </div>
      </aside>
    </div>
  </section>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
