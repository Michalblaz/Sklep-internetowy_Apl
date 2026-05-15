@extends('app')

@section('content')

@php
    $totalPrice = 0;
    $totalPowerDraw = 0;
    $buildItems = session('configurator_build', []);
    $productIdsForPower = collect($buildItems)
        ->flatMap(fn ($data) => isset($data['id']) ? [$data['id']] : collect($data)->pluck('id'))
        ->filter()
        ->unique();
    $powerDrawByProductId = \App\Models\Product::whereIn('id', $productIdsForPower)->pluck('power_draw_w', 'id');

    foreach($buildItems as $catId => $data) {
        if (isset($data['price'])) {
            $totalPrice += $data['price'];
            $totalPowerDraw += (int) ($data['power_draw_w'] ?? $powerDrawByProductId[$data['id']] ?? 0);
        } else {
            // Jeśli to tablica (RAM/Dyski)
            foreach($data as $item) {
                $totalPrice += $item['price'];
                $totalPowerDraw += (int) ($item['power_draw_w'] ?? $powerDrawByProductId[$item['id']] ?? 0);
            }
        }
    }

    $minPsuWatts = $totalPowerDraw > 0 ? ceil(($totalPowerDraw * 1.10) / 50) * 50 : 0; // +10% i zaokrąglenie w górę do 50W
    $recommendedPsuWatts = $totalPowerDraw > 0 ? ceil(($totalPowerDraw * 1.30) / 50) * 50 : 0; // +30% i zaokrąglenie w górę do 50W

    // Sprawdzamy, czy aktualnie wybrany zasilacz spełnia te normy
    $selectedPsu = $buildItems[6] ?? null;
    $selectedPsuWatts = 0;
    if ($selectedPsu) {
        $selectedPsuWatts = $selectedPsuWatts = (new \App\Http\Controllers\ConfiguratorController)->getNumericValueFromSession($selectedPsu, 20); 
    }   
