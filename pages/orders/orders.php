<?php
require_once __DIR__ . '/../../bootstrap.php';
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
    'SELECT o.*,
        COUNT(oi.id)          AS item_count,
        COALESCE(SUM(oi.quantity), 0) AS unit_count
     FROM orders o
     LEFT JOIN order_items oi ON oi.order_id = o.id
     WHERE o.client_id = ? AND o.deleted_at IS NULL
     GROUP BY o.id
     ORDER BY o.created_at DESC'
);
$stmt->execute([$clientId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

render_view('orders/index', ['orders' => $orders]);
