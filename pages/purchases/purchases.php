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
    'SELECT
        p.id,
        p.name,
        p.image_path,
        p.deleted_at,
        t.total_quantity,
        t.total_spent,
        GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR "|||") AS categories
     FROM (
       SELECT
            oi.product_id,
            SUM(oi.quantity)                 AS total_quantity,
           SUM(oi.quantity * oi.unit_price) AS total_spent
        FROM order_items oi
        JOIN orders o ON o.id = oi.order_id
        WHERE o.client_id = ? AND o.deleted_at IS NULL
        GROUP BY oi.product_id
     ) t
     JOIN products p ON p.id = t.product_id
     LEFT JOIN category_product cp ON cp.product_id = p.id
     LEFT JOIN categories c ON c.id = cp.category_id AND c.deleted_at IS NULL
     GROUP BY p.id, p.name, p.image_path, p.deleted_at, t.total_quantity, t.total_spent
     ORDER BY t.total_spent DESC'
);
$stmt->execute([$clientId]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);

render_view('purchases/index', ['purchases' => $purchases]);
