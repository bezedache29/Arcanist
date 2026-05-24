<?php

/**
 * @var int|null $level
 * @var string $text
 * @var string|null $extraClass
 */

$level = $level ?? 1;
$tag = "h" . $level;

$styles = [
    1 => 'font-grimoire text-4xl md:text-5xl text-mystic-500 font-bold tracking-wide',
    2 => 'font-grimoire text-2xl md:text-3xl text-mystic-500 font-semibold',
    3 => 'font-grimoire text-xl text-mystic-400 font-medium'
];

$class = $styles[$level] . ' ' . ($extraClass ?? '');
?>

<<?= $tag ?> class="<?= $class ?>">
    <?= $text ?>
</<?= $tag ?>>