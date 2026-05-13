<div class="space-y-8">
    @if (session()->has('admin_status'))
        <div class="mb-6 rounded-2xl border border-cyan-400/30 bg-cyan-500/10 px-5 py-4 text-cyan-200 shadow-[0_0_15px_rgba(34,211,238,0.2)] animate-pulse">
            {{ session('admin_status') }}
        </div>
    @endif

    <div class="bg-slate-950/60 backdrop-blur-2xl border border-white/10 rounded-[2rem] p-6 lg:p-10 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-600/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-cyan-600/10 rounded-full blur-[80px]"></div>

        <h2 class="text-2xl font-bruno text-white mb-10 flex items-center gap-4 tracking-wider">
            <span class="flex h-3 w-3 relative">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-500"></span>
            </span>
            {{ $isEditMode ? 'Edycja: ' . $name : 'Nowy projekt produktu' }}
        </h2>

        <div class="grid lg:grid-cols-2 gap-12">
            <div class="space-y-8">
                <div class="relative group">
                    <label class="text-[11px] uppercase tracking-[0.2em] text-cyan-400/70 ml-1 mb-2 block font-bold">Nazwa modelu</label>
                    <input type="text" wire:model.live="name" class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition-all outline-none text-lg">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-[0.2em] text-gray-500 ml-1 font-bold">Kategoria</label>
                        <select wire:model.live="category_id" class="w-full bg-slate-900 border border-white/10 rounded-2xl px-5 py-4 text-white focus:border-purple-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="">Wybierz segment</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-[0.2em] text-gray-500 ml-1 font-bold">Producent</label>
                        <select wire:model="brand_id" class="w-full bg-slate-900 border border-white/10 rounded-2xl px-5 py-4 text-white focus:border-purple-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="">Wybierz markę</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="relative">
                        <label class="text-[11px] uppercase tracking-[0.2em] text-emerald-400/70 ml-1 mb-2 block font-bold">Cena rynkowa (PLN)</label>
                        <input type="number" step="0.01" wire:model="base_price" class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                    </div>
                    <div class="flex items-center gap-3 px-1">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="is_promo" class="sr-only peer">
                            <div class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-fuchsia-600 shadow-[0_0_10px_rgba(0,0,0,0.5)]"></div>
                            <span class="ml-3 text-[10px] uppercase tracking-widest text-fuchsia-400 font-bold">Aktywuj promocję?</span>
                        </label>
                    </div>
                    @if($is_promo)
                        <div class="animate-fadeIn">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-fuchsia-400 mb-2 block font-bold">Cena promocyjna (PLN)</label>
                            <input type="number" step="0.01" wire:model="promo_price" class="w-full bg-fuchsia-500/5 border border-fuchsia-500/30 rounded-2xl px-5 py-4 text-white focus:border-fuchsia-500 shadow-[0_0_15px_rgba(217,70,239,0.1)] transition-all outline-none">
                        </div>
                    @endif
                    <div class="relative">
                        <label class="text-[11px] uppercase tracking-[0.2em] text-amber-400/70 ml-1 mb-2 block font-bold">Magazyn</label>
                        <input type="number" wire:model="stock_quantity" class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all outline-none font-mono">
                    </div>
                </div>
            </div>

           <div class="bg-white/[0.02] border border-white/5 rounded-[2.5rem] p-8 flex flex-col justify-center">
            <div class="w-full text-center"> <label class="text-[10px] uppercase tracking-[0.2em] text-purple-400 mb-3 block font-bold">Plik graficzny</label>
                <div class="relative group">
                    <input type="text" wire:model.live="file_name_input" placeholder="Wpisz jeśli inna niż nazwa"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-5 text-white focus:border-purple-500 outline-none text-center font-mono text-base transition-all">
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 h-0.5 w-0 group-focus-within:w-full bg-purple-500 transition-all duration-500 shadow-[0_0_15px_#a855f7]"></div>
                </div>
                    <div class="mt-4 p-3 rounded-lg bg-black/20 border border-white/5">
                        <p class="text-[9px] text-gray-500 uppercase tracking-widest mb-1">ścieżka automatyczna, Nazwa:</p>
                        <p class="text-[11px] font-mono text-purple-300/80 break-all">
                            @php
                                $source = $file_name_input ?: ($name ?: 'nazwa_produktu');
                                $cleaned = preg_replace('/\.jpg$/i', '', $source);
                                $previewFormatted = \Illuminate\Support\Str::ascii($cleaned); // Usuwa ą, ć, ś itp.
                                $previewFormatted = str_replace(' ', '_', $previewFormatted);

                                $folder = $categoryFolderMap[$category_id] ?? 'others';
                            @endphp
                            <span class="text-white font-bold">{{ $previewFormatted }}</span><span class="text-cyan-400">.jpg</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(count($availableAttributes) > 0)
        <div class="mt-16 pt-10 border-t border-white/10">
            <div class="flex items-center gap-4 mb-8">
                <h3 class="text-lg font-bruno text-white uppercase tracking-[0.3em]">Specyfikacja modułowa</h3>
                <div class="h-px flex-1 bg-gradient-to-r from-cyan-500/50 to-transparent"></div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">
                @foreach($availableAttributes as $attr)
                <div class="relative group" wire:key="attr-{{ $attr->id }}">
                    <label class="text-[10px] text-cyan-300/60 uppercase font-bold tracking-widest mb-2 block px-1">
                        {{ $attr->name }}
                    </label>
                    <div class="relative">
                        <input
                            list="list-{{ $attr->id }}"
                            wire:model="attributeValues.{{ $attr->id }}"
                            placeholder="Szukaj lub wpisz nową..."
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-gray-200 outline-none focus:border-cyan-400 focus:bg-cyan-400/5 transition-all shadow-[inset_0_0_10px_rgba(0,0,0,0.2)]"
                        >
                        <datalist id="list-{{ $attr->id }}">
                            @foreach($attr->values as $val)
                                <option value="{{ $val }}">
                            @endforeach
                        </datalist>

                        <div class="absolute bottom-0 left-0 h-0.5 w-0 group-focus-within:w-full bg-cyan-500 transition-all duration-500 shadow-[0_0_10px_#06b6d4]"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @error('db_error')
            <div class="mt-8 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-mono">
                ⚡ SYSTEM_ERROR: {{ $message }}
            </div>
        @enderror

        <div class="mt-12">
            <button wire:click="save" class="group relative w-full overflow-hidden rounded-2xl bg-cyan-600 py-5 transition-all hover:bg-cyan-500">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                <span class="relative text-white font-bold uppercase tracking-[0.4em] text-sm">
                    {{ $isEditMode ? 'Zaktualizuj produkt' : 'Wgraj do bazy danych' }}
                </span>
            </button>
        </div>
    </div>
</div>
