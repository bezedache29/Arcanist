<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100">Catalogue Produits</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($products)): ?>
        <p class="text-slate-500 dark:text-slate-400 col-span-full">Aucun produit disponible pour le moment.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all flex flex-col overflow-hidden">

                <?php if (!empty($product['image_path'])): ?>
                    <img src="<?= htmlspecialchars($product['image_path']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-48 object-cover">
                <?php else: ?>
                    <div class="w-full h-48 bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center border-b border-slate-100 dark:border-slate-700">
                        <svg class="h-12 w-12 text-slate-300 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                <?php endif; ?>

                <div class="p-6 flex-1 flex flex-col">
                    <h2 class="text-xl font-bold text-slate-700 dark:text-slate-100"><?= htmlspecialchars($product['name']) ?></h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed flex-1"><?= htmlspecialchars($product['description']) ?></p>

                    <div class="mt-6 flex justify-between items-center border-t border-slate-100 dark:border-slate-700 pt-4">
                        <span class="text-2xl font-black text-blue-600 dark:text-blue-400"><?= number_format($product['price'], 2, ',', ' ') ?> €</span>
                        <span class="text-xs font-semibold px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full">
                            Stock : <?= htmlspecialchars($product['stock']) ?>
                        </span>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>