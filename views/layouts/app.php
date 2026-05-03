<?php

/**
 * Variables injectees par le helper de vue.
 * @var string $content
 * @var string|null $title
 */

// On recupere l'URL courante pour savoir quelle section illuminer
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$isDashboard = strpos($currentUri, 'dashboard.php') !== false;
$isShop = strpos($currentUri, 'shop.php') !== false;
?>
<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
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

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>

    <title><?= htmlspecialchars($title ?? 'Arcanist B2B', ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-200 min-h-screen">

    <nav class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">

                <div class="flex items-center space-x-8">
                    <span class="text-2xl font-black text-blue-600 dark:text-blue-500">Arcanist</span>

                    <!-- Menu Bureau -->
                    <div class="hidden sm:flex space-x-4">
                        <!-- Lien Dashboard dynamique -->
                        <a href="/pages/dashboard.php" class="<?= $isDashboard ? 'text-blue-600 dark:text-blue-400 font-bold border-b-2 border-blue-600 dark:border-blue-400' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium' ?> transition pb-1">
                            Dashboard
                        </a>
                        <!-- Lien Catalogue dynamique -->
                        <a href="/pages/shop.php" class="<?= $isShop ? 'text-blue-600 dark:text-blue-400 font-bold border-b-2 border-blue-600 dark:border-blue-400' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium' ?> transition pb-1">
                            Catalogue
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button onclick="toggleDarkMode()" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full transition">
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </button>

                    <div class="hidden sm:block">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="text-sm font-bold text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-500 transition">Se déconnecter</button>
                        <?php else: ?>
                            <a href="/" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline transition">Se connecter</a>
                        <?php endif; ?>
                    </div>

                    <div class="sm:hidden flex items-center">
                        <button onclick="toggleMobileMenu()" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Mobile deroulant -->
        <div id="mobileMenu" class="hidden sm:hidden border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/pages/dashboard.php" class="block px-3 py-2 rounded-md text-base transition <?= $isDashboard ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700' ?>">Dashboard</a>
                <a href="/pages/shop.php" class="block px-3 py-2 rounded-md text-base transition <?= $isShop ? 'font-bold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : 'font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700' ?>">Catalogue</a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <button onclick="document.getElementById('logoutModal').classList.remove('hidden'); toggleMobileMenu();" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 dark:text-red-500 hover:bg-slate-50 dark:hover:bg-slate-700 transition mt-2 border-t border-slate-100 dark:border-slate-700">Se déconnecter</button>
                <?php else: ?>
                    <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 dark:text-blue-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition mt-2 border-t border-slate-100 dark:border-slate-700">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <?= $content ?>
    </main>

    <!-- Modal de deconnexion generee via notre composant -->
    <?php render_component('modal', [
        'id' => 'logoutModal',
        'title' => 'Déconnexion',
        'body' => 'Êtes-vous sûr de vouloir vous déconnecter de votre espace professionnel ?',
        'actionText' => 'Me déconnecter',
        'actionUrl' => '/pages/logout.php',
        'theme' => 'danger'
    ]); ?>

</body>

</html>