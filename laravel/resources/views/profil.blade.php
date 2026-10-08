@extends('app')

@section('content')
@php
    $profilePageScript = file_exists(resource_path('js/profile-page.js'))
        ? file_get_contents(resource_path('js/profile-page.js'))
        : '';

    $fieldLabels = [
        'first_name' => 'Imię',
        'last_name' => 'Nazwisko',
        'address_street' => 'Ulica i numer',
        'address_postal_code' => 'Kod pocztowy',
        'address_city' => 'Miasto',
        'phone' => 'Numer telefonu',
        'email' => 'Adres e-mail',
    ];

    $activeComplaintOrder = old('order_id');
    $activeComplaintShipment = $activeComplaintOrder
        ? ($shipmentHistory ?? collect())->firstWhere('id', (int) $activeComplaintOrder)
        : null;
@endphp

<div class="mx-auto max-w-7xl space-y-8 text-white">
    <div class="space-y-2">
        <p class="text-xs uppercase tracking-[0.35em] text-cyan-300/70">Panel użytkownika</p>
        <h1 class="font-['Bruno_Ace'] text-3xl text-white sm:text-4xl">Twój profil</h1>
    </div>

    @if (session('success'))
        <div class="rounded-3xl border border-emerald-400/40 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-3xl border border-rose-400/40 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-3xl border border-amber-400/40 bg-amber-500/10 px-5 py-4 text-sm text-amber-50">
            <p class="mb-2 font-semibold">Nie udało się zapisać wszystkich zmian:</p>
            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-8 xl:grid-cols-[360px_minmax(0,1fr)] items-start">
        <section class="rounded-[2rem] border border-cyan-300/30 bg-[linear-gradient(160deg,rgba(255,255,255,0.18),rgba(72,187,255,0.18),rgba(110,52,255,0.18))] p-6 shadow-[0_0_45px_rgba(80,180,255,0.12)]">
            <div class="mb-6 flex items-center justify-between gap-4">
                <div>
                    <h2 class="font-['Bruno_Ace'] text-2xl text-white">Dane użytkownika</h2>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-cyan-100">
                    <i class="fa-regular fa-user text-lg"></i>
                </div>
            </div>


            <form method="POST" action="{{ route('profil.update') }}" id="profile-form" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    @foreach ($fieldLabels as $field => $label)
                        <div class="rounded-[1.6rem] border border-white/20 bg-slate-950/15 p-4">
                            <div class="mb-2 flex items-center justify-between gap-4">
                                <label for="{{ $field }}" class="font-['Bruno_Ace'] text-sm text-cyan-50">{{ $label }}</label>
                            </div>
                            <input
                                id="{{ $field }}"
                                name="{{ $field }}"
                                type="{{ $field === 'email' ? 'email' : 'text' }}"
                                value="{{ old($field, $userData[$field]) }}"
                                readonly
                                class="profile-edit-field w-full rounded-full border border-white/15 bg-[linear-gradient(90deg,rgba(123,97,255,0.55),rgba(142,65,255,0.8))] px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-cyan-300/60 focus:bg-slate-900/40 focus:ring-2 focus:ring-cyan-300/30 read-only:cursor-default read-only:opacity-95"
                            >
                        </div>
                    @endforeach
                </div>


                <div id="password-section" class="hidden rounded-[1.8rem] border border-white/20 bg-slate-950/15 p-4">
                    <h3 class="mb-4 font-['Bruno_Ace'] text-xl text-white">Zabezpieczenia konta</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="mb-2 block text-sm text-cyan-50">
                                Aktualne hasło
                                <span class="text-white/55">(wymagane przy zmianie hasła lub e-maila)</span>
                            </label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                autocomplete="current-password"
                                class="w-full rounded-full border border-white/15 bg-[linear-gradient(90deg,rgba(123,97,255,0.55),rgba(142,65,255,0.8))] px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/30"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm text-cyan-50">Nowe hasło</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-full border border-white/15 bg-[linear-gradient(90deg,rgba(123,97,255,0.55),rgba(142,65,255,0.8))] px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/30"
                            >
                            <p class="mt-2 text-xs text-white/55">Minimum 8 znaków, mała i wielka litera oraz cyfra.</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm text-cyan-50">Powtórz hasło</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-full border border-white/15 bg-[linear-gradient(90deg,rgba(123,97,255,0.55),rgba(142,65,255,0.8))] px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/30"
                            >
                        </div>

                        <p id="password-mismatch-message" class="hidden rounded-2xl border border-rose-300/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-100">
                            Hasło i powtórzone hasło muszą być takie same.
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    id="profile-toggle-edit-button"
                    class="w-full rounded-full bg-[linear-gradient(90deg,rgba(129,150,255,0.95),rgba(164,66,255,0.95))] px-6 py-4 font-['Bruno_Ace'] text-lg text-white shadow-[0_12px_35px_rgba(126,76,255,0.35)] transition hover:scale-[1.01]"
                >
                    Edytuj profil
                </button>

                <button
                    type="submit"
                    id="profile-submit-button"
                    class="hidden w-full rounded-full bg-[linear-gradient(90deg,rgba(129,150,255,0.95),rgba(164,66,255,0.95))] px-6 py-4 font-['Bruno_Ace'] text-lg text-white shadow-[0_12px_35px_rgba(126,76,255,0.35)] transition hover:scale-[1.01] disabled:cursor-not-allowed disabled:opacity-60"
                >
                    Potwierdź
                </button>
            </form>
        </section>

        <div class="space-y-8">
            <section class="rounded-[2rem] border border-cyan-300/30 bg-[linear-gradient(160deg,rgba(255,255,255,0.2),rgba(96,165,250,0.18),rgba(99,102,241,0.22))] p-6 shadow-[0_0_45px_rgba(80,180,255,0.12)]">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h2 class="font-['Bruno_Ace'] text-2xl text-white">Zamówienia w trakcie</h2>
                    </div>

                    <span class="rounded-full border border-white/15 bg-slate-950/15 px-4 py-2 text-sm text-white/70">
                        Wybierz zamówienie, aby złożyć reklamację lub zwrot
                    </span>
                </div>


                <div class="space-y-4" id="shipment-list">
                    @forelse ($shipments as $shipment)
                        @include('partials.profile-shipment-card', ['shipment' => $shipment, 'selectable' => true])
                    @empty
                        <div class="rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80" data-empty-shipments>
                            Nie ma aktualnie zamówień w trakcie.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-[2rem] border border-cyan-300/30 bg-[linear-gradient(160deg,rgba(255,255,255,0.2),rgba(96,165,250,0.18),rgba(99,102,241,0.22))] p-6 shadow-[0_0_45px_rgba(80,180,255,0.12)]">
                <details class="group">
                    <summary class="flex cursor-pointer list-none flex-wrap items-center justify-between gap-4">
                        <h2 class="font-['Bruno_Ace'] text-2xl text-white">Historia zamówień</h2>
                        <span class="rounded-full border border-white/15 bg-slate-950/15 px-4 py-2 text-sm text-white/70 transition group-open:bg-white/10">
                            Rozwiń / zwiń
                        </span>
                    </summary>

                    <div class="mt-5 space-y-4">
                        @forelse ($shipmentHistory as $shipment)
                            @include('partials.profile-shipment-card', ['shipment' => $shipment, 'selectable' => true])
                        @empty
                            <div class="rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80">
                                Nie masz jeszcze zamówień w historii.
                            </div>
                        @endforelse
                    </div>
                </details>
            </section>

               <section class="rounded-[2rem] border border-cyan-300/30 bg-[linear-gradient(160deg,rgba(255,255,255,0.2),rgba(96,165,250,0.18),rgba(99,102,241,0.22))] p-6 shadow-[0_0_45px_rgba(80,180,255,0.12)]">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-['Bruno_Ace'] text-2xl text-white">Odpowiedzi sklepu</h2>
                        <p class="mt-2 text-sm text-cyan-50/70">Tu zobaczysz decyzje dotyczące reklamacji i zwrotów oraz możesz odpisać obsłudze.</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-cyan-100">
                        <i class="fa-regular fa-comments text-lg"></i>
                    </div>
                </div>

                <div class="max-h-[34rem] space-y-4 overflow-y-auto pr-2">
                    @forelse ($complaintReplies as $complaint)
                        <div class="rounded-[1.8rem] border border-white/15 bg-slate-950/15 p-4">
                            <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-100/60">
                                        Zamówienie #{{ $complaint['order_id'] }} · {{ $complaint['order_created_at'] }}
                                    </p>
                                    <h3 class="mt-2 font-['Bruno_Ace'] text-xl text-white">{{ $complaint['reason'] }}</h3>
                                </div>

                                <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-sm text-white">
                                    {{ $complaint['status_label'] }}
                                </span>
                            </div>

                           <div class="mt-4 space-y-3">
                                @forelse ($complaint['messages'] as $message)
                                    <div class="@if($message['sender_type'] === 'admin') ml-0 mr-10 border-cyan-300/20 bg-cyan-500/10 @else ml-10 mr-0 border-fuchsia-300/20 bg-fuchsia-500/10 @endif rounded-2xl border p-4">

                                        <div class="mb-2 flex items-center justify-between">
                                            <p class="text-xs uppercase tracking-[0.25em]
                                                @if($message['sender_type'] === 'admin')
                                                    text-cyan-100/70
                                                @else
                                                    text-fuchsia-100/70
                                                @endif
                                            ">
                                                {{ $message['sender_type'] === 'admin' ? 'Obsługa sklepu' : 'Ty' }}
                                            </p>

                                            <span class="text-xs text-white/50">
                                                {{ $message['created_at'] }}
                                            </span>
                                        </div>

                                        <p class="whitespace-pre-line text-sm text-white">
                                            {{ $message['message'] }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm text-white/60">
                                        Brak wiadomości w tej reklamacji.
                                    </div>
                                @endforelse
                            </div>

                            @if ($complaint['can_reply'])
                                <form method="POST" action="{{ route('profil.complaints.reply', $complaint['id']) }}" class="mt-4 space-y-3">
                                    @csrf

                                    <label for="customer_reply_{{ $complaint['id'] }}" class="block text-sm text-cyan-50">
                                        Odpowiedz obsłudze
                                    </label>

                                    <textarea
                                        id="customer_reply_{{ $complaint['id'] }}"
                                        name="customer_reply"
                                        rows="4"
                                        required
                                        class="w-full rounded-[1.4rem] border border-white/15 bg-slate-950/20 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/30"
                                        placeholder="Napisz wiadomość do obsługi sklepu..."
                                    ></textarea>

                                    <button
                                        type="submit"
                                        class="rounded-full bg-[linear-gradient(90deg,rgba(129,150,255,0.95),rgba(164,66,255,0.95))] px-5 py-3 font-['Bruno_Ace'] text-sm text-white shadow-[0_12px_35px_rgba(126,76,255,0.35)] transition hover:scale-[1.01]"
                                    >
                                        Wyślij odpowiedź
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <div class="rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80">
                            Nie masz jeszcze odpowiedzi na reklamacje lub zwroty.
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-[2rem] border border-cyan-300/30 bg-[linear-gradient(160deg,rgba(255,255,255,0.2),rgba(96,165,250,0.18),rgba(99,102,241,0.22))] p-6 shadow-[0_0_45px_rgba(80,180,255,0.12)]">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-['Bruno_Ace'] text-2xl text-white">Reklamacje i zwroty</h2>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-cyan-100">
                        <i class="fa-solid fa-arrow-rotate-left text-lg"></i>
                    </div>
                </div>


                <form method="POST" action="{{ route('profil.complaints.store') }}" id="complaint-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="order_id" id="complaint-order-id" value="{{ $activeComplaintOrder }}">

                    <div id="selected-shipment-box" class="rounded-[1.6rem] border border-white/15 bg-slate-950/15 px-5 py-4 text-sm text-cyan-50/90">
                        @if ($activeComplaintShipment)
                            Wybrane zamówienie: #{{ $activeComplaintShipment['display_id'] }} - {{ $activeComplaintShipment['status'] }}
                        @else
                            Nie wybrano zamówienia do reklamacji.
                        @endif
                    </div>

                    <p id="complaint-order-message" class="hidden rounded-2xl border border-rose-300/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-100">
                        Nie wybrano zamówienia do reklamacji.
                    </p>

                    <div class="grid gap-4 md:grid-cols-[minmax(0,1fr)_260px]">
                        <div class="space-y-4">
                            <div class="grid gap-3 sm:grid-cols-2">
                                <label class="flex items-center gap-3 rounded-2xl border border-white/15 bg-white/5 px-4 py-3">
                                    <input
                                        type="radio"
                                        name="reason"
                                        value="Reklamacja"
                                        {{ old('reason', 'Reklamacja') === 'Reklamacja' ? 'checked' : '' }}
                                        class="h-4 w-4 border-white/40 bg-transparent text-fuchsia-400 focus:ring-fuchsia-400"
                                    >
                                    <span class="font-['Bruno_Ace'] text-sm text-white">Reklamacja</span>
                                </label>

                                <label class="flex items-center gap-3 rounded-2xl border border-white/15 bg-white/5 px-4 py-3">
                                    <input
                                        type="radio"
                                        name="reason"
                                        value="Zwrot"
                                        {{ old('reason') === 'Zwrot' ? 'checked' : '' }}
                                        class="h-4 w-4 border-white/40 bg-transparent text-fuchsia-400 focus:ring-fuchsia-400"
                                    >
                                    <span class="font-['Bruno_Ace'] text-sm text-white">Zwrot</span>
                                </label>
                            </div>

                            <div>
                                <label for="description" class="mb-2 block text-sm text-cyan-50">Uzasadnienie</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="7"
                                    class="w-full rounded-[1.8rem] border border-white/15 bg-slate-950/20 px-4 py-4 text-sm text-white outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/30"
                                    placeholder="Opisz powód zgłoszenia..."
                                >{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between gap-4 rounded-[1.8rem] border border-white/15 bg-slate-950/15 p-4">
                            <div class="rounded-[1.4rem] border border-white/10 bg-white/5 px-4 py-4 text-sm text-cyan-50/85">
                                Jeśli chcesz wysłać zgłoszenie, najpierw wybierz przesyłkę z listy powyżej.
                            </div>

                            <div class="space-y-3">
                                <button
                                    type="submit"
                                    class="w-full rounded-full bg-[linear-gradient(90deg,rgba(129,150,255,0.95),rgba(164,66,255,0.95))] px-5 py-3 font-['Bruno_Ace'] text-white shadow-[0_12px_35px_rgba(126,76,255,0.35)] transition hover:scale-[1.01]"
                                >
                                    Wyślij
                                </button>
                                <button
                                    type="button"
                                    class="w-full rounded-full border border-white/15 bg-white/5 px-5 py-3 font-['Bruno_Ace'] text-white/85 transition hover:bg-white/10"
                                >
                                    Wydrukuj nalepkę
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

            <section class="rounded-[2rem] border border-cyan-300/30 bg-[linear-gradient(160deg,rgba(255,255,255,0.2),rgba(96,165,250,0.18),rgba(99,102,241,0.22))] p-6 shadow-[0_0_45px_rgba(80,180,255,0.12)]">
    <div class="mb-5 flex items-center justify-between gap-4">
        <div>
            <h2 class="font-['Bruno_Ace'] text-2xl text-white">Listy zakupowe</h2>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-cyan-100">
            <i class="fa-regular fa-heart text-lg"></i>
        </div>
    </div>

    <div class="space-y-4">
        @forelse ($groupedWishlists as $groupKey => $products)
            @php
                // Rozbijamy klucz zgrupowany po ID i nazwie listy
                list($wishlistId, $wishlistName) = explode('|', $groupKey);
                $productCount = $products->count();
                $productLabel = $productCount === 1
                    ? 'produkt'
                    : (($productCount % 10 >= 2 && $productCount % 10 <= 4 && ($productCount % 100 < 12 || $productCount % 100 > 14))
                        ? 'produkty'
                        : 'produktów');
            @endphp

            <details class="group rounded-[1.8rem] border border-white/15 bg-slate-950/20 overflow-hidden">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5 transition hover:bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-500/20 text-purple-300 border border-purple-500/30">
                            <i class="fa-solid fa-list-ul"></i>
                        </div>
                        <div>
                            <h3 class="font-['Bruno_Ace'] text-lg text-white">{{ $wishlistName }}</h3>
                            <p class="text-xs text-cyan-100/60">{{ $productCount }} {{ $productLabel }}</p>
                        </div>
                    </div>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white transition group-open:rotate-180">
                        <i class="fa-solid fa-chevron-down text-sm"></i>
                    </div>
                </summary>

                <div class="space-y-3 border-t border-white/10 p-5 bg-black/10">
                    @foreach ($products as $product)
                        <div class="grid gap-4 rounded-2xl border border-white/10 bg-white/5 p-4 md:grid-cols-[100px_minmax(0,1fr)_200px] transition hover:border-purple-500/30">

                            {{-- Zdjęcie z odnośnikiem do produktu --}}
                            <a href="{{ route('products.show', $product['id']) }}" class="overflow-hidden rounded-xl bg-white/90">
                                @if ($product['image_path'])
                                    <img src="{{ $product['image_path'] }}" alt="{{ $product['name'] }}" class="h-24 w-full object-contain p-2 hover:scale-105 transition">
                                @else
                                    <div class="flex h-24 items-center justify-center text-center text-[10px] text-slate-500">Brak zdjęcia</div>
                                @endif
                            </a>

                            <div class="space-y-2">
                                <p class="text-[10px] uppercase tracking-[0.25em] text-cyan-100/60">
                                    {{ $product['brand_name'] ?: 'Produkt obserwowany' }}
                                </p>
                                <a href="{{ route('products.show', $product['id']) }}" class="font-['Bruno_Ace'] text-lg text-white hover:text-purple-300 transition">
                                    {{ $product['name'] }}
                                </a>
                                <div class="flex flex-wrap items-center gap-2 text-sm">
                                    <span class="rounded-lg border border-emerald-300/25 bg-emerald-500/10 px-2 py-1 text-xs text-emerald-100">
                                        {{ $product['current_price'] }} zł
                                    </span>
                                    @if ($product['original_price'])
                                        <span class="text-white/55 line-through text-xs">{{ $product['original_price'] }} zł</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col justify-center gap-2">
                               <form method="POST" action="{{ route('cart.add') }}" class="ajax-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                    <input type="hidden" name="quantity" value="1">

                                    <button type="submit" class="mt-2 block w-full rounded-lg border border-purple-500/30 bg-purple-900/40 py-1.5 text-center text-[10px] font-bold text-purple-300 transition duration-200 hover:border-purple-500 hover:bg-purple-600 hover:text-white">
                                        <i class="fa-solid fa-cart-plus mr-1"></i> Do koszyka
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('profil.saved.remove', ['wishlistId' => $wishlistId, 'productId' => $product['id']]) }}">
                                    @csrf
                                    <button type="submit" class="w-full rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 py-2 font-['Bruno_Ace'] text-[11px] text-rose-200 transition hover:bg-rose-500/20">
                                        <i class="fa-solid fa-trash mr-1"></i> Usuń
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </details>
        @empty
            <div class="rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80">
                Nie stworzyłeś jeszcze żadnej listy obserwowanych produktów.
                <br>Przejdź do sklepu i kliknij ikonę serduszka, aby zacząć!
            </div>
        @endforelse
    </div>
