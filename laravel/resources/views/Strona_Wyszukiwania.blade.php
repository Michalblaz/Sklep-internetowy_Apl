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

            {{-- INFO + SORT --}}
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
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Cena rosnąco</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Cena malejąco</option>
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nazwa A-Z</option>
                    </select>
                </label>

            </div>

            {{-- 🔥 TWOJE KAFELKI --}}
            @if($all_products->count())

            <div class="space-y-4 mt-6">

                @foreach($all_products as $product)

                    @php
                        $discount = ($product->base_price > 0 && $product->promo_price)
                            ? round((($product->base_price - $product->promo_price) / $product->base_price) * 100)
                            : 0;

                        $price = $product->promo_price ?? $product->base_price;
                    @endphp

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6 hover:bg-white/10 transition">

                        {{-- LEWA --}}
                        <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-6 w-full">

                            <div class="bg-white rounded-xl p-4 overflow-hidden">
                                <x-kafelek-wyszukaj :product="$product" />
                            </div>

                            <div class="flex flex-col justify-between min-h-[120px]">

                                <p class="text-base sm:text-lg text-white font-semibold">
                                    {{ $product->name }}
                                </p>

                                <a href="{{ route('products.show', $product->id) }}"
                                   class="mt-4 inline-flex justify-center px-5 py-2 w-[200px]
                                          bg-linear-to-r from-indigo-600 to-purple-600
                                          hover:from-indigo-500 hover:to-purple-500
                                          text-white font-bold rounded-full transition">
                                    więcej informacji
                                </a>

                            </div>

                        </div>

                        {{-- PRAWA --}}
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 flex flex-col items-center justify-center gap-3 w-full lg:w-[280px]">

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

            <div class="mt-10">
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

            <div class="bg-black/40 p-5 rounded-2xl border border-white/10 backdrop-blur-xl sticky top-6">

                <h2 class="text-purple-300 font-bruno text-sm mb-6 uppercase tracking-widest italic">
                    Filtry
                </h2>

                <form id="filter-form" action="{{ route('wyszukaj') }}" method="GET" class="space-y-6">

                    <input type="hidden" name="search" value="{{ $search }}">

                    {{-- CENA --}}
                    <div>
                        <label class="text-[10px] text-gray-400 uppercase mb-3 block font-bold">
                            Cena
                        </label>

                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}"
                                   placeholder="Od"
                                   class="w-full bg-white/5 border border-white/10 px-3 py-2 rounded text-xs text-white">

                            <input type="number" name="max_price" value="{{ request('max_price') }}"
                                   placeholder="Do"
                                   class="w-full bg-white/5 border border-white/10 px-3 py-2 rounded text-xs text-white">
                        </div>
                    </div>

                    {{-- MARKI --}}
                    @if($brands->count())
                        <div class="border-t border-white/10 pt-4">
                            <p class="text-[10px] text-gray-400 uppercase mb-3 font-bold">Marka</p>

                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($brands as $brand)
                                    <label class="flex items-center gap-2 text-xs text-white/60">
                                        <input type="checkbox"
                                               name="brands[]"
                                               value="{{ $brand->id }}"
                                               {{ in_array((int)$brand->id, $selectedBrands, true) ? 'checked' : '' }}>
                                        {{ $brand->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- RESET --}}
                    <a href="{{ route('wyszukaj', ['search' => $search]) }}"
                       class="block text-center bg-white/10 hover:bg-white/20 py-2 rounded text-xs uppercase">
                        Reset
                    </a>

                </form>

            </div>

        </aside>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('filter-form');

    if (!form) return;

    form.querySelectorAll('input[type="checkbox"], select').forEach(el => {
        el.addEventListener('change', () => form.submit());
    });

    let t;
    form.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', () => {
            clearTimeout(t);
            t = setTimeout(() => form.submit(), 600);
        });
    });

});
</script>

@endsection
