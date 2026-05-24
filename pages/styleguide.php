<?php
require_once __DIR__ . '/../bootstrap.php';
require_alias('@/helpers/view.php');

session_start();

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: /pages/index.php');
    exit;
}

render_view('styleguide', [], null);