</section>
        </div>
    </div>
</div>

@if ($profilePageScript !== '')
    <script>
        {!! $profilePageScript !!}
    </script>
@endif



<div id="cartModal" style="display: none !important;" class="fixed inset-0 z-50 items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="relative mx-4 w-full max-w-4xl rounded-2xl border border-gray-700 bg-[#1a202c] p-6 text-white">
        <div class="mb-6 flex items-center gap-3 font-bruno text-emerald-400">
            <span class="relative flex h-3 w-3">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-3 w-3 rounded-full bg-emerald-500"></span>
            </span>
            Pomyślnie dodano produkt do koszyka!
        </div>

        <div class="mb-8 flex gap-4">
            <button onclick="closeModal()" class="rounded-xl bg-gray-700 px-6 py-2 text-xs font-bold uppercase transition hover:bg-gray-600">
                Kontynuuj zakupy
            </button>
            <a href="/koszyk" class="rounded-xl bg-purple-600 px-6 py-2 text-center text-xs font-bold uppercase transition hover:bg-purple-500">
                Przejdź do koszyka
            </a>
        </div>

        <hr class="mb-6 border-white/10">

        <div>
            <h4 class="mb-4 text-sm uppercase tracking-wider text-purple-300">
                Polecamy również:
            </h4>

            <div id="modal-recommendations" class="grid grid-cols-2 gap-4 md:grid-cols-4"></div>
        </div>

        <button onclick="closeModal()" class="absolute right-4 top-4 text-xl text-gray-400 hover:text-white">✕</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.ajax-cart-form');
    const modal = document.getElementById('cartModal');
    const recContainer = document.getElementById('modal-recommendations');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Zatrzymujemy domyślne przeładowanie / otwarcie JSON-a

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Czyszczenie poprzednich rekomendacji w modalu
                    recContainer.innerHTML = '';

                    // Generowanie kafelków dla produktów rekomendowanych
                    if (data.recommended && data.recommended.length > 0) {
                        data.recommended.forEach(item => {
                            const basePrice = parseFloat(item.base_price);
                            const promoPrice = item.promo_price ? parseFloat(item.promo_price) : null;
                            const hasPromotion = promoPrice !== null;
                            const imageSrc = item.image_url ? `/images/${item.image_url}` : '/images/placeholder.jpg';

                            const cardHtml = `
                                <div class="rounded-xl border border-white/5 bg-white/5 p-3 transition duration-200 hover:border-purple-500/40">
                                    <div class="mb-2 flex h-20 items-center justify-center rounded-lg bg-white/90 p-1">
                                        <img src="${imageSrc}" alt="${item.name}" class="max-h-full max-w-full object-contain">
                                    </div>
                                    <p class="truncate text-center text-xs font-medium text-gray-300" title="${item.name}">
                                        ${item.name}
                                    </p>
                                    <div class="mt-2 text-center text-xs">
                                        ${hasPromotion ? `
                                            <span class="font-black text-green-400">${promoPrice.toFixed(2)} zł</span>
                                            <span class="block text-[10px] text-gray-500 line-through">${basePrice.toFixed(2)} zł</span>
                                        ` : `
                                            <span class="font-black text-white">${basePrice.toFixed(2)} zł</span>
                                        `}
                                    </div>
                                    <a href="/produkt/${item.id}" class="mt-2 block w-full rounded-lg border border-purple-500/30 bg-purple-900/40 py-1.5 text-center text-[10px] font-bold text-purple-300 transition duration-200 hover:border-purple-500 hover:bg-purple-600 hover:text-white">
                                        Zobacz produkt
                                    </a>
                                </div>
                            `;
                            recContainer.insertAdjacentHTML('beforeend', cardHtml);
                        });
                    }

                    // Wyświetlenie modala
                    if (modal) {
                        modal.style.setProperty('display', 'flex', 'important');
                    }
                }
            })
            .catch(error => console.error('Błąd koszyka:', error));
        });
    });
});
</script>
@endsection
