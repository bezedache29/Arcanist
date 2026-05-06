<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Gestion des Catégories</h1>
        <p class="mt-2 text-sm text-slate-700 dark:text-slate-400">Gérez les catégories pour organiser votre catalogue de produits.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="/pages/admin/categories/categories_create.php" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
            Ajouter une catégorie
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 sm:rounded-lg overflow-hidden transition-colors">
    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
        <thead class="bg-slate-50 dark:bg-slate-900/50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-slate-900 dark:text-slate-200 sm:pl-6">Nom de la catégorie</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-800">
            <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="2" class="py-8 text-center text-sm text-slate-500 dark:text-slate-400">Aucune catégorie n'a été créée pour le moment.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 dark:text-slate-100 sm:pl-6">
                            <?= htmlspecialchars($category['name']) ?>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <a href="/pages/admin/categories/categories_edit.php?id=<?= $category['id'] ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-4">Modifier</a>
                            <button onclick="openDeleteModal(<?= $category['id'] ?>)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal pour valider le soft delete -->
<?php render_component('modal', [
    'id' => 'deleteCategoryModal',
    'title' => 'Supprimer la catégorie',
    'body' => 'Êtes-vous sûr ? Les produits qui étaient liés à cette catégorie ne seront pas supprimés, mais perdront ce classement.',
    'actionText' => 'Supprimer',
    'actionUrl' => '#',
    'theme' => 'danger'
]); ?>

<script>
    function openDeleteModal(categoryId) {
        const modal = document.getElementById('deleteCategoryModal');
        const confirmBtn = modal.querySelector('a');
        confirmBtn.href = '/pages/admin/categories/categories_delete.php?id=' + categoryId;
        modal.classList.remove('hidden');
    }
</script>