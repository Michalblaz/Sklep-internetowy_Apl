@extends('app')

@section('content')


<div class="w-full px-4 lg:px-8 py-6">
    @if(session('error'))
        <div class="col-span-full mb-4 p-4 bg-red-500/20 border border-red-500 text-red-500 rounded-xl font-bruno text-xs uppercase tracking-widest">
            ⚠️ {{ session('error') }}
        </div>
    @endif
    <div class="grid grid-cols-12 gap-6 items-start">

        <aside class="col-span-12 lg:col-span-2 xl:col-span-2">
            @if($category)
            <div class="bg-black/40 p-5 rounded-r-2xl border-y border-r border-white/10 backdrop-blur-xl sticky top-6 -ml-4 lg:-ml-8 shadow-2xl shadow-purple-900/10">
                <h2 class="text-neon-blue font-bruno text-sm mb-6 uppercase tracking-widest italic">Panel Filtrów</h2>
                <form id="filter-form" action="{{ route('konfigurator.index') }}" method="GET" class="space-y-6">
                    @php
                        $build = session('configurator_build', []);
                        $requiredValueIds = [];

                        // Standardowe atrybuty (Socket itp)
                        foreach($build as $catId => $bItem) {
                            $itemData = isset($bItem[0]) ? $bItem[0] : $bItem; // Obsługa tablic np. dla RAMu
                            if(isset($itemData['attributes'])) {
                                foreach($itemData['attributes'] as $aId => $vId) {
                                    $requiredValueIds[$aId] = is_array($vId) ? $vId[0] : $vId;
                                }
                            }
                        }
                    @endphp
                    <input type="hidden" name="category_id" value="{{ $category->id ?? '' }}">
                    <div class="mb-6 border-t border-white/5 pt-4">
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">Sortowanie</label>
                        <select name="sort" class="w-full bg-black/20 border border-white/10 rounded-lg py-2 px-3 text-[11px] text-white focus:border-neon-purple outline-none cursor-pointer">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Najnowsze</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Cena rosnąco ↑</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Cena malejąco ↓</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nazwa A-Z</option>
                        </select>
                    </div>
                       <div class="mb-6">
                            <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">Cena</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Od"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg py-2 px-3 text-[11px] text-white focus:border-neon-blue focus:ring-0 outline-none transition">

                                <div class="h-px w-4 bg-white/20"></div>

                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Do"
                                    class="w-full bg-white/5 border border-white/10 rounded-lg py-2 px-3 text-[11px] text-white focus:border-neon-blue focus:ring-0 outline-none transition">
                            </div>
                        </div>
                    <div>
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold">Marka</label>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}" {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}
                                        class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-purple focus:ring-neon-purple">
                                    <span class="text-[11px] text-white/60 group-hover:text-white transition"> {{ $brand->name }} </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                @foreach($category->attributes as $attribute)
                    @php
                        $forcedValueId = $requiredValueIds[$attribute->id] ?? null;
                        $isForcedAttribute = !is_null($forcedValueId);
                        //Wczytywanie z sesji odpowiednich atrybutów do dopasowania długości
                        $constraintsMap = [
                            24 => ['val' => $buildLimits['gpu_len'],      'type' => 'min'],
                            25 => ['val' => $buildLimits['cooler_h'],     'type' => 'min'],
                            50 => ['val' => $buildLimits['radiator_s'],   'type' => 'min'],
                            40 => ['val' => $buildLimits['case_gpu'],     'type' => 'max'],
                            41 => ['val' => $buildLimits['case_cooler'],  'type' => 'max'],
                            49 => ['val' => $buildLimits['case_radiator'],'type' => 'max'],
                        ];
                    @endphp

                    <div class="mb-1 border-t border-white/5 pt-2" x-data="{ open: false }">
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">
                            {{ $attribute->name }}
                        </label>

                        <div class="space-y-2">
                        @foreach($attribute->values as $index => $val)
                           @php
                                $numericVal = (float) preg_replace('/[^0-9.]/', '', $val->value);
                                $isDisabledByDimension = false;

                                if (isset($constraintsMap[$attribute->id])) {
                                    $check = $constraintsMap[$attribute->id];
                                    if ($check['val'] > 0) {
                                        $isDisabledByDimension = ($check['type'] === 'min')
                                            ? ($numericVal < $check['val'])
                                            : ($numericVal > $check['val']);
                                    }
                                }

                                $isAvailableInResults = in_array($val->id, $availableValueIds ?? []);
                                $isRequiredByBuild = $isForcedAttribute && (int) $forcedValueId === (int) $val->id;
                                $isSelectedInRequest = is_array(request()->input('attrs.' . $attribute->id)) && in_array($val->id, request()->input('attrs.' . $attribute->id));
                                $shouldBeChecked = $isForcedAttribute ? $isRequiredByBuild : $isSelectedInRequest;

                                $isGrayedOut = $isDisabledByDimension || (!$isAvailableInResults && !$shouldBeChecked);
                                $shouldBeDisabled = $isForcedAttribute || $isGrayedOut;
                            @endphp

                            <label class="flex items-center gap-3 group {{ $shouldBeDisabled ? 'opacity-25 cursor-not-allowed grayscale' : 'cursor-pointer' }}" x-show="open || {{ $index }} < 3">
                                <input type="checkbox" name="attrs[{{ $attribute->id }}][]" value="{{ $val->id }}"
                                    {{ $shouldBeChecked ? 'checked' : '' }}
                                    {{ $shouldBeDisabled ? 'disabled' : '' }}
                                    class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-blue focus:ring-neon-blue transition-all">

                                <span class="text-[11px] {{ $shouldBeDisabled ? 'text-white/20' : 'text-white/60 group-hover:text-neon-blue' }} transition uppercase font-bruno">
                                    {{ $val->value }}

                                    @if($isDisabledByDimension)
                                        <span class="text-[7px] text-red-500/70 ml-1 font-sans">(NIE ZMIEŚCI SIĘ)</span>
                                    @elseif(!$isAvailableInResults && !$shouldBeChecked)
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
                    <a href="{{ route('konfigurator.index', ['category_id' => $category->id]) }}"
                        class="block text-center w-full bg-neon-purple/80 hover:bg-neon-purple py-2 rounded font-bruno text-[10px] uppercase transition-all shadow-lg shadow-neon-purple/20">
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
                <div class="flex flex-col items-center justify-center min-h-100 text-center p-8 border border-dashed border-white/10 rounded-3xl bg-black/20 backdrop-blur-sm">
                    <div class="w-20 h-20 mb-6 rounded-full bg-neon-blue/10 flex items-center justify-center shadow-lg shadow-neon-blue/20">
                        <svg class="w-10 h-10 text-neon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bruno text-white uppercase italic mb-4">Witaj w konfiguratorze</h2>
                    <p class="text-text-muted max-w-md leading-relaxed">
                        Wybierz komponent z panelu po prawej i zacznij budować swoje wymarzone stanowisko :
                    </p>
                </div>
            @else
            <div class="flex items-center gap-4 mb-8">
                <div class="h-px grow bg-linear-to-r from-neon-blue/50 to-transparent"></div>
                <h1 class="text-xl font-bruno text-white uppercase italic">Wybierz podzespół</h1>
                 <span class="text-[10px] text-text-muted">Wyświetlono: {{ $products->firstItem() }}-{{ $products->lastItem() }} z {{ $products->total() }}</span>
                <div class="h-px grow bg-linear-to-l from-neon-blue/50 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-8 flex justify-end px-4">
                {{ $products->links() }}
            </div>
            @endif
        </main>

        <aside class="col-span-12 lg:col-span-2 xl:col-span-2">
           <section class="flex flex-col bg-black/30 p-6 rounded-lg border border-white/5 backdrop-blur-sm">
                <div class="text-[11px] tracking-[2px] mb-5 text-text-muted font-bruno">BUILD STATUS</div>
                <div class="text-neon-blue text-[10px] mb-3 uppercase font-bruno">Wymagane elementy</div>
                <ul class="space-y-2 mb-8">
                   <a href="{{ route('konfigurator.index', ['category_id' => 1]) }}"> <x-config-item label="CPU" id="cpu-status" :categoryId="1" /> </a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 2]) }}"> <x-config-item label="GPU" id="gpu-status" :categoryId="2" /> </a>
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
                    <a href="{{ route('konfigurator.index', ['category_id' => 12]) }}"><x-config-item label="Chłodzenie CPU" id="chlodzenie-status" :categoryId="12" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 13]) }}"><x-config-item label="Karty sieciowe" id="karty_sieciowe-status" :categoryId="13" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 14]) }}"><x-config-item label="Monitor" id="monitor-status" :categoryId="14"/></a>
                </ul>
                    <div class="mt-auto pt-6 border-t border-white/10 space-y-3">
                    <div class="bg-white/5 p-3 rounded flex justify-between items-center">
                        <span class="text-[10px] text-text-muted uppercase">Wartość:</span>
                            @php
                                $totalPrice = 0;
                                foreach(session('configurator_build', []) as $catId => $data) {
                                    if (isset($data['price'])) {
                                        $totalPrice += $data['price'];
                                    } else {
                                        // Jeśli to tablica (RAM/Dyski)
                                        foreach($data as $item) {
                                            $totalPrice += $item['price'];
                                        }
                                    }
                                }
                            @endphp
                            <span class="text-neon-blue font-bruno text-lg">{{ number_format($totalPrice, 2) }} zł</span>
                    </div>
                    <button class="w-full bg-neon-purple/80 hover:bg-neon-purple py-3 rounded font-bruno text-xs uppercase transition-all shadow-lg shadow-neon-purple/20">
                        KUP ZESTAW
                    </button>
                    <form action="{{ route('configurator.reset') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-neon-purple/80 hover:bg-neon-purple py-3 rounded font-bruno text-xs uppercase transition-all shadow-lg shadow-neon-purple/20">
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

        if (filterForm) {
            // 1. Obsługa Checkboxów i Selecta (Sortowanie)
            filterForm.querySelectorAll('input[type="checkbox"], select').forEach(element => {
                element.addEventListener('change', function() {
                    console.log('Zmiana w: ' + this.name + ' -> Wysyłam formularz');
                    filterForm.submit();
                });
            });

            let typingTimer;
            filterForm.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => {
                        console.log('Cena zmieniona -> Wysyłam formularz');
                        filterForm.submit();
                    }, 800);
                });
            });
        } else {
            console.error('Błąd: Nie znaleziono formularza o ID #filter-form');
        }
    });
</script>
@endsection
