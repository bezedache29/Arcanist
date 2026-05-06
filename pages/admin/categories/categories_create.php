<?php
require_once __DIR__ . '/../../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$error = '';

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
                $pdo = getDbConnection();
                $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
                $stmt->execute([$name]);

                unset($_SESSION['csrf_token']); // empêche le rejeu
                header('Location: /pages/admin/categories/categories.php');
                exit;
            } catch (PDOException $e) {
                $error = "Impossible de créer la catégorie (nom déjà utilisé ?).";
            }
        }
    }
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

render_view('admin/categories/categories_create', ['error' => $error], 'admin');
