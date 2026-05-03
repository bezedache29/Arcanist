<?php
// helpers/view.php

function render_view(string $viewPath, array $data = [], ?string $layout = 'app')
{
    // On extrait les variables pour la vue
    extract($data, EXTR_SKIP);

    // 1. On lance l'enregistrement (mise en mémoire tampon)
    ob_start();

    // On lit la vue (ex: le dashboard)
    $realPath = str_replace('@/', ROOT_PATH . '/', '@/views/' . $viewPath . '.php');
    if (file_exists($realPath)) {
        require $realPath;
    } else {
        error_log("Vue introuvable: $realPath");
        die("Erreur : La vue demandée n'existe pas.");
    }

    // 2. On coupe l'enregistrement et on crée la fameuse variable $content
    $content = ob_get_clean();

    // 3. On ouvre ton app.php, qui va maintenant trouver $content sans broncher
    if ($layout) {
        $layoutPath = str_replace('@/', ROOT_PATH . '/', '@/views/layouts/' . $layout . '.php');
        if (file_exists($layoutPath)) {
            require $layoutPath;
        } else {
            echo $content;
        }
    } else {
        echo $content;
    }
}

function render_component(string $componentPath, array $data = [])
{
    // Transforme le tableau en variables exploitables par le composant
    extract($data, EXTR_SKIP);

    // Cherche le composant dans un nouveau dossier views/components/
    $realPath = str_replace('@/', ROOT_PATH . '/', '@/components/' . $componentPath . '.php');

    if (file_exists($realPath)) {
        require $realPath;
    } else {
        echo "<!-- Erreur : Composant $componentPath introuvable -->";
    }
}
