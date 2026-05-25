<?php
require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$pdo      = getDbConnection();
$clientId = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare(
    'SELECT
        COUNT(*)                          AS order_count,
        COALESCE(SUM(total_amount), 0)    AS total_spent
     FROM orders
     WHERE client_id = ? AND deleted_at IS NULL'
);
$stmt->execute([$clientId]);
$orderStats = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare(
    'SELECT COALESCE(SUM(oi.quantity), 0) AS product_count
     FROM order_items oi
     JOIN orders o ON o.id = oi.order_id
     WHERE o.client_id = ? AND o.deleted_at IS NULL'
);
$stmt->execute([$clientId]);
$productStats = $stmt->fetch(PDO::FETCH_ASSOC);

render_view('dashboard/index', [
    'order_count'   => (int)$orderStats['order_count'],
    'product_count' => (int)$productStats['product_count'],
    'total_spent'   => (float)$orderStats['total_spent'],
]);
