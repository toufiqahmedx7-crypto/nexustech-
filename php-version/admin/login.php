<?php
/** NexusTech admin — login. */
require_once __DIR__ . '/../config.php';

if (admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) {
        $error = 'Session expired, please try again.';
    } elseif (admin_login(trim((string)($_POST['user'] ?? '')), (string)($_POST['pass'] ?? ''))) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Wrong username or password.';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login — NexusTech</title>
<link rel="icon" type="image/svg+xml" href="../assets/img/favicon.svg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin-login-body">
<div class="glow-frame" aria-hidden="true">
  <span class="glow-edge glow-top"></span>
  <span class="glow-edge glow-bottom"></span>
  <span class="glow-edge glow-left"></span>
  <span class="glow-edge glow-right"></span>
</div>

<div class="login-card glass">
  <div class="login-brand">
    <svg viewBox="0 0 32 32" width="34" height="34" aria-hidden="true">
      <defs><linearGradient id="lg" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#38bdf8"/><stop offset="100%" stop-color="#2563eb"/></linearGradient></defs>
      <rect x="2" y="2" width="28" height="28" rx="8" fill="none" stroke="url(#lg)" stroke-width="2.5"/>
      <path d="M10 22V10l12 12V10" fill="none" stroke="url(#lg)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span class="brand-name">Nexus<span>Tech</span></span>
  </div>
  <h1>Admin Panel</h1>
  <p class="login-sub">Sign in to manage products, categories and orders.</p>

  <?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>

  <form method="post" class="login-form">
    <?= csrf_field() ?>
    <label class="field">
      <span>Username</span>
      <input type="text" name="user" autocomplete="username" required autofocus>
    </label>
    <label class="field">
      <span>Password</span>
      <input type="password" name="pass" autocomplete="current-password" required>
    </label>
    <button class="btn btn-primary btn-block" type="submit">Sign in</button>
  </form>

  <p class="login-hint">Default credentials: <code>admin</code> / <code>admin123</code> — change them in <code>config.php</code>.</p>
  <a class="login-back" href="../index.php">&larr; Back to store</a>
</div>
</body>
</html>
