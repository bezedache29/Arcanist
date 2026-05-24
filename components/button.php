<?php

/**
 * @var string|null $label
 * @var string|null $type
 * @var string|null $variant
 * @var string|null $size
 * @var string|null $href
 * @var string|null $extraClass
 * @var string|null $attrType
 * @var string|null $onclick
 */

$type = $type ?? 'button';
$variant = $variant ?? 'primary';
$size = $size ?? 'md';
$label = $label ?? 'Bouton';
$extraClass = $extraClass ?? '';
$onclick = $onclick ?? '';

$baseStyles = "inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95";

$variants = [
    'primary'   => 'bg-mystic-500 dark:border-mystic-500 text-mystic-900 shadow-glow-mystic hover:bg-mystic-400',
    'secondary' => 'bg-arcane-700 text-mystic-900 border border-arcane-500/30 dark:border-arcane-700 hover:bg-arcane-500 hover:text-mystic-100 dark:text-mystic-100',
    'outline'   => 'border border-mystic-500/50 text-mystic-500 hover:bg-mystic-500/10',
    'ghost'     => 'text-mystic-900/60 dark:text-mystic-100/60 hover:text-mystic-400 hover:bg-white/5',
    'danger'    => 'bg-arcane-500 text-mystic-100 hover:bg-red-700 shadow-glow-arcane'
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-6 py-2.5 text-sm',
    'lg' => 'px-8 py-3.5 text-base'
];

$classes = "{$baseStyles} {$variants[$variant]} {$sizes[$size]} {$extraClass}";
?>

<?php if ($type === 'a'): ?>
    <a href="<?= $href ?? '#' ?>" class="<?= $classes ?>" <?= $onclick ? "onclick=\"$onclick\"" : "" ?>>
        <?= $label ?>
    </a>
<?php else: ?>
    <button type="<?= $attrType ?? 'button' ?>" class="<?= $classes ?>" <?= $onclick ? "onclick=\"$onclick\"" : "" ?>>
        <?= $label ?>
    </button>
<?php endif; ?>