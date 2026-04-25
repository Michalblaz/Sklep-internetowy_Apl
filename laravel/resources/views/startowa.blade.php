@extends('app')

@section('content')
<div class="w-full px-4 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-neon-blue/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Polecane Produkty</h2>
        <div class="h-px grow bg-linear-to-l from-neon-blue/50 to-transparent"></div>
    </div>

    <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl p-12 px-20 shadow-2xl shadow-purple-900/10 overflow-hidden">
        <div id="featured-container" class="overflow-hidden">
            <div id="featured-track" class="flex transition-transform duration-500 ease-out gap-10 items-stretch">
                @foreach($products as $product)
                    <div class="flex-none w-[260px] carousel-item transition-opacity duration-500">
                        @php
    $discount = 0;
    if($product->base_price > 0 && $product->promo_price) {
        $discount = round((($product->base_price - $product->promo_price) / $product->base_price) * 100);
    }
@endphp

<x-product-card :product="$product" :discount="$discount" />
                    </div>
                @endforeach
            </div>
        </div>
        <button id="featured-prev" onclick="moveCarousel('featured', -1, this)" class="absolute left-4 top-1/2 -translate-y-1/2 z-50 text-neon-blue text-5xl opacity-0 pointer-events-none transition-all duration-300 transform scale-100">◀</button>
        <button id="featured-next" onclick="moveCarousel('featured', 1, this)" class="absolute right-4 top-1/2 -translate-y-1/2 z-50 text-neon-blue text-5xl opacity-40 hover:opacity-100 transition-all duration-300 transform scale-100">▶</button>
    </div>
</div>

<div class="w-full px-4 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-red-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Oferty Promocyjne</h2>
        <div class="h-px grow bg-linear-to-l from-red-500/50 to-transparent"></div>
    </div>

    <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-2xl p-12 px-20 shadow-2xl shadow-red-900/20 overflow-hidden">
        <div id="promo-container" class="overflow-hidden">
            <div id="promo-track" class="flex transition-transform duration-500 ease-out gap-10 items-stretch">
                @foreach($promo_products as $product)
                    <div class="flex-none w-[260px] carousel-item relative transition-opacity duration-500">
                        @php
                            $discount = 0;
                            if($product->base_price > 0 && $product->promo_price) {
                                $discount = round((($product->base_price - $product->promo_price) / $product->base_price) * 100);
                            }
                        @endphp
                        <x-product-card :product="$product" :discount="$discount" />
                    </div>
                @endforeach
            </div>
        </div>
        <button id="promo-prev" onclick="moveCarousel('promo', -1, this)" class="absolute left-4 top-1/2 -translate-y-1/2 z-50 text-red-500 text-5xl opacity-0 pointer-events-none transition-all duration-300 transform scale-100">◀</button>
        <button id="promo-next" onclick="moveCarousel('promo', 1, this)" class="absolute right-4 top-1/2 -translate-y-1/2 z-50 text-red-500 text-5xl opacity-40 hover:opacity-100 transition-all duration-300 transform scale-100">▶</button>
    </div>
</div>


<div class="w-full px-4 lg:px-8 py-10">
    <div class="w-full px-4 lg:px-8 py-6">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-red-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Kategorie Produktów</h2>
        <div class="h-px grow bg-linear-to-l from-red-500/50 to-transparent"></div>
    </div>

    <div class="relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-[40px] p-8 shadow-2xl shadow-purple-900/20">
        <div class="flex flex-wrap gap-4 items-center">

            @foreach($categories as $category)
                <button class="px-6 py-2 bg-purple-900/30 border border-purple-500/30 text-gray-300 rounded-full text-sm font-medium transition-all duration-300 hover:bg-purple-600 hover:text-white hover:shadow-[0_0_15px_rgba(168,85,247,0.5)] hover:border-purple-400">
                    {{ $category->name }}
                </button>
            @endforeach

            <div class="ml-auto">
                <a href="{{ url('/') }}" class="px-6 py-2 bg-blue-900/20 border border-blue-500/30 text-blue-300 rounded-full text-sm font-bold uppercase tracking-tighter transition-all hover:bg-blue-600 hover:text-white hover:shadow-[0_0_15px_rgba(59,130,246,0.5)]">
                    Resetuj kategorie
                </a>
            </div>
        </div>
    </div>
</div>


