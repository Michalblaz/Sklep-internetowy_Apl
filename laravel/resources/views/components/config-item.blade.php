@props(['label', 'id', 'categoryId'])

@php
    $build = session('configurator_build', []);
    $selectedProduct = $build[$categoryId] ?? null;
@endphp

<li class="list-none">
    <div {{ $attributes->merge(['class' => 'group w-full flex justify-between items-center bg-white/5 border border-white/10 rounded-md py-[10px] px-3 text-[11px] uppercase transition-all duration-200 hover:bg-neon-purple/20 hover:border-neon-purple cursor-pointer '.($selectedProduct ? 'border-neon-blue/50' : '')]) }}>
        <span class="{{ $selectedProduct ? 'text-neon-blue font-bold' : 'text-white/70' }}">{{ $label }}</span>
        
        <span id="{{ $id }}" class="flex items-center gap-2">
            @if($selectedProduct)
                <span class="text-white font-bruno text-[9px]">{{ number_format($selectedProduct['price'], 0, ',', ' ') }} zł</span>
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
</li>