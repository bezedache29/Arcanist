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
$error = '';

// 1. Recuperation et verification de l'ID du produit
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /pages/admin/products/products.php');
    exit;
}

// 2. Recuperation du produit (seulement s'il n'est pas supprime)
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND deleted_at IS NULL');
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: /pages/admin/products/products.php');
    exit;
}

// Recuperation des categories actives et construction de la whitelist AVANT le POST
$stmtCats = $pdo->query('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY name ASC');
$categories = $stmtCats->fetchAll();

$categoriesById = [];
foreach ($categories as $cat) {
    $categoriesById[(int)$cat['id']] = true;
}

// 3. Traitement du formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (empty($csrfToken) || !hash_equals($sessionToken, $csrfToken)) {
        $error = "Jeton de sécurité invalide ou expiré.";
    } else {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = filter_var($_POST['price'] ?? null, FILTER_VALIDATE_FLOAT);
        $stock = filter_var($_POST['stock'] ?? null, FILTER_VALIDATE_INT);
        $categoryIds = $_POST['category_ids'] ?? [];

        if (
            empty($name) ||
            $price === false || $price === null || $price < 0 ||
            $stock === false || $stock === null || $stock < 0
        ) {
            $error = "Veuillez remplir correctement tous les champs obligatoires (prix et stock positifs).";
        } else {
            try {
                $pdo->beginTransaction();

                // Mise a jour des informations du produit
                $stmtUpdate = $pdo->prepare('UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?');
                $stmtUpdate->execute([$name, $description, $price, $stock, $id]);

                // Mise a jour des categories : on supprime d'abord les anciennes liaisons
                $stmtDeletePivot = $pdo->prepare('DELETE FROM category_product WHERE product_id = ?');
                $stmtDeletePivot->execute([$id]);

                // Puis on insere les nouvelles liaisons via la whitelist
                if (!empty($categoryIds) && is_array($categoryIds)) {
                    $stmtInsertPivot = $pdo->prepare('INSERT INTO category_product (product_id, category_id) VALUES (?, ?)');
                    foreach ($categoryIds as $catId) {
                        $catIdInt = (int)$catId;
                        if (isset($categoriesById[$catIdInt])) {
                            $stmtInsertPivot->execute([$id, $catIdInt]);
                        }
                    }
                }

                $pdo->commit();

                // Destruction du jeton CSRF pour eviter le replay
                unset($_SESSION['csrf_token']);

                header('Location: /pages/admin/products/products.php');
                exit;
            } catch (Exception $e) {
                // Securisation du rollback
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                error_log("Erreur lors de la modification du produit : " . $e->getMessage());
                $error = "Une erreur est survenue lors de la mise à jour.";
            }
        }
    }
}

// Generation du jeton CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Recuperation des ID des categories actuelles du produit pour pre-cocher les cases
$stmtCurrentCats = $pdo->prepare('SELECT category_id FROM category_product WHERE product_id = ?');
$stmtCurrentCats->execute([$id]);
$currentCategoryIds = $stmtCurrentCats->fetchAll(PDO::FETCH_COLUMN);

// On rend la vue en mode admin
render_view('admin/products/products_edit', [
    'error' => $error,
    'product' => $product,
    'categories' => $categories,
    'currentCategoryIds' => $currentCategoryIds
], 'admin');
