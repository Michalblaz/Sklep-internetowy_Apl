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

<!-- KATEGORIE -->
<div id="kategorie" class="w-full px-4 lg:px-8 py-10">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-purple-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Kategorie Produktów</h2>
        <div class="h-px grow bg-linear-to-l from-purple-500/50 to-transparent"></div>
    </div>

    <div class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-[40px] p-8">
        <div class="flex flex-wrap gap-4 items-center">
            @foreach($categories as $category)
                <a href="{{ url()->current() }}?category={{ $category->id }}#produkty"
                   class="px-6 py-2 rounded-full text-sm font-medium transition-all duration-300 border
                   {{ (string)request('category') === (string)$category->id
                        ? 'bg-purple-600 text-white border-purple-400 shadow-[0_0_12px_rgba(168,85,247,0.8)] scale-105'
                        : 'bg-purple-900/30 border-purple-500/30 text-gray-300 hover:bg-purple-600 hover:text-white hover:scale-105' }}">
                    {{ $category->name }}
                </a>
            @endforeach

            <div class="ml-auto">
                <a href="{{ url()->current() }}#produkty"
                   class="px-6 py-2 bg-blue-900/20 border border-blue-500/30 text-blue-300 rounded-full text-sm font-bold uppercase tracking-tighter transition-all duration-300 hover:bg-blue-600 hover:text-white hover:shadow-[0_0_15px_rgba(59,130,246,0.6)] hover:scale-105">
                    Resetuj kategorie
                </a>
            </div>
        </div>
    </div>
</div>

<!-- PRODUKTY -->
<div id="produkty" class="w-full px-4 lg:px-8 py-10">
    <div class="flex items-center gap-4 mb-8">
        <div class="h-px grow bg-linear-to-r from-emerald-500/50 to-transparent"></div>
        <h2 class="text-xl font-bruno text-white uppercase italic">Produkty</h2>
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
