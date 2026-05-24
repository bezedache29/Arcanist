<?php

/**
 * `@var` string|null $type         Type d'alerte : success | error | warning | info
 * `@var` string|null $message      Message à afficher
 * `@var` string|null $title        Titre optionnel
 * `@var` bool|null   $dismissible  Si vrai, affiche le bouton de fermeture
 * `@var` string|null $id           Identifiant HTML unique
 */

$type        = $type ?? 'info';
$message     = $message ?? '';
$title       = $title ?? null;
$dismissible = $dismissible ?? false;
$id          = $id ?? 'alert-' . substr(md5(uniqid()), 0, 8);

$icons = [
    'success' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'error'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
    'warning' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>',
    'info'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>',
];

$styles = [
    'success' => [
        'wrap'  => 'bg-emerald-50 border-emerald-200 dark:bg-emerald-500/10 dark:border-emerald-500/25',
        'icon'  => 'text-emerald-600 dark:text-emerald-400',
        'title' => 'text-emerald-700 dark:text-emerald-300',
        'text'  => 'text-emerald-700/80 dark:text-emerald-400/80',
    ],
    'error' => [
        'wrap'  => 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800/30',
        'icon'  => 'text-red-600 dark:text-red-400',
        'title' => 'text-red-700 dark:text-red-300',
        'text'  => 'text-red-700/80 dark:text-red-400/80',
    ],
    'warning' => [
        'wrap'  => 'bg-amber-50 border-amber-200 dark:bg-amber-500/10 dark:border-amber-500/25',
        'icon'  => 'text-amber-600 dark:text-amber-400',
        'title' => 'text-amber-700 dark:text-amber-300',
        'text'  => 'text-amber-700/80 dark:text-amber-400/80',
    ],
    'info' => [
        'wrap'  => 'bg-sky-50 border-sky-200 dark:bg-sky-500/10 dark:border-sky-500/25',
        'icon'  => 'text-sky-600 dark:text-sky-400',
        'title' => 'text-sky-700 dark:text-sky-300',
        'text'  => 'text-sky-700/80 dark:text-sky-400/80',
    ],
];

$s    = $styles[$type] ?? $styles['info'];
$icon = $icons[$type]  ?? $icons['info'];
?>

<div id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" role="alert"
    class="flex gap-3 rounded-xl border p-4 font-ui <?= $s['wrap'] ?>">

    <svg class="h-5 w-5 flex-shrink-0 mt-0.5 <?= $s['icon'] ?>" fill="none" viewBox="0 0 24 24"
        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <?= $icon ?>
    </svg>

    <div class="flex-1 min-w-0">
        <?php if ($title): ?>
            <p class="text-sm font-semibold mb-1 <?= $s['title'] ?>"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <p class="text-sm <?= $s['text'] ?>"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    </div>

    <?php if ($dismissible): ?>
        <button type="button"
            onclick="document.getElementById('<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>').remove()"
            class="flex-shrink-0 <?= $s['icon'] ?> opacity-50 hover:opacity-100 transition-opacity"
            aria-label="Fermer cette alerte">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    <?php endif; ?>
</div>