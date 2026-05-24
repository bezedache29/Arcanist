<?php

/** `@var` string $csrfToken Jeton CSRF pour les formulaires POST */
$csrfToken = $csrfToken ?? '';

// Closures utilitaires pour la documentation
$propsTable = function (array $rows) {
?>
    <div class="overflow-x-auto rounded-xl border border-arcane-700 mb-6">
        <table class="w-full text-sm font-ui">
            <thead>
                <tr class="bg-arcane-800/60 border-b border-arcane-700">
                    <?php foreach (['Prop', 'Type', 'Défaut', 'Description'] as $h): ?>
                        <th class="text-left px-4 py-3 text-[10px] font-bold uppercase tracking-widest text-mystic-100/30"><?= $h ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $i => [$name, $type, $default, $desc]): ?>
                    <tr class="border-b border-arcane-700/30 <?= $i % 2 !== 0 ? 'bg-arcane-800/20' : '' ?>">
                        <td class="px-4 py-2.5 font-mono text-xs text-mystic-400"><?= htmlspecialchars($name) ?></td>
                        <td class="px-4 py-2.5 font-mono text-xs text-sky-400"><?= htmlspecialchars($type) ?></td>
                        <td class="px-4 py-2.5 font-mono text-xs text-mystic-600"><?= htmlspecialchars($default) ?></td>
                        <td class="px-4 py-2.5 text-xs text-mystic-100/60"><?= htmlspecialchars($desc) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
};

