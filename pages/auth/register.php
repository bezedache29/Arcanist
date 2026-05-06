<?php
require_once __DIR__ . '/../../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validation du jeton CSRF
    $csrfToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    if (empty($csrfToken) || !hash_equals($sessionToken, $csrfToken)) {
        $error = "Jeton de sécurité invalide ou expiré. Veuillez réessayer.";
    } else {
        // Le jeton est valide, on le supprime pour éviter la réutilisation
        unset($_SESSION['csrf_token']);

        // 2. Reste de ta logique de validation
        $company = $_POST['company_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (empty($company) || empty($email) || empty($password)) {
            $error = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email n'est pas valide.";
        } elseif (strlen($password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères.";
        } elseif ($password !== $passwordConfirm) {
            $error = "Les mots de passe ne correspondent pas.";
        } else {
            $pdo = getDbConnection();

            $stmt = $pdo->prepare('SELECT id FROM clients WHERE email = ? AND deleted_at IS NULL');
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
}

// 3. Génération du jeton CSRF pour l'affichage du formulaire
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// On appelle la vue HTML et on lui passe les erreurs et le jeton
render_view('auth/register', [
    'error' => $error,
], 'auth');
