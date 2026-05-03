<?php
// pages/dashboard.php
require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/db.php');
require_alias('@/helpers/view.php');

session_start();

// Le videur
if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}

// On appelle la vue (le layout 'app' sera chargé automatiquement par le helper)
render_view('dashboard/index');