$codeBlock = function (string $code) {
?>
    <pre class="bg-arcane-900 rounded-xl border border-arcane-700 p-5 text-xs font-mono text-mystic-400/90 overflow-x-auto leading-relaxed mb-8"><code><?= htmlspecialchars($code) ?></code></pre>
<?php
};
?>
<!DOCTYPE html>
<html lang="fr" id="main-html">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design System — Arcanist</title>

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
        /* Palette — variables CSS adaptées au thème */
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

        /* Liens de navigation sidebar */
        .nav-link {
            display: block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            color: rgba(26, 22, 20, 0.45);
            transition: color 150ms, background-color 150ms;
            text-decoration: none;
        }

        .dark .nav-link {
            color: rgba(245, 239, 230, 0.4);
        }

        .nav-link:hover {
            color: var(--mystic-400);
            background-color: rgba(180, 147, 91, 0.07);
        }

        .nav-link.active {
            color: var(--mystic-500);
            background-color: rgba(180, 147, 91, 0.12);
            font-weight: 600;
        }

        /* Sections de composants */
        .ds-section {
            scroll-margin-top: 6rem;
            border-top: 1px solid rgba(214, 199, 177, 0.2);
            padding-top: 4rem;
        }

        .dark .ds-section {
            border-top-color: rgba(61, 28, 25, 0.5);
        }

        /* Boîte de démonstration visuelle */
        .demo-box {
            border-radius: 1rem;
            background-color: var(--arcane-800);
            border: 1px solid var(--arcane-700);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        /* Label de sous-section */
        .label-meta {
            display: block;
            font-size: 0.625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(26, 22, 20, 0.35);
            margin-bottom: 0.75rem;
        }

        .dark .label-meta {
            color: rgba(245, 239, 230, 0.3);
        }
    </style>
</head>

<body class="bg-arcane-900 bg-glow-light dark:bg-glow-dark text-mystic-900 dark:text-mystic-100 font-ui antialiased">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-mystic-500 focus:text-mystic-900 focus:rounded-lg">Aller au contenu</a>

    <!-- En-tête fixe -->
    <header class="fixed top-0 left-0 right-0 z-50 h-16 bg-arcane-800/95 backdrop-blur-sm border-b border-arcane-700 flex items-center px-6 justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="font-grimoire text-xl text-mystic-500">Arcanist</span>
            <span class="text-arcane-700 select-none">|</span>
            <span class="text-sm text-mystic-100/40">Design System</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="hidden sm:inline font-mono text-[11px] text-mystic-100/20 bg-arcane-900/60 px-2.5 py-1 rounded-full border border-arcane-700">v1.0.0</span>
            <button id="theme-toggle" type="button" aria-label="Basculer le thème"
                class="p-2 rounded-lg bg-arcane-700/40 border border-arcane-700 hover:border-mystic-500/50 text-mystic-100/50 hover:text-mystic-400 transition-all">
                <svg id="icon-dark" class="hidden h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
                <svg id="icon-light" class="hidden h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </header>

    <div class="flex">

        <!-- Sidebar de navigation -->
        <aside class="fixed top-16 left-0 bottom-0 w-56 bg-arcane-800/40 border-r border-arcane-700 overflow-y-auto hidden lg:block">
            <nav class="p-5 pt-8 space-y-7">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-100/20 mb-2 px-3">Fondations</p>
                    <ul class="space-y-0.5">
                        <li><a href="#couleurs" class="nav-link">Couleurs</a></li>
                        <li><a href="#typographie" class="nav-link">Typographie</a></li>
                        <li><a href="#ombres" class="nav-link">Ombres & Glow</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-100/20 mb-2 px-3">Composants</p>
                    <ul class="space-y-0.5">
                        <li><a href="#button" class="nav-link">Button</a></li>
                        <li>
                            <a href="#badge" class="nav-link flex items-center gap-2">
                                Badge
                                <span class="text-[9px] bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 px-1.5 py-0.5 rounded-full uppercase tracking-wide leading-none">new</span>
                            </a>
                        </li>
                        <li>
                            <a href="#alert" class="nav-link flex items-center gap-2">
                                Alert
                                <span class="text-[9px] bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20 px-1.5 py-0.5 rounded-full uppercase tracking-wide leading-none">new</span>
                            </a>
                        </li>
                        <li><a href="#input" class="nav-link">Input</a></li>
                        <li><a href="#textarea" class="nav-link">Textarea</a></li>
                        <li><a href="#title" class="nav-link">Title</a></li>
                        <li><a href="#card" class="nav-link">Card</a></li>
                        <li><a href="#modal" class="nav-link">Modal</a></li>
                    </ul>
                </div>
                <div class="px-3 pt-4 border-t border-arcane-700/50">
                    <p class="text-[10px] text-mystic-100/20 leading-relaxed">8 composants · 2 nouveaux</p>
                </div>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main id="main-content" class="lg:ml-56 flex-1 min-h-screen mt-16">
            <div class="max-w-4xl mx-auto px-6 lg:px-12 py-14 space-y-0">

                <!-- Introduction -->
                <div class="pb-16">
                    <?php render_component('title', ['text' => 'Design System', 'level' => 1]); ?>
                    <p class="mt-5 text-mystic-900/70 dark:text-mystic-100/50 max-w-xl leading-relaxed">
                        Bibliothèque de composants et de jetons de design pour Arcanist B2B.
                        Chaque composant est rendu via
                        <code class="font-mono text-mystic-400 bg-arcane-800 border border-arcane-700 px-1.5 py-0.5 rounded text-sm">render_component('nom', $props)</code>.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <?php render_component('badge', ['text' => '8 composants', 'variant' => 'default']); ?>
                        <?php render_component('badge', ['text' => 'PHP 8.2',       'variant' => 'info']); ?>
                        <?php render_component('badge', ['text' => 'Tailwind CSS',  'variant' => 'mystic']); ?>
                        <?php render_component('badge', ['text' => 'Dark Mode',     'variant' => 'success']); ?>
                    </div>
                </div>

                <!-- =========================================
                     FONDATIONS — COULEURS
                ========================================= -->
                <section id="couleurs" class="ds-section">
                    <?php render_component('title', ['text' => 'Couleurs', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl leading-relaxed">
                        Deux familles de jetons. Les valeurs changent entre les modes clair et sombre via des variables CSS. Bascule le thème pour visualiser les deux états.
                    </p>

                    <p class="label-meta">Famille arcane — Fonds, cartes, bordures</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                        <?php
                        $arcaneSwatches = [
                            ['arcane-900', '#F5EFE6', '#140C0B', 'Fond principal'],
                            ['arcane-800', '#E8DFD1', '#231513', 'Fond des cartes'],
                            ['arcane-700', '#D6C7B1', '#3D1C19', 'Bordures, hover'],
                            ['arcane-500', '#7F1D1D', '#7F1D1D', 'Danger, accents'],
                        ];
                        foreach ($arcaneSwatches as [$token, $light, $dark, $role]): ?>
                            <div>
                                <div class="flex h-14 rounded-xl overflow-hidden border border-arcane-700/50 mb-2 shadow-sm">
                                    <div class="flex-1" style="background:<?= $light ?>;" title="Mode clair"></div>
                                    <div class="flex-1" style="background:<?= $dark ?>;" title="Mode sombre"></div>
                                </div>
                                <p class="font-mono text-xs font-semibold text-mystic-400"><?= $token ?></p>
                                <p class="text-[10px] text-mystic-100/30 font-mono">☀ <?= $light ?> / ☾ <?= $dark ?></p>
                                <p class="text-[10px] text-mystic-100/40 mt-0.5"><?= $role ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <p class="label-meta">Famille mystic — Or, accents, texte</p>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                        <?php
                        $mysticSwatches = [
                            ['mystic-900', '#1A1614', '#594A3A', 'Texte principal'],
                            ['mystic-600', '#8B6F3E', '#8B6F3E', 'Accents secondaires'],
                            ['mystic-500', '#B4935B', '#B4935B', 'Boutons, prix'],
                            ['mystic-400', '#C5A672', '#C5A672', 'Hover, titres h3'],
                            ['mystic-100', '#FFFFFF', '#F5EFE6', 'Texte sur fond sombre'],
                        ];
                        foreach ($mysticSwatches as [$token, $light, $dark, $role]): ?>
                            <div>
                                <div class="flex h-14 rounded-xl overflow-hidden border border-arcane-700/50 mb-2 shadow-sm">
                                    <div class="flex-1" style="background:<?= $light ?>;" title="Mode clair"></div>
                                    <div class="flex-1" style="background:<?= $dark ?>;" title="Mode sombre"></div>
                                </div>
                                <p class="font-mono text-xs font-semibold text-mystic-400"><?= $token ?></p>
                                <p class="text-[10px] text-mystic-100/30 font-mono">☀ <?= $light ?></p>
                                <?php if ($light !== $dark): ?>
                                    <p class="text-[10px] text-mystic-100/30 font-mono">☾ <?= $dark ?></p>
                                <?php endif; ?>
                                <p class="text-[10px] text-mystic-100/40 mt-0.5"><?= $role ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- =========================================
                     FONDATIONS — TYPOGRAPHIE
                ========================================= -->
                <section id="typographie" class="ds-section">
                    <?php render_component('title', ['text' => 'Typographie', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 leading-relaxed">
                        Deux polices — <strong class="font-grimoire text-mystic-500">Playfair Display</strong> (grimoire) pour les titres,
                        <strong class="font-ui font-semibold text-mystic-500">Inter</strong> (ui) pour l'interface.
                    </p>

                    <div class="demo-box space-y-6">
                        <?php for ($lvl = 1; $lvl <= 3; $lvl++): ?>
                            <div class="flex items-baseline gap-4 <?= $lvl < 3 ? 'pb-6 border-b border-arcane-700/50' : '' ?>">
                                <span class="w-6 flex-shrink-0 font-mono text-[10px] text-mystic-100/25 text-right">H<?= $lvl ?></span>
                                <?php render_component('title', ['text' => 'Titre de niveau ' . $lvl . ' — Grimoire', 'level' => $lvl]); ?>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="demo-box space-y-4">
                        <div>
                            <p class="label-meta">Corps de texte — font-ui</p>
                            <p class="text-base leading-relaxed text-mystic-900/80 dark:text-mystic-100/80">
                                Texte courant pour les descriptions produit, les contenus B2B et les interfaces de gestion. Lisible à toutes les tailles sur fonds clairs et sombres.
                            </p>
                        </div>
                        <div class="border-t border-arcane-700/40 pt-4">
                            <p class="label-meta">Label — uppercase tracking-widest</p>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-100/40">Référence produit · Prix unitaire HT · Stock disponible</p>
                        </div>
                        <div class="border-t border-arcane-700/40 pt-4">
                            <p class="label-meta">Monospace — font-mono</p>
                            <p class="font-mono text-sm text-mystic-400 bg-arcane-900/60 px-3 py-2 rounded-lg border border-arcane-700/50 inline-block">render_component('button', ['variant' => 'primary'])</p>
                        </div>
                    </div>
                </section>

                <!-- =========================================
                     FONDATIONS — OMBRES
                ========================================= -->
                <section id="ombres" class="ds-section">
                    <?php render_component('title', ['text' => 'Ombres & Glow', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50">
                        Deux effets de lueur personnalisés, plus les utilitaires Tailwind standard.
                    </p>

                    <div class="demo-box grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <?php
                        $shadows = [
                            ['shadow-glow-mystic', 'Lueur or — boutons primaires, cartes survol'],
                            ['shadow-glow-arcane', 'Lueur rouge — danger, alertes'],
                            ['shadow-lg',          'Ombre Tailwind standard'],
                        ];
                        foreach ($shadows as [$cls, $desc]): ?>
                            <div class="flex flex-col gap-3">
                                <div class="h-20 rounded-xl bg-arcane-900 border border-arcane-700 <?= $cls ?>"></div>
                                <div>
                                    <p class="font-mono text-xs text-mystic-400"><?= $cls ?></p>
                                    <p class="text-[11px] text-mystic-100/40 mt-0.5"><?= $desc ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- =========================================
                     COMPOSANT — BUTTON
                ========================================= -->
                <section id="button" class="ds-section">
                    <?php render_component('title', ['text' => 'Button', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Rendu en <code class="font-mono text-mystic-400 bg-arcane-800 border border-arcane-700 px-1 rounded">&lt;button&gt;</code> ou
                        <code class="font-mono text-mystic-400 bg-arcane-800 border border-arcane-700 px-1 rounded">&lt;a&gt;</code> selon le prop <code class="font-mono text-mystic-400 bg-arcane-800 border border-arcane-700 px-1 rounded">type</code>.
                    </p>

                    <p class="label-meta">Variantes</p>
                    <div class="demo-box flex flex-wrap gap-4 mb-4">
                        <?php foreach (['primary', 'secondary', 'outline', 'ghost', 'danger'] as $v): ?>
                            <?php render_component('button', ['label' => ucfirst($v), 'variant' => $v]); ?>
                        <?php endforeach; ?>
                    </div>

                    <p class="label-meta">Tailles</p>
                    <div class="demo-box flex flex-wrap items-center gap-4 mb-4">
                        <?php foreach (['sm' => 'Petite (sm)', 'md' => 'Moyenne (md)', 'lg' => 'Grande (lg)'] as $s => $lbl): ?>
                            <?php render_component('button', ['label' => $lbl, 'variant' => 'primary', 'size' => $s]); ?>
                        <?php endforeach; ?>
                    </div>

                    <p class="label-meta">État désactivé</p>
                    <div class="demo-box flex flex-wrap gap-4 mb-6">
                        <?php foreach (['primary', 'secondary', 'danger'] as $v): ?>
                            <?php render_component('button', ['label' => ucfirst($v), 'variant' => $v, 'disabled' => true]); ?>
                        <?php endforeach; ?>
                    </div>

                    <?php $propsTable([
                        ['label',     'string',  "'Bouton'",  'Texte affiché dans le bouton'],
                        ['type',      'string',  "'button'",  "Élément HTML : 'button' ou 'a'"],
                        ['variant',   'string',  "'primary'", "primary · secondary · outline · ghost · danger"],
                        ['size',      'string',  "'md'",      "sm · md · lg"],
                        ['attrType',  'string',  "'button'",  "Attribut type HTML : button · submit · reset"],
                        ['href',      'string',  'null',      "URL cible (requis si type = 'a')"],
                        ['onclick',   'string',  "''",        'Code JavaScript inline'],
                        ['disabled',  'bool',    'false',     'Désactive visuellement et fonctionnellement'],
                        ['extraClass', 'string',  "''",        'Classes Tailwind supplémentaires'],
                    ]); ?>

                    <?php $codeBlock("render_component('button', [\n    'label'   => 'Commander',\n    'variant' => 'primary',\n    'size'    => 'md',\n]);\n\n// Lien stylé en bouton\nrender_component('button', [\n    'type'  => 'a',\n    'href'  => '/pages/shop.php',\n    'label' => 'Voir le catalogue',\n    'variant' => 'outline',\n]);\n\n// Soumission de formulaire désactivée\nrender_component('button', [\n    'label'    => 'Enregistrer',\n    'attrType' => 'submit',\n    'variant'  => 'primary',\n    'disabled' => true,\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — BADGE
                ========================================= -->
                <section id="badge" class="ds-section">
                    <div class="flex items-center gap-3 mb-1">
                        <?php render_component('title', ['text' => 'Badge', 'level' => 2]); ?>
                        <?php render_component('badge', ['text' => 'Nouveau', 'variant' => 'success', 'size' => 'sm']); ?>
                    </div>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Étiquette compacte pour statuts, catégories, indicateurs d'état ou compteurs.
                    </p>

                    <p class="label-meta">Variantes (taille md)</p>
                    <div class="demo-box flex flex-wrap gap-3 mb-4">
                        <?php foreach (['default', 'mystic', 'success', 'warning', 'danger', 'info'] as $v): ?>
                            <?php render_component('badge', ['text' => ucfirst($v), 'variant' => $v]); ?>
                        <?php endforeach; ?>
                    </div>

                    <p class="label-meta">Taille sm</p>
                    <div class="demo-box flex flex-wrap gap-3 mb-4">
                        <?php foreach (['default', 'mystic', 'success', 'warning', 'danger', 'info'] as $v): ?>
                            <?php render_component('badge', ['text' => ucfirst($v), 'variant' => $v, 'size' => 'sm']); ?>
                        <?php endforeach; ?>
                    </div>

                    <p class="label-meta">Exemples métier</p>
                    <div class="demo-box flex flex-wrap gap-3 mb-6">
                        <?php render_component('badge', ['text' => 'En stock',       'variant' => 'success']); ?>
                        <?php render_component('badge', ['text' => 'Stock faible',   'variant' => 'warning']); ?>
                        <?php render_component('badge', ['text' => 'Rupture',        'variant' => 'danger']); ?>
                        <?php render_component('badge', ['text' => 'Nouveau',        'variant' => 'info']); ?>
                        <?php render_component('badge', ['text' => 'B2B exclusif',   'variant' => 'mystic']); ?>
                        <?php render_component('badge', ['text' => 'Archivé',        'variant' => 'default']); ?>
                    </div>

                    <?php $propsTable([
                        ['text',      'string', "'Badge'",   'Texte affiché'],
                        ['variant',   'string', "'default'", "default · mystic · success · warning · danger · info"],
                        ['size',      'string', "'md'",      "sm · md"],
                        ['extraClass', 'string', "''",        'Classes Tailwind supplémentaires'],
                    ]); ?>

                    <?php $codeBlock("render_component('badge', [\n    'text'    => 'En stock',\n    'variant' => 'success',\n]);\n\nrender_component('badge', [\n    'text'    => 'Nouveau',\n    'variant' => 'info',\n    'size'    => 'sm',\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — ALERT
                ========================================= -->
                <section id="alert" class="ds-section">
                    <div class="flex items-center gap-3 mb-1">
                        <?php render_component('title', ['text' => 'Alert', 'level' => 2]); ?>
                        <?php render_component('badge', ['text' => 'Nouveau', 'variant' => 'success', 'size' => 'sm']); ?>
                    </div>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Bandeau de retour utilisateur — confirmation, erreur, avertissement ou information. Peut être fermé si <code class="font-mono text-mystic-400">dismissible</code> est activé.
                    </p>

                    <p class="label-meta">Quatre types</p>
                    <div class="demo-box space-y-3 mb-4">
                        <?php render_component('alert', ['type' => 'success', 'message' => 'Le produit a été créé avec succès et ajouté au catalogue.']); ?>
                        <?php render_component('alert', ['type' => 'error',   'message' => 'Impossible de supprimer : des commandes actives référencent ce produit.']); ?>
                        <?php render_component('alert', ['type' => 'warning', 'message' => 'Le stock de cet article est inférieur au seuil minimal configuré.']); ?>
                        <?php render_component('alert', ['type' => 'info',    'message' => 'Les tarifs affichés sont en euros HT. La TVA sera calculée à la commande.']); ?>
                    </div>

                    <p class="label-meta">Avec titre</p>
                    <div class="demo-box space-y-3 mb-4">
                        <?php render_component('alert', [
                            'type'    => 'error',
                            'title'   => 'Jeton de sécurité invalide',
                            'message' => 'Votre session a peut-être expiré. Rechargez la page et réessayez.',
                        ]); ?>
                        <?php render_component('alert', [
                            'type'    => 'warning',
                            'title'   => 'Action irréversible',
                            'message' => 'La suppression définitive ne peut pas être annulée.',
                        ]); ?>
                    </div>

                    <p class="label-meta">Fermable (dismissible)</p>
                    <div class="demo-box space-y-3 mb-6">
                        <?php render_component('alert', [
                            'type'        => 'success',
                            'title'       => 'Importation terminée',
                            'message'     => '142 produits ont été importés depuis le fichier CSV.',
                            'dismissible' => true,
                        ]); ?>
                        <?php render_component('alert', [
                            'type'        => 'info',
                            'message'     => 'Cliquez sur la croix pour faire disparaître cette alerte.',
                            'dismissible' => true,
                        ]); ?>
                    </div>

                    <?php $propsTable([
                        ['type',        'string', "'info'",  "success · error · warning · info"],
                        ['message',     'string', "''",      'Corps du message (obligatoire)'],
                        ['title',       'string', 'null',    'Titre en gras au-dessus du message'],
                        ['dismissible', 'bool',   'false',   'Affiche un bouton de fermeture'],
                        ['id',          'string', 'auto',    'Identifiant HTML (auto-généré si absent)'],
                    ]); ?>

                    <?php $codeBlock("render_component('alert', [\n    'type'    => 'success',\n    'message' => 'Enregistrement effectué.',\n]);\n\n// Avec titre et fermable\nrender_component('alert', [\n    'type'        => 'error',\n    'title'       => 'Erreur de validation',\n    'message'     => \$error,\n    'dismissible' => true,\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — INPUT
                ========================================= -->
                <section id="input" class="ds-section">
                    <?php render_component('title', ['text' => 'Input', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Champ de saisie texte avec label, placeholder, état d'erreur et marqueur de champ obligatoire.
                    </p>

                    <p class="label-meta">États</p>
                    <div class="demo-box grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <?php render_component('input', [
                            'name'        => 'demo-name',
                            'label'       => 'Nom de l\'artefact',
                            'placeholder' => 'Ex : Grimoire des Sombres...',
                        ]); ?>
                        <?php render_component('input', [
                            'name'     => 'demo-price',
                            'type'     => 'number',
                            'label'    => 'Prix HT',
                            'value'    => '24.50',
                            'required' => true,
                        ]); ?>
                        <?php render_component('input', [
                            'name'  => 'demo-email',
                            'type'  => 'email',
                            'label' => 'Email professionnel',
                            'error' => 'Format d\'email invalide.',
                        ]); ?>
                        <?php render_component('input', [
                            'name'        => 'demo-ref',
                            'label'       => 'Référence',
                            'placeholder' => 'CRY-892-ALPHA',
                            'required'    => true,
                        ]); ?>
                    </div>

                    <?php $propsTable([
                        ['name',       'string', "''",      'Attribut name du champ (obligatoire)'],
                        ['type',       'string', "'text'",  'Type HTML : text · email · password · number · …'],
                        ['id',         'string', '$name',   'Attribut id (reprend name si absent)'],
                        ['label',      'string', "''",      'Libellé affiché au-dessus du champ'],
                        ['placeholder', 'string', "''",      'Texte indicatif'],
                        ['value',      'string', "''",      'Valeur pré-remplie'],
                        ['required',   'bool',   'false',   'Ajoute l\'attribut required et un astérisque rouge'],
                        ['error',      'string', "''",      'Message d\'erreur — passe le champ en état danger'],
                        ['extraClass', 'string', "''",      'Classes sur le wrapper div'],
                    ]); ?>

                    <?php $codeBlock("render_component('input', [\n    'name'        => 'email',\n    'type'        => 'email',\n    'label'       => 'Email professionnel',\n    'placeholder' => 'contact@entreprise.fr',\n    'required'    => true,\n]);\n\n// Avec erreur (retour formulaire)\nrender_component('input', [\n    'name'  => 'price',\n    'type'  => 'number',\n    'label' => 'Prix HT',\n    'value' => \$formData['price'],\n    'error' => \$errors['price'] ?? '',\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — TEXTAREA
                ========================================= -->
                <section id="textarea" class="ds-section">
                    <?php render_component('title', ['text' => 'Textarea', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Zone de texte multi-lignes redimensionnable. Même API que Input, sans le prop <code class="font-mono text-mystic-400">type</code>.
                    </p>

                    <p class="label-meta">États</p>
                    <div class="demo-box grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <?php render_component('textarea', [
                            'name'        => 'demo-desc',
                            'label'       => 'Description du produit',
                            'placeholder' => 'Décrivez les propriétés et usages de cet artefact…',
                        ]); ?>
                        <?php render_component('textarea', [
                            'name'  => 'demo-notes',
                            'label' => 'Notes internes',
                            'error' => 'Ce champ ne peut pas dépasser 500 caractères.',
                        ]); ?>
                    </div>

                    <?php $propsTable([
                        ['name',       'string', "''",    'Attribut name (obligatoire)'],
                        ['id',         'string', '$name', 'Attribut id (reprend name si absent)'],
                        ['label',      'string', "''",    'Libellé affiché au-dessus'],
                        ['placeholder', 'string', "''",    'Texte indicatif'],
                        ['value',      'string', "''",    'Contenu pré-rempli'],
                        ['required',   'bool',   'false', 'Ajoute l\'attribut required et un astérisque rouge'],
                        ['error',      'string', "''",    'Message d\'erreur'],
                        ['extraClass', 'string', "''",    'Classes sur le wrapper div'],
                    ]); ?>

                    <?php $codeBlock("render_component('textarea', [\n    'name'        => 'description',\n    'label'       => 'Description produit',\n    'placeholder' => 'Détaillez les caractéristiques…',\n    'required'    => true,\n    'value'       => \$formData['description'] ?? '',\n    'error'       => \$errors['description'] ?? '',\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — TITLE
                ========================================= -->
                <section id="title" class="ds-section">
                    <?php render_component('title', ['text' => 'Title', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Titres sémantiques H1–H3 en police Grimoire. Les niveaux 4–6 utilisent le style H3 par défaut.
                    </p>

                    <div class="demo-box space-y-5 mb-6">
                        <?php for ($i = 1; $i <= 3; $i++): ?>
                            <div class="flex items-baseline gap-4 <?= $i < 3 ? 'pb-5 border-b border-arcane-700/40' : '' ?>">
                                <code class="w-12 flex-shrink-0 text-[10px] font-mono text-mystic-100/25 text-right">level=<?= $i ?></code>
                                <?php render_component('title', ['text' => 'Titre niveau ' . $i, 'level' => $i]); ?>
                            </div>
                        <?php endfor; ?>
                        <div class="pt-2">
                            <p class="label-meta">Avec extraClass (couleur surchargée)</p>
                            <?php render_component('title', ['text' => 'Titre danger', 'level' => 2, 'extraClass' => 'text-arcane-500']); ?>
                        </div>
                    </div>

                    <?php $propsTable([
                        ['text',      'string', "''",  'Texte du titre (obligatoire)'],
                        ['level',     'int',    '1',   'Niveau sémantique 1–6 (style limité à H1/H2/H3)'],
                        ['extraClass', 'string', "''",  'Classes Tailwind additionnelles (ex: couleur)'],
                    ]); ?>

                    <?php $codeBlock("render_component('title', [\n    'text'  => 'Catalogue des artefacts',\n    'level' => 1,\n]);\n\n// Avec couleur surchargée\nrender_component('title', [\n    'text'       => 'Attention',\n    'level'      => 3,\n    'extraClass' => 'text-arcane-500',\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — CARD
                ========================================= -->
                <section id="card" class="ds-section">
                    <?php render_component('title', ['text' => 'Card', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Carte produit B2B affichant image, référence, prix HT/TTC et stock. La TVA à 20&nbsp;% est calculée automatiquement.
                    </p>

                    <p class="label-meta">Avec et sans image</p>
                    <div class="demo-box grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <?php render_component('card', [
                            'title'   => 'Aethérium Brut',
                            'image'   => null,
                            'priceHT' => 24.50,
                            'ref'     => 'CRY-892-ALPHA',
                            'stock'   => 142,
                            'url'     => '#',
                        ]); ?>
                        <?php render_component('card', [
                            'title'   => 'Grimoire des Sombres',
                            'image'   => null,
                            'priceHT' => 189.00,
                            'ref'     => 'GRM-001-DARK',
                            'stock'   => 3,
                            'url'     => '#',
                        ]); ?>
                    </div>

                    <?php $propsTable([
                        ['title',   'string',     '—',    'Nom du produit (obligatoire)'],
                        ['image',   'string|null', 'null', 'URL de l\'image ou null pour afficher le placeholder'],
                        ['priceHT', 'float|int',  '—',    'Prix hors taxe — TTC calculé automatiquement (+20 % TVA)'],
                        ['ref',     'string',     '—',    'Référence produit affichée en uppercase'],
                        ['stock',   'int',        '—',    'Quantité en stock affichée dans le badge image'],
                        ['url',     'string',     '—',    'Lien du bouton "Détails du produit"'],
                    ]); ?>

                    <?php $codeBlock("render_component('card', [\n    'title'   => \$product['name'],\n    'image'   => \$product['image_path'],\n    'priceHT' => \$product['price'],\n    'ref'     => 'REF-' . \$product['id'],\n    'stock'   => \$product['stock'],\n    'url'     => '/pages/shop.php?id=' . \$product['id'],\n]);"); ?>
                </section>

                <!-- =========================================
                     COMPOSANT — MODAL
                ========================================= -->
                <section id="modal" class="ds-section">
                    <?php render_component('title', ['text' => 'Modal', 'level' => 2]); ?>
                    <p class="mt-3 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50 max-w-xl">
                        Dialogue de confirmation. En mode <code class="font-mono text-mystic-400">isPost = true</code>, soumet un formulaire POST avec token CSRF. Déclenché en JS via <code class="font-mono text-mystic-400">classList.remove('hidden')</code>.
                    </p>

                    <p class="label-meta">Deux thèmes</p>
                    <div class="demo-box flex flex-wrap gap-4 mb-6">
                        <?php render_component('button', [
                            'label'   => 'Confirmer une action',
                            'variant' => 'outline',
                            'onclick' => "document.getElementById('demo-modal-primary').classList.remove('hidden')",
                        ]); ?>
                        <?php render_component('button', [
                            'label'   => 'Supprimer un élément',
                            'variant' => 'danger',
                            'onclick' => "document.getElementById('demo-modal-danger').classList.remove('hidden')",
                        ]); ?>
                    </div>

                    <?php $propsTable([
                        ['id',          'string', "'modal'",        "Identifiant HTML — utilisé pour l'ouverture JS"],
                        ['title',       'string', "'Confirmation'", 'Titre affiché dans la modale'],
                        ['body',        'string', "'…'",            'Corps du message'],
                        ['actionText',  'string', "'Confirmer'",    'Libellé du bouton de confirmation'],
                        ['actionUrl',   'string', "'#'",            'URL cible (GET) ou action du formulaire (POST)'],
                        ['theme',       'string', "'primary'",      "primary · danger"],
                        ['isPost',      'bool',   'false',          'Active l\'envoi POST avec champ CSRF caché'],
                        ['csrfToken',   'string', "''",             'Token CSRF à injecter (requis si isPost = true)'],
                    ]); ?>

                    <?php $codeBlock("// Ouverture JS\ndocument.getElementById('confirm-delete')->classList.remove('hidden');\n\n// Rendu — mode lien GET\nrender_component('modal', [\n    'id'         => 'confirm-delete',\n    'title'      => 'Supprimer l\\'artefact',\n    'body'       => 'Cette action est irréversible.',\n    'actionText' => 'Supprimer',\n    'actionUrl'  => '/pages/admin/products/products_delete.php?id=' . \$id,\n    'theme'      => 'danger',\n]);\n\n// Rendu — mode formulaire POST avec CSRF\nrender_component('modal', [\n    'id'         => 'confirm-delete',\n    'title'      => 'Supprimer l\\'artefact',\n    'body'       => 'Cette action est irréversible.',\n    'actionText' => 'Supprimer',\n    'actionUrl'  => '/pages/admin/products/products_delete.php',\n    'theme'      => 'danger',\n    'isPost'     => true,\n    'csrfToken'  => \$csrfToken,\n]);"); ?>
                </section>

            </div>

            <!-- Pied de page -->
            <footer class="border-t border-arcane-700/40 mt-24 py-10 px-6 lg:px-12 text-center">
                <p class="text-xs text-mystic-100/20 font-mono">Arcanist Design System · PHP 8.2 · Tailwind CSS · 8 composants</p>
            </footer>
        </main>
    </div>

    <!-- Modales de démonstration (hors du flux principal) -->
    <?php render_component('modal', [
        'id'         => 'demo-modal-primary',
        'title'      => 'Valider la commande',
        'body'       => 'Souhaitez-vous envoyer ce bon de commande au fournisseur ?',
        'actionText' => 'Envoyer',
        'actionUrl'  => '#',
        'theme'      => 'primary',
    ]); ?>

    <?php render_component('modal', [
        'id'         => 'demo-modal-danger',
        'title'      => 'Supprimer l\'artefact',
        'body'       => 'Cette action est irréversible. Le produit sera définitivement retiré du catalogue B2B.',
        'actionText' => 'Supprimer définitivement',
        'actionUrl'  => '#',
        'theme'      => 'danger',
        'isPost'     => true,
        'csrfToken'  => $csrfToken,
    ]); ?>

    <script>
        // ——— Thème clair/sombre ———
        const html = document.getElementById('main-html');
        const iconDark = document.getElementById('icon-dark');
        const iconLight = document.getElementById('icon-light');

        function applyTheme(dark) {
            html.classList.toggle('dark', dark);
            iconDark.classList.toggle('hidden', dark);
            iconLight.classList.toggle('hidden', !dark);
        }

        applyTheme(
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
        );

        document.getElementById('theme-toggle').addEventListener('click', () => {
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('color-theme', isDark ? 'dark' : 'light');
            iconDark.classList.toggle('hidden', isDark);
            iconLight.classList.toggle('hidden', !isDark);
        });

        // ——— Navigation active via IntersectionObserver ———
        const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
        const sections = document.querySelectorAll('section[id]');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    const active = document.querySelector(`.nav-link[href="#${entry.target.id}"]`);
                    if (active) active.classList.add('active');
                }
            });
        }, {
            rootMargin: '-15% 0px -80% 0px'
        });

        sections.forEach(s => observer.observe(s));
    </script>
</body>

</html>