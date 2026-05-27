<div class="mb-8">
    <a href="/pages/admin/categories/categories.php"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-mystic-500 hover:text-mystic-400 transition-colors mb-4">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour aux catégories
    </a>
    <?php render_component('title', ['text' => 'Ajouter une catégorie', 'level' => 1]); ?>
</div>

<div class="bg-arcane-800 rounded-xl border border-arcane-700 max-w-xl">
    <div class="p-6 sm:p-8">

        <?php if (!empty($error)): ?>
            <?php render_component('alert', ['type' => 'error', 'message' => $error]); ?>
            <div class="mb-6"></div>
        <?php endif; ?>

        <form action="/pages/admin/categories/categories_create.php" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

            <?php render_component('input', [
                'name'     => 'name',
                'label'    => 'Nom',
                'required' => true,
            ]); ?>

            <div class="pt-5 flex items-center justify-end gap-4 border-t border-arcane-700/50">
                <?php render_component('button', [
                    'type'    => 'a',
                    'href'    => '/pages/admin/categories/categories.php',
                    'label'   => 'Annuler',
                    'variant' => 'ghost',
                ]); ?>
                <?php render_component('button', [
                    'label'    => 'Enregistrer',
                    'variant'  => 'primary',
                    'attrType' => 'submit',
                ]); ?>
            </div>
        </form>

    </div>
</div>
