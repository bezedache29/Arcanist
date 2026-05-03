<?php
// setup.php
require_once __DIR__ . '/bootstrap.php';
require_alias('@/helpers/db.php');

$pdo = getDbConnection();
$email = 'admin@arcanist.local';
// On crypte le mot de passe "admin123"
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO clients (email, password_hash, company_name, is_admin) VALUES (?, ?, 'Mon Entreprise Admin', 1)");
$stmt->execute([$email, $password]);

echo "✅ Compte administrateur créé ! Tu peux supprimer ce fichier. <br>";
echo "Email : admin@arcanist.local <br> Mot de passe : admin123";
