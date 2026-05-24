<?php

/**
 * @var string|null $id
 * @var string|null $title
 * @var string|null $body
 * @var string|null $actionText
 * @var string|null $actionUrl
 * @var string|null $theme
 * @var bool|null $isPost
 * @var string|null $csrfToken
 */

$id = $id ?? 'modal';
$title = $title ?? 'Confirmation';
$body = $body ?? 'Êtes-vous sûr de vouloir continuer ?';
$actionText = $actionText ?? 'Confirmer';
$actionUrl = $actionUrl ?? '#';
$theme = $theme ?? 'primary';
$isPost = $isPost ?? false;
$csrfToken = $csrfToken ?? '';

// Configuration visuelle selon le thème
$isDanger = ($theme === 'danger');
$iconBg = $isDanger ? 'bg-arcane-900/80 border border-arcane-500/30' : 'bg-mystic-900/40 border border-mystic-600/30 shadow-glow-mystic';
$iconColor = $isDanger ? 'text-arcane-500' : 'text-mystic-500';
$titleColor = $isDanger ? 'text-arcane-500' : 'text-mystic-500';
$modalGlow = $isDanger ? 'shadow-glow-arcane' : 'shadow-glow-mystic';
$btnVariant = $isDanger ? 'danger' : 'primary';

$iconSvg = $isDanger
    ? '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>'
    : '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>';
?>

<div id="<?= htmlspecialchars($id) ?>" class="hidden relative z-50 font-ui" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-arcane-900/80 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-xl bg-arcane-800 text-left transition-all sm:w-full sm:max-w-md border border-arcane-700 <?= $modalGlow ?>">

                <?php if ($isPost): ?>
                    <form action="<?= htmlspecialchars($actionUrl) ?>" method="POST" id="<?= htmlspecialchars($id) ?>-form">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="id" id="<?= htmlspecialchars($id) ?>-target-id" value="">
                    <?php endif; ?>

                    <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full <?= $iconBg ?> <?= $iconColor ?> sm:mx-0 sm:h-10 sm:w-10">
                                <?= $iconSvg ?>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <?php render_component('title', [
                                    'text' => $title,
                                    'level' => 3,
                                    'extraClass' => $titleColor
                                ]); ?>
                                <div class="mt-2">
                                    <p class="text-sm text-mystic-100/70"><?= htmlspecialchars($body) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-arcane-900/50 border-t border-arcane-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">

                        <?php render_component('button', [
                            'type' => $isPost ? 'button' : 'a',
                            'attrType' => $isPost ? 'submit' : 'button',
                            'href' => $isPost ? null : $actionUrl,
                            'label' => $actionText,
                            'variant' => $btnVariant,
                            'size' => 'md',
                            'extraClass' => 'w-full sm:w-auto'
                        ]); ?>

                        <?php render_component('button', [
                            'label' => 'Annuler',
                            'variant' => 'secondary',
                            'size' => 'md',
                            'onclick' => "document.getElementById('$id').classList.add('hidden')",
                            'extraClass' => 'w-full sm:w-auto mt-3 sm:mt-0'
                        ]); ?>
                    </div>

                    <?php if ($isPost): ?>
                    </form>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>