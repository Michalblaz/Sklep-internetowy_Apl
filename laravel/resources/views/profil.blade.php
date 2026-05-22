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
                    <h3 class="mb-4 font-['Bruno_Ace'] text-xl text-white">Zmień hasło</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="password" class="mb-2 block text-sm text-cyan-50">Nowe hasło</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-full border border-white/15 bg-[linear-gradient(90deg,rgba(123,97,255,0.55),rgba(142,65,255,0.8))] px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/30"
                            >
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
                        <h2 class="font-['Bruno_Ace'] text-2xl text-white">Śledzenie przesyłki</h2>
                    </div>

                    <label class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-slate-950/15 px-4 py-2 text-sm text-white">
                        <input
                            id="show-delivered-toggle"
                            type="checkbox"
                            class="h-4 w-4 rounded border-white/40 bg-transparent text-fuchsia-400 focus:ring-fuchsia-400"
                        >
                        <span>Pokaż dostarczone</span>
                    </label>
                </div>


                <div class="space-y-4" id="shipment-list">
                    @forelse ($shipments as $shipment)
                        <button
                            type="button"
                            data-order-select="{{ $shipment['id'] }}"
                            data-order-title="Przesyłka #{{ $shipment['id'] }} - {{ $shipment['status'] }}"
                            data-shipment-card
                            data-delivered="{{ $shipment['is_delivered'] ? 'true' : 'false' }}"
                            class="shipment-card w-full rounded-[1.8rem] border border-white/15 bg-slate-950/15 p-4 text-left transition hover:border-cyan-300/40 hover:bg-white/10"
                        >
                            <div class="grid gap-4 md:grid-cols-[120px_minmax(0,1fr)]">
                                <div class="overflow-hidden rounded-[1.4rem] border border-white/10 bg-white/90">
                                    @if ($shipment['image_path'])
                                        <img src="{{ $shipment['image_path'] }}" alt="{{ $shipment['first_product_name'] }}" class="h-28 w-full object-contain p-3">
                                    @else
                                        <div class="flex h-28 items-center justify-center text-center text-xs text-slate-500">
                                            Brak zdjęcia
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-3">
                                    <div class="grid gap-3 md:grid-cols-3">
                                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">ID</p>
                                            <p class="mt-2 font-['Bruno_Ace'] text-lg text-white">#{{ $shipment['id'] }}</p>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Status</p>
                                            <p class="mt-2 text-sm text-white">{{ $shipment['status'] }}</p>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Dostawca</p>
                                            <p class="mt-2 text-sm text-white">{{ $shipment['shipping_method'] }}</p>
                                        </div>
                                    </div>

                                    <div class="grid gap-3 md:grid-cols-3">
                                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Wartość zamówienia</p>
                                            <p class="mt-2 text-sm text-white">{{ $shipment['total'] }} zł</p>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Data</p>
                                            <p class="mt-2 text-sm text-white">{{ $shipment['created_at'] ?? 'Brak danych' }}</p>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                            <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Produkt</p>
                                            <p class="mt-2 text-sm text-white">{{ $shipment['first_product_name'] }}</p>
                                        </div>
                                    </div>

                                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3">
                                        <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Adres dostawy</p>
                                        <p class="mt-2 text-sm text-white">{{ $shipment['address'] !== '' ? $shipment['address'] : 'Brak danych adresowych' }}</p>
                                        @if ($shipment['complaint_label'])
                                            <p class="mt-2 text-xs uppercase tracking-[0.2em] text-fuchsia-200/80">
                                                Ostatnie zgłoszenie: {{ $shipment['complaint_label'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </button>
                    @empty
                        <div class="rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80" data-empty-shipments>
                            Nie ma przesyłek do śledzenia.
                        </div>
                    @endforelse
                </div>

                @if ($shipments->isNotEmpty())
                    <div
                        id="filtered-shipments-empty"
                        class="mt-4 hidden rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80"
                    >
                        Nie ma przesyłek do śledzenia.
                    </div>
                @endif
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
                        @if ($activeComplaintOrder)
                            Wybrana przesyłka: #{{ $activeComplaintOrder }}
                        @else
                            Nie wybrano przesyłki do reklamacji.
                        @endif
                    </div>

                    <p id="complaint-order-message" class="hidden rounded-2xl border border-rose-300/40 bg-rose-500/10 px-4 py-3 text-sm text-rose-100">
                        Nie wybrano przesyłki do reklamacji.
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
                        <h2 class="font-['Bruno_Ace'] text-2xl text-white">Obserwowane</h2>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/15 bg-white/10 text-cyan-100">
                        <i class="fa-regular fa-heart text-lg"></i>
                    </div>
                </div>


                <div class="space-y-4">
                    @forelse ($observedProducts as $product)
                        <div class="grid gap-4 rounded-[1.8rem] border border-white/15 bg-slate-950/15 p-4 md:grid-cols-[120px_minmax(0,1fr)_220px]">
                            <div class="overflow-hidden rounded-[1.4rem] border border-white/10 bg-white/90">
                                @if ($product['image_path'])
                                    <img src="{{ $product['image_path'] }}" alt="{{ $product['name'] }}" class="h-28 w-full object-contain p-3">
                                @else
                                    <div class="flex h-28 items-center justify-center text-center text-xs text-slate-500">
                                        Brak zdjęcia
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-2">
                                <p class="text-xs uppercase tracking-[0.25em] text-cyan-100/60">
                                    {{ $product['brand_name'] ?: 'Produkt obserwowany' }}
                                </p>
                                <h3 class="font-['Bruno_Ace'] text-xl text-white">{{ $product['name'] }}</h3>
                                <div class="flex flex-wrap items-center gap-3 text-sm">
                                    <span class="rounded-full border border-emerald-300/25 bg-emerald-500/10 px-3 py-1 text-emerald-100">
                                        Cena: {{ $product['current_price'] }} zł
                                    </span>
                                    @if ($product['original_price'])
                                        <span class="text-white/55 line-through">{{ $product['original_price'] }} zł</span>
                                    @endif
                                </div>
                                <p class="text-sm text-cyan-50/75">
                                    @if ($product['stock_quantity'] > 0)
                                        Dostępne sztuki: {{ $product['stock_quantity'] }}
                                    @else
                                        Brak produktów w magazynie.
                                    @endif
                                </p>
                            </div>

                            <div class="flex flex-col justify-center gap-3">
                                <form method="POST" action="{{ route('profil.saved.move-to-cart', $product['id']) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full rounded-full bg-[linear-gradient(90deg,rgba(129,150,255,0.95),rgba(164,66,255,0.95))] px-4 py-3 font-['Bruno_Ace'] text-sm text-white shadow-[0_12px_35px_rgba(126,76,255,0.35)] transition hover:scale-[1.01]"
                                    >
                                        Dodaj do koszyka
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('profil.saved.remove', $product['id']) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full rounded-full border border-white/15 bg-white/5 px-4 py-3 font-['Bruno_Ace'] text-sm text-white/90 transition hover:bg-white/10"
                                    >
                                        Usuń z obserwowanych
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-[1.8rem] border border-dashed border-white/20 bg-slate-950/15 px-5 py-8 text-center text-sm text-cyan-50/80">
                            Nie masz jeszcze żadnych obserwowanych produktów.
                        </div>
                    @endforelse

                    @if ($observedProducts->total() > 5)
                        <div class="mt-8 flex justify-center items-center gap-3 font-['Bruno_Ace']">
                            @if (!$observedProducts->onFirstPage())
                                <a href="{{ $observedProducts->appends(request()->except('observed_page'))->previousPageUrl() }}&observed_page={{ $observedProducts->currentPage() - 1 }}"
                                class="text-fuchsia-500 text-2xl hover:scale-110 transition hover:drop-shadow-[0_0_10px_rgba(217,70,239,0.7)]">
                                    ◀
                                </a>
                            @endif

                            <div class="flex gap-2">
                                @foreach ($observedProducts->getUrlRange(
                                    max(1, $observedProducts->currentPage() - 2),
                                    min($observedProducts->lastPage(), $observedProducts->currentPage() + 2)
                                ) as $page => $url)
                                    <a href="{{ request()->fullUrlWithQuery(['observed_page' => $page]) }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-full border text-sm transition-all duration-300
                                    {{ $page == $observedProducts->currentPage()
                                            ? 'bg-fuchsia-600 border-fuchsia-400 text-white shadow-[0_0_12px_rgba(217,70,239,0.8)] scale-110'
                                            : 'border-white/10 text-gray-400 hover:bg-fuchsia-600 hover:text-white hover:scale-110 hover:shadow-[0_0_10px_rgba(217,70,239,0.6)]' }}">
                                        {{ $page }}
                                    </a>
                                @endforeach
                            </div>

                            @if ($observedProducts->hasMorePages())
                                <a href="{{ $observedProducts->appends(request()->except('observed_page'))->nextPageUrl() }}&observed_page={{ $observedProducts->currentPage() + 1 }}"
                                class="text-fuchsia-500 text-2xl hover:scale-110 transition hover:drop-shadow-[0_0_10px_rgba(217,70,239,0.7)]">
                                    ▶
                                </a>
                            @endif
                        </div>
                    @endif
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
@endsection
