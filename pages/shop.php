<?php
require_once __DIR__ . '/../bootstrap.php';
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

$pdo  = getDbConnection();
$stmt = $pdo->query(
    'SELECT p.*,
        GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR "|||") AS categories
     FROM products p
     LEFT JOIN category_product cp ON cp.product_id = p.id
     LEFT JOIN categories c ON c.id = cp.category_id AND c.deleted_at IS NULL
     WHERE p.deleted_at IS NULL
     GROUP BY p.id
     ORDER BY p.name'
);
$products = $stmt->fetchAll();

render_view('shop/index', [
    'products'   => $products,
    'csrf_token' => $_SESSION['csrf_token'],
]);
