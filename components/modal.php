<?php
$id = $id ?? 'modal';
$title = $title ?? 'Confirmation';
$body = $body ?? 'Êtes-vous sûr de vouloir continuer ?';
$actionText = $actionText ?? 'Confirmer';
$actionUrl = $actionUrl ?? '#';
$theme = $theme ?? 'primary';
// Nouveaux paramètres pour activer le mode Formulaire POST sécurisé
$isPost = $isPost ?? false;
$csrfToken = $csrfToken ?? '';

// Application des couleurs et de l'icone selon le theme
if ($theme === 'danger') {
    $iconBg = 'bg-red-100 dark:bg-red-900/30';
    $iconColor = 'text-red-600 dark:text-red-500';
    $btnBg = 'bg-red-600 hover:bg-red-500';
    $iconSvg = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
} else {
    $iconBg = 'bg-blue-100 dark:bg-blue-900/30';
    $iconColor = 'text-blue-600 dark:text-blue-500';
    $btnBg = 'bg-blue-600 hover:bg-blue-500';
    $iconSvg = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>';
}
?>

<div id="<?= htmlspecialchars($id) ?>" class="hidden relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-xl bg-white dark:bg-slate-800 text-left shadow-xl transition-all sm:w-full sm:max-w-md border dark:border-slate-700">

                <!-- Si le mode POST est actif, on englobe le contenu dans un formulaire -->
                <?php if ($isPost): ?>
                    <form action="<?= htmlspecialchars($actionUrl) ?>" method="POST" id="<?= htmlspecialchars($id) ?>-form">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <!-- Input caché qui recevra l'ID dynamiquement via JS -->
                        <input type="hidden" name="id" id="<?= htmlspecialchars($id) ?>-target-id" value="">
                    <?php endif; ?>

                    <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full <?= $iconBg ?> <?= $iconColor ?> sm:mx-0 sm:h-10 sm:w-10">
                                <?= $iconSvg ?>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-slate-900 dark:text-slate-100" id="modal-title"><?= htmlspecialchars($title) ?></h3>
                                <div class="mt-2">
                                    <p class="text-sm text-slate-500 dark:text-slate-400"><?= htmlspecialchars($body) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-700/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <!-- Si mode POST = bouton submit. Sinon = lien normal -->
                        <?php if ($isPost): ?>
                            <button type="submit" class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto transition-colors <?= $btnBg ?>">
                                <?= htmlspecialchars($actionText) ?>
                            </button>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($actionUrl) ?>" class="inline-flex w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm sm:ml-3 sm:w-auto transition-colors <?= $btnBg ?>">
                                <?= htmlspecialchars($actionText) ?>
                            </a>
                        <?php endif; ?>

                        <button onclick="document.getElementById('<?= htmlspecialchars($id) ?>').classList.add('hidden')" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-slate-200 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 dark:hover:bg-slate-600 sm:mt-0 sm:w-auto transition-colors">
                            Annuler
                        </button>
                    </div>

                    <?php if ($isPost): ?>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>