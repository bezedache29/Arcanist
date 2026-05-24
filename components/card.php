<?php

/**
 * @var string $title
 * @var string|null $image
 * @var float|int $priceHT
 * @var string $ref
 * @var int $stock
 * @var string $url
 */

$tva = 1.20; // 20%
$priceTTC = $priceHT * $tva;
?>

<div class="bg-arcane-800 rounded-xl overflow-hidden border border-arcane-700 hover:border-mystic-500/50 transition-all shadow-lg group">
    <div class="h-52 bg-arcane-900 relative flex items-center justify-center overflow-hidden">
        <?php if ($image): ?>
            <img src="<?= $image ?>" alt="<?= $title ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        <?php else: ?>
            <span class="text-arcane-700 font-grimoire italic">Aucune image</span>
        <?php endif; ?>

        <div class="absolute top-3 right-3">
            <span class="bg-arcane-900/80 backdrop-blur-sm border border-arcane-500 text-arcane-400 text-xs px-2 py-1 rounded">
                Stock : <?= $stock ?>
            </span>
        </div>
    </div>

    <div class="p-5 flex flex-col gap-4">
        <div>
            <h3 class="font-grimoire text-xl text-mystic-900 dark:text-mystic-100 group-hover:text-mystic-500 transition-colors"><?= $title ?></h3>
            <p class="text-xs text-mystic-900/40 dark:text-mystic-100/40 mt-1 uppercase tracking-wider font-semibold">Ref: <?= $ref ?></p>
        </div>

        <div class="bg-arcane-900/50 rounded-lg p-3 border border-arcane-700/50 flex justify-between items-end">
            <div>
                <p class="text-[10px] text-mystic-100/40 uppercase font-bold mb-0.5">Prix Gros HT</p>
                <p class="font-ui text-2xl font-bold text-mystic-500"><?= number_format($priceHT, 2, ',', ' ') ?> €</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-mystic-100/30 uppercase">TTC</p>
                <p class="text-sm font-medium text-mystic-100/80"><?= number_format($priceTTC, 2, ',', ' ') ?> €</p>
            </div>
        </div>

        <?php render_component('button', [
            'type' => 'a',
            'href' => $url,
            'label' => 'Détails du produit',
            'variant' => 'secondary',
            'size' => 'sm',
            'extraClass' => 'w-full'
        ]); ?>
    </div>
</div>