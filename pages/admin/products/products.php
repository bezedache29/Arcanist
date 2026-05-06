<?php
require_once __DIR__ . '/../../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$pdo = getDbConnection();

// 1. On recupere tous les produits actifs
$stmt = $pdo->query('SELECT * FROM products WHERE deleted_at IS NULL ORDER BY created_at DESC');
$products = $stmt->fetchAll();

// 2. On recupere toutes les categories liees a ces produits
// On s'assure de ne prendre que les categories qui ne sont pas en soft-delete
$stmtCats = $pdo->query('
    SELECT cp.product_id, c.name 
    FROM category_product cp
    JOIN categories c ON cp.category_id = c.id
    WHERE c.deleted_at IS NULL
');
$allCategories = $stmtCats->fetchAll();

// 3. On regroupe les categories par ID de produit pour un affichage facile dans la vue
$productCategories = [];
foreach ($allCategories as $row) {
    $productCategories[$row['product_id']][] = $row['name'];
}

// On envoie les produits ET le tableau de correspondances des categories
render_view('admin/products/products', [
    'products' => $products,
    'productCategories' => $productCategories
], 'admin');
