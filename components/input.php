<?php

/**
 * @var string|null $type
 * @var string $name
 * @var string|null $id
 * @var string|null $label
 * @var string|null $placeholder
 * @var string|null $value
 * @var bool|null $required
 * @var string|null $error
 * @var string|null $extraClass
 * @var bool|null $showToggle
 */

$type = $type ?? 'text';
$name = $name ?? '';
$id = $id ?? $name;
$label = $label ?? '';
$placeholder = $placeholder ?? '';
$value = $value ?? '';
$required = $required ?? false;
$error = $error ?? '';
$extraClass = $extraClass ?? '';
$showToggle = ($showToggle ?? false) && $type === 'password';

// Base des styles
$baseInputClass = "w-full bg-arcane-900 dark:bg-arcane-700 text-mystic-900 dark:text-mystic-100 border rounded-lg py-2.5 font-ui transition-all duration-300 focus:outline-none focus:ring-1 placeholder-mystic-900/30 dark:placeholder-mystic-100/30";
$baseInputClass .= $showToggle ? " pl-4 pr-11" : " px-4";

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

    <?php if ($showToggle): ?>
        <div class="relative">
        <?php endif; ?>

        <input
            type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
            name="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
            id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>"
            value="<?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?>"
            placeholder="<?= htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8') ?>"
            <?= $required ? 'required' : '' ?>
            class="<?= htmlspecialchars($inputClass, ENT_QUOTES, 'UTF-8') ?>">

        <?php if ($showToggle): ?>
            <button
                type="button"
                aria-label="Show / hide password"
                onclick="(function(btn){
                var input = btn.parentElement.querySelector('input');
                var isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                btn.querySelector('.icon-eye').classList.toggle('hidden', isHidden);
                btn.querySelector('.icon-eye-off').classList.toggle('hidden', !isHidden);
            })(this)"
                class="absolute inset-y-0 right-0 flex items-center px-3 text-mystic-900/40 dark:text-mystic-100/40 hover:text-mystic-500 dark:hover:text-mystic-400 transition-colors">
                <!-- Œil ouvert -->
                <svg class="icon-eye w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <!-- Œil barré -->
                <svg class="icon-eye-off w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <p class="text-xs text-arcane-500 mt-0.5 ml-1 font-medium"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</div>