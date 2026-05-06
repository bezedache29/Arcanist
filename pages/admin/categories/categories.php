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

$stmt = $pdo->query('SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY created_at DESC');
$categories = $stmt->fetchAll();

render_view('admin/categories/categories', ['categories' => $categories], 'admin');
