<?php
/** NexusTech admin — categories: add / delete. */
$ADMIN_TITLE  = 'Categories';
$ADMIN_ACTIVE = 'categories.php';
require_once __DIR__ . '/includes/admin-header.php';

$notice = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        $notice = ['error', 'Session expired — please try again.'];
    } elseif (($_POST['action'] ?? '') === 'add') {
        $label   = trim((string)($_POST['label'] ?? ''));
        $icon    = trim((string)($_POST['icon'] ?? ''));
        $tagline = trim((string)($_POST['tagline'] ?? ''));
        if ($label === '') {
            $notice = ['error', 'Category name is required.'];
        } else {
            $slug = unique_slug(slugify($label), 'categories');
            $stmt = db()->prepare('INSERT INTO categories (slug, label, icon, tagline) VALUES (?, ?, ?, ?)');
            $stmt->execute([$slug, $label, $icon, $tagline]);
            header('Location: categories.php?added=1');
            exit;
        }
    } elseif (($_POST['action'] ?? '') === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $count = (int)db()->query('SELECT COUNT(*) AS c FROM products WHERE category_id = ' . $id)->fetch()['c'];
        if ($count > 0) {
            $notice = ['error', "Cannot delete — $count product(s) still use this category. Move or delete them first."];
        } else {
            $stmt = db()->prepare('DELETE FROM categories WHERE id = ?');
            $stmt->execute([$id]);
            $notice = ['success', 'Category deleted.'];
        }
    }
}

$categories = categories_all();
$productCounts = [];
foreach (db()->query('SELECT category_id, COUNT(*) AS c FROM products GROUP BY category_id') as $row) {
    $productCounts[(int)$row['category_id']] = (int)$row['c'];
}
?>
<?php if (isset($_GET['added'])): ?>
  <div class="flash flash-success">Category added.</div>
<?php endif; ?>
<?php if ($notice): ?>
  <div class="flash flash-<?= $notice[0] ?>"><?= e($notice[1]) ?></div>
<?php endif; ?>

<div class="panel glass">
  <h2>All categories (<?= count($categories) ?>)</h2>
  <div class="table-wrap">
    <table class="admin-table">
      <thead><tr><th>ID</th><th>Icon</th><th>Name</th><th>Slug</th><th>Tagline</th><th>Products</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach ($categories as $c): ?>
        <tr>
          <td class="cell-muted num">#<?= (int)$c['id'] ?></td>
          <td><?= e($c['icon']) ?></td>
          <td class="cell-strong"><?= e($c['label']) ?></td>
          <td class="cell-muted"><?= e($c['slug']) ?></td>
          <td class="cell-muted"><?= e($c['tagline']) ?></td>
          <td class="num"><?= $productCounts[(int)$c['id']] ?? 0 ?></td>
          <td>
            <form method="post" onsubmit="return confirm('Delete category &quot;<?= e($c['label']) ?>&quot;?');">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
              <button class="btn btn-danger btn-sm" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<form method="post" class="panel glass">
  <h2>Add a category</h2>
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="add">
  <div class="form-grid">
    <label class="field">
      <span>Name *</span>
      <input type="text" name="label" placeholder="Gaming" required>
    </label>
    <label class="field">
      <span>Icon (emoji)</span>
      <input type="text" name="icon" placeholder="🎮" maxlength="16">
    </label>
    <label class="field">
      <span>Tagline</span>
      <input type="text" name="tagline" placeholder="Gear up for victory">
    </label>
  </div>
  <div class="form-actions">
    <button class="btn btn-primary" type="submit">Add category</button>
  </div>
</form>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
