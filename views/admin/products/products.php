<?php

/**
 * @var array $products
 * @var array $productCategories
 */
?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <?php render_component('title', ['text' => 'Gestion du Catalogue', 'level' => 1]); ?>
        <p class="mt-1 text-sm text-mystic-900/60 dark:text-mystic-100/50">
            Liste de tous les produits disponibles pour vos clients.
        </p>
    </div>
    <?php render_component('button', [
        'type'    => 'a',
        'href'    => '/pages/admin/products/products_create.php',
        'label'   => 'Ajouter un produit',
        'variant' => 'primary',
        'size'    => 'sm',
    ]); ?>
</div>

<div class="bg-arcane-800 rounded-xl border border-arcane-700 overflow-hidden">
    <table class="min-w-full divide-y divide-arcane-700/50">
        <thead class="bg-arcane-900/50">
            <tr>
                <th scope="col" class="px-3 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 w-16">Image</th>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 sm:pl-6">Nom du produit</th>
                <th scope="col" class="px-3 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30">Catégories</th>
                <th scope="col" class="px-3 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30">Prix HT</th>
                <th scope="col" class="px-3 py-3.5 text-left text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30">Stock</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Actions</span></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-arcane-700/30 bg-arcane-800">
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6" class="py-10 px-6">
                        <?php render_component('alert', [
                            'type'    => 'info',
                            'message' => 'Aucun produit dans le catalogue.',
                        ]); ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <?php
                    $stock = (int)$product['stock'];
                    $stockVariant = $stock === 0 ? 'danger' : ($stock <= 10 ? 'warning' : 'success');
                    ?>
                    <tr class="hover:bg-arcane-700/20 transition-colors">

                        <td class="whitespace-nowrap px-3 py-4">
                            <?php if (!empty($product['image_path'])): ?>
                                <img src="<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                                     alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                     class="h-10 w-10 rounded-lg object-cover ring-1 ring-arcane-700 shadow-sm">
                            <?php else: ?>
                                <div class="h-10 w-10 rounded-lg bg-arcane-900/60 border border-arcane-700 flex items-center justify-center text-arcane-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </td>

                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-mystic-900 dark:text-mystic-100 sm:pl-6">
                            <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td class="px-3 py-4 text-sm">
                            <?php if (!empty($productCategories[$product['id']])): ?>
                                <div class="flex flex-wrap gap-1">
                                    <?php foreach ($productCategories[$product['id']] as $catName): ?>
                                        <?php render_component('badge', ['text' => $catName, 'variant' => 'mystic', 'size' => 'sm']); ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-mystic-900/30 dark:text-mystic-100/25 italic text-xs">Aucune</span>
                            <?php endif; ?>
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-mystic-500">
                            <?= number_format($product['price'], 2, ',', ' ') ?> €
                        </td>

                        <td class="whitespace-nowrap px-3 py-4">
                            <?php render_component('badge', ['text' => (string)$stock, 'variant' => $stockVariant, 'size' => 'sm']); ?>
                        </td>

                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <?php render_component('button', [
                                'type'       => 'a',
                                'variant'    => 'ghost',
                                'size'       => 'sm',
                                'href'       => '/pages/admin/products/products_edit.php?id=' . (int)$product['id'],
                                'label'      => 'Modifier',
                                'extraClass' => 'text-mystic-500 hover:text-mystic-400 mr-4',
                            ]); ?>
                            <?php render_component('button', [
                                'type'       => 'button',
                                'variant'    => 'none',
                                'size'       => 'sm',
                                'label'      => 'Supprimer',
                                'onclick'    => 'openDeleteModal(' . (int)$product['id'] . ')',
                                'extraClass' => 'text-arcane-500 hover:text-arcane-500/70 font-medium',
                            ]); ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php render_component('modal', [
    'id'         => 'deleteProductModal',
    'title'      => 'Supprimer le produit',
    'body'       => 'Êtes-vous sûr de vouloir retirer ce produit du catalogue ? Il ne sera plus visible par les clients.',
    'actionText' => 'Supprimer',
    'actionUrl'  => '/pages/admin/products/products_delete.php',
    'theme'      => 'danger',
    'isPost'     => true,
    'csrfToken'  => $_SESSION['csrf_token'] ?? '',
]); ?>

<script>
    function openDeleteModal(productId) {
        const modal = document.getElementById('deleteProductModal');
        const hiddenIdInput = document.getElementById('deleteProductModal-target-id');
        if (hiddenIdInput) {
            hiddenIdInput.value = productId;
        }
        modal.classList.remove('hidden');
    }
</script>
