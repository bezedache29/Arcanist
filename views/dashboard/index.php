<?php
/**
 * @var int   $order_count
 * @var int   $product_count
 * @var float $total_spent
 */
?>
<?php render_component('title', [
    'text'  => 'Bienvenue, ' . htmlspecialchars($_SESSION['company'], ENT_QUOTES, 'UTF-8'),
    'level' => 1,
]); ?>

<div class="flex flex-wrap items-center gap-3 mt-3 mb-10">
    <?php if ($_SESSION['is_admin']): ?>
        <?php render_component('badge', ['text' => 'Administrateur', 'variant' => 'mystic']); ?>
    <?php endif; ?>
    <?php render_component('badge', ['text' => 'Espace professionnel B2B', 'variant' => 'default']); ?>
</div>

<!-- Statistiques -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

    <a href="/pages/orders/orders.php"
       class="bg-arcane-800 rounded-xl border border-arcane-700 p-6 hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all group block">
        <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 mb-3">Commandes</p>
        <p class="font-grimoire text-4xl text-mystic-500 font-bold group-hover:text-mystic-400 transition-colors"><?= $order_count ?></p>
        <p class="text-xs text-mystic-900/50 dark:text-mystic-100/40 mt-2"><?= $order_count > 0 ? 'commande' . ($order_count > 1 ? 's' : '') . ' passée' . ($order_count > 1 ? 's' : '') : 'Aucune commande' ?></p>
    </a>

    <a href="/pages/purchases/purchases.php"
       class="bg-arcane-800 rounded-xl border border-arcane-700 p-6 hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all group block">
        <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 mb-3">Produits achetés</p>
        <p class="font-grimoire text-4xl text-mystic-500 font-bold group-hover:text-mystic-400 transition-colors"><?= $product_count ?></p>
        <p class="text-xs text-mystic-900/50 dark:text-mystic-100/40 mt-2"><?= $product_count > 0 ? 'unité' . ($product_count > 1 ? 's' : '') . ' commandée' . ($product_count > 1 ? 's' : '') : 'Aucun achat' ?></p>
    </a>

    <div class="bg-arcane-800 rounded-xl border border-arcane-700 p-6 hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all">
        <p class="text-[10px] font-bold uppercase tracking-widest text-mystic-900/40 dark:text-mystic-100/30 mb-3">Dépenses HT</p>
        <p class="font-grimoire text-4xl text-mystic-500 font-bold"><?= number_format($total_spent, 2, ',', ' ') ?> €</p>
        <p class="text-xs text-mystic-900/50 dark:text-mystic-100/40 mt-2"><?= $total_spent > 0 ? 'total hors taxes' : 'Aucune dépense' ?></p>
    </div>

</div>

<!-- Accès rapides -->
<div class="bg-arcane-800 rounded-xl border border-arcane-700 p-6">
    <?php render_component('title', ['text' => 'Accès rapides', 'level' => 2]); ?>
    <p class="mt-2 mb-5 text-sm text-mystic-900/60 dark:text-mystic-100/50">
        Naviguez vers les sections disponibles de votre espace professionnel.
    </p>
    <div class="flex flex-wrap gap-3">
        <?php render_component('button', [
            'type'    => 'a',
            'href'    => '/pages/shop.php',
            'label'   => 'Parcourir le catalogue',
            'variant' => 'primary',
        ]); ?>
        <?php render_component('button', [
            'type'    => 'a',
            'href'    => '/pages/orders/orders.php',
            'label'   => 'Mes commandes',
            'variant' => 'secondary',
        ]); ?>
        <?php render_component('button', [
            'type'    => 'a',
            'href'    => '/pages/purchases/purchases.php',
            'label'   => 'Produits achetés',
            'variant' => 'secondary',
        ]); ?>
        <?php if ($_SESSION['is_admin']): ?>
            <?php render_component('button', [
                'type'    => 'a',
                'href'    => '/pages/admin/dashboard.php',
                'label'   => 'Administration',
                'variant' => 'outline',
            ]); ?>
        <?php endif; ?>
    </div>
</div>
