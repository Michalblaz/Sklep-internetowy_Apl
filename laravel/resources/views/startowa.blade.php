@extends('app')

@section('content')
@if (session('success'))
    <div class="bg-green-500/20 text-green-300 p-3 mb-4">
        {{ session('success') }}
    </div>
@endif

<!-- POLECANE -->
<div id="polecane" class="w-full px-4 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-neon-blue/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Polecane Produkty</h2>
        <div class="h-px grow bg-linear-to-l from-neon-blue/50 to-transparent"></div>
    </div>

    <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl p-8 md:p-12 md:px-20 shadow-2xl shadow-cyan-900/20 overflow-hidden">
        <div id="recommended-container" class="overflow-hidden">
            <div id="recommended-track" class="flex transition-transform duration-500 ease-out gap-10 items-stretch">
                @foreach($products as $product)
                    @php
                        $discount = ($product->base_price > 0 && $product->promo_price)
                            ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                            : 0;
                    @endphp

                    <div class="home-carousel-item carousel-item flex-none w-[260px]">
                        <x-product-card-home :product="$product" :discount="$discount" />
                    </div>
                @endforeach
            </div>
        </div>

        <button
            id="recommended-prev"
            type="button"
            data-carousel="recommended"
            data-carousel-direction="-1"
            class="absolute left-4 top-1/2 -translate-y-1/2 text-neon-blue text-5xl opacity-0 pointer-events-none transition-all duration-300 hover:scale-110 hover:opacity-100 hover:drop-shadow-[0_0_10px_#22d3ee] active:scale-90"
            aria-label="Poprzednie polecane produkty"
        >
            &#9664;
        </button>

        <button
            id="recommended-next"
            type="button"
            data-carousel="recommended"
            data-carousel-direction="1"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-neon-blue text-5xl opacity-40 transition-all duration-300 hover:scale-110 hover:opacity-100 hover:drop-shadow-[0_0_10px_#22d3ee] active:scale-90"
            aria-label="Następne polecane produkty"
        >
            &#9654;
        </button>
    </div>
</div>

<!-- PROMOCJE -->
<div id="promocje" class="w-full px-4 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-red-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Oferty Promocyjne</h2>
        <div class="h-px grow bg-linear-to-l from-red-500/50 to-transparent"></div>
    </div>

    <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl p-8 md:p-12 md:px-20 shadow-2xl shadow-red-900/20 overflow-hidden">
        <div id="promo-container" class="overflow-hidden">
            <div id="promo-track" class="flex transition-transform duration-500 ease-out gap-10 items-stretch">
                @foreach($promo_products as $product)
                    @php
                        $discount = ($product->base_price > 0 && $product->promo_price)
                            ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                            : 0;
                    @endphp

                    <div class="home-carousel-item carousel-item flex-none w-[260px]">
                        <x-product-card-home :product="$product" :discount="$discount" />
                    </div>
                @endforeach
            </div>
        </div>

        <button
            id="promo-prev"
            type="button"
            data-carousel="promo"
            data-carousel-direction="-1"
            class="absolute left-4 top-1/2 -translate-y-1/2 text-red-500 text-5xl opacity-0 pointer-events-none transition-all duration-300 hover:scale-110 hover:opacity-100 hover:drop-shadow-[0_0_10px_#ef4444] active:scale-90"
            aria-label="Poprzednie promocje"
        >
            &#9664;
        </button>

        <button
            id="promo-next"
            type="button"
            data-carousel="promo"
            data-carousel-direction="1"
            class="absolute right-4 top-1/2 -translate-y-1/2 text-red-500 text-5xl opacity-40 transition-all duration-300 hover:scale-110 hover:opacity-100 hover:drop-shadow-[0_0_10px_#ef4444] active:scale-90"
            aria-label="Następne promocje"
        >
            &#9654;
        </button>
    </div>
</div>

<!-- FILTROWANIE -->
<div id="filtrowanie" class="w-full px-4 lg:px-8 py-10">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-purple-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Filtrowanie Produktów</h2>
        <div class="h-px grow bg-linear-to-l from-purple-500/50 to-transparent"></div>
    </div>

    <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-[40px] p-8">
        <form id="home-filter-form" action="{{ route('home') }}#filtrowanie" method="GET" class="grid gap-6 lg:grid-cols-2 xl:grid-cols-[0.8fr_0.8fr_1fr]">
            <div class="space-y-2">
                <label class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold">Kategoria</label>
                <select name="category_id" class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-purple-400 outline-none">
                    <option value="">Wszystkie kategorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (string)$selectedCategory === (string)$category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold">Sortowanie</label>
                <select name="sort" class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-purple-400 outline-none">
                    <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Najnowsze</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Cena rosnąco ↑</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Cena malejąco ↓</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nazwa A-Z</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold">Cena</label>
                <div class="flex items-center gap-3">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Od" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-cyan-400 outline-none">
                    <div class="h-px w-5 bg-white/20"></div>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Do" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:border-cyan-400 outline-none">
                </div>
            </div>

            <div class="relative space-y-3">
                <label class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold">Marka</label>
                <button type="button" data-brand-dropdown-toggle class="flex w-full items-center justify-between rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-left text-sm text-white transition hover:border-purple-400/60 hover:bg-purple-500/10">
                    <span id="home-brand-summary">
                        {{ count(request('brands', [])) ? 'Wybrano marek: ' . count(request('brands', [])) : 'Wybierz marki' }}
                    </span>
                    <span class="text-purple-300 transition" data-brand-dropdown-icon>&#9662;</span>
                </button>

                <div id="home-brand-dropdown" class="hidden absolute left-0 right-0 z-30 rounded-2xl border border-purple-400/25 bg-[#080b18]/95 p-4 shadow-2xl shadow-purple-950/50 backdrop-blur-xl">
                    <div class="mb-3">
                        <input
                            type="text"
                            id="home-brand-search"
                            autocomplete="off"
                            placeholder="Szukaj marki..."
                            class="w-full rounded-xl border border-white/10 bg-black/35 px-4 py-3 text-xs text-white placeholder:text-white/35 outline-none transition focus:border-cyan-300/70 focus:bg-cyan-400/5 focus:shadow-[0_0_18px_rgba(34,211,238,0.16)]"
                        >
                    </div>
                    <div id="home-brand-options" class="home-brand-grid gap-2 pr-2">
                        @foreach($brands as $brand)
                            <label class="flex items-center gap-3 rounded-xl border border-white/5 bg-white/[0.03] px-3 py-2 cursor-pointer group transition hover:border-purple-400/40 hover:bg-purple-500/10">
                                <input type="checkbox" name="brands[]" value="{{ $brand->id }}" {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }} class="w-3 h-3 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500">
                                <span class="text-xs text-white/60 group-hover:text-white transition">{{ $brand->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div id="home-brand-hidden-selected" class="hidden"></div>
                </div>
            </div>

            <div id="home-attribute-filters" class="lg:col-span-2 xl:col-span-2">
            @if($selectedCategoryModel)
                <div class="space-y-5">
                    <p class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold">Atrybuty kategorii</p>

                    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($selectedCategoryModel->attributes as $attribute)
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <p class="mb-3 text-[10px] text-purple-300 uppercase tracking-[0.2em] font-bold">
                                    {{ $attribute->display_name }}
                                </p>

                                <div class="space-y-2">
                                    @foreach($attribute->values as $index => $value)
                                        @php
                                            $selectedValues = request()->input('attrs.' . $attribute->id, []);
                                            $isSelected = is_array($selectedValues) && in_array($value->id, $selectedValues);
                                            $isAvailable = in_array($value->id, $availableValueIds ?? []);
                                            $isDisabled = !$isAvailable && !$isSelected;
                                            $displayValue = strtolower((string) $value->value);
                                        @endphp

                                        <label class="home-filter-option flex items-center gap-3 group {{ $isDisabled ? 'opacity-30 cursor-not-allowed grayscale' : 'cursor-pointer' }} {{ $index >= 3 ? 'hidden' : '' }}" @if($index >= 3) data-filter-extra="{{ $attribute->id }}" @endif>
                                            <input type="checkbox" name="attrs[{{ $attribute->id }}][]" value="{{ $value->id }}" {{ $isSelected ? 'checked' : '' }} {{ $isDisabled ? 'disabled' : '' }} class="w-3 h-3 rounded border-white/20 bg-white/5 text-cyan-400 focus:ring-cyan-400">
                                            <span class="text-[11px] {{ $isDisabled ? 'text-white/25' : 'text-white/65 group-hover:text-cyan-300' }} transition uppercase font-bruno">
                                                {{ match($displayValue) {
                                                    'true' => 'Posiada',
                                                    'false', '0' => 'Nie posiada',
                                                    default => $value->value,
                                                } }}
                                                @if($isDisabled)
                                                    <span class="text-[8px] text-white/35 ml-1 font-sans">(0)</span>
                                                @endif
                                            </span>
                                        </label>
                                    @endforeach
                                </div>

                                @if($attribute->values->count() > 3)
                                    <button type="button" data-filter-toggle="{{ $attribute->id }}" class="mt-3 text-[10px] text-cyan-300 hover:text-white transition uppercase font-bold">
                                        + Pokaż więcej ({{ $attribute->values->count() - 3 }})
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-white/10 bg-white/5 p-5 text-sm text-gray-400">
                    Wybierz kategorię, aby zobaczyć filtry atrybutów.
                </div>
            @endif
            </div>

            <div class="flex flex-wrap items-center gap-3 lg:col-span-2 xl:col-span-3">
                <button type="submit" class="px-6 py-3 bg-purple-700/70 border border-purple-400/40 text-white rounded-full text-sm font-bold uppercase tracking-widest transition hover:bg-purple-600 hover:shadow-[0_0_15px_rgba(168,85,247,0.6)]">
                    Filtruj
                </button>

                <a href="{{ route('home') }}#filtrowanie" class="px-6 py-3 bg-blue-900/20 border border-blue-500/30 text-blue-300 rounded-full text-sm font-bold uppercase tracking-widest transition hover:bg-blue-600 hover:text-white hover:shadow-[0_0_15px_rgba(59,130,246,0.6)]">
                    Resetuj filtry
                </a>
            </div>
        </form>

        <script type="application/json" id="home-filter-data">
            @json($filterDataByCategory)
        </script>
    </div>
</div>

<!-- PRODUKTY -->
<div id="produkty" class="w-full px-4 lg:px-8 py-10">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-emerald-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Produkty</h2>
        <span class="text-[10px] text-gray-500 uppercase tracking-[0.25em]">Znaleziono: {{ $all_products->total() }}</span>
        <div class="h-px grow bg-linear-to-l from-emerald-500/50 to-transparent"></div>
    </div>

    <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-[40px] p-8">
        <div class="home-products-grid">
            @foreach($all_products as $product)
                @php
                    $discount = ($product->base_price > 0 && $product->promo_price)
                        ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                        : 0;
                @endphp

                <div class="home-product-cell">
                    <x-product-card-home :product="$product" :discount="$discount" />
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center items-center gap-3 font-bruno">
            @if (!$all_products->onFirstPage())
                <a href="{{ $all_products->previousPageUrl() }}#produkty"
                   class="text-purple-500 text-2xl hover:scale-110 transition hover:drop-shadow-[0_0_10px_rgba(168,85,247,0.7)]">
                    &#9664;
                </a>
            @endif

            <div class="flex gap-2">
                @foreach ($all_products->getUrlRange(
                    max(1, $all_products->currentPage() - 2),
                    min($all_products->lastPage(), $all_products->currentPage() + 2)
                ) as $page => $url)
                    <a href="{{ $url }}#produkty"
                       class="w-10 h-10 flex items-center justify-center rounded-full border text-sm transition-all duration-300
                       {{ $page == $all_products->currentPage()
                            ? 'bg-purple-600 border-purple-400 text-white shadow-[0_0_12px_rgba(168,85,247,0.8)] scale-110'
                            : 'border-white/10 text-gray-400 hover:bg-purple-600 hover:text-white hover:scale-110 hover:shadow-[0_0_10px_rgba(168,85,247,0.6)]' }}">
                        {{ $page }}
                    </a>
                @endforeach
            </div>

            @if ($all_products->hasMorePages())
                <a href="{{ $all_products->nextPageUrl() }}#produkty"
                   class="text-purple-500 text-2xl hover:scale-110 transition hover:drop-shadow-[0_0_10px_rgba(168,85,247,0.7)]">
                    &#9654;
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
