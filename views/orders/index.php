<?php
/**
 * @var array[] $orders
 */

$statusMap = [
    'pending'   => ['label' => 'En attente',  'variant' => 'warning'],
    'completed' => ['label' => 'Livrée',       'variant' => 'success'],
    'cancelled' => ['label' => 'Annulée',      'variant' => 'danger'],
    'shipped'   => ['label' => 'Expédiée',     'variant' => 'info'],
];
?>

<?php render_component('title', ['text' => 'Mes commandes', 'level' => 1]); ?>

<div class="mt-2 mb-8 flex items-center gap-3">
    <?php render_component('badge', [
        'text'    => count($orders) . ' commande' . (count($orders) > 1 ? 's' : ''),
        'variant' => 'default',
    ]); ?>
</div>

<?php if (empty($orders)): ?>

    <div class="flex flex-col items-center justify-center py-24 gap-6">
        <div class="w-20 h-20 rounded-full bg-arcane-800 border border-arcane-700 flex items-center justify-center">
            <svg class="w-10 h-10 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div class="text-center">
            <p class="font-grimoire text-xl text-mystic-900 dark:text-mystic-100 mb-2">Aucune commande</p>
            <p class="text-sm text-mystic-900/50 dark:text-mystic-100/50">Vos commandes passées apparaîtront ici.</p>
        </div>
        <?php render_component('button', [
            'type'  => 'a',
            'href'  => '/pages/shop.php',
            'label' => 'Parcourir le catalogue',
        ]); ?>
    </div>

<?php else: ?>

    <div class="flex flex-col gap-4">
        <?php foreach ($orders as $order):
            $status  = $statusMap[$order['status']] ?? ['label' => $order['status'], 'variant' => 'default'];
            $totalTTC = (float)$order['total_amount'] * 1.20;
        ?>
        <a href="/pages/orders/order.php?id=<?= (int)$order['id'] ?>"
           class="bg-arcane-800 border border-arcane-700 rounded-xl p-5 hover:border-mystic-500/40 hover:shadow-glow-mystic transition-all flex flex-col sm:flex-row sm:items-center gap-4 group">

            <!-- Numéro + date -->
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-1">
                    <span class="font-grimoire text-lg text-mystic-900 dark:text-mystic-100 group-hover:text-mystic-500 transition-colors">
                        Commande #<?= str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?>
                    </span>
                    <?php render_component('badge', [
                        'text'    => $status['label'],
                        'variant' => $status['variant'],
                        'size'    => 'sm',
                    ]); ?>
                </div>
                <p class="text-xs text-mystic-900/50 dark:text-mystic-100/40">
                    <?= date('d/m/Y à H\hi', strtotime($order['created_at'])) ?>
                    &nbsp;·&nbsp;
                    <?= (int)$order['unit_count'] ?> article<?= $order['unit_count'] > 1 ? 's' : '' ?>
                    sur <?= (int)$order['item_count'] ?> référence<?= $order['item_count'] > 1 ? 's' : '' ?>
                </p>
            </div>

            <!-- Montants -->
            <div class="flex sm:flex-col items-center sm:items-end gap-4 sm:gap-1 shrink-0">
                <p class="font-ui font-bold text-xl text-mystic-500">
                    <?= number_format($order['total_amount'], 2, ',', ' ') ?> € <span class="text-xs font-normal text-mystic-100/40">HT</span>
                </p>
                <p class="text-xs text-mystic-900/40 dark:text-mystic-100/30">
                    <?= number_format($totalTTC, 2, ',', ' ') ?> € TTC
                </p>
            </div>

            <!-- Flèche -->
            <div class="hidden sm:flex shrink-0 text-mystic-900/20 dark:text-mystic-100/20 group-hover:text-mystic-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>

        </a>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
