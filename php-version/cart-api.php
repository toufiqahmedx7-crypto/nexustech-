<?php
/** NexusTech — cart JSON API (session-based). */
require_once __DIR__ . '/config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

switch ($action) {
    case 'add':
        cart_add((int)($_POST['id'] ?? 0), (int)($_POST['qty'] ?? 1), (int)($_POST['color'] ?? 0));
        break;
    case 'update':
        cart_update((string)($_POST['key'] ?? ''), (int)($_POST['qty'] ?? 0));
        break;
    case 'remove':
        cart_remove((string)($_POST['key'] ?? ''));
        break;
    case 'clear':
        $_SESSION['cart'] = [];
        break;
}

$items = [];
foreach (cart_items() as $key => $i) {
    $items[] = [
        'key'   => $key,
        'id'    => $i['id'],
        'slug'  => $i['slug'],
        'name'  => $i['name'],
        'price' => (float)$i['price'],
        'image' => $i['image'],
        'qty'   => $i['qty'],
    ];
}

json_out([
    'ok'    => true,
    'count' => cart_count(),
    'total' => cart_total(),
    'items' => $items,
]);
