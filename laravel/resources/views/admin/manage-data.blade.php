<section id="zarzadzanie" class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-xl space-y-8">
    <div class="flex flex-col gap-2">
        <h2 class="text-purple-400 text-xl font-bruno">Zarzadzanie danymi</h2>
        <p class="text-sm text-gray-400">Edycja tabel uzywanych przez sklep: atrybuty, dostawy, uzytkownicy i zamowienia.</p>
    </div>

    <div id="zarzadzanie-atrybuty" class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h3 class="text-cyan-300 text-lg">Atrybuty produktow</h3>
            <span class="text-xs uppercase tracking-[0.25em] text-gray-500">attribute_category</span>
        </div>

        <form method="POST" action="{{ route('admin.attribute-categories.store') }}#zarzadzanie-atrybuty" class="grid gap-3 md:grid-cols-[1fr_auto] rounded-2xl border border-white/10 bg-white/5 p-4">
            @csrf
            <input name="name" type="text" maxlength="100" required placeholder="Nowy atrybut, np. taktowanie_boost" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
            <button type="submit" class="rounded-xl border border-cyan-300/25 bg-cyan-500/20 px-5 py-3 text-sm font-bold text-cyan-100 transition hover:bg-cyan-500/30">Dodaj</button>
            <div class="md:col-span-2 rounded-xl border border-white/10 bg-black/20 p-4">
                <p class="mb-3 text-[10px] uppercase tracking-[0.25em] text-gray-500">Przypisz do kategorii</p>
                <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach($adminCategories as $category)
                        <label class="flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-gray-200">
                            <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="rounded border-white/20 bg-black/40 text-cyan-500">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>

        <div class="admin-record-scroll max-h-80 overflow-y-auto pr-2 space-y-3">
            @forelse($adminAttributes as $attribute)
                @php
                    $assignedCategoryIds = collect($attributeCategoryAssignments[$attribute->id] ?? []);
                @endphp
                <form method="POST" action="{{ route('admin.attribute-categories.update', $attribute->id) }}#zarzadzanie-atrybuty" class="grid gap-3 md:grid-cols-[80px_1fr_auto] md:items-center rounded-2xl border border-white/10 bg-white/5 p-4">
                    @csrf
                    @method('PATCH')
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">#{{ $attribute->id }}</p>
                    <input name="name" type="text" maxlength="100" required value="{{ $attribute->name }}" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                    <button type="submit" class="rounded-xl border border-purple-300/25 bg-purple-600/40 px-5 py-3 text-sm font-bold text-white transition hover:bg-purple-500/60">Zapisz</button>
                    <div class="md:col-span-3 rounded-xl border border-white/10 bg-black/20 p-4">
                        <p class="mb-3 text-[10px] uppercase tracking-[0.25em] text-gray-500">Kategorie przedmiotow</p>
                        <div class="grid gap-2 sm:grid-cols-2 xl:grid-cols-4">
                            @foreach($adminCategories as $category)
                                <label class="flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-gray-200">
                                    <input
                                        type="checkbox"
                                        name="category_ids[]"
                                        value="{{ $category->id }}"
                                        @checked($assignedCategoryIds->contains((int) $category->id))
                                        class="rounded border-white/20 bg-black/40 text-cyan-500"
                                    >
                                    <span>{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 p-8 text-center text-gray-500">Brak atrybutow.</div>
            @endforelse
        </div>
    </div>

    <div id="zarzadzanie-dostawy" class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h3 class="text-cyan-300 text-lg">Metody dostawy</h3>
            <span class="text-xs uppercase tracking-[0.25em] text-gray-500">shipping_methods</span>
        </div>

        <form method="POST" action="{{ route('admin.shipping-methods.store') }}#zarzadzanie-dostawy" class="grid gap-3 md:grid-cols-[1fr_180px_auto] rounded-2xl border border-white/10 bg-white/5 p-4">
            @csrf
            <input name="name" type="text" maxlength="100" required placeholder="Nowa metoda dostawy" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
            <input name="price" type="number" step="0.01" min="0" max="999999.99" required placeholder="Cena" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
            <button type="submit" class="rounded-xl border border-cyan-300/25 bg-cyan-500/20 px-5 py-3 text-sm font-bold text-cyan-100 transition hover:bg-cyan-500/30">Dodaj</button>
        </form>

        <div class="space-y-3">
            @forelse($adminShippingMethods as $method)
                <form method="POST" action="{{ route('admin.shipping-methods.update', $method->id) }}#zarzadzanie-dostawy" class="grid gap-3 md:grid-cols-[80px_1fr_180px_auto] md:items-center rounded-2xl border border-white/10 bg-white/5 p-4">
                    @csrf
                    @method('PATCH')
                    <p class="text-xs uppercase tracking-[0.2em] text-gray-500">#{{ $method->id }}</p>
                    <input name="name" type="text" maxlength="100" required value="{{ $method->name }}" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                    <input name="price" type="number" step="0.01" min="0" max="999999.99" required value="{{ number_format((float) $method->price, 2, '.', '') }}" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                    <button type="submit" class="rounded-xl border border-purple-300/25 bg-purple-600/40 px-5 py-3 text-sm font-bold text-white transition hover:bg-purple-500/60">Zapisz</button>
                </form>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 p-8 text-center text-gray-500">Brak metod dostawy.</div>
            @endforelse
        </div>
    </div>

    <div id="zarzadzanie-uzytkownicy" class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h3 class="text-cyan-300 text-lg">Edycja uzytkownikow</h3>
            <span class="text-xs uppercase tracking-[0.25em] text-gray-500">users</span>
        </div>

        <div class="admin-record-scroll max-h-[34rem] overflow-y-auto pr-2 space-y-4">
            @forelse($editableUsers as $editableUser)
                <form method="POST" action="{{ route('admin.users.update', $editableUser->id) }}#zarzadzanie-uzytkownicy" class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500">Uzytkownik #{{ $editableUser->id }}</p>
                        <label class="inline-flex items-center gap-2 text-sm text-purple-200">
                            <input type="hidden" name="is_Admin" value="0">
                            <input type="checkbox" name="is_Admin" value="1" @checked($editableUser->is_Admin) class="rounded border-white/20 bg-black/40 text-purple-500">
                            Administrator
                        </label>
                    </div>
                    <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                        <input name="first_name" type="text" maxlength="100" value="{{ $editableUser->first_name }}" placeholder="Imie" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="last_name" type="text" maxlength="100" value="{{ $editableUser->last_name }}" placeholder="Nazwisko" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="phone" type="text" maxlength="20" value="{{ $editableUser->phone }}" placeholder="Telefon" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="email" type="email" maxlength="255" required value="{{ $editableUser->email }}" placeholder="E-mail" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                    </div>
                    <button type="submit" class="rounded-xl border border-purple-300/25 bg-purple-600/40 px-5 py-3 text-sm font-bold text-white transition hover:bg-purple-500/60">Zapisz uzytkownika</button>
                </form>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 p-8 text-center text-gray-500">Brak uzytkownikow.</div>
            @endforelse
        </div>
    </div>

    <div id="zarzadzanie-zamowienia" class="space-y-4">
        <div class="flex items-center justify-between gap-4">
            <h3 class="text-cyan-300 text-lg">Edycja zamowien</h3>
            <span class="text-xs uppercase tracking-[0.25em] text-gray-500">orders</span>
        </div>

        <div class="admin-record-scroll max-h-[42rem] overflow-y-auto pr-2 space-y-4">
            @forelse($editableOrders as $order)
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}#zarzadzanie-zamowienia" class="rounded-2xl border border-white/10 bg-white/5 p-4 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                        <p class="text-white">Zamowienie #{{ $order->id }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user_email ?? 'Brak uzytkownika' }} | {{ $order->created_at }}</p>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
                        <select name="shipping_method_id" class="admin-filter-select rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-purple-300/60">
                            <option value="">Brak metody</option>
                            @foreach($adminShippingMethods as $method)
                                <option value="{{ $method->id }}" @selected((string) $order->shipping_method_id === (string) $method->id)>
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                        <input name="tracking_status" type="text" maxlength="100" value="{{ $order->tracking_status }}" placeholder="Status" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="shipping_cost" type="number" step="0.01" min="0" max="999999.99" value="{{ $order->shipping_cost !== null ? number_format((float) $order->shipping_cost, 2, '.', '') : '' }}" placeholder="Koszt dostawy" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="payment_method" type="text" maxlength="100" value="{{ $order->payment_method }}" placeholder="Platnosc" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                    </div>

                    <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                        <input name="shipping_first_name" type="text" maxlength="255" value="{{ $order->shipping_first_name }}" placeholder="Imie odbiorcy" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="shipping_last_name" type="text" maxlength="255" value="{{ $order->shipping_last_name }}" placeholder="Nazwisko odbiorcy" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="shipping_phone" type="text" maxlength="255" value="{{ $order->shipping_phone }}" placeholder="Telefon" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="shipping_street" type="text" maxlength="255" value="{{ $order->shipping_street }}" placeholder="Ulica" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="shipping_city" type="text" maxlength="255" value="{{ $order->shipping_city }}" placeholder="Miasto" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                        <input name="shipping_postal_code" type="text" maxlength="20" value="{{ $order->shipping_postal_code }}" placeholder="Kod pocztowy" class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">
                    </div>

                    <input name="pickup_point_info" type="text" maxlength="255" value="{{ $order->pickup_point_info }}" placeholder="Punkt odbioru / dodatkowe informacje" class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none focus:border-cyan-300/60">

                    <button type="submit" class="rounded-xl border border-purple-300/25 bg-purple-600/40 px-5 py-3 text-sm font-bold text-white transition hover:bg-purple-500/60">Zapisz zamowienie</button>
                </form>
            @empty
                <div class="rounded-2xl border border-dashed border-white/10 p-8 text-center text-gray-500">Brak zamowien.</div>
            @endforelse
        </div>
    </div>
</section>
