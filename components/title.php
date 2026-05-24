<?php

/**
 * @var int|null $level
 * @var string $text
 * @var string|null $extraClass
 */

$level = (int)($level ?? 1);
$level = max(1, min(6, $level));
$tag = 'h' . $level;

$styles = [
    1 => 'font-grimoire text-4xl md:text-5xl text-mystic-500 font-bold tracking-wide',
    2 => 'font-grimoire text-2xl md:text-3xl text-mystic-500 font-semibold',
    3 => 'font-grimoire text-xl text-mystic-400 font-medium'
];

$class = ($styles[$level] ?? $styles[1]) . ' ' . ($extraClass ?? '');
?>

<<?= $tag ?> class="<?= htmlspecialchars($class, ENT_QUOTES, 'UTF-8') ?>">
    <?= htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8') ?>
</<?= $tag ?>>