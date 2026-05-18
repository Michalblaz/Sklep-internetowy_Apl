@extends('app')

@section('content')
@php
    $selectedBrands = collect($selectedBrands ?? request('brands', []))->map(fn ($id) => (int) $id)->all();
    $selectedAttrs = $selectedAttrs ?? request('attrs', []);
@endphp

<div class="w-full px-4 lg:px-8 py-6">
    <section class="flex flex-wrap items-center gap-x-6 gap-y-2 border-b border-white/10 pb-6 mb-6">
        <p class="text-xs uppercase tracking-widest text-purple-300 font-bruno">
            Wyniki wyszukiwania
        </p>

        <h1 class="text-3xl font-bold">
            Fraza:
            <span class="text-purple-400">"{{ $search }}"</span>
        </h1>
    </section>

    <div class="grid grid-cols-12 gap-6 items-start">

        {{-- LEWA STRONA --}}
        <main class="col-span-12 lg:col-span-9 space-y-6">



            {{-- kafelki  --}}
            {{-- polecane --}}
            <div id="polecane" class="w-full py-6 relative">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-px grow bg-linear-to-r from-neon-blue/50 to-transparent"></div>
                    <h2 class="text-xl font-bruno text-white uppercase italic">Polecane Produkty</h2>
                    <div class="h-px grow bg-linear-to-l from-neon-blue/50 to-transparent"></div>
                </div>

            <div class="relative bg-black/20 px-16 py-4 rounded-xl border border-white/10"> 

                <div id="recommended-container" class="overflow-hidden">

                    <div id="recommended-track" class="flex transition-transform duration-500 ease-out gap-10 items-stretch">

                        @foreach($products as $product)
                            <div class="carousel-item flex-none w-[220px] sm:w-[240px] lg:w-[260px]">

                                @php
                                    $discount = ($product->base_price > 0 && $product->promo_price)
                                        ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                                        : 0;
                                @endphp

                                <x-product-card-home :product="$product" :discount="$discount" />

                            </div>
                        @endforeach

                    </div>



                </div>

                <button id="recommended-prev" onclick="moveCarousel('recommended', -1)"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-neon-blue text-5xl opacity-0 pointer-events-none transition-all duration-300 hover:scale-110 hover:opacity-100 hover:drop-shadow-[0_0_10px_#22d3ee] active:scale-90">
                        ◀
                    </button>

                    <button id="recommended-next" onclick="moveCarousel('recommended', 1)"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-neon-blue text-5xl opacity-40 transition-all duration-300 hover:scale-110 hover:opacity-100 hover:drop-shadow-[0_0_10px_#22d3ee] active:scale-90">
                        ▶
                    </button>

            </div>


            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 bg-black/20 p-4 rounded-xl border border-white/10">

                <div class="text-xs text-gray-300">
                    @if($all_products->total() > 0)
                        Wyswietlono {{ $all_products->firstItem() }}-{{ $all_products->lastItem() }} z {{ $all_products->total() }}
                    @else
                        Brak wyników
                    @endif
                </div>

                <label class="flex items-center gap-3 text-xs text-gray-300">
                    Sortowanie
                    <select
                        name="sort"
                        form="filter-form"
                        class="bg-black/30 border border-white/10 text-xs px-3 py-2 rounded-lg text-white"
                    >
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Najnowsze</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Najniższa Cena</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Najwyższa Cena</option>
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nazwa A-Z</option>
                    </select>
                </label>

            </div>

            @if($all_products->count())

            <div id="search-results-list" class="space-y-4 mt-6">

                @foreach($all_products as $product)

                    @php
                        $discount = ($product->base_price > 0 && $product->promo_price)
                            ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                            : 0;

                        $price = $product->promo_price ?? $product->base_price;
                        $rating = round((float) ($product->reviews_avg_rating ?? 0), 2);
                        $ratingColorSegments = [];

                        for ($segment = 0; $segment < 5; $segment++) {
                            $segmentFill = max(0, min(1, $rating - $segment));
                            $ratingColorSegments[] = $segmentFill >= 1
                                ? 1
                                : ($segmentFill <= 0 ? 0 : round(floor($segmentFill * 10) / 10, 1));
                        }
                    @endphp

                    <div class="search-result-card bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6 hover:bg-white/10 transition">

                        {{-- LEWA --}}
                        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 w-full">

                            <div class="bg-white rounded-xl p-4 overflow-hidden flex items-center justify-center w-full sm:w-auto">
                                <x-kafelek-wyszukaj :product="$product" />
                            </div>

                            <div class="flex flex-col justify-between min-h-[120px]">

                                <p class="text-base sm:text-lg text-white font-semibold">
                                    {{ $product->name }}
                                </p>

                                <div class="order-3 mt-3 flex w-fit items-center gap-3 rounded-full border border-white/10 bg-black/20 px-3 py-2"
                                     aria-label="Srednia ocena produktu: {{ number_format($rating, 2) }}">
                                    <div class="flex items-center gap-1">
                                        @foreach($ratingColorSegments as $segmentFill)
                                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" class="rating-star h-4 w-4">
                                                <path class="rating-star__base" d="M12 2.5 14.94 8.46 21.52 9.42 16.76 14.06 17.88 20.62 12 17.53 6.12 20.62 7.24 14.06 2.48 9.42 9.06 8.46 12 2.5Z" />
                                                <path class="rating-star__fill"
                                                      style="clip-path: inset(0 {{ number_format((1 - $segmentFill) * 100, 0, '.', '') }}% 0 0);"
                                                      d="M12 2.5 14.94 8.46 21.52 9.42 16.76 14.06 17.88 20.62 12 17.53 6.12 20.62 7.24 14.06 2.48 9.42 9.06 8.46 12 2.5Z" />
                                            </svg>
                                        @endforeach
                                    </div>

                                    <span class="text-xs font-semibold text-white/85">
                                        {{ number_format($rating, 2) }}
                                    </span>
                                </div>

                                <a href="{{ route('products.show', $product->id) }}"
                                   class="order-2 mt-12 inline-flex justify-center px-5 py-2 w-[200px]
                                          bg-linear-to-r from-indigo-600 to-purple-600
                                          hover:from-indigo-500 hover:to-purple-500
                                          text-white font-bold rounded-full transition">
                                    więcej informacji
                                </a>

                            </div>

                        </div>

                        {{-- PRAWA --}}
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-col items-center justify-center gap-3 w-full lg:w-[280px] self-stretch">

                            <p class="text-lg text-white font-semibold">
                                {{ $price }} zł
                            </p>

                            <button class="w-full py-3 bg-linear-to-r from-indigo-600 to-purple-600
                                           hover:from-indigo-500 hover:to-purple-500
                                           text-white font-bold rounded-full transition">
                                Dodaj do koszyka
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="mt-8 flex justify-end px-4">
                {{ $all_products->links() }}
            </div>







            @else

            <div class="text-center text-xl text-gray-400 py-20 border border-dashed border-white/10 rounded-2xl bg-black/20">
                Nie znaleziono produktów
            </div>

            @endif

        </main>

        {{-- PRAWA STRONA - FILTRY --}}
        <aside class="col-span-12 lg:col-span-3">

            <div id="filter-panel" class="bg-black/40 p-5 rounded-2xl border border-white/10 backdrop-blur-xl sticky top-6 overflow-y-auto shadow-2xl shadow-purple-900/10">

                <div class="flex items-center justify-between gap-3 mb-6">
                    <h2 class="text-purple-300 font-bruno text-sm uppercase tracking-widest italic">
                        Filtry
                    </h2>
                    <span class="text-[10px] text-white/40 uppercase tracking-widest">
                        {{ $all_products->total() }}
                    </span>
                </div>

                <form id="filter-form" action="{{ route('wyszukaj') }}" method="GET" class="space-y-6">

                    <input type="hidden" name="search" value="{{ $search }}">

                    {{-- CENA --}}
                    <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                        <label class="text-[10px] text-gray-400 uppercase mb-3 block font-bold tracking-widest">
                            Cena
                        </label>

                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                   placeholder="Od"
                                   class="w-full bg-black/30 border border-white/10 px-3 py-2 rounded-lg text-xs text-white focus:border-purple-400 focus:outline-none transition">

                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                   placeholder="Do"
                                   class="w-full bg-black/30 border border-white/10 px-3 py-2 rounded-lg text-xs text-white focus:border-purple-400 focus:outline-none transition">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-linear-to-r from-indigo-600 to-purple-600
                                   hover:from-indigo-500 hover:to-purple-500
                                   text-white font-bold rounded-xl uppercase tracking-widest text-xs transition">
                        Filtruj
                    </button>

                    {{-- MARKI --}}
                    @if($brands->count())
                        <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                            <p class="text-[10px] text-gray-400 uppercase mb-3 font-bold tracking-widest">Marka</p>

                            <div class="filter-options space-y-2 max-h-56 overflow-y-auto pr-1">
                                @foreach($brands as $brand)
                                    @php
                                        $checked = in_array((int)$brand->id, $selectedBrands, true);
                                    @endphp

                                    <label class="flex items-center justify-between gap-3 rounded-lg border px-3 py-2 text-xs transition cursor-pointer
                                                  {{ $checked ? 'border-purple-400/70 bg-purple-500/15 text-white shadow-[0_0_14px_rgba(168,85,247,0.18)]' : 'border-white/10 bg-black/20 text-white/60 hover:border-purple-400/40 hover:bg-white/10 hover:text-white' }}">
                                        <span class="truncate">{{ $brand->name }}</span>
                                        <input type="checkbox"
                                               name="brands[]"
                                               value="{{ $brand->id }}"
                                               {{ $checked ? 'checked' : '' }}
                                               class="h-4 w-4 rounded border-white/20 bg-black/40 text-purple-500 focus:ring-purple-500 focus:ring-offset-0">
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- ATRYBUTY --}}
                    @foreach($attributes as $attribute)
                        @if($attribute->values->count())
                            <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4">
                                <p class="text-[10px] text-gray-400 uppercase mb-3 font-bold tracking-widest">
                                    {{ $attribute->name }}
                                </p>

                                <div class="filter-options space-y-2 max-h-56 overflow-y-auto pr-1">
                                    @foreach($attribute->values as $value)
                                        @php
                                            $selectedAttributeValues = collect($selectedAttrs[$attribute->id] ?? [])->map(fn ($id) => (int) $id)->all();
                                            $checked = in_array((int)$value->id, $selectedAttributeValues, true);
                                        @endphp

                                        <label class="flex items-center justify-between gap-3 rounded-lg border px-3 py-2 text-xs transition cursor-pointer
                                                      {{ $checked ? 'border-cyan-400/70 bg-cyan-500/15 text-white shadow-[0_0_14px_rgba(34,211,238,0.14)]' : 'border-white/10 bg-black/20 text-white/60 hover:border-cyan-400/40 hover:bg-white/10 hover:text-white' }}">
                                            <span class="truncate">{{ $value->value }}</span>
                                            <input type="checkbox"
                                                   name="attrs[{{ $attribute->id }}][]"
                                                   value="{{ $value->id }}"
                                                   {{ $checked ? 'checked' : '' }}
                                                   class="h-4 w-4 rounded border-white/20 bg-black/40 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-0">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{-- RESET --}}
                    <a href="{{ route('wyszukaj', ['search' => $search]) }}"
                       class="block text-center border border-purple-400/30 bg-purple-500/10 hover:bg-purple-500/20 py-3 rounded-xl text-xs uppercase tracking-widest transition">
                        Reset
                    </a>

                </form>

            </div>

        </aside>

    </div>
