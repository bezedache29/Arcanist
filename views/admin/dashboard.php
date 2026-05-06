<?php

/**
 * @var array $stats
 */
?>
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Vue d'ensemble</h1>
    <p class="mt-2 text-sm text-slate-700 dark:text-slate-400">Bienvenue dans votre espace d'administration. Voici un résumé de votre activité.</p>
</div>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Carte Produits -->
    <div class="overflow-hidden rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 transition-colors">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-blue-50 dark:bg-blue-900/30 p-3">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-slate-500 dark:text-slate-400">Produits actifs</dt>
                        <dd class="text-lg font-semibold text-slate-900 dark:text-slate-100"><?= $stats['products'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 dark:bg-slate-900/50 px-5 py-3">
            <div class="text-sm">
                <a href="/pages/admin/products/products.php" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">Voir les produits</a>
            </div>
        </div>
    </div>

    <!-- Carte Categories -->
    <div class="overflow-hidden rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 transition-colors">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-purple-50 dark:bg-purple-900/30 p-3">
                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-slate-500 dark:text-slate-400">Catégories</dt>
                        <dd class="text-lg font-semibold text-slate-900 dark:text-slate-100"><?= $stats['categories'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 dark:bg-slate-900/50 px-5 py-3">
            <div class="text-sm">
                <a href="/pages/admin/categories/categories.php" class="font-medium text-purple-600 dark:text-purple-400 hover:text-purple-500">Gérer les catégories</a>
            </div>
        </div>
    </div>

    <!-- Carte Clients -->
    <div class="overflow-hidden rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 transition-colors">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-green-50 dark:bg-green-900/30 p-3">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-slate-500 dark:text-slate-400">Clients B2B</dt>
                        <dd class="text-lg font-semibold text-slate-900 dark:text-slate-100"><?= $stats['clients'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 dark:bg-slate-900/50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-green-600 dark:text-green-400 opacity-50 cursor-not-allowed">Voir les clients</a>
            </div>
        </div>
    </div>

    <!-- Carte Commandes -->
    <div class="overflow-hidden rounded-lg bg-white dark:bg-slate-800 shadow-sm ring-1 ring-slate-200 dark:ring-slate-700 transition-colors">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-amber-50 dark:bg-amber-900/30 p-3">
                    <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-slate-500 dark:text-slate-400">En attente</dt>
                        <dd class="text-lg font-semibold text-slate-900 dark:text-slate-100"><?= $stats['pending_orders'] ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 dark:bg-slate-900/50 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-amber-600 dark:text-amber-400 opacity-50 cursor-not-allowed">Traiter les commandes</a>
            </div>
        </div>
    </div>
</div>