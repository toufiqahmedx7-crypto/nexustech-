<?php
require_once __DIR__ . '/../config.php';

$PAGE_TITLE = $PAGE_TITLE ?? 'NexusTech — Premium Electronics & Gadgets';
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($PAGE_TITLE) ?></title>
<link rel="icon" type="image/svg+xml" href="assets/img/favicon.svg">
<meta name="description" content="NexusTech — Premium electronics, smartphones, laptops, audio, wearables, cameras and accessories.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="glow-frame" aria-hidden="true">
  <span class="glow-edge glow-top"></span>
  <span class="glow-edge glow-bottom"></span>
  <span class="glow-edge glow-left"></span>
  <span class="glow-edge glow-right"></span>
</div>

<header class="navbar" id="navbar">
  <div class="navbar-inner container">
    <a href="index.php" class="brand" aria-label="NexusTech home">
      <span class="brand-mark">
        <svg viewBox="0 0 32 32" width="26" height="26" aria-hidden="true">
          <defs><linearGradient id="brand-g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#38bdf8"/><stop offset="100%" stop-color="#2563eb"/></linearGradient></defs>
          <rect x="2" y="2" width="28" height="28" rx="8" fill="none" stroke="url(#brand-g)" stroke-width="2.5"/>
          <path d="M10 22V10l12 12V10" fill="none" stroke="url(#brand-g)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
      <span class="brand-name">Nexus<span>Tech</span></span>
    </a>

    <nav class="nav-links" aria-label="Primary">
      <a href="index.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? ' active' : '' ?>">Home</a>
      <a href="featured.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) === 'featured.php' ? ' active' : '' ?>">Featured</a>
      <a href="products.php" class="nav-link<?= in_array(basename($_SERVER['PHP_SELF']), ['products.php', 'product.php']) ? ' active' : '' ?>">Products</a>
      <a href="trust.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) === 'trust.php' ? ' active' : '' ?>">Why Us</a>
    </nav>

    <div class="nav-actions">
      <button class="cart-button" id="cart-open" aria-label="Open cart">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
        </svg>
        <span class="cart-badge" id="cart-badge" data-count="<?= cart_count() ?>" <?= cart_count() === 0 ? 'hidden' : '' ?>><?= cart_count() ?></span>
      </button>
      <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <nav class="mobile-menu" id="mobile-menu" aria-label="Mobile">
    <a href="index.php" class="mobile-link">Home</a>
    <a href="featured.php" class="mobile-link">Featured</a>
    <a href="products.php" class="mobile-link">Products</a>
    <a href="trust.php" class="mobile-link">Why Us</a>
  </nav>
</header>

<main>
