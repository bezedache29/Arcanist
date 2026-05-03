<?php
if (!function_exists('dd')) {
    function dd(...$vars)
    {
        echo '<div style="background-color: #1e1e1e; color: #10b981; padding: 20px; border-radius: 8px; font-family: monospace; z-index: 9999; position: relative; text-align: left; margin: 20px; overflow-x: auto;">';
        foreach ($vars as $var) {
            echo '<pre style="margin-bottom: 10px;">';
            var_dump($var);
            echo '</pre>';
        }
        echo '</div>';
        die(1);
    }
}
