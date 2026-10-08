@props([
    'product',
    'discount' => 0,
])

@php
    $hasRating = $product->reviews_avg_rating !== null;
    $rating = round((float) ($product->reviews_avg_rating ?? 0), 2);
    $ratingSegments = [];

    for ($segment = 0; $segment < 5; $segment++) {
        $segmentFill = max(0, min(1, $rating - $segment));
        $ratingSegments[] = $segmentFill >= 1
            ? 1
            : ($segmentFill <= 0 ? 0 : round(floor($segmentFill * 10) / 10, 1));
    }

    $stockQuantity = (int) ($product->stock_quantity ?? 0);
@endphp

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
        <h3 class="flex min-h-[4.75rem] items-start justify-center text-white text-center font-bold text-lg mb-3 tracking-wide uppercase transition-colors duration-200 group-hover:text-purple-400">
            {{ $product->name }}
        </h3>

        <div class="mt-auto mb-6 flex min-h-[4.25rem] flex-col items-center justify-end gap-2 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.16em] {{ $stockQuantity <= 0 ? 'text-red-300/90' : ($stockQuantity <= 3 ? 'text-amber-300' : 'text-cyan-200/85') }}">
                {{ $stockQuantity > 0 ? 'Na stanie: ' . $stockQuantity : 'Brak na stanie' }}
            </p>

            <div class="flex items-center justify-center gap-2 text-sm text-white/80" title="{{ $hasRating ? 'Średnia ocen: ' . number_format($rating, 2, ',', ' ') : 'Brak ocen' }}">
                <div class="aspect-square w-8">
                    <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false" class="block h-full w-full overflow-visible">
                        @foreach ($ratingSegments as $segmentFill)
                            @php
                                $segmentStyle = '--arm-fill:' . number_format($segmentFill, 2, '.', '') . ';';
                            @endphp
                            <polygon
                                points="50,50 38,33 50,6 62,33"
                                class="home-rating-star__arm"
                                style="{{ $segmentStyle }}"
                                transform="rotate({{ $loop->index * 72 }} 50 50)"
                            />
                        @endforeach
                    </svg>
                </div>
                <span class="font-semibold">{{ $hasRating ? number_format($rating, 2, ',', ' ') : 'Brak ocen' }}</span>
            </div>
        </div>

        <a href="{{ route('products.show', $product->id) }}"
           class="w-full inline-flex justify-center py-3 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-full transition-all duration-300 shadow-lg uppercase tracking-widest">
            Zobacz
        </a>
    </div>
</div>
