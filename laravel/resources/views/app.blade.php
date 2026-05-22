<!DOCTYPE html>
<html lang="pl">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techblef</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>     
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        <div class="flex-1">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" class="w-10 h-10">
            </a>
        </div>

        <form action="{{ route('wyszukaj') }}" method="GET" class="w-1/2 flex items-center gap-2">
            <div class="search-autocomplete relative flex-1">
                <input
                    id="site-search-input"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Szukaj produktu, marki lub kategorii"
                    maxlength="100"
                    autocomplete="off"
                    data-suggestions-url="{{ route('wyszukaj.suggestions') }}"
                    class="w-full px-4 py-2 rounded-full bg-purple-900/40 border border-purple-500/40 text-white placeholder:text-white/40 focus:border-purple-400 outline-none"
                >
                <div
                    id="site-search-suggestions"
                    class="search-suggestions hidden"
                    role="listbox"
                    aria-label="Podpowiedzi produktów"
                ></div>
            </div>
            <button
                type="submit"
                class="px-4 py-2 rounded-full bg-purple-600 hover:bg-purple-500 text-sm font-bold transition">
                Szukaj
            </button>
        </form>

        <div class="flex-1 flex items-center justify-end gap-6">

            {{-- Sekcja narzędziowa (Admin + Koszyk) --}}
            <div class="flex items-center gap-4 border-r border-white/10 pr-4">
                @auth
                    @if(Auth::user()->is_Admin)
                        <a href="{{ route('admin') }}"
                           class="text-xl text-gray-400 hover:text-cyan-400 hover:drop-shadow-[0_0_8px_rgba(34,211,238,0.8)] transition-all"
                           title="Panel Administratora">
                           <i class="fa-solid fa-gear"></i>
                        </a>
                    @endif
                @endauth

                <a href="{{ route('cart.index') }}" class="text-xl text-gray-400 hover:text-purple-400 transition-all">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </div>

            {{-- Sekcja użytkownika --}}
            <div class="flex items-center gap-2">
                @auth
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold leading-none mb-1">Zalogowany</span>
                        <a href="{{ route('profil') }}" class="text-sm font-bruno text-white leading-none hover:text-cyan-400 transition-colors">
                            {{ Auth::user()->first_name }}
                        </a>
                    </div>

                    <form method="POST" action="/logout" class="ml-2">
                        @csrf
                        <button class="group flex items-center gap-2 px-3 py-1.5 rounded-lg border border-red-500/20 bg-red-500/5 hover:bg-red-500/20 transition-all">
                            <span class="text-[11px] uppercase tracking-widest text-red-400 font-bold">Wyloguj</span>
                            <i class="fa-solid fa-power-off text-xs text-red-500"></i>
                        </button>
                    </form>
                @else
                    <a href="/log_in" class="flex items-center gap-2 px-4 py-2 rounded-full border border-purple-500/30 bg-purple-500/10 hover:bg-purple-500/20 transition-all group">
                        <i class="fa-solid fa-user text-xs text-purple-400"></i>
                        <span class="text-[11px] uppercase tracking-widest text-white font-bold">Logowanie</span>
                    </a>
                @endauth
            </div>
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
    <p class="text-gray-400 font-bruno">Lokalizacja: al. Tadeusza Rejtana 16C, 35-310 Rzeszów</p>
    <a
        href="#polityka-cookies"
        data-cookie-open
        class="mt-5 inline-flex items-center gap-2 rounded-full border border-cyan-400/25 bg-cyan-400/5 px-5 py-2 text-xs font-bold uppercase tracking-[0.22em] text-cyan-200 transition hover:border-cyan-300/60 hover:bg-cyan-400/10 hover:text-white"
    >
        <i class="fa-solid fa-shield-halved text-cyan-300"></i>
        Prywatność i cookies
    </a>
</footer>

<div
    id="cookie-notice-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/70 px-4 backdrop-blur-sm"
    aria-hidden="true"
    aria-labelledby="cookie-notice-title"
>
    <div class="w-full max-w-2xl rounded-3xl border border-white/10 bg-slate-950/95 p-6 shadow-[0_24px_70px_rgba(0,0,0,0.55)]">
        <p class="text-[10px] uppercase tracking-[0.35em] text-cyan-300">Prywatność</p>
        <h2 id="cookie-notice-title" class="mt-2 text-xl text-white font-bruno">Pliki cookies i dane techniczne</h2>

        <div class="mt-5 space-y-3 text-sm leading-6 text-gray-300">
            <p>
                Sklep korzysta z niezbędnych danych technicznych, żeby działało logowanie, koszyk, zabezpieczenia formularzy oraz zapamiętywanie sesji użytkownika.
            </p>
            <p>
                Liczba wyświetleń strony startowej jest zapisywana tylko raz w ramach jednej sesji sklepu. Samo odświeżenie strony albo przechodzenie między widokami nie powinno nabijać kolejnych wejść.
            </p>
            <p>
                Dla statystyk technicznych możemy zapisać m.in. identyfikator sesji, datę wejścia, adres IP oraz informacje o przeglądarce lub urządzeniu. Nie służy to do reklam, tylko do statystyk działania strony.
            </p>
        </div>

        <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:justify-end">
            <button
                type="button"
                data-cookie-close
                class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-bold text-gray-200 transition hover:bg-white/10"
            >
                Zamknij
            </button>
            <button
                type="button"
                data-cookie-accept
                class="rounded-2xl border border-cyan-300/40 bg-cyan-500/20 px-5 py-3 text-sm font-bold text-cyan-100 shadow-[0_0_22px_rgba(34,211,238,0.18)] transition hover:bg-cyan-400/30 hover:text-white"
            >
                Rozumiem
            </button>
        </div>
    </div>
</div>
@if (session('order_success'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            alert(@json(session('order_success')));
        });
    </script>
@endif
@livewireScripts
</body>
</html>
