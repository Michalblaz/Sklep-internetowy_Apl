<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techblef</title>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    <header>
        <div class="flex items-center justify-between p-4 bg-black/20">
            <div class="w-15 h-15 bg-linear-to-br from-[#101321]/80 to-[#190c30]/90 border border-white/10 rounded-xl flex items-center justify-center shadow-[0_0_15px_-3px] shadow-neon-purple/50 backdrop-blur-lg">
                <a href="/startowa">
                    <img src="{{ asset('images/logo.png') }}"
                        class="w-10 h-10 opacity-90 brightness-110 drop-shadow-[0_0_3px_#fff]"
                        alt="Logo">
                </a>
            </div>

            <input type="text"
                   placeholder="WYSZUKIWARKA"
                   class="w-1/2 px-4 py-2 rounded-full bg-purple-900/40 border border-purple-500/40 text-white placeholder-gray-400 focus:outline-none focus:border-purple-400">

            <div class="flex gap-4 text-2xl">
                <a href="/koszyk" title="Koszyk">🛒</a>
                <a href="/profil" title="Profil">👤</a>
            </div>
        </div>

        <nav class="flex justify-center gap-10 py-4 text-xs uppercase tracking-widest border-b border-white/5">
            <a href="#" class="hover:text-purple-400 transition">Polecane produkty</a>
            <a href="#" class="hover:text-purple-400 transition">Oferty promocyjne</a>
            <a href="#" class="hover:text-purple-400 transition">Kategorie</a>
            <a href="{{ route('products.index') }}" class="hover:text-purple-400 transition">Konfigurator PC</a>
        </nav>
    </header>

    <main class="p-6 grow">
        @yield('content')
    </main>

    <footer class="p-10 border-t border-cyan-400/20 bg-black/10">
        <h2 class="font-bold text-lg mb-2">Informacje</h2>
        <p class="text-gray-400 font-bruno">E-mail: techblef@gmail.com</p>
        <p class="text-gray-400 font-bruno">Numer kontaktowy: +48 109247685</p>
        <p class="text-gray-400 font-bruno">Lokalizacja: al. Tadeusza Rejtana 16C, 35-310 Rzeszów</p>
    </footer>

</body>
</html>
