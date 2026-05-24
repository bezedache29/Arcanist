<?php

/**
 * @var string|null $text
 * @var string|null $variant  default | mystic | success | warning | danger | info
 * @var string|null $size     sm | md
 * @var string|null $extraClass
 */

$text       = $text ?? 'Badge';
$variant    = $variant ?? 'default';
$size       = $size ?? 'md';
$extraClass = $extraClass ?? '';

$variants = [
    'default' => 'bg-arcane-700/40 text-mystic-900/60 dark:text-mystic-100/60 border border-arcane-700/60 dark:border-arcane-700',
    'mystic'  => 'bg-mystic-500/10 text-mystic-600 dark:text-mystic-400 border border-mystic-500/30',
    'success' => 'bg-emerald-100 text-emerald-700 border border-emerald-300 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/30',
    'warning' => 'bg-amber-100 text-amber-700 border border-amber-300 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/30',
    'danger'  => 'bg-red-100 text-red-700 border border-red-300 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30',
    'info'    => 'bg-sky-100 text-sky-700 border border-sky-300 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/30',
];

$sizes = [
    'sm' => 'text-[10px] px-2 py-0.5',
    'md' => 'text-xs px-2.5 py-1',
];

$classes = 'inline-flex items-center font-ui font-semibold uppercase tracking-wider rounded-full '
    . ($variants[$variant] ?? $variants['default']) . ' '
    . ($sizes[$size] ?? $sizes['md']) . ' '
    . $extraClass;
?>

<span class="<?= htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') ?>">
    <?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?>
</span>