</div>

<style>
.carousel-item { display:flex }
.filter-options {
    scrollbar-width: thin;
    scrollbar-color: rgba(168, 85, 247, 0.65) rgba(255, 255, 255, 0.08);
}

#filter-panel {
    scrollbar-width: thin;
    scrollbar-color: rgba(168, 85, 247, 0.65) rgba(255, 255, 255, 0.08);
}

.rating-star__base {
    fill: rgba(255, 255, 255, 0.16);
    stroke: rgba(255, 255, 255, 0.22);
    stroke-width: 1.4;
    stroke-linejoin: round;
}

.rating-star__fill {
    fill: rgb(243, 255, 0);
    stroke: rgba(6, 8, 14, 0.9);
    stroke-width: 1.1;
    stroke-linejoin: round;
}

.filter-options::-webkit-scrollbar {
    width: 6px;
}

#filter-panel::-webkit-scrollbar {
    width: 6px;
}

.filter-options::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 999px;
}

#filter-panel::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 999px;
}

.filter-options::-webkit-scrollbar-thumb {
    background: rgba(168, 85, 247, 0.65);
    border-radius: 999px;
}

#filter-panel::-webkit-scrollbar-thumb {
    background: rgba(168, 85, 247, 0.65);
    border-radius: 999px;
}
</style>

