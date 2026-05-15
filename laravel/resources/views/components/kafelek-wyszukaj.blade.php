@props(['product'])

<div class="bg-white/5 border border-white/10 rounded-xl p-4 overflow-hidden flex items-center justify-center w-full max-w-[240px] aspect-square">
    <img
        src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/' . $product->image_url) }}"
        alt="{{ $product->name }}"
        class="block max-h-full max-w-full object-contain mx-auto"
    >
</div>
