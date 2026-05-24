<!DOCTYPE html>
<html lang="fr" id="main-html">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design System - Arcane B2B</title>

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
                        'glow-light': 'radial-gradient(circle, rgba(214, 199, 177, 0.15), rgba(245, 239, 230, 1))',
                        'glow-dark': 'radial-gradient(circle at top, rgba(180, 147, 91, 0.06), transparent 40%)',
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
                        }
                    },
                    fontFamily: {
                        grimoire: ['"Playfair Display"', 'serif'],
                        ui: ['"Inter"', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow-mystic': '0 0 15px -3px rgba(196, 166, 97, 0.25)',
                        'glow-arcane': '0 0 20px -5px rgba(140, 58, 58, 0.15)',
                    }
                }
            }
        }
    </script>

    <style type="text/tailwindcss">
        @layer base {
            /* MODE CLAIR - Vieux Parchemin */
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

            /* MODE SOMBRE - Dark Academia */
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
        }
    </style>
</head>

<body class="bg-arcane-900 bg-glow-light dark:bg-glow-dark text-mystic-900 dark:text-mystic-100 font-ui p-8 antialiased min-h-screen transition-colors duration-500">

    <div class="max-w-5xl mx-auto space-y-16">

        <header class="flex justify-between items-start border-b border-arcane-700 pb-8">
            <div>
                <?php render_component('title', [
                    'text' => 'Design System',
                    'level' => 1
                ]); ?>
                <p class="mt-4 text-mystic-900/60 dark:text-mystic-100/60">Utilisation des composants natifs du framework Arcane.</p>
            </div>

            <button id="theme-toggle" type="button" aria-label="Basculer le thème" aria-pressed="false" class="p-3 rounded-xl bg-arcane-800 border border-arcane-700 hover:border-mystic-500 transition-all shadow-lg group">
                <svg id="theme-toggle-dark-icon" aria-hidden="true" class="hidden w-6 h-6 text-mystic-600 group-hover:text-mystic-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" aria-hidden="true" class="hidden w-6 h-6 text-mystic-500 group-hover:text-mystic-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>
        </header>

        <section>
            <?php render_component('title', ['text' => 'Typographie', 'level' => 2, 'extraClass' => 'mb-6']); ?>
            <div class="space-y-6 bg-arcane-800 p-8 rounded-2xl border border-arcane-700 shadow-glow-arcane transition-all duration-500">
                <div>
                    <h1 class="font-grimoire text-4xl text-mystic-900 dark:text-white transition-colors">Titre Principal H1 (Grimoire)</h1>
                    <p class="text-sm text-mystic-900/60 dark:text-mystic-100/60 mt-1">Playfair Display - Bold</p>
                </div>
                <p class="font-ui text-base leading-relaxed text-mystic-900/80 dark:text-mystic-100/80 transition-colors">
                    Corps de texte standard utilisant la police Inter pour une lisibilité B2B optimale. Le texte s'adapte automatiquement à l'ambiance choisie.
                </p>
            </div>
        </section>

        <section>
            <h2 class="font-grimoire text-xs font-bold uppercase tracking-widest text-arcane-500 mb-6">Actions & Boutons</h2>
            <div class="flex flex-wrap gap-6 bg-arcane-800 p-8 rounded-2xl border border-arcane-700 shadow-md">
                <?php render_component('button', ['label' => 'Ajouter au panier', 'variant' => 'primary']); ?>
                <?php render_component('button', ['label' => 'Gérer le stock', 'variant' => 'secondary']); ?>
                <?php render_component('button', ['label' => 'Annuler', 'variant' => 'ghost']); ?>
                <?php render_component('button', ['label' => 'Danger variant', 'variant' => 'danger', 'size' => 'sm']); ?>
            </div>
        </section>

        <section>
            <h2 class="font-grimoire text-xs font-bold uppercase tracking-widest text-arcane-500 mb-6">Composants Modales</h2>
            <div class="flex flex-wrap gap-6 bg-arcane-800 p-8 rounded-2xl border border-arcane-700 shadow-md">
                <?php render_component('button', [
                    'label' => 'Ouvrir Confirmation',
                    'variant' => 'outline',
                    'onclick' => "document.getElementById('modal-demo-standard').classList.remove('hidden')"
                ]); ?>

                <?php render_component('button', [
                    'label' => 'Ouvrir Alerte Danger',
                    'variant' => 'outline',
                    'extraClass' => 'border-arcane-500 text-arcane-500 hover:bg-arcane-500/10',
                    'onclick' => "document.getElementById('modal-demo-danger').classList.remove('hidden')"
                ]); ?>
            </div>

            <?php
            render_component('modal', [
                'id' => 'modal-demo-standard',
                'title' => 'Valider la commande',
                'body' => 'Souhaitez-vous envoyer ce bon de commande au fournisseur d\'artefacts ?',
                'actionText' => 'Envoyer la commande',
                'theme' => 'primary'
            ]);

            render_component('modal', [
                'id' => 'modal-demo-danger',
                'title' => 'Supprimer l\'artefact',
                'body' => 'Cette action est irréversible. Le grimoire sera définitivement retiré du catalogue B2B.',
                'actionText' => 'Supprimer définitivement',
                'theme' => 'danger',
                'isPost' => true,
                'csrfToken' => $_SESSION['csrf_token']
            ]);
            ?>
        </section>

        <section>
            <h2 class="font-grimoire text-xs font-bold uppercase tracking-widest text-arcane-500 mb-6">Composants Formulaire</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-arcane-800 p-8 rounded-2xl border border-arcane-700 shadow-md">
                <?php render_component('input', ['label' => 'Nom de l\'artefact', 'name' => 'name', 'placeholder' => 'Ex: Grimoire...', 'required' => true]); ?>
                <?php render_component('input', ['type' => 'number', 'label' => 'Prix HT', 'name' => 'price', 'value' => '24.50']); ?>
                <div class="md:col-span-2">
                    <?php render_component('textarea', ['label' => 'Description', 'name' => 'desc']); ?>
                </div>
            </div>
        </section>

        <section>
            <h2 class="font-grimoire text-xs font-bold uppercase tracking-widest text-arcane-500 mb-6">Composant Carte</h2>
            <div class="max-w-sm">
                <?php render_component('card', [
                    'title'   => 'Aethérium Brut',
                    'image'   => null,
                    'priceHT' => 24.50,
                    'ref'     => 'CRY-892-ALPHA',
                    'stock'   => 142,
                    'url'     => '#'
                ]); ?>
            </div>
        </section>

    </div>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const html = document.getElementById('main-html');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeToggleBtn.setAttribute('aria-pressed', 'true');
            lightIcon.classList.remove('hidden');
        } else {
            html.classList.remove('dark');
            themeToggleBtn.setAttribute('aria-pressed', 'false');
            darkIcon.classList.remove('hidden');
        }

        themeToggleBtn.addEventListener('click', function() {
            darkIcon.classList.toggle('hidden');
            lightIcon.classList.toggle('hidden');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                themeToggleBtn.setAttribute('aria-pressed', 'false');
            } else {
                html.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                themeToggleBtn.setAttribute('aria-pressed', 'true');
            }
        });
    </script>
</body>

</html>