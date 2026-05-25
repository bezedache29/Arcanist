<?php
/**
 * @var array  $products
 * @var string $csrf_token
 */
?>
<?php render_component('title', ['text' => 'Catalogue', 'level' => 1]); ?>

<div class="mt-2 mb-8 flex items-center gap-3">
    <?php render_component('badge', ['text' => count($products) . ' produit' . (count($products) > 1 ? 's' : ''), 'variant' => 'default']); ?>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    <?php if (empty($products)): ?>
        <?php render_component('alert', [
            'type'    => 'info',
            'message' => 'Aucun produit disponible pour le moment.',
        ]); ?>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <?php
            $stock        = (int)$product['stock'];
            $stockVariant = $stock === 0 ? 'danger' : ($stock <= 10 ? 'warning' : 'success');
            $stockLabel   = $stock === 0 ? 'Rupture' : 'Stock : ' . $stock;
            $categories   = !empty($product['categories']) ? explode('|||', $product['categories']) : [];
            ?>
            <div class="bg-arcane-800 rounded-xl overflow-hidden border border-arcane-700 hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all flex flex-col group">

                <!-- Image -->
                <div class="h-52 bg-arcane-900 relative flex items-center justify-center overflow-hidden">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                        <svg class="h-12 w-12 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    <?php endif; ?>

                    <div class="absolute top-3 right-3">
                        <?php render_component('badge', ['text' => $stockLabel, 'variant' => $stockVariant, 'size' => 'sm']); ?>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="p-5 flex-1 flex flex-col gap-4">
                    <div class="flex-1">
                        <?php if (!empty($categories)): ?>
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                <?php foreach ($categories as $cat): ?>
                                    <?php render_component('badge', ['text' => $cat, 'variant' => 'default', 'size' => 'sm']); ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <h2 class="font-grimoire text-xl text-mystic-900 dark:text-mystic-100 group-hover:text-mystic-500 transition-colors">
                            <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                        <?php if (!empty($product['description'])): ?>
                            <p class="text-sm text-mystic-900/60 dark:text-mystic-100/50 mt-2 leading-relaxed line-clamp-3">
                                <?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Prix -->
                    <div class="bg-arcane-900/50 rounded-lg p-3 border border-arcane-700/50 flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-mystic-100/40 uppercase font-bold tracking-widest mb-0.5">Prix Gros HT</p>
                            <p class="font-ui text-2xl font-bold text-mystic-500"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-mystic-100/30 uppercase tracking-widest">TTC</p>
                            <p class="text-sm font-medium text-mystic-100/80"><?= number_format($product['price'] * 1.20, 2, ',', ' ') ?> €</p>
                        </div>
                    </div>

                    <!-- Lien détail + ajout au panier -->
                    <?php render_component('button', [
                        'type'       => 'a',
                        'href'       => '/pages/shop/product.php?id=' . (int)$product['id'],
                        'label'      => 'Voir le détail',
                        'variant'    => 'secondary',
                        'size'       => 'sm',
                        'extraClass' => 'w-full',
                    ]); ?>

                    <?php if ($stock > 0): ?>
                        <form action="/pages/cart/cart_add.php" method="POST" class="flex gap-2 items-center">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                            <input type="hidden" name="redirect" value="/pages/shop.php">
                            <input type="number"
                                   name="quantity"
                                   value="1"
                                   min="1"
                                   max="<?= $stock ?>"
                                   class="w-16 text-center bg-arcane-900 dark:bg-arcane-700 border border-arcane-700 text-mystic-900 dark:text-mystic-100 rounded-lg py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-mystic-500 focus:border-mystic-500">
                            <?php render_component('button', [
                                'attrType'   => 'submit',
                                'label'      => 'Ajouter au panier',
                                'variant'    => 'primary',
                                'size'       => 'sm',
                                'extraClass' => 'flex-1',
                            ]); ?>
                        </form>
                    <?php else: ?>
                        <?php render_component('button', [
                            'label'      => 'Rupture de stock',
                            'variant'    => 'secondary',
                            'size'       => 'sm',
                            'extraClass' => 'w-full',
                            'disabled'   => true,
                        ]); ?>
                    <?php endif; ?>

                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
