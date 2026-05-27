<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

$orderId  = (int)($_GET['id'] ?? 0);
$clientId = (int)$_SESSION['user_id'];

if ($orderId <= 0) {
    header('Location: /pages/orders/orders.php');
    exit;
}

$pdo = getDbConnection();

// On vérifie que la commande appartient bien au client connecté
$stmt = $pdo->prepare(
    'SELECT * FROM orders WHERE id = ? AND client_id = ? AND deleted_at IS NULL'
);
$stmt->execute([$orderId, $clientId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: /pages/orders/orders.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT oi.*, p.name, p.image_path
     FROM order_items oi
     JOIN products p ON p.id = oi.product_id
     WHERE oi.order_id = ?'
);
$stmt->execute([$orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

render_view('orders/order', [
    'order' => $order,
    'items' => $items,
]);
