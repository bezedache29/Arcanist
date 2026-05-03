<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Le CDN Tailwind : Il fait tout le travail tout seul ! -->
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Arcanist - B2B</title>
</head>

<body class="bg-slate-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-slate-800 mb-6">Arcanist B2B</h1>

        <form action="#" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700">Email pro</label>
                <input type="email" class="mt-1 w-full p-2 border border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Mot de passe</label>
                <input type="password" class="mt-1 w-full p-2 border border-slate-300 rounded focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                Se connecter
            </button>
        </form>

        <!-- Mode Invité pour les recruteurs -->
        <div class="mt-6 border-t pt-4">
            <a href="/shop" class="block w-full text-center border-2 border-green-500 text-green-600 font-bold py-2 px-4 rounded hover:bg-green-50 transition">
                Accès Démo (Invité)
            </a>
        </div>
    </div>

</body>

</html>