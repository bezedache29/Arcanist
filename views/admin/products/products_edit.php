<?php

/**
 * @var string $error
 * @var array $product
 * @var array $categories
 * @var array $currentCategoryIds
 */
?>
<div class="mb-8">
    <a href="/pages/admin/products/products.php" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium flex items-center transition">
        &larr; Retour au catalogue
    </a>
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mt-4">Modifier le produit</h1>
</div>

<div class="bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 sm:rounded-xl overflow-hidden transition-colors max-w-3xl">
    <div class="p-6 sm:p-8">

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded relative mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/pages/admin/products/products_edit.php?id=<?= $product['id'] ?>" method="POST" class="space-y-6">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nom du produit <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required class="mt-1 block w-full rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-900 dark:text-white transition-colors">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-900 dark:text-white transition-colors"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Prix unitaire HT (€) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" required class="mt-1 block w-full rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-900 dark:text-white transition-colors">
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Stock <span class="text-red-500">*</span></label>
                    <input type="number" step="1" min="0" name="stock" id="stock" value="<?= htmlspecialchars($product['stock']) ?>" required class="mt-1 block w-full rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-900 dark:text-white transition-colors">
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-700 pt-6">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-4">Catégories</label>
                <?php if (empty($categories)): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-400 italic">Aucune catégorie disponible.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <?php foreach ($categories as $category): ?>
                            <label class="relative flex items-start cursor-pointer">
                                <div class="flex h-6 items-center">
                                    <input type="checkbox" name="category_ids[]" value="<?= $category['id'] ?>" <?= in_array($category['id'], $currentCategoryIds) ? 'checked' : '' ?> class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-blue-600 focus:ring-blue-600 transition-colors">
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <span class="font-medium text-slate-700 dark:text-slate-300"><?= htmlspecialchars($category['name']) ?></span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-slate-200 dark:border-slate-700 mt-8">
                <a href="/pages/admin/products/products.php" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-colors">
                    Enregistrer les modifications
                </button>
            </div>
        </form>

    </div>
</div>