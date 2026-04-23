   
@props(['label', 'id'])

<li>
    <button {{ $attributes->merge(['class' => 'group w-full flex justify-between items-center bg-white/5 border border-white/10 rounded-md py-[10px] px-3 text-[11px] uppercase transition-all duration-200 hover:bg-neon-purple/20 hover:border-neon-purple hover:shadow-[0_0_10px_rgba(122,66,184,0.3)] hover:translate-x-1']) }}>
        <span>{{ $label }}</span>
        <span id="{{ $id }}" class="text-text-muted flex items-center gap-1">
            Wybierz...
        </span>
    </button>
</li>