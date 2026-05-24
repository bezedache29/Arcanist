<?php

/**
 * Variables injectees par le helper de vue.
 * @var string $content
 * @var string|null $title
 */

$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$isDashboard = strpos($currentUri, 'dashboard.php') !== false;
$isShop = strpos($currentUri, 'shop.php') !== false;
?>
<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
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

    <nav class="bg-white dark:bg-slate-900 shadow-sm border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">

                <!-- Partie Gauche : Logo + Liens Desktop -->
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <span class="text-xl font-bold text-blue-600 dark:text-blue-400">Arcanist</span>
                    </div>

                    <!-- Liens Desktop (Caches sur mobile) -->
                    <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/pages/dashboard.php" class="<?= $isDashboard ? 'border-blue-500 dark:text-white' : 'border-transparent text-slate-500 dark:text-slate-400 hover:border-slate-300 hover:text-slate-700 dark:hover:text-slate-300' ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                        <a href="/pages/shop.php" class="<?= $isShop ? 'border-blue-500 text-slate-900 dark:text-white' : 'border-transparent dark:text-slate-400 hover:border-slate-300 hover:text-slate-700 dark:hover:text-slate-300' ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                            Catalogue
                        </a>
                    </div>
                </div>

                <!-- Partie Droite : Dropdown Profil Desktop + Bouton Burger Mobile -->
                <div class="flex items-center">

                    <!-- Dropdown Utilisateur Desktop (Cache sur mobile) -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="relative ml-3">
                            <div>
                                <button type="button" onclick="toggleUserMenu()" id="user-menu-button" class="flex items-center gap-2 rounded-full bg-white dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition">
                                    <span class="sr-only">Ouvrir le menu utilisateur</span>
                                    <div class="h-9 w-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:ring-2 hover:ring-blue-500 transition-all">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div id="user-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-slate-800 py-1 shadow-lg ring-1 ring-black/5 dark:ring-white/10 focus:outline-none transition-all">
                                <button onclick="toggleDarkMode()" class="flex w-full items-center px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    Thème clair / sombre
                                </button>
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                    <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                                    <a href="/pages/admin/dashboard.php" class="flex px-4 py-2 text-sm text-blue-600 dark:text-blue-400 font-medium hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Administration
                                    </a>
                                <?php endif; ?>
                                <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                                <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="flex w-full items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Se déconnecter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- LE BOUTON BURGER (Visible uniquement sur mobile) -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="inline-flex items-center justify-center rounded-md p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-500 dark:hover:bg-slate-800 dark:hover:text-slate-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors" aria-expanded="false">
                            <span class="sr-only">Ouvrir le menu principal</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Le Menu Mobile qui s'ouvre au clic -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="space-y-1 pb-3 pt-2">
                <a href="/pages/dashboard.php" class="<?= $isDashboard ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-500 text-blue-700 dark:text-blue-400' : 'border-transparent dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600' ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium transition-colors">
                    Dashboard
                </a>
                <a href="/pages/shop.php" class="<?= $isShop ? 'bg-blue-50 dark:bg-blue-900/50 border-blue-500 text-blue-700 dark:text-blue-400' : 'border-transparent dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:border-slate-300 dark:hover:border-slate-600' ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium transition-colors">
                    Catalogue
                </a>
            </div>
            <div class="border-t border-slate-200 dark:border-slate-700 pb-3 pt-4">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-slate-800 dark:text-slate-200">Mon Profil</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <button onclick="toggleDarkMode()" class="block w-full text-left px-4 py-2 text-base font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                        Thème clair / sombre
                    </button>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="/pages/admin/dashboard.php" class="block px-4 py-2 text-base font-medium text-purple-600 dark:text-purple-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            Administration
                        </a>
                    <?php endif; ?>
                    <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 dark:text-red-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <?= $content ?>
    </main>

    <!-- Modal de deconnexion -->
    <?php render_component('modal', [
        'id' => 'logoutModal',
        'title' => 'Déconnexion',
        'body' => 'Êtes-vous sûr de vouloir vous déconnecter de votre espace professionnel ?',
        'actionText' => 'Me déconnecter',
        'actionUrl' => '/pages/logout.php',
        'theme' => 'danger'
    ]); ?>

    <script>
        // Ouvrir/Fermer le menu au clic sur l'avatar
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        }

        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(event) {
            const button = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');

            // Si le clic n'est ni sur le bouton, ni dans le menu, on cache le menu
            if (button && menu && !button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

</body>

</html>