@extends('app')

@section('content')

<div class="w-full px-6 lg:px-12 py-8 flex gap-8">

    <div class="flex-1 space-y-8">

        <!-- PROFIL -->
        <h1 class="text-3xl text-white font-bruno mb-4">Profil admina</h1>

        <!-- STATYSTYKI -->
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-xl">

            <h2 class="text-purple-400 text-xl mb-6 font-bruno">Sklep</h2>

            <div class="grid grid-cols-3 gap-6 text-gray-200">
                <div>Klienci<br><span class="text-white text-xl">1200</span></div>
                <div>Wyświetlenia<br><span class="text-white text-xl">25k</span></div>
            </div>

            <h2 class="text-purple-400 text-xl mt-8 mb-4 font-bruno">Konta</h2>

            <div class="grid grid-cols-3 gap-6 text-gray-200">
                <div>Aktywne<br><span class="text-white text-xl">800</span></div>
                <div>Zawieszone<br><span class="text-white text-xl">50</span></div>
                <div>Zbanowane<br><span class="text-white text-xl">20</span></div>
            </div>

            <h2 class="text-purple-400 text-xl mt-8 mb-4 font-bruno">Statystyki</h2>

            <div class="grid grid-cols-2 gap-6 text-gray-200">
                <div>Zamówienia<br><span class="text-white text-xl">430</span></div>
                <div>Produkty<br><span class="text-white text-xl">1200</span></div>
            </div>

        </div>

        <!-- WYKRESY -->
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-xl">
            <h2 class="text-purple-400 text-xl mb-6 font-bruno">Wykresy</h2>

            <div class="bg-white/10 h-64 rounded-xl flex items-center justify-center text-gray-400 mb-6">
                [Wykres 1]
            </div>

            <div class="bg-white/10 h-64 rounded-xl flex items-center justify-center text-gray-400">
                [Wykres 2]
            </div>
        </div>

        <!-- REKLAMACJE -->
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-xl">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-purple-400 text-xl font-bruno">Reklamacje</h2>
                <input type="text" placeholder="Szukaj..."
                       class="bg-white/10 border border-white/20 rounded px-4 py-1 text-sm text-white">
            </div>

            <div class="space-y-6">

                @for($i = 0; $i < 3; $i++)
                <div class="flex items-center gap-6 text-gray-300">
                    <div class="w-16 h-16 bg-white/20 rounded"></div>

                    <div class="w-32">Jan</div>
                    <div class="flex-1">Uszkodzenie mechaniczne</div>

                    <div class="flex gap-4 text-purple-400">
                        <button class="hover:underline">Opis</button>
                        <button class="hover:underline">Odpowiedz</button>
                        <button class="hover:underline text-red-400">Odrzuć</button>
                    </div>
                </div>
                @endfor

            </div>

            <div class="mt-6 flex justify-center gap-2 text-purple-400">
                <span>◀</span>
                <span class="px-2">1</span>
                <span class="px-2">2</span>
                <span class="px-2">3</span>
                <span>▶</span>
            </div>

        </div>

        <!-- UŻYTKOWNICY -->
        <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-xl">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-purple-400 text-xl font-bruno">Użytkownicy</h2>
                <input type="text" placeholder="Szukaj..."
                       class="bg-white/10 border border-white/20 rounded px-4 py-1 text-sm text-white">
            </div>

            <div class="space-y-4 text-gray-300">

                @for($i = 0; $i < 4; $i++)
                <div class="grid grid-cols-4 items-center">
                    <div>Łukasz</div>
                    <div>example@gmail.com</div>
                    <div>Aktywny</div>
                    <div class="flex gap-4 text-purple-400">
                        <button>Zawieś</button>
                        <button class="text-red-400">Ban</button>
                    </div>
                </div>
                @endfor

            </div>

            <div class="mt-6 flex justify-center gap-2 text-purple-400">
                <span>◀</span>
                <span class="px-2">1</span>
                <span class="px-2">2</span>
                <span class="px-2">3</span>
                <span>▶</span>
            </div>

        </div>

    </div>


    <div class="w-[250px] bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 h-fit shadow-xl">

        <h2 class="text-white text-xl mb-6 font-bruno">Menu</h2>

        <div class="flex flex-col gap-4 text-purple-400">
            <a href="#" class="hover:text-white transition">Sklep</a>
            <a href="#" class="hover:text-white transition">Konta</a>
            <a href="#" class="hover:text-white transition">Statystyki</a>
            <a href="#" class="hover:text-white transition">Wykresy</a>
            <a href="#" class="hover:text-white transition">Reklamacje</a>
            <a href="#" class="hover:text-white transition">Użytkownicy</a>
        </div>

    </div>

</div>

@endsection
