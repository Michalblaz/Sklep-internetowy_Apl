@props(['label', 'id', 'categoryId'])

@php
    $build = session('configurator_build', []);
    $selectedProduct = $build[$categoryId] ?? null;

    // Logika obsługi wielu przedmiotów (np. 2 dyski) lub jednego
    $isMulti = $selectedProduct && !isset($selectedProduct['id']);
    $items = $isMulti ? $selectedProduct : ($selectedProduct ? [$selectedProduct] : []);
@endphp

<li class="list-none relative group"> 
    <div {{ $attributes->merge(['class' => 'w-full flex justify-between items-center bg-white/5 border border-white/10 rounded-md py-[10px] px-3 text-[11px] uppercase transition-all duration-200 hover:bg-neon-purple/20 hover:border-neon-purple cursor-pointer '.($selectedProduct ? 'border-neon-blue/50' : '')]) }}>
        <span class="{{ $selectedProduct ? 'text-neon-blue font-bold' : 'text-white/70' }}">{{ $label }}</span>
        
        <span id="{{ $id }}" class="flex items-center gap-2">
            @if($selectedProduct)
                <span class="text-white font-bruno text-[9px]">
                    @if($isMulti)
                        {{ count($selectedProduct) }} szt.
                    @else
                        {{ number_format($selectedProduct['price'], 0, ',', ' ') }} zł
                    @endif
                </span>
                <div class="flex items-center justify-center w-3 h-3 rounded-full bg-[#32CD32] shadow-[0_0_8px_rgba(50,205,50,0.5)]">
                    <svg class="w-2 h-2 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            @else
                <span class="text-white/30 italic lowercase text-[9px]">Wybierz...</span>
            @endif
        </span>
    </div>

    @if($selectedProduct)
        <div class="absolute right-[105%] top-0 w-64 bg-black/90 border border-neon-blue/30 p-4 rounded-lg shadow-2xl hidden group-hover:block z-100 backdrop-blur-md pointer-events-none animate-in fade-in slide-in-from-right-2 duration-200">
            <div class="text-neon-blue text-[9px] font-bruno mb-2 uppercase tracking-wider border-b border-white/10 pb-1">
                Aktualny wybór:
            </div>
            
            @foreach($items as $item)
                <div class="mb-3 last:mb-0 border-b border-white/5 pb-2 last:border-0">
                    <div class="text-white text-[10px] font-bold leading-tight uppercase">{{ $item['name'] }}</div>
                    <div class="text-neon-purple text-[10px] mt-1 font-bruno">{{ number_format($item['price'], 2, ',', ' ') }} zł</div>
                </div>
            @endforeach

            <div class="absolute top-4 -right-1.5 w-3 h-3 bg-black/90 border-t border-r border-neon-blue/30 rotate-45"></div>
        </div>
    @endif
</li>