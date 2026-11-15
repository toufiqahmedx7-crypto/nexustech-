<?php
/** NexusTech admin — add / edit a product. */
require_once __DIR__ . '/../config.php';

$id      = (int)($_GET['id'] ?? 0);
$editing = $id > 0;
$product = $editing ? product_by_id($id) : null;

$ADMIN_ACTIVE = 'products.php';
$ADMIN_TITLE  = $editing ? 'Edit product' : 'Add product';
require_once __DIR__ . '/includes/admin-header.php';

if ($editing && !$product) {
    echo '<div class="flash flash-error">Product not found.</div>';
    require_once __DIR__ . '/includes/admin-footer.php';
    exit;
}

$errors = [];
$values = [
    'name' => '', 'slug' => '', 'brand' => '', 'category_id' => '', 'price' => '',
    'old_price' => '', 'rating' => '4.5', 'reviews' => '0', 'stock' => '0',
    'badge' => '', 'colors' => '', 'short_desc' => '', 'description' => '',
    'specs' => '', 'images' => '',
];

if ($editing) {
    $values['name']        = $product['name'];
    $values['slug']        = $product['slug'];
    $values['brand']       = $product['brand'];
    $values['category_id'] = (string)$product['category_id'];
    $values['price']       = (string)$product['price'];
    $values['old_price']   = $product['old_price'] !== null ? (string)$product['old_price'] : '';
    $values['rating']      = (string)$product['rating'];
    $values['reviews']     = (string)$product['reviews'];
    $values['stock']       = (string)$product['stock'];
    $values['badge']       = (string)($product['badge'] ?? '');
    $values['colors']      = implode(', ', product_colors($product));
    $values['short_desc']  = (string)$product['short_desc'];
    $values['description'] = (string)$product['description'];
    foreach (product_specs($product) as $k => $v) $values['specs'] .= $k . ': ' . $v . "\n";
    foreach (product_images($product) as $img) $values['images'] .= $img . "\n";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $k => $_) {
        $values[$k] = trim((string)($_POST[$k] ?? ''));
    }
    $values['category_id'] = (string)($_POST['category_id'] ?? '');

    if ($values['name'] === '')          $errors[] = 'Product name is required.';
    if ($values['brand'] === '')         $errors[] = 'Brand is required.';
    if (!ctype_digit((string)$values['category_id']) || !category_by_id((int)$values['category_id'])) $errors[] = 'Choose a valid category.';
    if (!is_numeric($values['price']) || (float)$values['price'] < 0) $errors[] = 'Price must be a number.';
    if ($values['old_price'] !== '' && (!is_numeric($values['old_price']) || (float)$values['old_price'] < 0)) $errors[] = 'Old price must be a number.';
    if (!is_numeric($values['stock']) || (int)$values['stock'] < 0) $errors[] = 'Stock must be a number.';
    if ($values['images'] === '')        $errors[] = 'At least one image URL is required.';

    if (!$errors) {
        $specs  = [];
        foreach (preg_split('/\r\n|\r|\n/', $values['specs']) as $line) {
            if (strpos($line, ':') === false) continue;
            [$k, $v] = explode(':', $line, 2);
            if (trim($k) !== '') $specs[trim($k)] = trim($v);
        }
        $colors = array_values(array_filter(array_map('trim', explode(',', $values['colors']))));
        $images = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $values['images']))));

        $slug = slugify($values['slug'] !== '' ? $values['slug'] : $values['name']);
        $slug = unique_slug($slug, 'products', $editing ? $id : 0);

        $cols = 'slug, name, brand, category_id, price, old_price, rating, reviews, stock, badge, colors, short_desc, description, specs, images';
        $marks = '?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?';
        $params = [
            $slug,
            $values['name'],
            $values['brand'],
            (int)$values['category_id'],
            (float)$values['price'],
            $values['old_price'] !== '' ? (float)$values['old_price'] : null,
            max(0, min(5, (float)$values['rating'])),
            max(0, (int)$values['reviews']),
            (int)$values['stock'],
            $values['badge'] !== '' ? $values['badge'] : null,
            json_encode($colors),
            $values['short_desc'],
            $values['description'],
            json_encode($specs),
            json_encode($images),
        ];

        if ($editing) {
            $set = 'slug = ?, name = ?, brand = ?, category_id = ?, price = ?, old_price = ?, rating = ?, reviews = ?, stock = ?, badge = ?, colors = ?, short_desc = ?, description = ?, specs = ?, images = ?';
            $stmt = db()->prepare("UPDATE products SET $set WHERE id = ?");
            $stmt->execute(array_merge($params, [$id]));
        } else {
            $stmt = db()->prepare("INSERT INTO products ($cols) VALUES ($marks)");
            $stmt->execute($params);
        }
        header('Location: products.php?saved=1');
        exit;
    }
}