<script>
const carouselPositions = { recommended: 0 };

function moveCarousel(id, direction) {
    const track = document.getElementById(`${id}-track`);
    const container = document.getElementById(`${id}-container`);
    const items = track.querySelectorAll('.carousel-item');

    if (!items.length) return;

    const itemWidth = items[0].offsetWidth + 40;
    const maxScroll = track.scrollWidth - container.offsetWidth;

    carouselPositions[id] += direction * itemWidth;

    if (carouselPositions[id] < 0) carouselPositions[id] = 0;
    if (carouselPositions[id] > maxScroll) carouselPositions[id] = maxScroll;

    track.style.transform = `translateX(-${carouselPositions[id]}px)`;

    updateArrows(id, maxScroll);
}

function updateArrows(id, maxScroll) {
    const prevBtn = document.getElementById(`${id}-prev`);
    const nextBtn = document.getElementById(`${id}-next`);
    const current = carouselPositions[id];

    prevBtn.style.opacity = current <= 0 ? "0" : "0.4";
    prevBtn.style.pointerEvents = current <= 0 ? "none" : "auto";

    nextBtn.style.opacity = current >= maxScroll ? "0" : "0.4";
    nextBtn.style.pointerEvents = current >= maxScroll ? "none" : "auto";
}

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('filter-form');

    if (!form) return;

    const track = document.getElementById('recommended-track');
    const container = document.getElementById('recommended-container');
    if (track && container) {
        const maxScroll = track.scrollWidth - container.offsetWidth;
        updateArrows('recommended', maxScroll);
    }

    const filterPanel = document.getElementById('filter-panel');
    const resultsList = document.getElementById('search-results-list');
    const firstResultCard = document.querySelector('.search-result-card');

    function syncFilterPanelHeight() {
        if (!filterPanel || !resultsList || !firstResultCard || window.innerWidth < 1024) {
            if (filterPanel) {
                filterPanel.style.maxHeight = '';
                filterPanel.style.minHeight = '';
            }

            return;
        }

        const cardHeight = firstResultCard.offsetHeight;
        const resultCards = resultsList.querySelectorAll('.search-result-card').length;
        const resultListStyles = window.getComputedStyle(resultsList);
        const cardGap = parseFloat(resultListStyles.rowGap || resultListStyles.gap) || 16;
        const visibleCards = Math.min(Math.max(resultCards, 2), 8);
        const maxPanelHeight = (cardHeight * visibleCards) + (cardGap * (visibleCards - 1));

        filterPanel.style.minHeight = `${(cardHeight * 2) + cardGap}px`;
        filterPanel.style.maxHeight = `${maxPanelHeight}px`;
    }

    syncFilterPanelHeight();
    window.addEventListener('resize', syncFilterPanelHeight);

});
</script>

@endsection
