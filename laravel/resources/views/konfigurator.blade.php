@extends('app')

@section('content')

<div class="w-full px-4 lg:px-8 py-6">
    @if(session('error'))
        <div class="col-span-full mb-4 p-4 bg-red-500/20 border border-red-500 text-red-500 rounded-xl font-bruno text-xs uppercase tracking-widest">
            ⚠️{{ session('error') }}
        </div>
    @endif
    <div class="grid grid-cols-12 gap-6 items-start">

        <aside class="col-span-12 lg:col-span-2 xl:col-span-2">
            @if($category)
            <div id="filter-panel" class="bg-black/40 p-5 rounded-r-2xl border-y border-r border-white/10 backdrop-blur-xl sticky top-6 -ml-4 lg:-ml-8 shadow-2xl shadow-purple-900/10">
                <h2 class="text-neon-blue font-bruno text-sm mb-6 uppercase tracking-widest italic">Panel Filtrów</h2>
                <form id="filter-form" action="{{ route('konfigurator.index') }}" method="GET" class="space-y-6">
                    <input type="hidden" name="category_id" value="{{ $category->id ?? '' }}">
                    @if($filterState['change'])
                        <input type="hidden" name="change" value="1">
                    @endif
                    <div class="mb-6 border-t border-white/5 pt-4">
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">Sortowanie</label>
                        <select name="sort" class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-3 text-[11px] text-white focus:border-neon-purple outline-none cursor-pointer">
                            <option value="newest" {{ $filterState['sort'] == 'newest' ? 'selected' : '' }}>Najnowsze</option>
                            <option value="price_asc" {{ $filterState['sort'] == 'price_asc' ? 'selected' : '' }}>Cena rosnąco ↑</option>
                            <option value="price_desc" {{ $filterState['sort'] == 'price_desc' ? 'selected' : '' }}>Cena malejąco ↓</option>
                            <option value="name_asc" {{ $filterState['sort'] == 'name_asc' ? 'selected' : '' }}>Nazwa A-Z</option>
                            <option value="rating_desc" {{ $filterState['sort'] == 'rating_desc' ? 'selected' : '' }}>Najwyżej oceniane</option>
                            <option value="stock_desc" {{ $filterState['sort'] == 'stock_desc' ? 'selected' : '' }}>Dostępność: od największej</option>
                        </select>
                    </div>
                       <div class="mb-6">
                            <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">Cena</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ $filterState['min_price'] }}" placeholder="Od"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg py-2 px-3 text-[11px] text-white focus:border-neon-blue focus:ring-0 outline-none transition">

                                <div class="h-px w-4 bg-white/20"></div>

                                <input type="number" name="max_price" value="{{ $filterState['max_price'] }}" placeholder="Do"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg py-2 px-3 text-[11px] text-white focus:border-neon-blue focus:ring-0 outline-none transition">
                            </div>
                        </div>
                    <div>
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold">Marka</label>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}" {{ in_array((int) $brand->id, $filterState['brands'], true) ? 'checked' : '' }}
                                        class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-purple focus:ring-neon-purple">
                                    <span class="text-[11px] text-white/60 group-hover:text-white transition"> {{ $brand->name }} </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                @foreach($category->attributes as $attribute)
                    <div class="mb-1 border-t border-white/5 pt-2" x-data="{ open: false }">
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">
                            {{ $attribute->display_name }}
                        </label>

                        <div class="space-y-2">
                        @foreach($attribute->values as $index => $val)
                            <label class="flex items-center gap-3 group {{ $filterValueStates[$attribute->id][$val->id]['labelClass'] }}" x-show="open || {{ $index }} < 3">
                                <input type="checkbox" name="attrs[{{ $attribute->id }}][]" value="{{ $val->id }}"
                                    {{ $filterValueStates[$attribute->id][$val->id]['shouldBeChecked'] ? 'checked' : '' }}
                                    {{ $filterValueStates[$attribute->id][$val->id]['shouldBeDisabled'] ? 'disabled' : '' }}
                                    class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-blue focus:ring-neon-blue transition-all">

                                <span class="text-[11px] {{ $filterValueStates[$attribute->id][$val->id]['textClass'] }} transition uppercase font-bruno">
                                        {{ $filterValueStates[$attribute->id][$val->id]['display_value'] }}
                                        @if($filterValueStates[$attribute->id][$val->id]['isDisabledByDimension'])
                                        <span class="text-[7px] text-red-500/70 ml-1 font-sans">(NIE ZMIEŚCI SIĘ)</span>
                                    @elseif(!$filterValueStates[$attribute->id][$val->id]['isAvailableInResults'] && !$filterValueStates[$attribute->id][$val->id]['shouldBeChecked'])
                                        <span class="text-[7px] text-white/30 ml-1 font-sans">(0)</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                        </div>

                        @if($attribute->values->count() > 3)
                            <button
                                @click="open = !open"
                                type="button"
                                class="mt-3 text-[9px] text-neon-blue hover:text-white transition uppercase font-bold flex items-center gap-1"
                            >
                                <span x-text="open ? '- Pokaż mniej' : '+ Pokaż więcej ({{ $attribute->values->count() - 3 }})'"></span>
                            </button>
                        @endif
                    </div>
                @endforeach
                   <button type="submit" class="{{ $buttonClass }} relative z-10 w-full shrink-0 !py-1 text-base mb-2">
                        Filtruj wyniki
                    </button>

                    <a href="{{ route('konfigurator.index', $resetFilterParams) }}"
                        class="relative z-10 w-full block shrink-0 !py-1 text-base text-center font-bold uppercase rounded-full border border-red-500 bg-red-950/20 text-red-400 shadow-[0_0_15px_rgba(239,68,68,0.15)] hover:bg-red-600 hover:text-white hover:shadow-[0_0_25px_rgba(239,68,68,0.45)] transition-all duration-200 active:scale-95">
                        Resetuj filtry
                    </a>
                </form>
            </div>
            @else
                <div class="p-5 text-center text-[10px] text-text-muted uppercase tracking-widest border border-white/5 rounded-2xl">
                    Wybierz kategorię, aby zobaczyć filtry
                </div>
            @endif
        </aside>

       <main class="col-span-12 lg:col-span-8 xl:col-span-8">
            @if(!$category)
                <div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-8 border border-white/5 rounded-3xl bg-black/20 backdrop-blur-sm">
                    <div class="w-20 h-20 mb-6 rounded-full bg-neon-blue/10 flex items-center justify-center border border-neon-blue/20 animate-pulse">
                        <svg class="w-10 h-10 text-neon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bruno text-white mb-4 uppercase tracking-widest">Witaj w Konfiguratorze</h2>
                    <p class="text-text-muted max-w-md font-light leading-relaxed">Wybierz kategorię z menu po prawej, aby rozpocząć budowę swojej maszyny.</p>
                </div>
            @else
                 {{-- JEŚLI MAMY PRZEDMIOT(Y) I NIE KLIKNĘLIŚMY "ZMIEŃ" (LUB "DODAJ") --}}
                @if(count($selectedCategoryItems) > 0 && !$isChanging)
                    <div class="space-y-8 mb-8">
                        @foreach($selectedCategoryItems as $index => $selectedItem)
                            <div class="relative bg-black/40 border border-neon-blue/30 rounded-2xl p-6 lg:p-10 backdrop-blur-md shadow-[0_0_30px_rgba(0,240,255,0.05)] overflow-hidden flex flex-col md:flex-row items-center gap-10">

                                <div class="w-56 h-56 bg-white rounded-xl p-4 flex items-center justify-center shrink-0 shadow-lg">
                                    @if($selectedItem['image_url'])
                                        <img src="{{ asset('images/' . $selectedItem['image_url']) }}"
                                            alt="{{ $selectedItem['name'] }}"
                                            class="max-w-full max-h-full object-contain">
                                    @else
                                        <span class="text-gray-400 text-[10px] font-bruno">Brak zdjęcia</span>
                                    @endif
                                </div>

                                <div class="grow text-left">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded text-[10px] font-bruno tracking-widest uppercase border border-green-500/30">
                                            Aktualnie wybrany {{ $isMultiCategory ? '#'.($index+1) : '' }}
                                        </span>
                                    </div>

                                    <h2 class="text-3xl font-bold text-white mb-2 uppercase tracking-tight">{{ $selectedItem['name'] }}</h2>

                                    @if($selectedItem['discount'] > 0 && $selectedItem['promo_price'])
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="flex flex-col leading-tight">
                                                <span class="text-gray-400 line-through text-sm font-bruno">
                                                    {{ number_format($selectedItem['base_price'], 0, ',', ' ') }} z&#322;
                                                </span>
                                                <span class="text-green-400 font-bruno text-2xl">
                                                    {{ number_format($selectedItem['promo_price'], 0, ',', ' ') }} z&#322;
                                                </span>
                                            </div>
                                            <span class="bg-red-600/90 text-white font-bold px-3 py-1 rounded-full text-xs shadow-[0_0_15px_rgba(220,38,38,0.5)] font-bruno">
                                                -{{ $selectedItem['discount'] }}%
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-green-400 font-bruno text-2xl mb-6">
                                            {{ number_format($selectedItem['price'], 0, ',', ' ') }} zł
                                        </div>
                                    @endif

                                    @if(!empty($selectedItem['attributes']))
                                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                                            @foreach($selectedItem['attributes'] as $attr)
                                            <div class="flex flex-col border-l-2 border-neon-blue/30 pl-4 py-1 bg-white/5 rounded-r-xl transition-all hover:bg-white/10">
                                                <span class="text-[9px] text-gray-400 uppercase font-bruno">
                                                    {{ $attr['label'] }}
                                                </span>
                                            <span class="text-white text-sm font-semibold">
                                                    {{ $attr['display_value'] }}
                                                </span>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- PRZYCISKI --}}
                                    <div class="flex flex-wrap gap-4 mt-6">
                                        <a href="{{ route('konfigurator.index', ['category_id' => $category->id, 'change' => '1', 'replace_index' => $index]) }}"
                                        class="inline-flex items-center gap-2 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white py-3 px-6 rounded-full font-bold text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Zmień model
                                        </a>

                                        <form action="{{ route('konfigurator.remove', ['category' => $category->id, 'index' => $isMultiCategory ? $index : 0]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-2 bg-red-500/10 hover:bg-red-600 border border-red-500/50 hover:border-red-600 text-red-400 hover:text-white py-3 px-6 rounded-full font-bold text-[10px] uppercase tracking-widest transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                             Usuń z zestawu
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Przycisk "DODAJ KOLEJNY" widoczny tylko dla Dysków i RAM-u pod listą wybranych --}}
                        @if($isMultiCategory)
                            <div class="flex justify-center mt-6">
                                <a href="{{ route('konfigurator.index', ['category_id' => $category->id, 'change' => '1']) }}"
                                class="inline-flex items-center gap-3 bg-green-500/10 hover:bg-green-600 border border-green-500/50 hover:border-green-500 text-green-400 hover:text-white py-4 px-10 rounded-full font-bold text-sm uppercase tracking-widest transition-all shadow-[0_0_15px_rgba(34,197,94,0.2)]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Dodaj kolejny model
                                </a>
                            </div>
                        @endif
                    </div>

                  {{-- TUTAJ KLUCZOWA ZMIANA: WYŚWIETL LISTĘ TYLKO JEŚLI NIE WYBRANO LUB KLIKNIĘTO ZMIEŃ/DODAJ --}}
                @else
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-px grow bg-linear-to-r from-neon-blue/50 to-transparent"></div>
                        <h1 class="text-xl font-bruno text-white uppercase italic">Wybierz podzespół</h1>
                        <span class="text-[10px] text-text-muted uppercase">Dostępnych: {{ $products->total() }}</span>
                        <div class="h-px grow bg-linear-to-l from-neon-blue/50 to-transparent"></div>
                    </div>
                    @if($category->id == 6 && $summary['totalPowerDraw'] > 0)
                        <div class="col-span-full mb-6 space-y-3">
                            {{-- Alert o minimalnej mocy --}}
                            <div class="flex items-center gap-4 p-4 bg-orange-500/10 border border-orange-500/30 rounded-xl">
                                <div class="shrink-0 w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bruno text-xs uppercase tracking-wider">Wymagana moc minimalna</h4>
                                    <p class="text-orange-200/70 text-[11px]">Twój zestaw pobiera około <b>{{ $summary['totalPowerDraw'] }}W</b>. Wybierz zasilacz o mocy minimum <b>{{ $summary['minPsuWatts'] }}W</b> (+10% zapasu).</p>
                                </div>
                            </div>

                            {{-- Alert o zalecanej mocy (EFEKTYWNOŚĆ) --}}
                            <div class="flex items-center gap-4 p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                                <div class="shrink-0 w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bruno text-xs uppercase tracking-wider">Zalecana moc (Optymalna)</h4>
                                    <p class="text-green-200/70 text-[11px]">Dla najlepszej kultury pracy i sprawności zalecamy zasilacz <b>{{ $recommendedPsuWatts }}W</b> (+30% zapasu).</p>
                                </div>
                            </div>

                            {{-- Walidacja wybranego modelu --}}
                            @if($summary['selectedPsuWatts'] > 0 && $summary['selectedPsuWatts'] < $summary['minPsuWatts'])
                                <div class="p-3 bg-red-500/20 border border-red-500 rounded-lg animate-pulse">
                                    <p class="text-red-400 text-[10px] font-bruno text-center uppercase">⚠️ UWAGA: Wybrany zasilacz ({{ $summary['selectedPsuWatts'] }}W) jest za słaby dla tego zestawu!</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">
                        @forelse($products as $product)
                            <x-product-card :product="$product" :discount="$product->configurator_discount" :replaceIndex="$replaceIndex" />
                        @empty
                           <div class="col-span-full py-16">
                                <div class="mx-auto max-w-2xl rounded-[1.8rem] border border-dashed border-purple-500/30 bg-purple-900/10 px-5 py-12 text-center shadow-[0_0_15px_rgba(168,85,247,0.1)]">
                                    <i class="fa-solid fa-magnifying-glass-minus text-4xl text-purple-400 mb-4 opacity-75"></i>
                                    <p class="font-bruno text-lg uppercase tracking-widest text-purple-200">
                                        Brak produktów
                                    </p>
                                    <p class="mt-2 text-sm text-purple-300/60 font-sans tracking-normal">
                                        Przepraszamy, nie mamy produktów spełniających wybrane kryteria. Spróbuj zmienić filtry.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 flex justify-end px-4">
                        {{ $products->appends($filterQueryParams)->links() }}
                    </div>
                @endif
            @endif
        </main>

        <aside class="col-span-12 lg:col-span-2 xl:col-span-2">
           <section class="flex flex-col bg-black/30 p-6 rounded-lg border border-white/5 backdrop-blur-sm">
                <div class="text-[11px] tracking-[2px] mb-5 text-text-muted font-bruno">BUILD STATUS</div>
                <div class="text-neon-blue text-[10px] mb-3 uppercase font-bruno">Wymagane elementy</div>
                <ul class="space-y-2 mb-8">
                   <a href="{{ route('konfigurator.index', ['category_id' => 1]) }}"> <x-config-item label="CPU" id="cpu-status" :categoryId="1" /> </a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 2]) }}"> <x-config-item label="GPU" id="gpu-status" :categoryId="2" :required-warning="$buildStatus['gpuMissing']" required-text="Procesor nie ma zintegrowanej grafiki" /> </a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 3]) }}"> <x-config-item label="Płyta główna" id="plyta-status" :categoryId="3" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 4]) }}"> <x-config-item label="Pamięć RAM" id="ram-status" :categoryId="4" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 5]) }}"> <x-config-item label="Dysk" id="dysk-status" :categoryId="5"/></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 6]) }}"> <x-config-item label="Zasilacz" id="zasilacz-status" :categoryId="6"/></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 7]) }}"> <x-config-item label="Obudowa" id="obudowa-status" :categoryId="7"/></a>
                </ul>

                <div class="text-neon-blue text-[10px] mb-3 uppercase font-bruno">Dodatkowe elementy</div>
                <ul class="space-y-2">
                <a href="{{ route('konfigurator.index', ['category_id' => 8]) }}"> <x-config-item label="Myszka" id="myszka-status" :categoryId="8" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 9]) }}"><x-config-item label="Klawiatura" id="klawiatura-status" :categoryId="9"/></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 10]) }}"><x-config-item label="Słuchawki" id="sluchawki-status" :categoryId="10" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 11]) }}"><x-config-item label="Głośniki" id="glosniki-status" :categoryId="11" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 12]) }}"><x-config-item label="Chłodzenie CPU" id="chlodzenie-status" :categoryId="12" :required-warning="$buildStatus['coolerMissing']" required-text="Procesor nie ma chłodzenia w zestawie" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 13]) }}"><x-config-item label="Karty sieciowe" id="karty_sieciowe-status" :categoryId="13" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 14]) }}"><x-config-item label="Monitor" id="monitor-status" :categoryId="14"/></a>
                </ul>
                    <div class="mt-auto pt-6 border-t border-white/10 space-y-3">
                    <div class="bg-white/5 p-3 rounded flex justify-between items-center">
                        <span class="text-[10px] text-text-muted uppercase">Wartość:</span>
                        <span class="text-neon-blue font-bruno text-lg">{{ number_format($summary['totalPrice'], 2) }} zł</span>
                    </div>
                    <div class="bg-red-500/10 p-3 rounded flex justify-between items-center border border-red-500/30 shadow-[0_0_18px_rgba(239,68,68,0.18)]">
                        <span class="text-[10px] text-red-200 uppercase font-bruno">Pobór mocy:</span>
                        <span class="text-red-400 font-bruno text-lg drop-shadow-[0_0_8px_rgba(248,113,113,0.75)]">~{{ number_format($summary['totalPowerDraw'], 0, ',', ' ') }} W</span>
                    </div>


                    <div class="mt-8">
                        <form action="{{ route('konfigurator.moveToCart') }}" method="POST">
                            @csrf
                            <button class="{{ $buttonClass }} relative z-10 w-full shrink-0 py-3 text-base">
                                KUP ZESTAW
                            </button>
                        </form>
                    </div>
                    <form action="{{ route('configurator.reset') }}" method="POST">
                        @csrf
                        <button type="submit" class="{{ $buttonClass }} relative z-10 w-full shrink-0 py-3 text-base">
                            RESETUJ ZESTAW
                        </button>
                    </form>
                </div>
            </section>
        </aside>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"> </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filter-form');
        const filterPanel = document.getElementById('filter-panel');

        // 1. Blokowanie pozycji
        const savedScrollPosition = sessionStorage.getItem('configurator_scroll_pos');
        if (savedScrollPosition) {
            window.scrollTo({
                top: parseInt(savedScrollPosition, 10),
                behavior: 'instant' // 'instant' sprawia, że użytkownik nawet nie zauważy mignięcia/skoku
             });
            // Czyścimy pamięć sesji, żeby przy zwykłym odświeżeniu F5 nie blokować użytkownika
            sessionStorage.removeItem('configurator_scroll_pos');
        }

        if (filterForm && filterPanel) {
            // Flaga informująca, czy użytkownik dokonał jakiejkolwiek zmiany w filtrach
            let filtersChanged = false;

            // 1. Nasłuchiwanie zmian na checkboxach i selectach
            filterForm.querySelectorAll('input[type="checkbox"], select').forEach(element => {
                element.addEventListener('change', function() {
                    console.log('Wykryto zmianę w: ' + this.name);
                    filtersChanged = true;
                });
            });

            // 2. Nasłuchiwanie zmian w polach wpisywania ceny (od/do)
            filterForm.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    console.log('Wykryto zmianę ceny w: ' + this.name);
                    filtersChanged = true;
                });
            });

            // 3. Obsługa opuszczania panelu myszką jeśli zmieniliśmy jakieś filtry
            filterPanel.addEventListener('mouseleave', function() {
                if (filtersChanged) {
                    console.log('Myszka opuściła panel i filtry zostały zmienione -> Wysyłam formularz');
                    // Zapamiętanie pozycji
                    sessionStorage.setItem('configurator_scroll_pos', window.scrollY);
                    filterForm.submit();
                } else {
                    console.log('Myszka opuściła panel, ale nic nie zmieniono -> Brak akcji');
                }
            });
        }
    });
</script>
@endsection
