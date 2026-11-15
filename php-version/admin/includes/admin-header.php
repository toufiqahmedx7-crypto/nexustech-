<?php
/** NexusTech admin — shared layout header. Expects $ADMIN_TITLE and $ADMIN_ACTIVE. */
require_once __DIR__ . '/../auth.php';

$ADMIN_TITLE  = $ADMIN_TITLE ?? 'Dashboard';
$ADMIN_ACTIVE = $ADMIN_ACTIVE ?? '';

$navItems = [
    'index.php'     => ['Dashboard', 'M3 12l9-9 9 9M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10'],
    'products.php'  => ['Products', 'M20 7H4m16 0-1.6-3.2A2 2 0 0 0 16.6 2.6H7.4a2 2 0 0 0-1.8 1.2L4 7m16 0v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7'],
    'categories.php'=> ['Categories', 'M4 6h16M4 12h16M4 18h10'],
    'orders.php'    => ['Orders', 'M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2'],
];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($ADMIN_TITLE) ?> — NexusTech Admin</title>
<link rel="icon" type="image/svg+xml" href="../assets/img/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin-body">
<div class="admin-shell">
  <aside class="admin-sidebar">
    <a href="index.php" class="admin-brand">
      <svg viewBox="0 0 32 32" width="24" height="24" aria-hidden="true">
        <defs><linearGradient id="ag" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#38bdf8"/><stop offset="100%" stop-color="#2563eb"/></linearGradient></defs>
        <rect x="2" y="2" width="28" height="28" rx="8" fill="none" stroke="url(#ag)" stroke-width="2.5"/>
        <path d="M10 22V10l12 12V10" fill="none" stroke="url(#ag)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span>Nexus<span>Admin</span></span>
    </a>
    <nav class="admin-nav">
      <?php foreach ($navItems as $href => [$label, $path]): ?>
        <a href="<?= $href ?>" class="admin-nav-link<?= $ADMIN_ACTIVE === $href ? ' active' : '' ?>">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="<?= $path ?>"/></svg>
          <?= e($label) ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="admin-sidebar-foot">
      <a href="../index.php" class="admin-nav-link">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg>
        View store
      </a>
      <a href="logout.php" class="admin-nav-link danger">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4m7 14 5-5-5-5m5 5H9"/></svg>
        Logout
      </a>
    </div>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <h1><?= e($ADMIN_TITLE) ?></h1>
      <span class="admin-user">Signed in as <strong><?= e($_SESSION['admin'] ?? 'admin') ?></strong></span>
    </header>
    <main class="admin-content">