@endphp
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
                            if ($category && $catId == $category->id) {
                                continue; 
                            }
                            $itemData = isset($bItem[0]) ? $bItem[0] : $bItem; // Obsługa tablic np. dla RAMu
                            if(isset($itemData['attributes'])) {
                                foreach($itemData['attributes'] as $aId => $vId) {
                                    $requiredValueIds[$aId] = is_array($vId) ? $vId[0] : $vId;
                                }
                            }
                        }
                    @endphp
                    <input type="hidden" name="category_id" value="{{ $category->id ?? '' }}">
                    @if(request('change') == '1')
                        <input type="hidden" name="change" value="1">
                    @endif
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
                            {{ $attribute->display_name }}
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
                                $displayVal = strtolower((string) $val->value);
                            @endphp

                            <label class="flex items-center gap-3 group {{ $shouldBeDisabled ? 'opacity-25 cursor-not-allowed grayscale' : 'cursor-pointer' }}" x-show="open || {{ $index }} < 3">
                                <input type="checkbox" name="attrs[{{ $attribute->id }}][]" value="{{ $val->id }}"
                                    {{ $shouldBeChecked ? 'checked' : '' }}
                                    {{ $shouldBeDisabled ? 'disabled' : '' }}
                                    class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-blue focus:ring-neon-blue transition-all">

                                <span class="text-[11px] {{ $shouldBeDisabled ? 'text-white/20' : 'text-white/60 group-hover:text-neon-blue' }} transition uppercase font-bruno">
                                        {{ match($displayVal) {
                                            'true' => 'Posiada',
                                            'false', '0' => 'Nie posiada',
                                            default => $val->value,
                                        } }}
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
                    <a href="{{ route('konfigurator.index', array_merge(['category_id' => $category->id], request('change') == '1' ? ['change' => '1'] : [])) }}"
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
                <div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-8 border border-white/5 rounded-3xl bg-black/20 backdrop-blur-sm">
                    <div class="w-20 h-20 mb-6 rounded-full bg-neon-blue/10 flex items-center justify-center border border-neon-blue/20 animate-pulse">
                        <svg class="w-10 h-10 text-neon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bruno text-white mb-4 uppercase tracking-widest">Witaj w Konfiguratorze</h2>
                    <p class="text-text-muted max-w-md font-light leading-relaxed">Wybierz kategorię z menu po prawej, aby rozpocząć budowę swojej maszyny.</p>
                </div>
            @else
                @php
                    $selectedInThisCategory = session('configurator_build.' . $category->id);
                    $replaceIndex = request('replace_index');

                    // Konwersja na tablicę, aby obsłużyć wiele przedmiotów dla RAM (4) i Dysków (5)
                    $categoryItems = [];
                    if ($selectedInThisCategory) {
                        if (is_array($selectedInThisCategory) && isset($selectedInThisCategory[0])) {
                            $categoryItems = $selectedInThisCategory;
                        } else {
                            $categoryItems = [$selectedInThisCategory];
                        }
                    }
                    
                    $isChanging = request('change') == '1';
                    $isMultiCategory = in_array($category->id, [4, 5]); // RAM = 4, Dyski = 5

                @endphp

                {{-- JEŚLI MAMY PRZEDMIOT(Y) I NIE KLIKNĘLIŚMY "ZMIEŃ" (LUB "DODAJ") --}}
                @if(count($categoryItems) > 0 && !$isChanging)
                    <div class="space-y-8 mb-8">
                        @foreach($categoryItems as $index => $selectedItemData)
                            @php
                                // Pobieramy model dla KRAŻDEGO z wybranych przedmiotów (żeby atrybuty/ceny się zgadzały)
                                $selectedProductModel = $selectedItemData ? \App\Models\Product::with(['attributeValues.attribute'])->find($selectedItemData['id']) : null;
                                
                                // Zabezpieczenie: Przygotowujemy atrybuty specyficzne dla tego wybranego modelu
                                $selectedProductAttributes = [];
                                if ($selectedProductModel) {
                                    foreach ($selectedProductModel->attributeValues as $attrVal) {
                                        $rawName = $attrVal->attribute->name ?? 'Parametr';
                                        $selectedProductAttributes[] = [
                                            'label' => ucfirst(str_replace('_', ' ', $rawName)), // Możesz podpiąć tu swoje tłumaczenia, jeśli masz je w modelu
                                            'value' => $attrVal->value
                                        ];
                                    }
                                }
                            @endphp

                            <div class="relative bg-black/40 border border-neon-blue/30 rounded-2xl p-6 lg:p-10 backdrop-blur-md shadow-[0_0_30px_rgba(0,240,255,0.05)] overflow-hidden flex flex-col md:flex-row items-center gap-10">
                                
                                <div class="w-56 h-56 bg-white rounded-xl p-4 flex items-center justify-center shrink-0 shadow-lg">
                                    @if($selectedProductModel && $selectedProductModel->image_url) 
                                        <img src="{{ asset('images/' . $selectedProductModel->image_url) }}" 
                                            alt="{{ $selectedProductModel->name }}" 
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
                                    
                                    <h2 class="text-3xl font-bold text-white mb-2 uppercase tracking-tight">{{ $selectedItemData['name'] }}</h2>
                                    
                                    @php
                                        $selectedModelDiscount = ($selectedProductModel && $selectedProductModel->base_price > 0 && $selectedProductModel->promo_price && $selectedProductModel->promo_price < $selectedProductModel->base_price)
                                            ? round((($selectedProductModel->base_price - $selectedProductModel->promo_price) / $selectedProductModel->base_price) * 100)
                                            : 0;
                                        $selectedDiscount = $selectedItemData['discount'] ?? $selectedModelDiscount;
                                        $selectedBasePrice = $selectedItemData['base_price'] ?? $selectedProductModel?->base_price ?? $selectedItemData['price'];
                                        $selectedPromoPrice = $selectedItemData['promo_price'] ?? ($selectedModelDiscount > 0 ? $selectedProductModel->promo_price : null);
                                    @endphp
                                    
                                    @if($selectedDiscount > 0 && $selectedPromoPrice)
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="flex flex-col leading-tight">
                                                <span class="text-gray-400 line-through text-sm font-bruno">
                                                    {{ number_format($selectedBasePrice, 0, ',', ' ') }} z&#322;
                                                </span>
                                                <span class="text-green-400 font-bruno text-2xl">
                                                    {{ number_format($selectedPromoPrice, 0, ',', ' ') }} z&#322;
                                                </span>
                                            </div>
                                            <span class="bg-red-600/90 text-white font-bold px-3 py-1 rounded-full text-xs shadow-[0_0_15px_rgba(220,38,38,0.5)] font-bruno">
                                                -{{ $selectedDiscount }}%
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-green-400 font-bruno text-2xl mb-6">
                                            {{ number_format($selectedItemData['price'], 0, ',', ' ') }} zł
                                        </div>
                                    @endif

                                    @if($selectedProductModel && $selectedProductModel->attributeValues)
                                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                                            @foreach($selectedProductAttributes as $attr)
                                            <div class="flex flex-col border-l-2 border-neon-blue/30 pl-4 py-1 bg-white/5 rounded-r-xl transition-all hover:bg-white/10">
                                                <span class="text-[9px] text-gray-400 uppercase font-bruno">    
                                                    {{ $attr['label'] }}
                                                </span>
                                            <span class="text-white text-sm font-semibold">
                                                    @php
                                                        $value = strtolower((string) $attr['value']);
                                                    @endphp
                                                    {{ match($value) {
                                                        'true' => 'Posiada',
                                                        'false', '0' => 'Nie posiada',
                                                        default => $attr['value'],
                                                    } }}
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

                                        <a href="{{ route('konfigurator.remove', ['category' => $category->id, 'index' => $isMultiCategory ? $index : 0]) }}"
                                        class="inline-flex items-center gap-2 bg-red-500/10 hover:bg-red-600 border border-red-500/50 hover:border-red-600 text-red-400 hover:text-white py-3 px-6 rounded-full font-bold text-[10px] uppercase tracking-widest transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Usuń z zestawu
                                        </a>
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
                    @if($category->id == 6 && $totalPowerDraw > 0)
                        <div class="col-span-full mb-6 space-y-3">
                            {{-- Alert o minimalnej mocy --}}
                            <div class="flex items-center gap-4 p-4 bg-orange-500/10 border border-orange-500/30 rounded-xl">
                                <div class="shrink-0 w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-white font-bruno text-xs uppercase tracking-wider">Wymagana moc minimalna</h4>
                                    <p class="text-orange-200/70 text-[11px]">Twój zestaw pobiera ok. <b>{{ $totalPowerDraw }}W</b>. Wybierz zasilacz o mocy minimum <b>{{ $minPsuWatts }}W</b> (+10% zapasu).</p>
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
                            @if($selectedPsuWatts > 0 && $selectedPsuWatts < $minPsuWatts)
                                <div class="p-3 bg-red-500/20 border border-red-500 rounded-lg animate-pulse">
                                    <p class="text-red-400 text-[10px] font-bruno text-center uppercase">⚠️ UWAGA: Wybrany zasilacz ({{ $selectedPsuWatts }}W) jest za słaby dla tego zestawu!</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">
                        @forelse($products as $product)
                            @php
                                $discount = ($product->base_price > 0 && $product->promo_price && $product->promo_price < $product->base_price)
                                    ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                                    : 0;
                            @endphp
                            <x-product-card :product="$product" :discount="$discount" :replaceIndex="request('replace_index')" />
                        @empty
                            <div class="col-span-full py-20 text-center">
                                <p class="text-text-muted font-bruno uppercase tracking-widest">Brak produktów spełniających kryteria</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <div class="mt-8 flex justify-end px-4">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            @endif
        </main>

        <aside class="col-span-12 lg:col-span-2 xl:col-span-2">
           <section class="flex flex-col bg-black/30 p-6 rounded-lg border border-white/5 backdrop-blur-sm">
                @php
                    $cpuSelection = session('configurator_build.1');
                    $cpuRequiresGpu = (bool) ($cpuSelection['requires_gpu'] ?? false);
                    $cpuRequiresCooler = (bool) ($cpuSelection['requires_cooler'] ?? false);

                    if ($cpuSelection && (!array_key_exists('requires_gpu', $cpuSelection) || !array_key_exists('requires_cooler', $cpuSelection))) {
                        $cpuFlags = \DB::table('product_attributes')
                            ->join('attribute_values', 'product_attributes.attribute_value_id', '=', 'attribute_values.id')
                            ->where('product_attributes.product_id', $cpuSelection['id'])
                            ->whereIn('product_attributes.attribute_category_id', [7, 38])
                            ->pluck('attribute_values.value', 'product_attributes.attribute_category_id');

                        $cpuRequiresGpu = strtolower((string) ($cpuFlags[7] ?? 'true')) === 'false';
                        $cpuRequiresCooler = strtolower((string) ($cpuFlags[38] ?? 'true')) === 'false';
                    }

                    $gpuMissing = $cpuRequiresGpu && !session()->has('configurator_build.2');
                    $coolerMissing = $cpuRequiresCooler && !session()->has('configurator_build.12');
                @endphp
                <div class="text-[11px] tracking-[2px] mb-5 text-text-muted font-bruno">BUILD STATUS</div>
                <div class="text-neon-blue text-[10px] mb-3 uppercase font-bruno">Wymagane elementy</div>
                <ul class="space-y-2 mb-8">
                   <a href="{{ route('konfigurator.index', ['category_id' => 1]) }}"> <x-config-item label="CPU" id="cpu-status" :categoryId="1" /> </a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 2]) }}"> <x-config-item label="GPU" id="gpu-status" :categoryId="2" :required-warning="$gpuMissing" required-text="Procesor nie ma zintegrowanej grafiki" /> </a>
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
                    <a href="{{ route('konfigurator.index', ['category_id' => 12]) }}"><x-config-item label="Chłodzenie CPU" id="chlodzenie-status" :categoryId="12" :required-warning="$coolerMissing" required-text="Procesor nie ma chłodzenia w zestawie" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 13]) }}"><x-config-item label="Karty sieciowe" id="karty_sieciowe-status" :categoryId="13" /></a>
                    <a href="{{ route('konfigurator.index', ['category_id' => 14]) }}"><x-config-item label="Monitor" id="monitor-status" :categoryId="14"/></a>
                </ul>
                    <div class="mt-auto pt-6 border-t border-white/10 space-y-3">
                    <div class="bg-white/5 p-3 rounded flex justify-between items-center">
                        <span class="text-[10px] text-text-muted uppercase">Wartość:</span>
                        <span class="text-neon-blue font-bruno text-lg">{{ number_format($totalPrice, 2) }} zł</span>
                    </div>
                    <div class="bg-red-500/10 p-3 rounded flex justify-between items-center border border-red-500/30 shadow-[0_0_18px_rgba(239,68,68,0.18)]">
                        <span class="text-[10px] text-red-200 uppercase font-bruno">Pobór mocy:</span>
                        <span class="text-red-400 font-bruno text-lg drop-shadow-[0_0_8px_rgba(248,113,113,0.75)]">~{{ number_format($totalPowerDraw, 0, ',', ' ') }} W</span>
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
