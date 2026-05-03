<div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 mb-8 flex justify-between items-center transition-colors">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Bienvenue, <?= htmlspecialchars($_SESSION['company']) ?></h1>
        <?php if ($_SESSION['is_admin']): ?>
            <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-xs font-bold px-2 py-1 rounded mt-2 inline-block">Administrateur</span>
        <?php endif; ?>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 transition-colors">
    <h2 class="text-xl font-bold text-slate-700 dark:text-slate-200 mb-4">Vos statistiques</h2>
    <p class="text-slate-500 dark:text-slate-400">Bientôt, vous retrouverez vos commandes ici.</p>
</div>