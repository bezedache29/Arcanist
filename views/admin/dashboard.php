<?php

/**
 * @var array $stats
 */

$statCards = [
    [
        'label'  => 'Produits actifs',
        'value'  => $stats['products'],
        'link'   => '/pages/admin/products/products.php',
        'cta'    => 'Voir les produits',
        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />',
    ],
    [
        'label'  => 'Catégories',
        'value'  => $stats['categories'],
        'link'   => '/pages/admin/categories/categories.php',
        'cta'    => 'Gérer les catégories',
        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />',
    ],
    [
        'label'  => 'Clients B2B',
        'value'  => $stats['clients'],
        'link'   => null,
        'cta'    => 'Voir les clients',
        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />',
    ],
    [
        'label'  => 'En attente',
        'value'  => $stats['pending_orders'],
        'link'   => null,
        'cta'    => 'Traiter les commandes',
        'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />',
    ],
];
?>

<?php render_component('title', ['text' => "Vue d'ensemble", 'level' => 1]); ?>
<p class="mt-2 mb-8 text-sm text-mystic-900/60 dark:text-mystic-100/50">
    Résumé de l'activité de votre catalogue B2B.
</p>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <?php foreach ($statCards as $card): ?>
        <div class="bg-arcane-800 rounded-xl border border-arcane-700 overflow-hidden hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 rounded-lg bg-arcane-700/60 border border-arcane-700 p-3">
                        <svg class="h-6 w-6 text-mystic-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <?= $card['icon'] ?>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 truncate">
                            <?= htmlspecialchars($card['label'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <p class="font-grimoire text-3xl font-bold text-mystic-500 mt-0.5">
                            <?= (int)$card['value'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-arcane-900/40 border-t border-arcane-700/50 px-5 py-3">
                <?php if ($card['link']): ?>
                    <a href="<?= htmlspecialchars($card['link'], ENT_QUOTES, 'UTF-8') ?>"
                       class="text-sm font-medium text-mystic-500 hover:text-mystic-400 transition-colors">
                        <?= htmlspecialchars($card['cta'], ENT_QUOTES, 'UTF-8') ?> &rarr;
                    </a>
                <?php else: ?>
                    <span class="text-sm text-mystic-900/30 dark:text-mystic-100/25 cursor-not-allowed">
                        <?= htmlspecialchars($card['cta'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
