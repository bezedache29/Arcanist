<?php

function render_view(string $viewPath, array $data = [], ?string $layout = 'app')
{
    // On extrait les variables pour la vue
    extract($data, EXTR_SKIP);

    ob_start();

    $realPath = str_replace('@/', ROOT_PATH . '/', '@/views/' . $viewPath . '.php');
    if (file_exists($realPath)) {
        require $realPath;
    } else {
        error_log("Vue introuvable: $realPath");
        die("Erreur : La vue demandée n'existe pas.");
    }

    $content = ob_get_clean();

    if ($layout) {
        $layoutPath = str_replace('@/', ROOT_PATH . '/', '@/layouts/' . $layout . '.php');
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
    extract($data, EXTR_SKIP);

    $realPath = str_replace('@/', ROOT_PATH . '/', '@/components/' . $componentPath . '.php');

    if (file_exists($realPath)) {
        require $realPath;
    } else {
        echo "<!-- Erreur : Composant $componentPath introuvable -->";
    }
}
