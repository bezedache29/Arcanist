<?php
require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/view.php');
require_alias('@/helpers/db.php');

session_start();

// Gestion du POST et validation du token CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Rejet et arret si le token est invalide
        die('Erreur CSRF : Jeton de securite invalide.');
    }

    // Le traitement du POST se ferait ici en temps normal
    // Pour le styleguide, on redirige simplement apres validation
    header('Location: /pages/styleguide.php');
    exit;
}

// Generation d'un nouveau token pour les requetes GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// On passe le token a la vue pour l'injecter dans les modales
render_view('styleguide', [
    'csrfToken' => $_SESSION['csrf_token']
], null);
