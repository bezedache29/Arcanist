<?php
/**
 * @var array[] $purchases
 */

$totalUnits = array_sum(array_column($purchases, 'total_quantity'));
$totalSpent = array_sum(array_column($purchases, 'total_spent'));
?>

<?php render_component('title', ['text' => 'Produits achetés', 'level' => 1]); ?>

<div class="mt-2 mb-8 flex flex-wrap items-center gap-3">
    <?php render_component('badge', [
        'text'    => count($purchases) . ' référence' . (count($purchases) > 1 ? 's' : ''),
        'variant' => 'default',
    ]); ?>
    <?php render_component('badge', [
        'text'    => $totalUnits . ' unité' . ($totalUnits > 1 ? 's' : ''),
        'variant' => 'default',
    ]); ?>
    <?php render_component('badge', [
        'text'    => number_format($totalSpent, 2, ',', ' ') . ' € HT',
        'variant' => 'mystic',
    ]); ?>
</div>

<?php if (empty($purchases)): ?>

    <div class="flex flex-col items-center justify-center py-24 gap-6">
        <div class="w-20 h-20 rounded-full bg-arcane-800 border border-arcane-700 flex items-center justify-center">
            <svg class="w-10 h-10 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <div class="text-center">
            <p class="font-grimoire text-xl text-mystic-900 dark:text-mystic-100 mb-2">Aucun achat</p>
            <p class="text-sm text-mystic-900/50 dark:text-mystic-100/50">Les produits de vos commandes apparaîtront ici.</p>
        </div>
        <?php render_component('button', [
            'type'  => 'a',
            'href'  => '/pages/shop.php',
            'label' => 'Parcourir le catalogue',
        ]); ?>
    </div>

<?php else: ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($purchases as $item):
            $available  = empty($item['deleted_at']);
            $categories = !empty($item['categories']) ? explode('|||', $item['categories']) : [];
        ?>
        <div class="bg-arcane-800 border border-arcane-700 rounded-xl overflow-hidden flex flex-col hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all group">

            <!-- Image -->
            <div class="h-40 bg-arcane-900 relative flex items-center justify-center overflow-hidden">
                <?php if (!empty($item['image_path'])): ?>
                    <img src="<?= htmlspecialchars($item['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                         alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <?php else: ?>
                    <svg class="w-10 h-10 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                <?php endif; ?>

                <!-- Badge quantité -->
                <div class="absolute top-3 left-3">
                    <span class="bg-arcane-900/80 backdrop-blur-sm border border-arcane-700 text-mystic-100/70 text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded-full">
                        × <?= (int)$item['total_quantity'] ?>
                    </span>
                </div>

                <?php if (!$available): ?>
                    <div class="absolute top-3 right-3">
                        <?php render_component('badge', ['text' => 'Retiré', 'variant' => 'danger', 'size' => 'sm']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Contenu -->
            <div class="p-4 flex-1 flex flex-col gap-3">
                <?php if (!empty($categories)): ?>
                    <div class="flex flex-wrap gap-1.5">
                        <?php foreach ($categories as $cat): ?>
                            <?php render_component('badge', ['text' => $cat, 'variant' => 'default', 'size' => 'sm']); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <h3 class="font-grimoire text-base text-mystic-900 dark:text-mystic-100 group-hover:text-mystic-500 transition-colors leading-snug">
                    <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                </h3>

                <!-- Stats achat -->
                <div class="bg-arcane-900/50 rounded-lg p-3 border border-arcane-700/50 grid grid-cols-2 gap-3 mt-auto">
                    <div>
                        <p class="text-[10px] text-mystic-100/40 uppercase font-bold tracking-widest mb-0.5">Qté achetée</p>
                        <p class="font-ui font-bold text-lg text-mystic-500"><?= (int)$item['total_quantity'] ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-mystic-100/40 uppercase font-bold tracking-widest mb-0.5">Total HT</p>
                        <p class="font-ui font-bold text-lg text-mystic-500"><?= number_format($item['total_spent'], 2, ',', ' ') ?> €</p>
                    </div>
                </div>

                <!-- Lien détail si produit encore disponible -->
                <?php if ($available): ?>
                    <?php render_component('button', [
                        'type'       => 'a',
                        'href'       => '/pages/shop/product.php?id=' . (int)$item['id'],
                        'label'      => 'Voir le produit',
                        'variant'    => 'secondary',
                        'size'       => 'sm',
                        'extraClass' => 'w-full',
                    ]); ?>
                <?php endif; ?>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
