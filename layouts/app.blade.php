<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Techblef</title>
    <link rel="stylesheet" href="{{ asset('output.css') }}">
    <link rel="stylesheet" href="/output.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-[#0b0e1e] text-white font-sans">

    <!-- NAVBAR -->
    <header>
        <div class="flex items-center justify-between p-4 bg-black/20">
            <div class="w-14 h-14 bg-white/10 border rounded flex items-center justify-center">
                <a href="/">
                    <img src="/Logo.png" class="w-12">
                </a>
            </div>

            <input type="text"
                   placeholder="WYSZUKIWARKA"
                   class="w-1/2 px-4 py-2 rounded-full bg-purple-900/40 border border-purple-500/40">

            <div class="flex gap-4">
                <a href="/koszyk">🛒</a>
                <a href="/profil">👤</a>
            </div>
        </div>

        <nav class="flex justify-center gap-10 py-4 text-xs uppercase">
            <a href="#">Polecane produkty</a>
            <a href="#">Oferty promocyjne</a>
            <a href="#">Kategorie</a>
            <a href="/konfigurator">Konfigurator PC</a>
        </nav>
    </header>

    <!-- CONTENT -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="p-10 border-t border-cyan-400/20">
        <h2>Informacje</h2>
        <p>techblef@gmail.com</p>
    </footer>

</body>
</html>