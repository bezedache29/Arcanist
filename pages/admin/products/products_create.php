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

// Recuperation de toutes les categories actives et construction de la whitelist
$stmtCats = $pdo->query('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY name ASC');
$categories = $stmtCats->fetchAll();

$categoriesById = [];
foreach ($categories as $cat) {
    $categoriesById[(int)$cat['id']] = true;
}

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
            $error = "Veuillez remplir correctement tous les champs obligatoires.";
        } else {
            try {
                // Demarrage de la transaction
                $pdo->beginTransaction();

                // 1. Insertion du produit
                $stmt = $pdo->prepare('INSERT INTO products (name, description, price, stock) VALUES (?, ?, ?, ?)');
                $stmt->execute([$name, $description, $price, $stock]);

                // On recupere l'ID du produit fraichement cree
                $productId = $pdo->lastInsertId();

                // 2. Insertion des liaisons avec les categories
                if (!empty($categoryIds) && is_array($categoryIds)) {
                    $stmtPivot = $pdo->prepare('INSERT INTO category_product (product_id, category_id) VALUES (?, ?)');
                    foreach ($categoryIds as $catId) {
                        $catIdInt = (int) $catId;
                        // On verifie que l'ID fait bien partie de la whitelist
                        if (isset($categoriesById[$catIdInt])) {
                            $stmtPivot->execute([$productId, $catIdInt]);
                        }
                    }
                }

                // Si tout s'est bien passe, on valide la transaction
                $pdo->commit();

                header('Location: /pages/admin/products/products.php');
                exit;
            } catch (Exception $e) {
                // En cas d'erreur, on annule la transaction si elle est active
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                // Optionnel : on peut aussi logger l'erreur réelle pour le debug
                error_log("Erreur lors de la création du produit : " . $e->getMessage());
                $error = "Une erreur est survenue lors de l'enregistrement en base de données.";
            }
        }
    }
}

// Generation du jeton CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// On rend la vue en envoyant la variable $categories
render_view('admin/products/products_create', [
    'error' => $error,
    'categories' => $categories
], 'admin');
