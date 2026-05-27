<?php
/**
 * @var array   $order
 * @var array[] $items
 */

$statusMap = [
    'pending'   => ['label' => 'En attente',  'variant' => 'warning'],
    'completed' => ['label' => 'Livrée',       'variant' => 'success'],
    'cancelled' => ['label' => 'Annulée',      'variant' => 'danger'],
    'shipped'   => ['label' => 'Expédiée',     'variant' => 'info'],
];

$status   = $statusMap[$order['status']] ?? ['label' => $order['status'], 'variant' => 'default'];
$totalHT  = (float)$order['total_amount'];
$totalTVA = $totalHT * 0.20;
$totalTTC = $totalHT * 1.20;
$orderNum = '#' . str_pad($order['id'], 4, '0', STR_PAD_LEFT);
?>

<!-- Fil d'Ariane -->
<nav class="flex items-center gap-2 text-sm text-mystic-900/50 dark:text-mystic-100/40 mb-8">
    <a href="/pages/orders/orders.php" class="hover:text-mystic-500 transition-colors">Mes commandes</a>
    <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-mystic-900/80 dark:text-mystic-100/80">Commande <?= $orderNum ?></span>
</nav>

<!-- En-tête commande -->
<div class="bg-arcane-800 border border-arcane-700 rounded-xl p-6 mb-6 flex flex-col sm:flex-row sm:items-center gap-4">
    <div class="flex-1">
        <div class="flex items-center gap-3 mb-1">
            <?php render_component('title', ['text' => 'Commande ' . $orderNum, 'level' => 1]); ?>
            <?php render_component('badge', [
                'text'    => $status['label'],
                'variant' => $status['variant'],
            ]); ?>
        </div>
        <p class="text-sm text-mystic-900/50 dark:text-mystic-100/40 mt-2">
            Passée le <?= date('d/m/Y à H\hi', strtotime($order['created_at'])) ?>
        </p>
    </div>
    <div class="text-right shrink-0">
        <p class="text-[10px] text-mystic-100/40 uppercase tracking-widest mb-1">Total HT</p>
        <p class="font-ui font-bold text-3xl text-mystic-500"><?= number_format($totalHT, 2, ',', ' ') ?> €</p>
        <p class="text-xs text-mystic-900/40 dark:text-mystic-100/30 mt-0.5"><?= number_format($totalTTC, 2, ',', ' ') ?> € TTC</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- Liste des articles -->
    <div class="xl:col-span-2">
        <?php render_component('title', ['text' => 'Articles commandés', 'level' => 2]); ?>

        <div class="mt-4 flex flex-col gap-3">
            <?php foreach ($items as $item):
                $subtotal = (float)$item['unit_price'] * (int)$item['quantity'];
            ?>
            <div class="bg-arcane-800 border border-arcane-700 rounded-xl flex overflow-hidden">

                <!-- Image -->
                <div class="w-20 shrink-0 bg-arcane-900 flex items-center justify-center overflow-hidden">
                    <?php if (!empty($item['image_path'])): ?>
                        <img src="<?= htmlspecialchars($item['image_path'], ENT_QUOTES, 'UTF-8') ?>"
                             alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                             class="w-full h-full object-cover">
                    <?php else: ?>
                        <svg class="w-6 h-6 text-arcane-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    <?php endif; ?>
                </div>

                <!-- Détails -->
                <div class="flex-1 p-4 flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="flex-1">
                        <p class="font-grimoire text-base text-mystic-900 dark:text-mystic-100">
                            <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <p class="text-xs text-mystic-900/40 dark:text-mystic-100/40 mt-0.5">
                            <?= (int)$item['quantity'] ?> × <?= number_format($item['unit_price'], 2, ',', ' ') ?> € HT
                        </p>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="font-ui font-bold text-mystic-500"><?= number_format($subtotal, 2, ',', ' ') ?> € HT</p>
                        <p class="text-xs text-mystic-100/30"><?= number_format($subtotal * 1.20, 2, ',', ' ') ?> € TTC</p>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Récapitulatif financier -->
    <div class="xl:col-span-1">
        <div class="bg-arcane-800 border border-arcane-700 rounded-xl p-6 sticky top-24">
            <h2 class="font-grimoire text-lg text-mystic-900 dark:text-mystic-100 mb-6">Récapitulatif</h2>

            <div class="flex flex-col gap-3 text-sm">
                <?php
                $unitCount = array_sum(array_column($items, 'quantity'));
                $refCount  = count($items);
                ?>
                <div class="flex justify-between text-mystic-900/60 dark:text-mystic-100/50">
                    <span><?= $unitCount ?> article<?= $unitCount > 1 ? 's' : '' ?> (<?= $refCount ?> ref.)</span>
                </div>
                <div class="flex justify-between text-mystic-900/70 dark:text-mystic-100/60">
                    <span>Total HT</span>
                    <span><?= number_format($totalHT, 2, ',', ' ') ?> €</span>
                </div>
                <div class="flex justify-between text-mystic-900/70 dark:text-mystic-100/60">
                    <span>TVA (20 %)</span>
                    <span><?= number_format($totalTVA, 2, ',', ' ') ?> €</span>
                </div>
                <div class="border-t border-arcane-700 pt-3 flex justify-between font-bold text-base">
                    <span>Total TTC</span>
                    <span class="text-mystic-500"><?= number_format($totalTTC, 2, ',', ' ') ?> €</span>
                </div>
            </div>

            <div class="mt-6">
                <?php render_component('button', [
                    'type'       => 'a',
                    'href'       => '/pages/orders/orders.php',
                    'label'      => '← Mes commandes',
                    'variant'    => 'ghost',
                    'size'       => 'sm',
                    'extraClass' => 'w-full',
                ]); ?>
            </div>
        </div>
    </div>

</div>
