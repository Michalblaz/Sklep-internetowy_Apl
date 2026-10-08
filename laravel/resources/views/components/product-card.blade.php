@props(['product', 'discount' => 0, 'replaceIndex' => null])

<div class="relative group overflow-hidden rounded-2xl border border-white/5 bg-black/30 backdrop-blur-md p-4 shadow-xl hover:border-purple-500/30 transition-all duration-300 flex flex-col justify-between h-full">
    <div>
        <div class="w-full aspect-square rounded-xl bg-white/5 overflow-hidden mb-4 relative flex items-center justify-center">
        <a href="/produkt/{{ $product->id }}" class="block bg-white rounded-xl p-4 mb-6 overflow-hidden cursor-pointer group/img">
            @if($product->image_url)
                <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}"
                    class="w-full h-48 object-contain transition-transform duration-500 group-hover/img:scale-110 group-hover:scale-105">
            @else
                <div class="w-full h-48 flex items-center justify-center bg-gray-100 text-gray-400 text-xs font-bruno rounded-xl">
                    BRAK ZDJĘCIA
                </div>
            @endif
        </a>         
           @if($discount > 0)
                <span class="absolute top-3 right-3 z-30 bg-red-600 text-white text-sm sm:text-base font-black px-3 py-1 rounded-xl uppercase tracking-wide animate-pulse font-bruno border border-red-400/40 shadow-[0_0_20px_rgba(220,38,38,0.8)] scale-105 group-hover:scale-115 transition-transform duration-300">
                    -{{ $discount }}%
                </span>
            @endif

            @if($product->reviews_avg_rating)
                <div class="absolute bottom-2 left-2 flex items-center gap-1 bg-black/60 backdrop-blur-md px-2 py-0.5 rounded-lg border border-white/10 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-yellow-400 drop-shadow-[0_0_4px_rgba(250,204,21,0.6)]" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-white text-xs font-bold font-bruno">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                </div>
            @endif
        </div>

        <p class="text-[10px] uppercase font-bruno text-gray-500 mb-1">
            {{ optional($product->brand)->name ?? 'Gamer' }}
        </p>
        <h3 class="text-sm font-bold text-white/90 line-clamp-2 h-10 group-hover:text-purple-400 transition uppercase tracking-wide">
            {{ $product->name }}
        </h3>
    </div>
    <div class="mt-4">
        <div class="mb-2 flex items-center gap-1.5 text-xs">
            @if($product->stock_quantity > 0)
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $product->stock_quantity <= 3 ? 'bg-amber-400' : 'bg-emerald-400' }} opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $product->stock_quantity <= 3 ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                </span>
                <span class="{{ $product->stock_quantity <= 3 ? 'text-amber-400' : 'text-emerald-400' }} font-medium">
                    Dostępność: <strong class="font-bold">{{ $product->stock_quantity }} szt.</strong>
                </span>
            @else
                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                <span class="text-red-500 font-medium">Produkt niedostępny</span>
            @endif
        </div>

        <div class="mb-3 flex items-baseline gap-2">
            @if($discount > 0)
                <span class="text-lg font-black text-green-400 font-bruno drop-shadow-[0_0_8px_rgba(74,222,128,0.3)]">
                    {{ number_format($product->promo_price, 2, ',', ' ') }} zł
                </span>
                <span class="text-xs text-gray-500 line-through">
                    {{ number_format($product->base_price, 2, ',', ' ') }} zł
                </span>
            @endif
            @if($discount <= 0)
                <span class="text-lg font-black text-white font-bruno">
                    {{ number_format($product->base_price, 2, ',', ' ') }} zł
                </span>
            @endif
        </div>

        <form action="{{ route('configurator.select') }}" method="POST" class="w-full">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="category_id" value="{{ $product->category_id }}">
            <input type="hidden" name="replace_index" value="{{ $replaceIndex }}">

            <button type="submit" 
                @if($product->stock_quantity <= 0) disabled @endif
                class="w-full py-2 bg-purple-900/30 hover:bg-purple-600 border border-purple-500/30 hover:border-purple-500 text-purple-300 hover:text-white text-xs font-bold font-bruno rounded-xl transition-all duration-200 active:scale-95 flex items-center justify-center gap-2 uppercase tracking-tighter shadow-lg disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-purple-900/30 disabled:hover:border-purple-500/30 disabled:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Wybierz
            </button>
        </form>
    </div>
</div>
