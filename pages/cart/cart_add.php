<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/shop.php');
    exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    header('Location: /pages/shop.php');
    exit;
}

$productId = (int)($_POST['product_id'] ?? 0);
$quantity  = max(1, (int)($_POST['quantity'] ?? 1));

if ($productId <= 0) {
    header('Location: /pages/shop.php');
    exit;
}

$pdo  = getDbConnection();
$stmt = $pdo->prepare('SELECT id, stock FROM products WHERE id = ? AND deleted_at IS NULL');
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: /pages/shop.php');
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$currentQty                    = $_SESSION['cart'][$productId] ?? 0;
$_SESSION['cart'][$productId] = min($currentQty + $quantity, (int)$product['stock']);

// Redirection sécurisée : on n'accepte que les URLs internes connues
$allowed = ['/pages/shop.php', '/pages/cart/cart.php'];
$redirect = in_array($_POST['redirect'] ?? '', $allowed) ? $_POST['redirect'] : '/pages/shop.php';

header('Location: ' . $redirect);
exit;
