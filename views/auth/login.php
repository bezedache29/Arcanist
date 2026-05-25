<div class="bg-arcane-800 border border-arcane-700 rounded-2xl p-8 shadow-glow-mystic">

    <div class="text-center mb-8">
        <?php render_component('title', ['text' => 'Arcanist B2B', 'level' => 1, 'extraClass' => 'text-center']); ?>
        <p class="mt-2 text-sm text-mystic-900/50 dark:text-mystic-100/40">Espace professionnel</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="mb-6">
            <?php render_component('alert', ['type' => 'error', 'message' => $error]); ?>
        </div>
    <?php endif; ?>

    <form action="/" method="POST" class="space-y-4">
        <?php render_component('input', [
            'name'        => 'email',
            'type'        => 'email',
            'label'       => 'Email pro',
            'placeholder' => 'contact@entreprise.fr',
            'required'    => true,
        ]); ?>
        <?php render_component('input', [
            'name'        => 'password',
            'type'        => 'password',
            'label'       => 'Mot de passe',
            'required'    => true,
            'showToggle'  => true,
        ]); ?>

        <div class="pt-2">
            <?php render_component('button', [
                'label'      => 'Se connecter',
                'variant'    => 'primary',
                'attrType'   => 'submit',
                'size'       => 'lg',
                'extraClass' => 'w-full justify-center',
            ]); ?>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="/pages/auth/register.php"
            class="text-sm text-mystic-500 hover:text-mystic-400 transition-colors font-semibold">
            Créer un compte entreprise
        </a>
    </div>

    <div class="mt-6 border-t border-arcane-700 pt-6 space-y-3">
        <?php render_component('button', [
            'type'       => 'a',
            'href'       => '/pages/shop.php',
            'label'      => 'Accès Démo (Invité)',
            'variant'    => 'outline',
            'extraClass' => 'w-full justify-center',
        ]); ?>
        <?php render_component('button', [
            'type'       => 'a',
            'href'       => '/pages/styleguide.php',
            'label'      => 'Design System',
            'variant'    => 'ghost',
            'size'       => 'sm',
            'extraClass' => 'w-full justify-center',
        ]); ?>
    </div>

</div>
