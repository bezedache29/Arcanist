<?php
// pages/auth/register.php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = $_POST['company_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if ($password !== $passwordConfirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $pdo = getDbConnection();

        $stmt = $pdo->prepare('SELECT id FROM clients WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO clients (company_name, email, password_hash) VALUES (?, ?, ?)');
            $insert->execute([$company, $email, $hashedPassword]);

            // Redirection vers la page de connexion après succès
            header('Location: /');
            exit;
        }
    }
}

// On appelle la vue HTML et on lui passe les éventuelles erreurs
render_view('auth/register', ['error' => $error], 'auth');