<div class="w-full px-4 lg:px-8 py-10">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-emerald-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Produkty</h2>
        <div class="h-px grow bg-linear-to-l from-emerald-500/50 to-transparent"></div>
    </div>

    <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-[40px] p-8 shadow-2xl shadow-emerald-900/10">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 auto-rows-fr">
            @foreach($all_products as $product)
                <div class="flex h-full transform hover:scale-[1.02] transition-transform duration-300">
                    @php
    $discount = 0;
    if($product->base_price > 0 && $product->promo_price) {
        $discount = round((($product->base_price - $product->promo_price) / $product->base_price) * 100);
    }
@endphp

<x-product-card :product="$product" :discount="$discount" class="h-full w-full" />
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center items-center gap-3 font-bruno">
            @if (!$all_products->onFirstPage())
                <a href="{{ $all_products->previousPageUrl() }}" class="text-purple-500 text-2xl">◀</a>
            @endif

            <div class="flex gap-2">
                @foreach ($all_products->getUrlRange(max(1, $all_products->currentPage() - 2), min($all_products->lastPage(), $all_products->currentPage() + 2)) as $page => $url)
                    <a href="{{ $url }}"
                       class="w-10 h-10 flex items-center justify-center rounded-full border text-sm transition-all
                       {{ $page == $all_products->currentPage() ? 'bg-purple-600 border-purple-400 text-white' : 'border-white/10 text-gray-400' }}">
                        {{ $page }}
                    </a>
                @endforeach
            </div>

            @if ($all_products->hasMorePages())
                <a href="{{ $all_products->nextPageUrl() }}" class="text-purple-500 text-2xl">▶</a>
            @endif
        </div>
    </div>
</div>


<style>
    .carousel-item { display: flex !important; opacity: 0.2; }
    .carousel-item.is-visible { opacity: 1; }
    .nav-btn-click { transform: translateY(-50%) scale(0.7) !important; }
    button[onclick^="moveCarousel"] { transition: transform 0.1s ease-in-out, opacity 0.3s !important; transform: translateY(-50%) scale(1); }
    .btn-hidden { opacity: 0 !important; pointer-events: none !important; }
    .btn-visible { opacity: 0.4 !important; pointer-events: auto !important; }

    .grid < x-product-card { height: 100%; }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #000; }
    ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #a855f7; }

    #promo-track .bg-neon-blue, #promo-track button { background-color: #dc2626 !important; }

</style>

<script>
    const carouselPositions = { featured: 0, promo: 0 };

    function moveCarousel(id, direction, btn) {
        const track = document.getElementById(`${id}-track`);
        const container = document.getElementById(`${id}-container`);
        const itemWidth = 300;
        const maxScroll = track.scrollWidth - container.offsetWidth;

        if (btn) {
            btn.classList.remove('nav-btn-click');
            void btn.offsetWidth;
            btn.classList.add('nav-btn-click');
            setTimeout(() => btn.classList.remove('nav-btn-click'), 100);
        }

        carouselPositions[id] += direction * itemWidth;
        if (carouselPositions[id] < 0) carouselPositions[id] = 0;
        if (carouselPositions[id] > maxScroll) carouselPositions[id] = maxScroll;

        track.style.transform = `translateX(-${carouselPositions[id]}px)`;
        updateArrows(id, maxScroll);
    }

    function updateArrows(id, maxScroll) {
        const prevBtn = document.getElementById(`${id}-prev`);
        const nextBtn = document.getElementById(`${id}-next`);
        const currentPos = carouselPositions[id];

        if (currentPos <= 0) { prevBtn.classList.add('btn-hidden'); }
        else { prevBtn.classList.remove('btn-hidden'); prevBtn.classList.add('btn-visible'); }

        if (currentPos >= maxScroll - 10) { nextBtn.classList.add('btn-hidden'); }
        else { nextBtn.classList.remove('btn-hidden'); nextBtn.classList.add('btn-visible'); }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const containers = ['featured-container', 'promo-container'];
        containers.forEach(containerId => {
            const container = document.getElementById(containerId);
            if (!container) return;
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    entry.isIntersecting ? entry.target.classList.add('is-visible') : entry.target.classList.remove('is-visible');
                });
            }, { root: container, threshold: 0.95 });
            container.querySelectorAll('.carousel-item').forEach(item => observer.observe(item));
        });
    });
</script>
@endsection