$categories = categories_all();
?>
<?php foreach ($errors as $err): ?>
  <div class="flash flash-error"><?= e($err) ?></div>
<?php endforeach; ?>

<form method="post" class="panel glass">
  <h2><?= $editing ? 'Edit: ' . e($product['name']) : 'New product' ?></h2>

  <div class="form-grid">
    <label class="field span-2">
      <span>Product name *</span>
      <input type="text" name="name" value="<?= e($values['name']) ?>" required>
    </label>
    <label class="field">
      <span>Slug (auto if empty)</span>
      <input type="text" name="slug" value="<?= e($values['slug']) ?>" placeholder="galaxy-s25-ultra">
    </label>
    <label class="field">
      <span>Brand *</span>
      <input type="text" name="brand" value="<?= e($values['brand']) ?>" required>
    </label>
    <label class="field">
      <span>Category *</span>
      <select name="category_id" required>
        <option value="">— choose —</option>
        <?php foreach ($categories as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= (string)$c['id'] === $values['category_id'] ? 'selected' : '' ?>>
            <?= e($c['label']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <label class="field">
      <span>Price ($) *</span>
      <input type="number" step="0.01" min="0" name="price" value="<?= e($values['price']) ?>" required>
    </label>
    <label class="field">
      <span>Old price ($, empty = none)</span>
      <input type="number" step="0.01" min="0" name="old_price" value="<?= e($values['old_price']) ?>">
    </label>
    <label class="field">
      <span>Stock *</span>
      <input type="number" min="0" name="stock" value="<?= e($values['stock']) ?>" required>
    </label>
    <label class="field">
      <span>Rating (0–5)</span>
      <input type="number" step="0.1" min="0" max="5" name="rating" value="<?= e($values['rating']) ?>">
    </label>
    <label class="field">
      <span>Review count</span>
      <input type="number" min="0" name="reviews" value="<?= e($values['reviews']) ?>">
    </label>
    <label class="field">
      <span>Badge (New / Deal / Best Seller / empty)</span>
      <input type="text" name="badge" value="<?= e($values['badge']) ?>">
    </label>
    <label class="field">
      <span>Colors (comma separated)</span>
      <input type="text" name="colors" value="<?= e($values['colors']) ?>" placeholder="Titanium Black, Silver">
    </label>
    <label class="field span-2">
      <span>Short description</span>
      <input type="text" name="short_desc" value="<?= e($values['short_desc']) ?>">
    </label>
    <label class="field span-2">
      <span>Full description</span>
      <textarea name="description" rows="4"><?= e($values['description']) ?></textarea>
    </label>
    <label class="field span-2">
      <span>Specs — one per line, format <code>Key: Value</code></span>
      <textarea name="specs" rows="6" placeholder="Display: 6.9&quot; AMOLED&#10;Battery: 5000 mAh"><?= e($values['specs']) ?></textarea>
    </label>
    <label class="field span-2">
      <span>Image URLs — one per line (first = main image) *</span>
      <textarea name="images" rows="4" placeholder="https://images.unsplash.com/photo-...?w=900&q=80" required><?= e($values['images']) ?></textarea>
      <span class="field-hint">Tip: copy any Unsplash photo address, it already works with the store.</span>
    </label>
  </div>

  <div class="form-actions">
    <button class="btn btn-primary" type="submit"><?= $editing ? 'Save changes' : 'Create product' ?></button>
    <a class="btn btn-ghost" href="products.php">Cancel</a>
  </div>
</form>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
