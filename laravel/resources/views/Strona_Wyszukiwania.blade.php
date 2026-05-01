@extends('app')

@section('content')

<div class="w-full px-4 lg:px-8 py-6">
    <div class="grid grid-cols-12 gap-6">

        {{-- lewa strona --}}
        <main class="col-span-12 lg:col-span-9 space-y-6">

            <div>
                <h1 class="text-lg font-bruno text-white italic">
                    Znalezione wyniki dla: <span class="text-neon-blue">Karta pamięci SSD</span>
                </h1>
                <p class="text-[10px] text-text-muted">(wyniki: 120)</p>
            </div>

            <div class="bg-black/30 p-5 rounded-2xl border border-white/10 backdrop-blur">
                <h2 class="text-sm font-bruno text-white mb-4">Polecane w kategorii</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @for($i=0; $i<3; $i++)
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                        <div class="h-24 bg-white/10 mb-3 rounded"></div>
                        <p class="text-xs text-white mb-2">Nazwa produktu</p>
                        <span class="bg-neon-blue px-2 py-1 text-[10px] rounded">699 zł</span>
                    </div>
                    @endfor

                </div>
            </div>


            <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl border border-white/10">
                <button class="text-white text-xs">☰</button>

                <select class="bg-black/30 border border-white/10 text-xs px-3 py-1 rounded">
                    <option>Sortowanie</option>
                </select>

                <div class="text-xs text-white">1 z 60</div>
            </div>

            @for($i=0; $i<3; $i++)
            <div class="bg-black/30 border border-white/10 rounded-xl p-4 flex items-center justify-between">

                <div class="flex items-center gap-4">
                    <div class="w-24 h-20 bg-white/10 rounded"></div>

                    <div>
                        <p class="text-sm text-white">Samsung 1TB SSD</p>

                        <button class="text-[10px] mt-2 px-3 py-1 border border-white/20 rounded">
                            więcej info
                        </button>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-lg text-white mb-2">699 zł</p>

                    <button class="px-4 py-2 bg-neon-purple text-xs rounded">
                        Dodaj do koszyka
                    </button>
                </div>

            </div>
            @endfor

        </main>


        <aside class="col-span-12 lg:col-span-3">

            <div class="bg-black/30 p-5 rounded-2xl border border-white/10 space-y-6">

                <h2 class="text-sm font-bruno text-white">Filtry</h2>

                <input type="text" placeholder="szukaj filtrów"
                    class="w-full bg-white/5 border border-white/10 px-3 py-2 text-xs rounded">

                <div>
                    <p class="text-[10px] mb-2 text-text-muted">Cena</p>
                    <div class="flex gap-2">
                        <input type="number" placeholder="od"
                            class="w-full bg-white/5 border border-white/10 px-2 py-1 text-xs rounded">
                        <input type="number" placeholder="do"
                            class="w-full bg-white/5 border border-white/10 px-2 py-1 text-xs rounded">
                    </div>
                </div>

                <div>
                    <p class="text-[10px] mb-2 text-text-muted">Producent</p>

                    @foreach(['MSI','Dell','HP','Lenovo','Apple'] as $brand)
                        <label class="flex items-center gap-2 text-xs mb-1">
                            <input type="checkbox">
                            {{ $brand }}
                        </label>
                    @endforeach
                </div>

                <div>
                    <p class="text-[10px] mb-2 text-text-muted">Przeznaczenie</p>

                    @foreach(['Dla graczy','Do biura','Serwery'] as $type)
                        <label class="flex items-center gap-2 text-xs mb-1">
                            <input type="checkbox">
                            {{ $type }}
                        </label>
                    @endforeach
                </div>

            </div>

        </aside>

    </div>
</div>

@endsection
