<div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-md border dark:border-slate-700 transition-colors">
    <h1 class="text-3xl font-bold text-center text-slate-800 dark:text-slate-100 mb-6">Arcanist B2B</h1>

    <?php if (!empty($error)): ?>
        <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-800 text-red-700 dark:text-red-400 px-4 py-3 rounded relative mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form action="/" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email pro</label>
            <input type="email" name="email" required class="mt-1 w-full p-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded focus:ring-blue-500 focus:border-blue-500 text-slate-900 dark:text-white transition-colors">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Mot de passe</label>
            <input type="password" name="password" required class="mt-1 w-full p-2 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded focus:ring-blue-500 focus:border-blue-500 text-slate-900 dark:text-white transition-colors">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
            Se connecter
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="/pages/auth/register.php" class="text-blue-600 dark:text-blue-400 font-bold hover:underline text-sm transition">Créer un compte entreprise</a>
    </div>

    <div class="mt-6 border-t dark:border-slate-700 pt-4 transition-colors">
        <a href="/pages/shop.php" class="block w-full text-center border-2 border-green-500 text-green-600 dark:text-green-500 font-bold py-2 px-4 rounded hover:bg-green-50 dark:hover:bg-green-900/20 transition">
            Accès Démo (Invité)
        </a>
    </div>
</div>