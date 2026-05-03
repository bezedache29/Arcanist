<?php
// bootstrap.php

// 1. On définit la racine du projet comme constante globale
define('ROOT_PATH', __DIR__);

// 2. Fonction utilitaire pour simuler l'alias @/
function require_alias($path)
{
    // Si le chemin commence par @/
    if (strpos($path, '@/') === 0) {
        // On remplace @/ par le chemin physique de la racine
        $realPath = str_replace('@/', ROOT_PATH . '/', $path);
        require_once $realPath;
    } else {
        // Fallback classique
        require_once $path;
    }
}

require_alias('@/helpers/debug.php');
