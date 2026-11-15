<?php
/**
 * NexusTech — one-click installer.
 * Open http://localhost/nexustech/php-version/setup.php once.
 * Creates the database, tables and seeds 24 products + 6 categories.
 */
require __DIR__ . '/seed-data.php';

$host = '127.0.0.1';
$port = '3306';
$name = 'nexustech';
$user = 'root';
$pass = '';

$messages = [];
$error    = null;

try {
    $server = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $messages[] = 'Connected to MySQL server.';

    $server->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $messages[] = "Database `$name` ready.";

    $server->exec("USE `$name`");

    $server->exec('CREATE TABLE IF NOT EXISTS categories (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(50) NOT NULL UNIQUE,
        label VARCHAR(80) NOT NULL,
        icon VARCHAR(16) NOT NULL DEFAULT "",
        tagline VARCHAR(160) NOT NULL DEFAULT ""
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    $server->exec('CREATE TABLE IF NOT EXISTS products (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        slug VARCHAR(120) NOT NULL UNIQUE,
        name VARCHAR(160) NOT NULL,
        brand VARCHAR(80) NOT NULL,
        category_id INT UNSIGNED NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        old_price DECIMAL(10,2) NULL,
        rating DECIMAL(2,1) NOT NULL DEFAULT 4.5,
        reviews INT UNSIGNED NOT NULL DEFAULT 0,
        stock INT NOT NULL DEFAULT 0,
        badge VARCHAR(40) NULL,
        colors JSON NULL,
        short_desc VARCHAR(255) NOT NULL DEFAULT "",
        description TEXT NULL,
        specs JSON NULL,
        images JSON NULL,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    $server->exec('CREATE TABLE IF NOT EXISTS orders (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        order_no VARCHAR(20) NOT NULL UNIQUE,
        customer_name VARCHAR(120) NOT NULL,
        phone VARCHAR(40) NOT NULL,
        address VARCHAR(255) NOT NULL,
        payment VARCHAR(30) NOT NULL DEFAULT "cod",
        items_count INT UNSIGNED NOT NULL DEFAULT 0,
        total DECIMAL(10,2) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT "pending",
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    $server->exec('CREATE TABLE IF NOT EXISTS order_items (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        order_id INT UNSIGNED NOT NULL,
        product_id INT UNSIGNED NULL,
        name VARCHAR(160) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        qty INT UNSIGNED NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    $messages[] = 'Tables created (products, categories, orders).';

    $count = (int)$server->query('SELECT COUNT(*) AS c FROM categories')->fetch()['c'];
    if ($count === 0) {
        $stmt = $server->prepare('INSERT INTO categories (slug, label, icon, tagline) VALUES (?, ?, ?, ?)');
        foreach (SEED_CATEGORIES as $c) {
            $stmt->execute([$c['slug'], $c['label'], $c['icon'], $c['tagline']]);
        }
        $messages[] = 'Seeded ' . count(SEED_CATEGORIES) . ' categories.';
    } else {
        $messages[] = 'Categories already present, skipped.';
    }

    $count = (int)$server->query('SELECT COUNT(*) AS c FROM products')->fetch()['c'];
    if ($count === 0) {
        $catIds = [];
        foreach ($server->query('SELECT id, slug FROM categories') as $row) {
            $catIds[$row['slug']] = (int)$row['id'];
        }
        $stmt = $server->prepare(
            'INSERT INTO products
             (slug, name, brand, category_id, price, old_price, rating, reviews, stock, badge, colors, short_desc, description, specs, images)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        foreach (SEED_PRODUCTS as $p) {
            $stmt->execute([
                $p['slug'], $p['name'], $p['brand'], $catIds[$p['category']],
                $p['price'], $p['old_price'], $p['rating'], $p['reviews'], $p['stock'],
                $p['badge'], json_encode($p['colors']), $p['short'],
                $p['description'], json_encode($p['specs']), json_encode($p['images']),
            ]);
        }
        $messages[] = 'Seeded ' . count(SEED_PRODUCTS) . ' products.';
    } else {
        $messages[] = 'Products already present, skipped.';
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NexusTech — Setup</title>
<style>
  body { background:#07080c; color:#f5f7fa; font-family:system-ui,sans-serif; display:grid; place-items:center; min-height:100vh; margin:0; }
  .box { max-width:640px; padding:2.5rem; border:1px solid rgba(56,189,248,.28); border-radius:18px; background:rgba(255,255,255,.04); }
  h1 { margin-top:0; }
  li { margin:.4rem 0; color:#9aa4b5; }
  .ok { color:#6ee7a0; }
  .err { color:#ff8a80; word-break:break-all; }
  a.btn { display:inline-block; margin-top:1.2rem; padding:.8rem 1.8rem; border-radius:999px; text-decoration:none; color:#fff;
          background:linear-gradient(135deg,#38bdf8,#2563eb); font-weight:600; }
</style>
</head>
<body>
  <div class="box">
    <h1>⚙️ NexusTech Setup</h1>
    <?php if ($error): ?>
      <p class="err">✗ <?= htmlspecialchars($error) ?></p>
      <p style="color:#9aa4b5">Check the DB_* constants at the top of <code>config.php</code> and reload this page.</p>
    <?php else: ?>
      <ul>
        <?php foreach ($messages as $m): ?><li class="ok">✓ <?= htmlspecialchars($m) ?></li><?php endforeach; ?>
      </ul>
      <a class="btn" href="index.php">Open the store →</a>
    <?php endif; ?>
  </div>
</body>
</html>
