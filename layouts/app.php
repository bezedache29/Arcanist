<?php

/**
 * Variables injectées par le helper de vue.
 * @var string $content
 * @var string|null $title
 */

$currentUri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isDashboard = strpos($currentUri, 'dashboard.php') !== false && strpos($currentUri, 'admin') === false;
$isShop      = (strpos($currentUri, 'shop') !== false) && strpos($currentUri, 'cart') === false;
$isOrders    = strpos($currentUri, 'orders') !== false;
$isCart      = strpos($currentUri, 'cart') !== false;
$cartCount   = array_sum($_SESSION['cart'] ?? []);
?>
<!DOCTYPE html>
<html lang="fr" id="main-html">

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
            theme: {
                extend: {
                    backgroundImage: {
                        'glow-light': 'radial-gradient(circle at top, rgba(214, 199, 177, 0.2), rgba(245, 239, 230, 1))',
                        'glow-dark': 'radial-gradient(circle at top, rgba(180, 147, 91, 0.05), transparent 50%)',
                    },
                    colors: {
                        arcane: {
                            900: 'var(--arcane-900)',
                            800: 'var(--arcane-800)',
                            700: 'var(--arcane-700)',
                            500: 'var(--arcane-500)',
                        },
                        mystic: {
                            900: 'var(--mystic-900)',
                            600: 'var(--mystic-600)',
                            500: 'var(--mystic-500)',
                            400: 'var(--mystic-400)',
                            100: 'var(--mystic-100)',
                        },
                    },
                    fontFamily: {
                        grimoire: ['"Playfair Display"', 'serif'],
                        ui: ['"Inter"', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow-mystic': '0 0 15px -3px rgba(196, 166, 97, 0.25)',
                        'glow-arcane': '0 0 20px -5px rgba(140, 58, 58, 0.15)',
                    },
                },
            },
        }
    </script>

    <style>
        :root {
            --arcane-900: #F5EFE6;
            --arcane-800: #E8DFD1;
            --arcane-700: #D6C7B1;
            --arcane-500: #7F1D1D;
            --mystic-900: #1A1614;
            --mystic-600: #8B6F3E;
            --mystic-500: #B4935B;
            --mystic-400: #C5A672;
            --mystic-100: #FFFFFF;
        }

        .dark {
            --arcane-900: #140C0B;
            --arcane-800: #231513;
            --arcane-700: #3D1C19;
            --arcane-500: #7F1D1D;
            --mystic-900: #594A3A;
            --mystic-600: #8B6F3E;
            --mystic-500: #B4935B;
            --mystic-400: #C5A672;
            --mystic-100: #F5EFE6;
        }
    </style>

    <script>
        (function() {
            const dark = localStorage.theme === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.getElementById('main-html').classList.toggle('dark', dark);
        })();
    </script>

    <title><?= htmlspecialchars($title ?? 'Arcanist B2B', ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body class="bg-arcane-900 bg-glow-light dark:bg-glow-dark text-mystic-900 dark:text-mystic-100 font-ui antialiased min-h-screen">

    <nav class="bg-arcane-800/95 backdrop-blur-sm border-b border-arcane-700 sticky top-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">

                <!-- Logo + Liens Desktop -->
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <span class="font-grimoire text-xl text-mystic-500">Arcanist</span>
                    </div>

                    <div class="hidden sm:-my-px sm:ml-8 sm:flex sm:space-x-6">
                        <a href="/pages/dashboard.php" class="<?= $isDashboard ? 'border-mystic-500 text-mystic-500' : 'border-transparent text-mystic-900/50 dark:text-mystic-100/50 hover:border-arcane-700 hover:text-mystic-400' ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                        <a href="/pages/shop.php" class="<?= $isShop ? 'border-mystic-500 text-mystic-500' : 'border-transparent text-mystic-900/50 dark:text-mystic-100/50 hover:border-arcane-700 hover:text-mystic-400' ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                            Catalogue
                        </a>
                        <a href="/pages/orders/orders.php" class="<?= $isOrders ? 'border-mystic-500 text-mystic-500' : 'border-transparent text-mystic-900/50 dark:text-mystic-100/50 hover:border-arcane-700 hover:text-mystic-400' ?> inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium transition-colors">
                            Commandes
                        </a>
                    </div>
                </div>

                <!-- Partie droite : panier + profil desktop + burger mobile -->
                <div class="flex items-center gap-2">

                    <!-- Icône panier Desktop -->
                    <div class="hidden sm:flex sm:items-center">
                        <a href="/pages/cart/cart.php"
                            class="relative flex items-center justify-center h-9 w-9 rounded-full <?= $isCart ? 'text-mystic-500' : 'text-mystic-900/50 dark:text-mystic-100/50 hover:text-mystic-400' ?> hover:bg-arcane-700/40 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <?php if ($cartCount > 0): ?>
                                <span class="absolute -top-0.5 -right-0.5 bg-mystic-500 text-mystic-900 text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center leading-none">
                                    <?= $cartCount > 99 ? '99+' : $cartCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- Dropdown profil Desktop -->
                    <div class="hidden sm:flex sm:items-center">
                        <div class="relative ml-3">
                            <button type="button" onclick="toggleUserMenu()" id="user-menu-button"
                                class="flex items-center gap-2 rounded-full focus:outline-none focus:ring-2 focus:ring-mystic-500 focus:ring-offset-2 dark:focus:ring-offset-arcane-900 transition">
                                <span class="sr-only">Ouvrir le menu utilisateur</span>
                                <div class="h-9 w-9 rounded-full bg-arcane-700 flex items-center justify-center text-mystic-500 border border-arcane-700 hover:border-mystic-500/50 hover:shadow-glow-mystic transition-all">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                            </button>

                            <div id="user-menu" class="hidden absolute right-0 z-10 mt-2 w-52 origin-top-right rounded-xl bg-arcane-800 py-1 shadow-lg border border-arcane-700 focus:outline-none">
                                <button onclick="toggleDarkMode()" class="flex w-full items-center px-4 py-2.5 text-sm text-mystic-900/70 dark:text-mystic-100/70 hover:bg-arcane-700/40 hover:text-mystic-400 transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    Thème clair / sombre
                                </button>
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                    <div class="border-t border-arcane-700 my-1"></div>
                                    <a href="/pages/admin/dashboard.php" class="flex items-center px-4 py-2.5 text-sm text-mystic-500 font-medium hover:bg-arcane-700/40 transition-colors">
                                        <svg class="w-4 h-4 mr-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Administration
                                    </a>
                                <?php endif; ?>
                                <div class="border-t border-arcane-700 my-1"></div>
                                <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="flex w-full items-center px-4 py-2.5 text-sm text-arcane-500 hover:bg-arcane-700/40 transition-colors">
                                    <svg class="w-4 h-4 mr-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Se déconnecter
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Icône panier Mobile -->
                    <div class="flex items-center sm:hidden">
                        <a href="/pages/cart/cart.php"
                            class="relative flex items-center justify-center h-9 w-9 rounded-full <?= $isCart ? 'text-mystic-500' : 'text-mystic-900/50 dark:text-mystic-100/50 hover:text-mystic-400' ?> hover:bg-arcane-700/40 transition-colors mr-1">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                            <?php if ($cartCount > 0): ?>
                                <span class="absolute -top-0.5 -right-0.5 bg-mystic-500 text-mystic-900 text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center leading-none">
                                    <?= $cartCount > 99 ? '99+' : $cartCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </div>

                    <!-- Bouton burger Mobile -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" onclick="const menu=document.getElementById('mobile-menu');menu.classList.toggle('hidden');this.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');"
                            class="inline-flex items-center justify-center rounded-lg p-2 text-mystic-900/40 dark:text-mystic-100/40 hover:bg-arcane-700/40 hover:text-mystic-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-mystic-500 transition-colors"
                            aria-expanded="false" aria-controls="mobile-menu">
                            <span class="sr-only">Ouvrir le menu principal</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="sm:hidden hidden" id="mobile-menu">
            <div class="space-y-1 pb-3 pt-2 border-t border-arcane-700">
                <a href="/pages/dashboard.php" class="<?= $isDashboard ? 'border-mystic-500 text-mystic-500 bg-arcane-700/40' : 'border-transparent text-mystic-900/50 dark:text-mystic-100/50 hover:bg-arcane-700/40 hover:text-mystic-400' ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium transition-colors">
                    Dashboard
                </a>
                <a href="/pages/shop.php" class="<?= $isShop ? 'border-mystic-500 text-mystic-500 bg-arcane-700/40' : 'border-transparent text-mystic-900/50 dark:text-mystic-100/50 hover:bg-arcane-700/40 hover:text-mystic-400' ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium transition-colors">
                    Catalogue
                </a>
                <a href="/pages/orders/orders.php" class="<?= $isOrders ? 'border-mystic-500 text-mystic-500 bg-arcane-700/40' : 'border-transparent text-mystic-900/50 dark:text-mystic-100/50 hover:bg-arcane-700/40 hover:text-mystic-400' ?> block border-l-4 py-2 pl-3 pr-4 text-base font-medium transition-colors">
                    Commandes
                </a>
            </div>
            <div class="border-t border-arcane-700 pb-3 pt-4">
                <div class="flex items-center px-4">
                    <div class="h-10 w-10 rounded-full bg-arcane-700 flex items-center justify-center text-mystic-500 border border-arcane-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-mystic-900/80 dark:text-mystic-100/80">Mon Profil</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <button onclick="toggleDarkMode()" class="block w-full text-left px-4 py-2 text-base font-medium text-mystic-900/50 dark:text-mystic-100/50 hover:bg-arcane-700/40 hover:text-mystic-400 transition-colors">
                        Thème clair / sombre
                    </button>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="/pages/admin/dashboard.php" class="block px-4 py-2 text-base font-medium text-mystic-500 hover:bg-arcane-700/40 transition-colors">
                            Administration
                        </a>
                    <?php endif; ?>
                    <button onclick="document.getElementById('logoutModal').classList.remove('hidden')" class="block w-full text-left px-4 py-2 text-base font-medium text-arcane-500 hover:bg-arcane-700/40 transition-colors">
                        Se déconnecter
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <?= $content ?>
    </main>

    <!-- Modal de déconnexion -->
    <?php render_component('modal', [
        'id'         => 'logoutModal',
        'title'      => 'Déconnexion',
        'body'       => 'Êtes-vous sûr de vouloir vous déconnecter de votre espace professionnel ?',
        'actionText' => 'Me déconnecter',
        'actionUrl'  => '/pages/logout.php',
        'theme'      => 'danger'
    ]); ?>

    <script>
        function toggleDarkMode() {
            const isDark = document.getElementById('main-html').classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
        }

        function toggleUserMenu() {
            document.getElementById('user-menu').classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const button = document.getElementById('user-menu-button');
            const menu = document.getElementById('user-menu');
            if (button && menu && !button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

</body>

</html>