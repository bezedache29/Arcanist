<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Catalogue Produits</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($products)): ?>
        <p class="text-slate-500 dark:text-slate-400">Aucun produit disponible pour le moment.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all">
                <h2 class="text-xl font-bold text-slate-700 dark:text-slate-100"><?= htmlspecialchars($product['name']) ?></h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed"><?= htmlspecialchars($product['description']) ?></p>

                <div class="mt-6 flex justify-between items-center border-t border-slate-100 dark:border-slate-700 pt-4">
                    <span class="text-2xl font-black text-blue-600 dark:text-blue-400"><?= number_format($product['price'], 2, ',', ' ') ?> €</span>
                    <span class="text-xs font-semibold px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full">
                        Stock : <?= htmlspecialchars($product['stock']) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>