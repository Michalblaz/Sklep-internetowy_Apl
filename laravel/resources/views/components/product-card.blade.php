@props(['product', 'discount' => 0, 'replaceIndex' => null])

<div class="relative group flex flex-col h-full bg-[#1a202c] border border-gray-700 rounded-2xl p-4 transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(139,92,246,0.3)]">

    <div class="absolute top-3 left-3 z-10 bg-black/80 backdrop-blur-md text-white px-4 py-2 rounded-xl text-sm shadow-[0_0_15px_rgba(34,197,94,0.3)] transition-all duration-300 group-hover:scale-105">

        @if($discount > 0)
            <div class="flex flex-col leading-tight">
                <span class="text-gray-400 line-through text-xs">
                    {{ number_format($product->base_price, 0, ',', ' ') }} zł
                </span>
                <span class="text-green-400 font-bold text-base">
                    {{ number_format($product->promo_price, 0, ',', ' ') }} zł
                </span>
            </div>
        @else
            <span class="text-green-400 font-bold text-base">
                {{ number_format($product->base_price, 0, ',', ' ') }} zł
            </span>
        @endif

    </div>

    @if($discount > 0)
    <div class="absolute top-3 right-3 z-20">
        <div class="bg-red-600/90 backdrop-blur-md text-white font-bold px-4 py-1 rounded-full text-sm shadow-[0_0_15px_rgba(220,38,38,0.5)] font-bruno transition-all duration-300 group-hover:scale-105">
            -{{ $discount }}%
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl p-4 mb-6 overflow-hidden">
        <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}"
             class="w-full h-48 object-contain transition-transform duration-500 group-hover:scale-110">
    </div>

    <div class="flex flex-col flex-grow">
        <h3 class="text-white text-center font-bold text-lg mb-6 tracking-wide uppercase">
            {{ $product->name }}
        </h3>

        <form action="{{ route('configurator.select') }}" method="POST" class="mt-auto">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="category_id" value="{{ $product->category_id }}">
            <input type="hidden" name="price" value="{{ $discount > 0 ? $product->promo_price : $product->base_price }}">
            <input type="hidden" name="name" value="{{ $product->name }}">
            <input type="hidden" name="replace_index" value="{{ $replaceIndex }}">

            <button type="submit"
                class="w-full py-3 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-full transition-all duration-300 shadow-lg uppercase tracking-tighter">
                Wybierz
            </button>
        </form>
    </div>
</div>
