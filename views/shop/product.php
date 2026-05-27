<?php
/**
 * @var array    $product
 * @var string[] $categories
 * @var string   $csrf_token
 */

$stock        = (int)$product['stock'];
$stockVariant = $stock === 0 ? 'danger' : ($stock <= 10 ? 'warning' : 'success');
$stockLabel   = $stock === 0 ? 'Rupture de stock' : 'En stock (' . $stock . ' unités)';
?>

<!-- Fil d'Ariane -->
<nav class="flex items-center gap-2 text-sm text-mystic-900/50 dark:text-mystic-100/40 mb-8">
    <a href="/pages/shop.php" class="hover:text-mystic-500 transition-colors">Catalogue</a>
    <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-mystic-900/80 dark:text-mystic-100/80 truncate"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

    <!-- Image -->
    <div class="bg-arcane-800 rounded-2xl border border-arcane-700 overflow-hidden aspect-square flex items-center justify-center">
        <?php if (!empty($product['image_path'])): ?>
            <img src="<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                 class="w-full h-full object-cover">
        <?php else: ?>
            <div class="flex flex-col items-center gap-4 text-arcane-700">
                <svg class="w-20 h-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="font-grimoire italic text-sm">Aucune image</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Informations -->
    <div class="flex flex-col gap-6">

        <!-- En-tête -->
        <div>
            <?php if (!empty($categories)): ?>
                <div class="flex flex-wrap gap-2 mb-3">
                    <?php foreach ($categories as $cat): ?>
                        <?php render_component('badge', ['text' => $cat, 'variant' => 'default', 'size' => 'sm']); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <h1 class="font-grimoire text-3xl text-mystic-900 dark:text-mystic-100 leading-tight mb-3">
                <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
            </h1>

            <?php render_component('badge', ['text' => $stockLabel, 'variant' => $stockVariant]); ?>
        </div>

        <!-- Description -->
        <?php if (!empty($product['description'])): ?>
            <div class="bg-arcane-800/60 rounded-xl border border-arcane-700/50 p-5">
                <p class="text-sm text-mystic-900/80 dark:text-mystic-100/70 leading-relaxed">
                    <?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8')) ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Prix -->
        <div class="bg-arcane-900/50 rounded-xl border border-arcane-700/50 p-5 flex justify-between items-end">
            <div>
                <p class="text-[10px] text-mystic-100/40 uppercase font-bold tracking-widest mb-1">Prix Gros HT</p>
                <p class="font-ui text-4xl font-bold text-mystic-500"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-mystic-100/30 uppercase tracking-widest mb-1">TTC</p>
                <p class="text-lg font-medium text-mystic-100/70"><?= number_format($product['price'] * 1.20, 2, ',', ' ') ?> €</p>
            </div>
        </div>

        <!-- Ajout au panier -->
        <?php if ($stock > 0): ?>
            <form action="/pages/cart/cart_add.php" method="POST" class="flex gap-3 items-center">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                <input type="hidden" name="redirect" value="/pages/cart/cart.php">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] text-mystic-100/40 uppercase font-bold tracking-widest">Quantité</label>
                    <input type="number"
                           name="quantity"
                           value="1"
                           min="1"
                           max="<?= $stock ?>"
                           class="w-20 text-center bg-arcane-900 dark:bg-arcane-700 border border-arcane-700 text-mystic-900 dark:text-mystic-100 rounded-lg py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-mystic-500 focus:border-mystic-500">
                </div>
                <?php render_component('button', [
                    'attrType'   => 'submit',
                    'label'      => 'Ajouter au panier',
                    'variant'    => 'primary',
                    'size'       => 'lg',
                    'extraClass' => 'flex-1',
                ]); ?>
            </form>
        <?php else: ?>
            <?php render_component('button', [
                'label'      => 'Rupture de stock',
                'variant'    => 'secondary',
                'size'       => 'lg',
                'extraClass' => 'w-full',
                'disabled'   => true,
            ]); ?>
        <?php endif; ?>

        <!-- Retour catalogue -->
        <?php render_component('button', [
            'type'       => 'a',
            'href'       => '/pages/shop.php',
            'label'      => '← Retour au catalogue',
            'variant'    => 'ghost',
            'size'       => 'sm',
            'extraClass' => 'self-start',
        ]); ?>

    </div>
</div>
