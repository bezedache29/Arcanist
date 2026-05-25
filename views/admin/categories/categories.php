<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <?php render_component('title', ['text' => 'Gestion des Catégories', 'level' => 1]); ?>
        <p class="mt-1 text-sm text-mystic-900/60 dark:text-mystic-100/50">
            Organisez votre catalogue de produits par catégories.
        </p>
    </div>
    <?php render_component('button', [
        'type'    => 'a',
        'href'    => '/pages/admin/categories/categories_create.php',
        'label'   => 'Ajouter une catégorie',
        'variant' => 'primary',
        'size'    => 'sm',
    ]); ?>
</div>

<div class="bg-arcane-800 rounded-xl border border-arcane-700 overflow-hidden">
    <table class="min-w-full divide-y divide-arcane-700/50">
        <thead class="bg-arcane-900/50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 sm:pl-6">
                    Nom de la catégorie
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-arcane-700/30 bg-arcane-800">
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="2" class="py-10 px-6">
                        <?php render_component('alert', [
                            'type'    => 'info',
                            'message' => "Aucune catégorie n'a été créée pour le moment.",
                        ]); ?>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <tr class="hover:bg-arcane-700/20 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-mystic-900 dark:text-mystic-100 sm:pl-6">
                            <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="/pages/admin/categories/categories_edit.php?id=<?= (int)$category['id'] ?>"
                               class="text-mystic-500 hover:text-mystic-400 font-medium transition-colors mr-4">
                                Modifier
                            </a>
                            <button onclick="openDeleteModal(<?= (int)$category['id'] ?>)"
                                    class="text-arcane-500 hover:text-arcane-500/70 font-medium transition-colors">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php render_component('modal', [
    'id'         => 'deleteCategoryModal',
    'title'      => 'Supprimer la catégorie',
    'body'       => 'Êtes-vous sûr ? Les produits liés à cette catégorie ne seront pas supprimés, mais perdront ce classement.',
    'actionText' => 'Supprimer',
    'actionUrl'  => '#',
    'theme'      => 'danger',
]); ?>

<script>
    function openDeleteModal(categoryId) {
        const modal = document.getElementById('deleteCategoryModal');
        const confirmBtn = modal.querySelector('a');
        confirmBtn.href = '/pages/admin/categories/categories_delete.php?id=' + categoryId;
        modal.classList.remove('hidden');
    }
</script>
