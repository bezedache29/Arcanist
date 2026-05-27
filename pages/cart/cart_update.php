<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('`@/helpers/view.php`');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/cart/cart.php');
    exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    header('Location: /pages/cart/cart.php');
    exit;
}

$productId = (int)($_POST['product_id'] ?? 0);
$quantity  = max(1, (int)($_POST['quantity'] ?? 1));

if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
    $pdo  = getDbConnection();
    $stmt = $pdo->prepare('SELECT stock FROM products WHERE id = ? AND deleted_at IS NULL');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if ($product) {
        $stock = (int)$product['stock'];
        if ($stock <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId] = min($quantity, $stock);
        }
    }
}

header('Location: /pages/cart/cart.php');
exit;
