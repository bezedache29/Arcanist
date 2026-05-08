<?php

/**
 * @var array $products
 * @var array $productCategories
 */
?>
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Gestion du Catalogue</h1>
        <p class="mt-2 text-sm text-slate-700 dark:text-slate-400">Liste de tous les produits disponibles pour vos clients.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="/pages/admin/products/products_create.php" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition">
            Ajouter un produit
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 sm:rounded-lg overflow-hidden transition-colors">
    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
        <thead class="bg-slate-50 dark:bg-slate-900/50">
            <tr>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 dark:text-slate-200 w-16">Image</th>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 dark:text-slate-200 sm:pl-6">Nom du produit</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 dark:text-slate-200">Catégories</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 dark:text-slate-200">Prix unitaire</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900 dark:text-slate-200">Stock</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="6" class="py-8 text-center text-sm text-slate-500 dark:text-slate-400">Aucun produit dans le catalogue.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">

                        <td class="whitespace-nowrap px-3 py-4">
                            <?php if (!empty($product['image_path'])): ?>
                                <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="h-10 w-10 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700 shadow-sm">
                            <?php else: ?>
                                <div class="h-10 w-10 rounded-md bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-slate-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </td>

                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 dark:text-slate-100 sm:pl-6">
                            <?= htmlspecialchars($product['name']) ?>
                        </td>

                        <td class="px-3 py-4 text-sm text-slate-500 dark:text-slate-400">
                            <?php if (!empty($productCategories[$product['id']])): ?>
                                <div class="flex flex-wrap gap-1">
                                    <?php foreach ($productCategories[$product['id']] as $catName): ?>
                                        <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10 dark:bg-purple-900/30 dark:text-purple-400">
                                            <?= htmlspecialchars($catName) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <span class="text-slate-400 dark:text-slate-500 italic text-xs">Aucune</span>
                            <?php endif; ?>
                        </td>

                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500 dark:text-slate-400">
                            <?= number_format($product['price'], 2, ',', ' ') ?> €
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium <?= $product['stock'] > 0 ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10 dark:bg-red-900/30 dark:text-red-400' ?>">
                                <?= htmlspecialchars($product['stock']) ?>
                            </span>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="/pages/admin/products/products_edit.php?id=<?= (int)$product['id'] ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4">Modifier</a>
                            <button onclick="openDeleteModal(<?= (int)$product['id'] ?>)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php render_component('modal', [
    'id' => 'deleteProductModal',
    'title' => 'Supprimer le produit',
    'body' => 'Êtes-vous sûr de vouloir retirer ce produit du catalogue ? Il ne sera plus visible par les clients.',
    'actionText' => 'Supprimer',
    'actionUrl' => '/pages/admin/products/products_delete.php',
    'theme' => 'danger',
    'isPost' => true,
    'csrfToken' => $_SESSION['csrf_token'] ?? ''
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