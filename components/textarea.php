<?php

/**
 * @var string $name
 * @var string|null $id
 * @var string|null $label
 * @var string|null $placeholder
 * @var string|null $value
 * @var bool|null $required
 * @var string|null $error
 * @var string|null $extraClass
 */

$name = $name ?? '';
$id = $id ?? $name;
$label = $label ?? '';
$placeholder = $placeholder ?? '';
$value = $value ?? '';
$required = $required ?? false;
$error = $error ?? '';
$extraClass = $extraClass ?? '';

// Base des styles
$baseInputClass = "w-full bg-arcane-900 dark:bg-arcane-700 text-mystic-900 dark:text-mystic-100 border rounded-lg px-4 py-2.5 font-ui transition-all duration-300 focus:outline-none focus:ring-1 placeholder-mystic-900/30 dark:placeholder-mystic-100/30";

// Gestion du style selon l'état (Normal vs Erreur)
if (!empty($error)) {
    $inputClass = $baseInputClass . " border-arcane-500 focus:border-arcane-500 focus:ring-arcane-500 bg-arcane-500/5";
} else {
    // On s'assure que la bordure est visible mais douce
    $inputClass = $baseInputClass . " border-arcane-700 focus:border-mystic-500 focus:ring-mystic-500 hover:border-mystic-600";
}
?>

<div class="flex flex-col gap-1.5 <?= htmlspecialchars($extraClass, ENT_QUOTES, 'UTF-8') ?>">
    <?php if ($label): ?>
        <label for="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" class="text-xs font-bold uppercase tracking-wider text-mystic-900/50 dark:text-mystic-100/50 ml-1">
            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?> <?php if ($required): ?><span class="text-arcane-500 ml-0.5">*</span><?php endif; ?>
        </label>
    <?php endif; ?>

    <textarea
        name="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
        id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"
        placeholder="<?= htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8') ?>"
        <?= $required ? 'required' : '' ?>
        class="<?= htmlspecialchars($inputClass, ENT_QUOTES, 'UTF-8') ?> min-h-[120px] resize-y"><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></textarea>

    <?php if (!empty($error)): ?>
        <p class="text-xs text-arcane-500 mt-0.5 ml-1 font-medium"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</div>