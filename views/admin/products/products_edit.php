<?php

/**
 * @var string $error
 * @var array $product
 * @var array $categories
 * @var array $currentCategoryIds
 */

$inputClass = 'w-full bg-arcane-900 dark:bg-arcane-700 text-mystic-900 dark:text-mystic-100 border border-arcane-700 rounded-lg py-2.5 px-4 font-ui transition-all duration-300 focus:outline-none focus:ring-1 focus:border-mystic-500 focus:ring-mystic-500 hover:border-mystic-600';
$labelClass = 'text-xs font-bold uppercase tracking-wider text-mystic-900/50 dark:text-mystic-100/50 ml-1';
?>

<div class="mb-8">
    <a href="/pages/admin/products/products.php"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-mystic-500 hover:text-mystic-400 transition-colors mb-4">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour au catalogue
    </a>
    <?php render_component('title', ['text' => 'Modifier le produit', 'level' => 1]); ?>
</div>

<div class="bg-arcane-800 rounded-xl border border-arcane-700 max-w-3xl">
    <div class="p-6 sm:p-8">

        <?php if (!empty($error)): ?>
            <?php render_component('alert', ['type' => 'error', 'message' => $error]); ?>
            <div class="mb-6"></div>
        <?php endif; ?>

        <form action="/pages/admin/products/products_edit.php?id=<?= (int)$product['id'] ?>"
              method="POST" enctype="multipart/form-data" class="space-y-6">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <?php render_component('input', [
                'name'     => 'name',
                'label'    => 'Nom du produit',
                'required' => true,
                'value'    => $product['name'],
            ]); ?>

            <!-- Image du produit -->
            <div class="flex flex-col gap-1.5">
                <label class="<?= $labelClass ?>">Image du produit</label>
                <div class="mt-1 flex items-center gap-6">
                    <div id="preview-container" class="<?= empty($product['image_path']) ? 'hidden' : '' ?> shrink-0">
                        <img id="image-preview"
                             src="<?= htmlspecialchars($product['image_path'] ?? '#', ENT_QUOTES, 'UTF-8') ?>"
                             alt="Aperçu"
                             class="h-24 w-24 object-cover rounded-xl ring-1 ring-arcane-700 shadow-sm">
                    </div>
                    <div id="preview-placeholder"
                         class="<?= !empty($product['image_path']) ? 'hidden' : '' ?> shrink-0 h-24 w-24 flex items-center justify-center rounded-xl border-2 border-dashed border-arcane-700 text-arcane-700 bg-arcane-900/50">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="image" id="image-input" accept="image/jpeg, image/png, image/webp"
                               class="block w-full text-sm text-mystic-900/50 dark:text-mystic-100/40 cursor-pointer
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold
                                      file:bg-arcane-700/60 file:text-mystic-400 hover:file:bg-arcane-700 transition-colors">
                        <p class="mt-2 text-xs text-mystic-900/40 dark:text-mystic-100/30">
                            Formats acceptés : JPG, PNG, WEBP · Laissez vide pour conserver l'image actuelle.
                        </p>
                    </div>
                </div>
            </div>

            <?php render_component('textarea', [
                'name'  => 'description',
                'label' => 'Description',
                'value' => $product['description'] ?? '',
            ]); ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label for="price" class="<?= $labelClass ?>">
                        Prix unitaire HT (€) <span class="text-arcane-500 ml-0.5">*</span>
                    </label>
                    <input type="number" step="0.01" min="0" name="price" id="price"
                           value="<?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?>"
                           required class="<?= $inputClass ?>">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label for="stock" class="<?= $labelClass ?>">
                        Stock <span class="text-arcane-500 ml-0.5">*</span>
                    </label>
                    <input type="number" step="1" min="0" name="stock" id="stock"
                           value="<?= htmlspecialchars($product['stock'], ENT_QUOTES, 'UTF-8') ?>"
                           required class="<?= $inputClass ?>">
                </div>
            </div>

            <!-- Catégories -->
            <div class="border-t border-arcane-700/50 pt-6">
                <p class="<?= $labelClass ?> mb-4">Catégories</p>
                <?php if (empty($categories)): ?>
                    <?php render_component('alert', [
                        'type'    => 'warning',
                        'message' => 'Aucune catégorie disponible.',
                    ]); ?>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        <?php foreach ($categories as $category): ?>
                            <label class="relative flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="category_ids[]"
                                       value="<?= (int)$category['id'] ?>"
                                       <?= in_array($category['id'], $currentCategoryIds) ? 'checked' : '' ?>
                                       class="h-4 w-4 rounded border-arcane-700 bg-arcane-900 accent-mystic-500 cursor-pointer">
                                <span class="text-sm font-medium text-mystic-900/70 dark:text-mystic-100/70 group-hover:text-mystic-500 transition-colors">
                                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="pt-5 flex items-center justify-end gap-4 border-t border-arcane-700/50">
                <?php render_component('button', [
                    'type'    => 'a',
                    'href'    => '/pages/admin/products/products.php',
                    'label'   => 'Annuler',
                    'variant' => 'ghost',
                ]); ?>
                <?php render_component('button', [
                    'label'    => 'Enregistrer les modifications',
                    'variant'  => 'primary',
                    'attrType' => 'submit',
                ]); ?>
            </div>

        </form>
    </div>
</div>

<?php render_component('modal', [
    'id'         => 'imageSizeErrorModal',
    'title'      => 'Fichier trop lourd',
    'body'       => "L'image sélectionnée dépasse la limite de 2 Mo. Veuillez choisir un fichier plus léger.",
    'actionText' => 'Compris',
    'actionUrl'  => '#',
    'theme'      => 'danger',
]); ?>

<script>
    document.getElementById('image-input').addEventListener('change', function(evt) {
        const file = evt.target.files[0];
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const placeholder = document.getElementById('preview-placeholder');
        const errorModal = document.getElementById('imageSizeErrorModal');
        const originalSrc = preview.src;
        const wasHidden = container.classList.contains('hidden');

        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                errorModal.classList.remove('hidden');
                this.value = '';
                if (wasHidden) {
                    container.classList.add('hidden');
                    if (placeholder) placeholder.classList.remove('hidden');
                } else {
                    preview.src = originalSrc;
                }
                return;
            }
            preview.src = URL.createObjectURL(file);
            container.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
    });

    const modal = document.getElementById('imageSizeErrorModal');
    modal.querySelector('a').addEventListener('click', function(e) {
        e.preventDefault();
        modal.classList.add('hidden');
    });
</script>
