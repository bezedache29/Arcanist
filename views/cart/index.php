<?php
$tva      = 0.20;
$totalTVA = $totalHT * $tva;
$totalTTC = $totalHT * (1 + $tva);
?>

<?php render_component('title', ['text' => 'Mon Panier', 'level' => 1]); ?>

<div class="mt-2 mb-8 flex items-center gap-3">
    <?php
    $total_items = array_sum(array_column($items, 'quantity'));
    render_component('badge', [
        'text'    => $total_items . ' article' . ($total_items > 1 ? 's' : ''),
        'variant' => 'default',
    ]);
    ?>
</div>

<?php if (empty($items)): ?>

    <div class="flex flex-col items-center justify-center py-24 gap-6">
        <div class="w-20 h-20 rounded-full bg-arcane-800 border border-arcane-700 flex items-center justify-center">
            <svg class="w-10 h-10 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </div>
        <div class="text-center">
            <p class="font-grimoire text-xl text-mystic-900 dark:text-mystic-100 mb-2">Votre panier est vide</p>
            <p class="text-sm text-mystic-900/50 dark:text-mystic-100/50">Explorez le catalogue pour ajouter des produits.</p>
        </div>
        <?php render_component('button', [
            'type'  => 'a',
            'href'  => '/pages/shop.php',
            'label' => 'Retourner au catalogue',
        ]); ?>
    </div>

<?php else: ?>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <!-- Liste des articles -->
        <div class="xl:col-span-2 flex flex-col gap-4">

            <?php foreach ($items as $item):
                $product = $item['product'];
                $qty     = $item['quantity'];
            ?>
            <div class="bg-arcane-800 border border-arcane-700 rounded-xl overflow-hidden flex gap-0">

                <!-- Image -->
                <div class="w-28 shrink-0 bg-arcane-900 flex items-center justify-center overflow-hidden">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <svg class="w-8 h-8 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- Détails -->
                <div class="flex-1 p-4 flex flex-col sm:flex-row sm:items-center gap-4">

                    <div class="flex-1">
                        <h3 class="font-grimoire text-base text-mystic-900 dark:text-mystic-100">
                            <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <p class="text-xs text-mystic-900/50 dark:text-mystic-100/40 mt-0.5">
                            Prix unitaire HT : <span class="text-mystic-500 font-semibold"><?= number_format($product['price'], 2, ',', ' ') ?> €</span>
                        </p>
                    </div>

                    <!-- Mise à jour quantité -->
                    <form action="/pages/cart/cart_update.php" method="POST" class="flex items-center gap-2">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                        <input type="number"
                               name="quantity"
                               value="<?= $qty ?>"
                               min="1"
                               max="<?= (int)$product['stock'] ?>"
                               class="w-16 text-center bg-arcane-900 dark:bg-arcane-700 border border-arcane-700 text-mystic-900 dark:text-mystic-100 rounded-lg py-1.5 text-sm focus:outline-none focus:ring-1 focus:ring-mystic-500 focus:border-mystic-500">
                        <?php render_component('button', [
                            'attrType'   => 'submit',
                            'label'      => 'Maj',
                            'variant'    => 'secondary',
                            'size'       => 'sm',
                        ]); ?>
                    </form>

                    <!-- Sous-total -->
                    <div class="text-right shrink-0 min-w-[80px]">
                        <p class="text-[10px] text-mystic-100/40 uppercase tracking-widest mb-0.5">Sous-total HT</p>
                        <p class="font-ui font-bold text-mystic-500"><?= number_format($item['subtotal'], 2, ',', ' ') ?> €</p>
                    </div>

                    <!-- Supprimer -->
                    <form action="/pages/cart/cart_remove.php" method="POST" class="shrink-0">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
                        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
                        <button type="submit"
                                class="p-2 rounded-lg text-mystic-900/30 dark:text-mystic-100/30 hover:text-arcane-500 hover:bg-arcane-500/10 transition-colors"
                                title="Retirer du panier">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>

                </div>
            </div>
            <?php endforeach; ?>

        </div>

        <!-- Récapitulatif commande -->
        <div class="xl:col-span-1">
            <div class="bg-arcane-800 border border-arcane-700 rounded-xl p-6 sticky top-24">
                <h2 class="font-grimoire text-lg text-mystic-900 dark:text-mystic-100 mb-6">Récapitulatif</h2>

                <div class="flex flex-col gap-3 text-sm">
                    <div class="flex justify-between text-mystic-900/70 dark:text-mystic-100/60">
                        <span>Total HT</span>
                        <span><?= number_format($totalHT, 2, ',', ' ') ?> €</span>
                    </div>
                    <div class="flex justify-between text-mystic-900/70 dark:text-mystic-100/60">
                        <span>TVA (20 %)</span>
                        <span><?= number_format($totalTVA, 2, ',', ' ') ?> €</span>
                    </div>
                    <div class="border-t border-arcane-700 pt-3 flex justify-between font-bold text-base text-mystic-900 dark:text-mystic-100">
                        <span>Total TTC</span>
                        <span class="text-mystic-500"><?= number_format($totalTTC, 2, ',', ' ') ?> €</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-3">
                    <?php render_component('button', [
                        'type'       => 'button',
                        'attrType'   => 'button',
                        'label'      => 'Passer la commande',
                        'variant'    => 'primary',
                        'size'       => 'md',
                        'extraClass' => 'w-full',
                        'disabled'   => true,
                    ]); ?>
                    <?php render_component('button', [
                        'type'       => 'a',
                        'href'       => '/pages/shop.php',
                        'label'      => 'Continuer les achats',
                        'variant'    => 'ghost',
                        'size'       => 'sm',
                        'extraClass' => 'w-full',
                    ]); ?>
                </div>

                <p class="text-[10px] text-mystic-100/30 text-center mt-4">
                    Commande en cours de développement
                </p>
            </div>
        </div>

    </div>

<?php endif; ?>
