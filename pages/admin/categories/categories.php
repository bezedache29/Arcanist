<?php
require_once __DIR__ . '/../../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$categories = [];

try {
    $pdo = getDbConnection();
    // On recupere les categories actives (gestion du soft delete)
    $stmt = $pdo->query('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY created_at DESC');
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    // Enregistrement de l'erreur pour le debug sans l'exposer a l'utilisateur
    error_log('Erreur BDD lors de la récupération des catégories : ' . $e->getMessage());
    // $categories reste un tableau vide, la vue gérera cela proprement (message "Aucune catégorie")
}

render_view('admin/categories/categories', ['categories' => $categories], 'admin');
