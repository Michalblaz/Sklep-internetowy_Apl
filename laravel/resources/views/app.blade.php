<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techblef</title>

    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        [id] {
            scroll-margin-top: 100px;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-[#0f172a] text-white">

<header>
    <div class="flex items-center justify-between p-4 bg-black/20">

        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}"
                 class="w-10 h-10">
        </a>

        <input type="text"
               placeholder="WYSZUKIWARKA"
               class="w-1/2 px-4 py-2 rounded-full bg-purple-900/40 border border-purple-500/40 text-white">

        <div class="flex gap-4 text-2xl items-center">

    <a href="/koszyk">🛒</a>

    @auth
        <span class="text-2xl text-gray-300">
            👤 {{ Auth::user()->first_name }}
        </span>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-2xl text-red-400 hover:text-red-300">
                Wyloguj
            </button>
        </form>

    @else
        <a href="/log_in" class="text-2xl hover:text-purple-400 transition">
            👤 Logowanie
        </a>
    @endauth

</div>
    </div>

    <nav class="flex justify-center gap-10 py-4 text-xs uppercase tracking-widest border-b border-white/5">

        <a href="{{ route('home') }}#polecane" class="hover:text-purple-400 transition">
            Polecane produkty
        </a>

        <a href="{{ route('home') }}#promocje" class="hover:text-purple-400 transition">
            Oferty promocyjne
        </a>

        <a href="{{ route('home') }}#kategorie" class="hover:text-purple-400 transition">
            Kategorie
        </a>

        <a href="{{ route('konfigurator.index') }}" class="hover:text-purple-400 transition">
            Konfigurator PC
        </a>

    </nav>
</header>

<main class="p-6 grow">
    @yield('content')
</main>

<footer class="p-10 border-t border-cyan-400/20 bg-black/10">
    <h2 class="font-bold text-lg mb-2">Informacje</h2>
    <p class="text-gray-400 font-bruno">E-mail: techblef@gmail.com</p>
    <p class="text-gray-400 font-bruno">Numer kontaktowy: +48 109247685</p>
</footer>

</body>
</html>
