<?php

/**
 * Variables injectees par le helper de vue.
 * @var string $content
 * @var string|null $title
 */
?>
<!DOCTYPE html>
<html lang="fr" id="main-html">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Authentification — Arcanist' ?></title>

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
        // Application du thème avant le premier rendu pour éviter le flash
        (function () {
            const dark = localStorage.theme === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.getElementById('main-html').classList.toggle('dark', dark);
        })();
    </script>
</head>

<body class="bg-arcane-900 bg-glow-light dark:bg-glow-dark text-mystic-900 dark:text-mystic-100 font-ui antialiased flex items-start justify-center min-h-screen py-12 px-4 relative">

    <!-- Bouton bascule de thème -->
    <button id="theme-toggle" type="button" aria-label="Basculer le thème"
        class="absolute top-4 right-4 p-2 rounded-lg bg-arcane-800/80 border border-arcane-700 hover:border-mystic-500/50 text-mystic-900/40 dark:text-mystic-100/50 hover:text-mystic-400 transition-all">
        <svg id="icon-moon" class="h-5 w-5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
        </svg>
        <svg id="icon-sun" class="h-5 w-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
        </svg>
    </button>

    <div class="w-full max-w-md">
        <?= $content ?>
    </div>

    <script>
        const html   = document.getElementById('main-html');
        const btnToggle = document.getElementById('theme-toggle');

        btnToggle.addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
        });
    </script>
</body>

</html>
