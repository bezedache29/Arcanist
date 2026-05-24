<?php
if (getenv('APP_DEBUG')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

// Redirection si déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: /pages/dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $pdo = getDbConnection();
    // Exclusion des comptes supprimés (soft delete)
    $stmt = $pdo->prepare('SELECT * FROM clients WHERE email = ? AND deleted_at IS NULL');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['company'] = $user['company_name'];

        header('Location: /pages/dashboard.php');
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}

render_view('auth/login', ['error' => $error], 'auth');
