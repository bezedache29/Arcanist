<?php
// pages/shop.php
require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

// On demarre la session pour que le layout (app.php) te reconnaisse
session_start();

$pdo = getDbConnection();

// Recuperation des produits actifs uniquement
$stmt = $pdo->query('SELECT * FROM products WHERE deleted_at IS NULL');
$products = $stmt->fetchAll();

// Envoi des donnees vers la vue
render_view('shop/index', ['products' => $products]);
