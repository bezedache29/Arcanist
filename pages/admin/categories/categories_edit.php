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

// 1. Recuperation de l'ID depuis l'URL
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /pages/admin/categories/categories.php');
    exit;
}

// 2. Recuperation de la categorie en base de donnees
$stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ? AND deleted_at IS NULL');
$stmt->execute([$id]);
$category = $stmt->fetch();

// Si la categorie n'existe pas ou a ete supprimee (soft delete)
if (!$category) {
    header('Location: /pages/admin/categories/categories.php');
    exit;
}

// 3. Traitement du formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (empty($csrfToken) || !hash_equals($sessionToken, $csrfToken)) {
        $error = "Jeton de sécurité invalide ou expiré.";
    } else {
        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $error = "Le nom de la catégorie est obligatoire.";
        } elseif (mb_strlen($name) > 100) {
            $error = "Le nom de la catégorie ne doit pas dépasser 100 caractères.";
        } else {
            try {
                $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
                $stmt->execute([$name, $id]);

                unset($_SESSION['csrf_token']);
                header('Location: /pages/admin/categories/categories.php');
                exit;
            } catch (PDOException $e) {
                error_log('[categories_edit] ' . $e->getMessage());
                $error = "Impossible de mettre à jour la catégorie.";
            }
        }
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// On rend la vue avec le layout admin
render_view('admin/categories/categories_edit', [
    'error' => $error,
    'category' => $category
], 'admin');
