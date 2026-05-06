<?php
require_once __DIR__ . '/../../../bootstrap.php';
require_alias('@/helpers/db.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $pdo = getDbConnection();

    $stmt = $pdo->prepare('UPDATE categories SET deleted_at = CURRENT_TIMESTAMP WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: /pages/admin/categories/categories.php');
exit;
