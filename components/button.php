<?php

/**
 * `@var` string|null $label       Libellé du bouton
 * `@var` string|null $type        Type d'élément : button | a
 * `@var` string|null $variant     Variante visuelle : primary | secondary | outline | ghost | danger
 * `@var` string|null $size        Taille : sm | md | lg
 * `@var` string|null $href        URL cible (pour type='a')
 * `@var` string|null $extraClass  Classes CSS supplémentaires
 * `@var` string|null $attrType    Type d'attribut HTML : button | submit | reset
 * `@var` string|null $onclick     Code JavaScript inline
 * `@var` bool|null   $disabled    État désactivé
 */

$type       = $type ?? 'button';
$variant    = $variant ?? 'primary';
$size       = $size ?? 'md';
$label      = $label ?? 'Bouton';
$extraClass = $extraClass ?? '';
$onclick    = $onclick ?? '';
$disabled   = $disabled ?? false;
$title      = $title ?? '';
$content    = $content ?? null;
$rawHtml    = $rawHtml ?? false;

$baseStyles = $disabled
    ? 'inline-flex items-center justify-center font-semibold rounded-lg opacity-40 cursor-not-allowed select-none'
    : 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95';

$variants = [
    'primary'   => 'bg-mystic-500 dark:border-mystic-500 text-mystic-900 shadow-glow-mystic hover:bg-mystic-400',
    'secondary' => 'bg-arcane-700/50 border border-arcane-700 text-mystic-900 dark:text-mystic-100 hover:bg-arcane-700',
    'outline'   => 'border border-mystic-500/50 text-mystic-500 hover:bg-mystic-500/10',
    'ghost'     => 'text-mystic-900/60 dark:text-mystic-100/60 hover:text-mystic-400 hover:bg-white/5',
    'danger'    => 'bg-arcane-500 text-mystic-100 hover:bg-red-700 shadow-glow-arcane',
    'none'      => '',
];

$sizes = [
    'sm'   => 'px-3 py-1.5 text-xs',
    'md'   => 'px-6 py-2.5 text-sm',
    'lg'   => 'px-8 py-3.5 text-base',
    'icon' => 'p-2',
];

$classes = $baseStyles . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . $extraClass;
?>

<?php if ($type === 'a'): ?>
    <a href="<?= htmlspecialchars($href ?? '#', ENT_QUOTES, 'UTF-8') ?>"
        class="<?= htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') ?>"
        <?= $onclick ? 'onclick="' . htmlspecialchars($onclick, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
        <?= $disabled ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
        <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
    </a>
<?php else: ?>
    <button type="<?= htmlspecialchars($attrType ?? 'button', ENT_QUOTES, 'UTF-8') ?>"
        class="<?= htmlspecialchars($classes, ENT_QUOTES, 'UTF-8') ?>"
        <?= $onclick ? 'onclick="' . htmlspecialchars($onclick, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
        <?= $title ? 'title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
        <?= $disabled ? 'disabled aria-disabled="true"' : '' ?>>
        <?= ($content !== null && $rawHtml) ? $content : htmlspecialchars($content ?? $label, ENT_QUOTES, 'UTF-8') ?>
    </button>
<?php endif; ?>