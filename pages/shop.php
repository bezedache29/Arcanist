<?php
require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

$pdo = getDbConnection();

$stmt = $pdo->query('SELECT * FROM products WHERE deleted_at IS NULL');
$products = $stmt->fetchAll();

render_view('shop/index', ['products' => $products]);
