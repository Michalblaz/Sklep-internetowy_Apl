@props(['product'])
<div class="relative group bg-[#1a202c] border border-gray-700 rounded-2xl p-4 transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(139,92,246,0.3)]">
    
    <div class="absolute top-3 left-3 z-10 bg-green-500 text-black font-bold px-4 py-1 rounded-full text-sm shadow-[0_0_10px_rgba(34,197,94,0.5)]">
        {{ number_format($product->base_price, 0, ',', ' ') }} zł
    </div>

    <div class="bg-white rounded-xl p-4 mb-6 overflow-hidden">
        <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}"
             class="w-full h-48 object-contain transition-transform duration-500 group-hover:scale-110">
    </div>

    <h3 class="text-white text-center font-bold text-lg mb-6 tracking-wide uppercase">
        {{ $product->name }}
    </h3>

    <form action="{{ route('configurator.select') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
        <input type="hidden" name="price" value="{{ $product->base_price }}">
        <input type="hidden" name="name" value="{{ $product->name }}">

        <button type="submit" class="w-full py-3 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-full transition-all duration-300 shadow-lg uppercase tracking-tighter">
            Wybierz
        </button>
    </form>
</div>