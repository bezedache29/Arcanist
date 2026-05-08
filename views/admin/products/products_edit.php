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

        <form action="/pages/admin/products/products_edit.php?id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nom du produit <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required class="mt-1 block w-full rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-900 dark:text-white transition-colors">
            </div>

            <div>
                <label for="image-input" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Image du produit</label>
                <div class="mt-2 flex items-center gap-6">
                    <div id="preview-container" class="<?= empty($product['image_path']) ? 'hidden' : '' ?> shrink-0">
                        <img id="image-preview" src="<?= htmlspecialchars($product['image_path'] ?? '#') ?>" alt="Aperçu" class="h-24 w-24 object-cover rounded-lg ring-1 ring-slate-200 dark:ring-slate-700 shadow-sm">
                    </div>
                    <div id="preview-placeholder" class="<?= !empty($product['image_path']) ? 'hidden' : '' ?> shrink-0 h-24 w-24 flex items-center justify-center rounded-lg border-2 border-dashed border-slate-300 dark:border-slate-600 text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-800/50 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <input type="file" name="image" id="image-input" accept="image/jpeg, image/png, image/webp" class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 dark:hover:file:bg-blue-900/50 transition-colors cursor-pointer">
                        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Formats acceptés : JPG, PNG, WEBP. Laissez vide pour conserver l'image actuelle.</p>
                    </div>
                </div>
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

<?php render_component('modal', [
    'id' => 'imageSizeErrorModal',
    'title' => 'Fichier trop lourd',
    'body' => 'L\'image sélectionnée dépasse la limite de 2 Mo. Veuillez choisir un fichier plus léger pour optimiser les performances.',
    'actionText' => 'Compris',
    'actionUrl' => '#',
    'theme' => 'danger'
]); ?>

<script>
    document.getElementById('image-input').addEventListener('change', function(evt) {
        const file = evt.target.files[0];
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const placeholder = document.getElementById('preview-placeholder');
        const errorModal = document.getElementById('imageSizeErrorModal');

        // On sauvegarde l'état initial (pour pouvoir y revenir en cas d'erreur)
        // Pour l'edit, src contient déjà l'image de la BDD
        const originalSrc = preview.src;
        const wasHidden = container.classList.contains('hidden');

        if (file) {
            const maxSize = 2 * 1024 * 1024;

            if (file.size > maxSize) {
                // Affichage de la modale custom
                errorModal.classList.remove('hidden');

                // Réinitialisation du champ de fichier
                this.value = '';

                // RESTAURATION : On remet l'aperçu comme il était avant la sélection
                if (wasHidden) {
                    container.classList.add('hidden');
                    if (placeholder) placeholder.classList.remove('hidden');
                } else {
                    preview.src = originalSrc;
                }
                return;
            }

            // Si tout est OK, on génère l'aperçu du nouveau fichier
            preview.src = URL.createObjectURL(file);
            container.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
    });

    // Gestion de la fermeture de la modale d'erreur
    const modal = document.getElementById('imageSizeErrorModal');
    const closeBtn = modal.querySelector('a'); // Le bouton "Compris"

    closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        modal.classList.add('hidden');
    });
</script>