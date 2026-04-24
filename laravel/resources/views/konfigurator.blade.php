@extends('app')

@section('content')


<div class="w-full px-4 lg:px-8 py-6">
    <div class="grid grid-cols-12 gap-6 items-start">
        
        <aside class="col-span-12 lg:col-span-2 xl:col-span-2">
            <div class="bg-black/40 p-5 rounded-r-2xl border-y border-r border-white/10 backdrop-blur-xl sticky top-6 -ml-4 lg:-ml-8 shadow-2xl shadow-purple-900/10">
                <h2 class="text-neon-blue font-bruno text-sm mb-6 uppercase tracking-widest italic">Panel Filtrów</h2>
                
                <form id="filter-form" action="{{ route('products.index') }}" method="GET" class="space-y-6">
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <div>
                        <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold">Marka</label>
                        <div class="space-y-2">
                            @foreach($brands as $brand)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="brands[]" value="{{ $brand->id }}" 
                                        class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-purple focus:ring-neon-purple">
                                    <span class="text-[11px] text-white/60 group-hover:text-white transition">{{ $brand->brand->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                 @foreach($category->attributes as $attribute)
                        <div class="mb-1 border-t border-white/5 pt-2" x-data="{ open: false }">
                            <label class="text-[9px] text-text-muted uppercase mb-3 block font-bold tracking-widest">
                                {{ $attribute->name }}
                            </label>
                            
                            <div class="space-y-2">
                                @foreach($attribute->values as $index => $val)
                                    <label class="flex items-center gap-3 cursor-pointer group" 
                                        x-show="open || {{ $index }} < 3">
                                        <input type="checkbox" name="attrs[{{ $attribute->id }}][]" value="{{ $val->id }}" 
                                            class="w-3 h-3 rounded border-white/20 bg-white/5 text-neon-blue focus:ring-neon-blue">
                                        <span class="text-[11px] text-white/60 group-hover:text-white transition uppercase font-bruno">
                                            {{ $val->value }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @if($attribute->values->count() > 3)
                                <button @click="open = !open" type="button" 
                                        class="mt-3 text-[9px] text-neon-blue hover:text-white transition uppercase font-bold flex items-center gap-1">
                                    <span x-text="open ? '- Pokaż mniej' : '+ Pokaż więcej ({{ $attribute->values->count() - 3 }})'"></span>
                                </button>
                            @endif
                        </div>
                    @endforeach
                     
                </form>
            </div>
        </aside>

        <main class="col-span-12 lg:col-span-7 xl:col-span-8">
            <div class="flex items-center gap-4 mb-8">
                <div class="h-px grow bg-linear-to-r from-neon-blue/50 to-transparent"></div>
                <h1 class="text-xl font-bruno text-white uppercase italic">Wybierz podzespół</h1>
                 <span class="text-[10px] text-text-muted">Wyświetlono: {{ $products->firstItem() }}-{{ $products->lastItem() }} z {{ $products->total() }}</span>
                <div class="h-px grow bg-linear-to-l from-neon-blue/50 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-10">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-8 flex justify-end px-4">
                {{ $products->links() }}
            </div>
        </main>

        <aside class="col-span-12 lg:col-span-2">
           <section class="w-80 flex flex-col bg-black/30 p-6 rounded-lg border border-white/5 backdrop-blur-sm">
                <div class="text-[11px] tracking-[2px] mb-5 text-text-muted font-bruno">BUILD STATUS</div>
                <div class="text-neon-blue text-[10px] mb-3 uppercase font-bruno">Wymagane elementy</div>
                <ul class="space-y-2 mb-8">
                    <a href="{{ route('products.index', ['category_id' => 1]) }}"> <x-config-item label="CPU" id="cpu-status" /> </a>
                    <a href="{{ route('products.index', ['category_id' => 2]) }}"> <x-config-item label="GPU" id="gpu-status" /> </a>
                    <a href="{{ route('products.index', ['category_id' => 3]) }}"> <x-config-item label="Płyta główna" id="plyta-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 4]) }}"> <x-config-item label="Pamięć RAM" id="ram-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 5]) }}"> <x-config-item label="Dysk" id="dysk-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 6]) }}"> <x-config-item label="Zasilacz" id="zasilacz-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 7]) }}"> <x-config-item label="Obudowa" id="obudowa-status" /></a>
                </ul>

                <div class="text-neon-blue text-[10px] mb-3 uppercase font-bruno">Dodatkowe elementy</div>
                <ul class="space-y-2">
                <a href="{{ route('products.index', ['category_id' => 8]) }}"> <x-config-item label="Myszka" id="myszka-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 9]) }}"><x-config-item label="Klawiatura" id="klawiatura-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 10]) }}"><x-config-item label="Słuchawki" id="sluchawki-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 11]) }}"><x-config-item label="Głośniki" id="glosniki-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 12]) }}"><x-config-item label="Chłodzenie CPU" id="chlodzenie-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 13]) }}"><x-config-item label="Karty sieciowe" id="karty_sieciowe-status" /></a>
                    <a href="{{ route('products.index', ['category_id' => 14]) }}"><x-config-item label="Monitor" id="monitor-status" /></a>
                </ul>
                    <div class="mt-auto pt-6 border-t border-white/10 space-y-3">
                    <div class="bg-white/5 p-3 rounded flex justify-between items-center">
                        <span class="text-[10px] text-text-muted uppercase">Wartość:</span>
                        <span class="text-neon-blue font-bruno">... zł</span>
                    </div>
                    <button class="w-full bg-neon-purple/80 hover:bg-neon-purple py-3 rounded font-bruno text-xs uppercase transition-all shadow-lg shadow-neon-purple/20">
                        KUP ZESTAW
                    </button>
                </div>
            </section>
        </aside>

    </div>
</div>
    
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
   
 document.querySelectorAll('#filter-form input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', () => {
    document.getElementById('filter-form').submit();
    });
});
</script>
@endsection