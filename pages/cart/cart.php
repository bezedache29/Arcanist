<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$cart    = $_SESSION['cart'] ?? [];
$items   = [];
$totalHT = 0.0;

if (!empty($cart)) {
    $ids          = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $pdo          = getDbConnection();
    $stmt         = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders) AND deleted_at IS NULL");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $qty      = $cart[$product['id']];
        $subtotal = (float)$product['price'] * $qty;
        $totalHT += $subtotal;
        $items[]  = [
            'product'  => $product,
            'quantity' => $qty,
            'subtotal' => $subtotal,
        ];
    }
}

render_view('cart/index', [
    'items'      => $items,
    'totalHT'    => $totalHT,
    'csrf_token' => $_SESSION['csrf_token'],
]);
