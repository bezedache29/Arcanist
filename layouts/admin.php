<?php

/**
 * @var string $content
 * @var string|null $title
 */
$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
    <title><?= $title ?? 'Administration - Arcanist' ?></title>
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-200">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        <aside class="w-64 flex-shrink-0 bg-slate-900 dark:bg-slate-950 text-slate-300 flex flex-col transition-colors">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="text-white text-lg font-bold">Arcanist Admin</span>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="/pages/admin/dashboard.php" class="<?= strpos($currentUri, 'dashboard.php') !== false ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' ?> flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors mb-4">
                    <svg class="mr-3 h-5 w-5 flex-shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Vue d'ensemble
                </a>

                <p class="px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Catalogue</p>
                <a href="/pages/admin/categories/categories.php" class="<?= strpos($currentUri, 'categories') !== false ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' ?> flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors">
                    Catégories
                </a>
                <a href="/pages/admin/products/products.php" class="<?= strpos($currentUri, 'products') !== false ? 'bg-slate-800 text-white' : 'hover:bg-slate-800 hover:text-white' ?> flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors">
                    Produits
                </a>

                <p class="px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-8 mb-2">Ventes</p>
                <a href="#" class="hover:bg-slate-800 hover:text-white flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors opacity-50 cursor-not-allowed">
                    Commandes
                </a>
                <a href="#" class="hover:bg-slate-800 hover:text-white flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors opacity-50 cursor-not-allowed">
                    Clients
                </a>
            </nav>

            <!-- Bas de la sidebar (Bouton retour et Dark Mode) -->
            <div class="p-4 border-t border-slate-800 space-y-2">
                <button onclick="toggleDarkMode()" class="w-full flex items-center justify-center px-2 py-2 text-sm font-medium rounded-md hover:bg-slate-800 hover:text-white transition-colors">
                    Basculer le thème
                </button>
                <a href="/pages/dashboard.php" class="w-full flex items-center justify-center px-2 py-2 text-sm font-medium rounded-md bg-blue-600 text-white hover:bg-blue-500 transition-colors">
                    &larr; Retour au site
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-8 px-8 max-w-7xl mx-auto">
                <?= $content ?>
            </div>
        </main>

    </div>

</body>

</html>