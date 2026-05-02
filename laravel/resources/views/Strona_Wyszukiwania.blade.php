@extends('app')

@section('content')

<div class="w-full px-4 lg:px-8 py-6">
    <div class="grid grid-cols-12 gap-6">

        {{-- lewa strona --}}
        <main class="col-span-12 lg:col-span-9 space-y-6">

            <div>
                <h1 class="text-lg font-bruno text-white italic">
                    Znalezione wyniki dla: <span class="text-neon-blue"> wpisna fraza</span>
                </h1>
                <p class="text-[10px] text-text-muted">(wyniki: 120)</p>
            </div>

            {{-- karuzelaa --}}
            <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl p-12 px-20 overflow-hidden min-h-[480px]">

                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-sm font-bruno text-white">
                        Polecane w kategorii
                    </h2>

                    <div class="flex items-center gap-2">
                        <button id="recommended-prev"
                            onclick="moveCarousel('recommended', -1)"
                            class="text-white text-3xl opacity-0 hover:opacity-100 transition">
                            ◀
                        </button>

                        <button id="recommended-next"
                            onclick="moveCarousel('recommended', 1)"
                            class="text-white text-3xl opacity-40 hover:opacity-100 transition">
                            ▶
                        </button>
                    </div>
                </div>

                <div id="recommended-container" class="overflow-hidden">
                    <div id="recommended-track"
                        class="flex transition-transform duration-500 ease-out gap-10 items-stretch">

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

            </div>



            {{-- sortowanie --}}
            <div class="flex items-center justify-between bg-black/20 p-3 rounded-xl border border-white/10">
                <button class="text-white text-xs">☰</button>

                <select class="bg-black/30 border border-white/10 text-xs px-3 py-1 rounded">
                    <option>Sortowanie</option>
                </select>

                <div class="text-xs text-white">1 z 60</div>
            </div>


           {{-- lista --}}
            <div class="space-y-4 mt-6">

                @foreach($products as $product)

                    @php
                        $discount = ($product->base_price > 0 && $product->promo_price)
                            ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                            : 0;

                        $price = $product->promo_price ?? $product->base_price;
                    @endphp

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-6 flex flex-col lg:flex-row lg:items-stretch lg:items-center justify-between gap-6 hover:bg-white/10 transition">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 sm:gap-6 w-full h-full">

                            <div class="bg-white rounded-xl p-4 mb-6 overflow-hidden">
                               <x-kafelek-wyszukaj :product="$product" />
                            </div>

                            <div class="flex flex-col justify-between h-full min-h-[150px]">

                                <p class="text-base sm:text-lg lg:text-xl text-white font-semibold break-words leading-snug">
                                    {{ $product->name }}
                                </p>

                                <a href="{{ route('products.show', $product->id) }}"
                                class="mt-4 inline-flex justify-center px-4 sm:px-6 py-2.5 sm:py-3 w-[180px] sm:w-[280px] bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-full transition-all duration-300 shadow-lg uppercase tracking-widest text-xs sm:text-sm">
                                    więcej informacji
                                </a>

                            </div>

                        </div>


                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-row lg:flex-col items-center justify-center gap-4 w-full lg:w-[380px] xl:w-[420px]">

                            <p class="text-lg text-white font-semibold whitespace-nowrap">
                                {{ $price }} zł
                            </p>

                            <button class="w-full inline-flex justify-center py-3 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-full transition-all duration-300 shadow-lg uppercase tracking-widest">
                                Dodaj do koszyka
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

                </main>


                {{-- prawa strona  --}}
                {{-- filtry --}}
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

                    </div>

                </aside>

            </div>
        </div>


<style>
.carousel-item { display:flex }
html { scroll-behavior: smooth; }
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
    nextBtn.style.opacity = current >= maxScroll ? "0" : "0.4";
}

document.addEventListener('DOMContentLoaded', function() {
    const id = 'recommended';

    const track = document.getElementById(`${id}-track`);
    const container = document.getElementById(`${id}-container`);
    if (!track || !container) return;

    const maxScroll = track.scrollWidth - container.offsetWidth;
    updateArrows(id, maxScroll);
});
</script>

@endsection
