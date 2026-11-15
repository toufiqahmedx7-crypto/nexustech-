<?php
/**
 * NexusTech — configuration & helpers
 * Edit the DB_* constants to match your MySQL server (XAMPP defaults shown).
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'nexustech');
define('DB_USER', 'root');
define('DB_PASS', '');

session_start();

function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            header('Location: setup.php?error=' . urlencode($e->getMessage()));
            exit;
        }
    }
    return $pdo;
}

function e(?string $s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function money(float $n): string
{
    return '$' . number_format($n, 0);
}

function json_out(array $data): void
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

/* ---------- Cart (PHP session) ---------- */

function &cart_items(): array
{
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

function cart_add(int $productId, int $qty, int $colorIndex = 0): void
{
    $product = product_by_id($productId);
    if (!$product || $qty < 1) return;
    $qty      = min($qty, 99);
    $key      = $productId . '-' . $colorIndex;
    $items    = &cart_items();
    if (isset($items[$key])) {
        $items[$key]['qty'] = min($items[$key]['qty'] + $qty, 99);
    } else {
        $items[$key] = [
            'id'    => $product['id'],
            'slug'  => $product['slug'],
            'name'  => $product['name'],
            'price' => (float)$product['price'],
            'image' => product_images($product)[0],
            'color' => $colorIndex,
            'qty'   => $qty,
        ];
    }
}

function cart_remove(string $key): void
{
    $items = &cart_items();
    unset($items[$key]);
}

function cart_update(string $key, int $qty): void
{
    $items = &cart_items();
    if ($qty <= 0) {
        unset($items[$key]);
        return;
    }
    if (isset($items[$key])) {
        $items[$key]['qty'] = min($qty, 99);
    }
}

function cart_count(): int
{
    $count = 0;
    foreach (cart_items() as $i) $count += $i['qty'];
    return $count;
}

function cart_total(): float
{
    $total = 0.0;
    foreach (cart_items() as $i) $total += $i['qty'] * $i['price'];
    return $total;
}

/* ---------- Product helpers ---------- */

function product_images(array $p): array
{
    $images = json_decode($p['images'] ?? '[]', true);
    return is_array($images) && $images ? $images : ['https://via.placeholder.com/900'];
}

function product_colors(array $p): array
{
    $colors = json_decode($p['colors'] ?? '[]', true);
    return is_array($colors) ? $colors : [];
}

function product_specs(array $p): array
{
    $specs = json_decode($p['specs'] ?? '{}', true);
    return is_array($specs) ? $specs : [];
}

function products_all(): array
{
    return db()->query('SELECT * FROM products ORDER BY category_id, price')->fetchAll();
}

function products_by_category(int $categoryId): array
{
    $stmt = db()->prepare('SELECT * FROM products WHERE category_id = ? ORDER BY price');
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll();
}

function products_featured(int $limit = 8): array
{
    $stmt = db()->prepare('SELECT * FROM products WHERE badge IS NOT NULL ORDER BY rating DESC LIMIT ?');
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function product_by_slug(string $slug): ?array
{
    $stmt = db()->prepare('SELECT * FROM products WHERE slug = ? LIMIT 1');
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function product_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM products WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function products_related(array $product, int $count = 4): array
{
    $stmt = db()->prepare(
        'SELECT * FROM products
         WHERE id <> ?
         ORDER BY (category_id = ?) DESC, rating DESC
         LIMIT ?'
    );
    $stmt->bindValue(1, $product['id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $product['category_id'], PDO::PARAM_INT);
    $stmt->bindValue(3, $count, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function products_search(string $q, ?int $categoryId = null): array
{
    $sql    = 'SELECT * FROM products WHERE (name LIKE ? OR brand LIKE ? OR short_desc LIKE ?)';
    $params = ["%$q%", "%$q%", "%$q%"];
    if ($categoryId !== null) {
        $sql .= ' AND category_id = ?';
        $params[] = $categoryId;
    }
    $sql .= ' ORDER BY category_id, price';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function categories_all(): array
{
    return db()->query('SELECT * FROM categories ORDER BY id')->fetchAll();
}

function category_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM categories WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function stars_html(float $rating): string
{
    $full = (int)round($rating);
    $html = '<span class="stars" aria-hidden="true">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<svg width="13" height="13" viewBox="0 0 24 24" class="star' . ($i <= $full ? ' filled' : '') . '"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01z"/></svg>';
    }
    return $html . '</span>';
}

function badge_html(?string $badge): string
{
    if (!$badge) return '';
    $class = 'badge badge-' . strtolower(str_replace(' ', '-', $badge));
    return '<span class="' . e($class) . '">' . e($badge) . '</span>';
}

function product_card_html(array $p, int $index = 0): string
{
    $images = product_images($p);
    $lowStock = (int)$p['stock'] <= 15
        ? '<span class="badge badge-low">Only ' . (int)$p['stock'] . ' left</span>'
        : '';
    ob_start();
    ?>
    <article class="product-card glass reveal" style="--d: <?= ($index % 4) * 70 ?>ms">
      <a href="product.php?slug=<?= e($p['slug']) ?>" class="product-media">
        <img src="<?= e($images[0]) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
        <?= badge_html($p['badge']) . $lowStock ?>
      </a>
      <div class="product-body">
        <span class="product-brand"><?= e($p['brand']) ?></span>
        <a href="product.php?slug=<?= e($p['slug']) ?>" class="product-name"><?= e($p['name']) ?></a>
        <div class="rating"><?= stars_html((float)$p['rating']) ?>
          <span class="rating-value"><?= number_format((float)$p['rating'], 1) ?></span>
          <span class="rating-count">(<?= number_format((int)$p['reviews']) ?>)</span>
        </div>
        <div class="product-foot">
          <div class="price-group">
            <span class="price"><?= money((float)$p['price']) ?></span>
            <?php if ($p['old_price']): ?><span class="price-old"><?= money((float)$p['old_price']) ?></span><?php endif; ?>
          </div>
          <button class="btn btn-primary btn-sm add-to-cart"
                  data-id="<?= (int)$p['id'] ?>" data-qty="1" data-color="0"
                  aria-label="Add <?= e($p['name']) ?> to cart">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
            Add
          </button>
        </div>
      </div>
    </article>
    <?php
    return (string)ob_get_clean();
}

/* ---------- Admin auth ---------- */

/* Change these two lines before putting the site online. */
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

function admin_is_logged_in(): bool
{
    return !empty($_SESSION['admin']);
}

function admin_login(string $user, string $pass): bool
{
    if (hash_equals(ADMIN_USER, $user) && hash_equals(ADMIN_PASS, $pass)) {
        $_SESSION['admin'] = $user;
        return true;
    }
    return false;
}

function admin_logout(): void
{
    unset($_SESSION['admin']);
}

/* ---------- CSRF protection ---------- */

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_ok(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], (string)$_POST['csrf']);
}

/* ---------- Orders ---------- */

const ORDER_STATUSES = ['pending', 'paid', 'shipped', 'delivered', 'cancelled'];

function slugify(string $s): string
{
    $s = strtolower(trim($s));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim($s, '-') ?: 'item';
}

function unique_slug(string $slug, string $table, int $ignoreId = 0): string
{
    $base   = $slug;
    $suffix = 2;
    while (true) {
        $stmt = db()->prepare("SELECT id FROM `$table` WHERE slug = ? AND id <> ? LIMIT 1");
        $stmt->execute([$slug, $ignoreId]);
        if (!$stmt->fetch()) return $slug;
        $slug = $base . '-' . $suffix++;
    }
}

function orders_create(string $name, string $phone, string $address, string $payment): array
{
    $pdo     = db();
    $orderNo = 'NX-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO orders (order_no, customer_name, phone, address, payment, items_count, total, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$orderNo, $name, $phone, $address, $payment, cart_count(), cart_total(), 'pending']);
        $orderId = (int)$pdo->lastInsertId();

        $itemStmt  = $pdo->prepare('INSERT INTO order_items (order_id, product_id, name, price, qty) VALUES (?, ?, ?, ?, ?)');
        $stockStmt = $pdo->prepare('UPDATE products SET stock = GREATEST(stock - ?, 0) WHERE id = ?');
        foreach (cart_items() as $i) {
            $itemStmt->execute([$orderId, $i['id'], $i['name'], $i['price'], $i['qty']]);
            $stockStmt->execute([$i['qty'], $i['id']]);
        }
        $pdo->commit();
    } catch (Throwable $ex) {
        $pdo->rollBack();
        throw $ex;
    }
    $_SESSION['cart'] = [];
    return ['id' => $orderId, 'order_no' => $orderNo];
}

function orders_all(): array
{
    return db()->query('SELECT * FROM orders ORDER BY id DESC')->fetchAll();
}

function order_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM orders WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function order_items_for(int $orderId): array
{
    $stmt = db()->prepare('SELECT * FROM order_items WHERE order_id = ? ORDER BY id');
    $stmt->execute([$orderId]);
    return $stmt->fetchAll();
}

function order_set_status(int $id, string $status): void
{
    if (!in_array($status, ORDER_STATUSES, true)) return;
    $stmt = db()->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $stmt->execute([$status, $id]);
}

function admin_stats(): array
{
    $pdo = db();
    return [
        'products'    => (int)$pdo->query('SELECT COUNT(*) AS c FROM products')->fetch()['c'],
        'categories'  => (int)$pdo->query('SELECT COUNT(*) AS c FROM categories')->fetch()['c'],
        'orders'      => (int)$pdo->query('SELECT COUNT(*) AS c FROM orders')->fetch()['c'],
        'revenue'     => (float)$pdo->query("SELECT COALESCE(SUM(total),0) AS s FROM orders WHERE status <> 'cancelled'")->fetch()['s'],
        'low_stock'   => $pdo->query('SELECT * FROM products WHERE stock <= 5 ORDER BY stock, name')->fetchAll(),
        'recent'      => $pdo->query('SELECT * FROM orders ORDER BY id DESC LIMIT 5')->fetchAll(),
    ];
}
