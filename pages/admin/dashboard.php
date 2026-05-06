<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$pdo = getDbConnection();
$stats = [];

// Nombre de produits actifs
$stmt = $pdo->query('SELECT COUNT(*) FROM products WHERE deleted_at IS NULL');
$stats['products'] = $stmt->fetchColumn();

// Nombre de categories
$stmt = $pdo->query('SELECT COUNT(*) FROM categories WHERE deleted_at IS NULL');
$stats['categories'] = $stmt->fetchColumn();

// Nombre de clients (utilisateurs non-admin)
$stmt = $pdo->query('SELECT COUNT(*) FROM clients WHERE is_admin = 0 AND deleted_at IS NULL');
$stats['clients'] = $stmt->fetchColumn();

// Nombre de commandes en attente
$stmt = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending' AND deleted_at IS NULL");
$stats['pending_orders'] = $stmt->fetchColumn();

// On rend la vue en forcant le layout admin
render_view('admin/dashboard', ['stats' => $stats], 'admin');
