<div class="mb-8">
    <a href="/pages/admin/categories/categories.php" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium flex items-center transition">
        &larr; Retour aux catégories
    </a>
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mt-4">Ajouter une catégorie</h1>
</div>

<div class="bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 sm:rounded-xl overflow-hidden transition-colors max-w-xl">
    <div class="p-6 sm:p-8">

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded relative mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="/pages/admin/categories/categories_create.php" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nom <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 py-2 px-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 text-slate-900 dark:text-white transition-colors">
            </div>

            <div class="pt-4 flex items-center justify-end space-x-4 border-t border-slate-200 dark:border-slate-700 mt-8">
                <a href="/pages/admin/categories/categories.php" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 transition-colors">
                    Annuler
                </a>
                <button type="submit" class="inline-flex justify-center rounded-md bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition-colors">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>