<div class="bg-arcane-800 border border-arcane-700 rounded-2xl p-8 shadow-glow-mystic">

    <div class="text-center mb-8">
        <?php render_component('title', ['text' => 'Créer un compte', 'level' => 1, 'extraClass' => 'text-center']); ?>
        <p class="mt-2 text-sm text-mystic-900/50 dark:text-mystic-100/40">Espace professionnel B2B</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="mb-6">
            <?php render_component('alert', ['type' => 'error', 'message' => $error]); ?>
        </div>
    <?php endif; ?>

    <form action="/pages/auth/register.php" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <?php render_component('input', [
            'name'     => 'company_name',
            'label'    => "Nom de l'entreprise",
            'required' => true,
        ]); ?>
        <?php render_component('input', [
            'name'        => 'email',
            'type'        => 'email',
            'label'       => 'Email pro',
            'placeholder' => 'contact@entreprise.fr',
            'required'    => true,
        ]); ?>
        <?php render_component('input', [
            'name'       => 'password',
            'type'       => 'password',
            'label'      => 'Mot de passe',
            'required'   => true,
            'showToggle' => true,
        ]); ?>
        <?php render_component('input', [
            'name'       => 'password_confirm',
            'type'       => 'password',
            'label'      => 'Confirmer le mot de passe',
            'required'   => true,
            'showToggle' => true,
        ]); ?>

        <div class="pt-2">
            <?php render_component('button', [
                'label'      => "S'inscrire",
                'variant'    => 'primary',
                'attrType'   => 'submit',
                'size'       => 'lg',
                'extraClass' => 'w-full justify-center',
            ]); ?>
        </div>
    </form>

    <div class="mt-6 border-t border-arcane-700 pt-6 text-center">
        <p class="text-sm text-mystic-900/50 dark:text-mystic-100/50">
            Déjà un compte ?
            <a href="/" class="text-mystic-500 hover:text-mystic-400 transition-colors font-semibold ml-1">Se connecter</a>
        </p>
    </div>

</div>
