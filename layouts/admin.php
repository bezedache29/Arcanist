<?php

/**
 * @var string $content
 * @var string|null $title
 */
$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$navLink = function (string $href, string $label, bool $active, string $icon = '') use ($currentUri): string {
    $base   = 'flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors';
    $state  = $active
        ? 'bg-arcane-700/50 text-mystic-400 border-l-2 border-mystic-500 pl-[10px]'
        : 'text-mystic-100/50 hover:bg-arcane-700/30 hover:text-mystic-400 border-l-2 border-transparent pl-[10px]';
    return '<a href="' . $href . '" class="' . $base . ' ' . $state . '">' . $icon . $label . '</a>';
};

$isDashboard  = strpos($currentUri, 'dashboard.php') !== false;
$isCategories = strpos($currentUri, 'categories') !== false;
$isProducts   = strpos($currentUri, 'products') !== false;
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
                        'glow-dark':  'radial-gradient(circle at top, rgba(180, 147, 91, 0.05), transparent 50%)',
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
                        ui:       ['"Inter"', 'sans-serif'],
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
        (function () {
            const dark = localStorage.theme === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.getElementById('main-html').classList.toggle('dark', dark);
        })();
    </script>

    <title><?= htmlspecialchars($title ?? 'Administration — Arcanist', ENT_QUOTES, 'UTF-8') ?></title>
</head>

<body class="bg-arcane-900 bg-glow-light dark:bg-glow-dark text-mystic-900 dark:text-mystic-100 font-ui antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar — toujours sombre via la classe dark forcée -->
        <aside class="dark w-64 flex-shrink-0 bg-arcane-900 text-mystic-100 flex flex-col border-r border-arcane-700">

            <div class="h-16 flex items-center px-6 border-b border-arcane-700 gap-2">
                <span class="font-grimoire text-xl text-mystic-500">Arcanist</span>
                <span class="text-[10px] font-bold uppercase tracking-widest text-mystic-100/25 mt-1">Admin</span>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">

                <?= $navLink('/pages/admin/dashboard.php', "Vue d'ensemble", $isDashboard, '<svg class="h-4 w-4 flex-shrink-0 opacity-60" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>') ?>

                <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-100/25 px-3 pt-6 pb-2">Catalogue</p>

                <?= $navLink('/pages/admin/categories/categories.php', 'Catégories', $isCategories, '<svg class="h-4 w-4 flex-shrink-0 opacity-60" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>') ?>

                <?= $navLink('/pages/admin/products/products.php', 'Produits', $isProducts, '<svg class="h-4 w-4 flex-shrink-0 opacity-60" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>') ?>

                <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-100/25 px-3 pt-6 pb-2">Ventes</p>

                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg border-l-2 border-transparent pl-[10px] text-mystic-100/25 cursor-not-allowed">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" /></svg>
                    Commandes
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg border-l-2 border-transparent pl-[10px] text-mystic-100/25 cursor-not-allowed">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    Clients
                </a>

            </nav>

            <div class="p-4 border-t border-arcane-700 space-y-2">
                <button onclick="toggleDarkMode()" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium rounded-lg text-mystic-100/50 hover:bg-arcane-700/30 hover:text-mystic-400 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    Basculer le thème
                </button>
                <a href="/pages/dashboard.php" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium rounded-lg bg-arcane-700/40 text-mystic-400 border border-arcane-700 hover:border-mystic-500/40 hover:text-mystic-500 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour au site
                </a>
            </div>

        </aside>

        <!-- Contenu principal -->
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-8 px-8 max-w-7xl mx-auto">
                <?= $content ?>
            </div>
        </main>

    </div>

    <script>
        function toggleDarkMode() {
            const isDark = document.getElementById('main-html').classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
        }
    </script>

</body>

</html>
