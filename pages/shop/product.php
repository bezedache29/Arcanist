<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$productId = (int)($_GET['id'] ?? 0);

if ($productId <= 0) {
    header('Location: /pages/shop.php');
    exit;
}

$pdo = getDbConnection();

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND deleted_at IS NULL');
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: /pages/shop.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT c.name FROM categories c
     JOIN category_product cp ON cp.category_id = c.id
     WHERE cp.product_id = ? AND c.deleted_at IS NULL'
);
$stmt->execute([$productId]);
$categories = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

render_view('shop/product', [
    'product'    => $product,
    'categories' => $categories,
    'csrf_token' => $_SESSION['csrf_token'],
]);
