@extends('app')

@section('content')
@php
    $user = auth()->user();
    $recipientFirstName = old('recipient_first_name', $user->first_name ?? '');
    $recipientLastName = old('recipient_last_name', $user->last_name ?? '');
    $recipientPhone = old('recipient_phone', $user->phone ?? '');
    $insuredProducts = session('insured_products', []);
    $initialShipping = (float) ($shippingMethods->first()->price ?? 0);
    $initialTotal = $totalPrice + $insurance + $initialShipping;
    $panelClass = 'rounded-2xl border border-white/10 bg-[linear-gradient(145deg,rgba(83,107,121,0.82),rgba(18,64,83,0.88)_46%,rgba(20,36,75,0.94)_100%)] shadow-[0_24px_60px_rgba(0,0,0,0.35),inset_0_1px_0_rgba(255,255,255,0.08)]';
    $fieldClass = 'w-full rounded-xl border border-white/20 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-purple-300 focus:bg-black/30';
    $buttonClass = 'inline-flex items-center justify-center rounded-full bg-linear-to-r from-indigo-500 to-purple-600 px-6 py-3 text-xs font-bold uppercase tracking-widest text-white shadow-[0_0_22px_rgba(124,92,255,0.45)] transition hover:from-indigo-400 hover:to-purple-500 disabled:cursor-not-allowed disabled:opacity-50';
    $paymentLabels = ['blik' => 'BLIK', 'card' => 'Karta płatnicza', 'cod' => 'Gotówka przy odbiorze'];
@endphp

<form action="{{ route('transakcje.store') }}" method="POST" id="checkout-form">
    @csrf
    <input type="hidden" name="pickup_point_info" id="pickup-point-info" value="{{ old('pickup_point_info') }}">

    <section class="w-full px-4 py-6 text-white lg:px-8">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4 border-b border-white/10 pb-6">
            <div>
                <p class="mb-2 text-[10px] uppercase tracking-[0.32em] text-purple-300">Transakcja</p>
                <h1 class="text-2xl font-bold sm:text-3xl">Dostawa i płatność</h1>
            </div>

            <a href="{{ route('cart.index') }}" class="text-xs uppercase tracking-widest text-white/55 transition hover:text-cyan-300">
                Powrót do koszyka
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-amber-300/40 bg-amber-500/10 px-5 py-4 text-sm text-amber-50">
                <p class="mb-2 font-semibold">Sprawdź dane zamówienia:</p>
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-7 xl:grid-cols-[minmax(0,1fr)_410px]">
            <div class="space-y-6">
                <article class="{{ $panelClass }}">
                    <div class="border-b border-white/20 bg-white/10 px-5 py-4 sm:px-8">
                        <h2 class="text-xl text-[#b7a8ff] sm:text-2xl">Dane odbiorcy</h2>
                    </div>

                    <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-8">
                        <input class="{{ $fieldClass }}" type="text" name="recipient_first_name" value="{{ $recipientFirstName }}" placeholder="Imię" autocomplete="given-name" required>
                        <input class="{{ $fieldClass }}" type="text" name="recipient_last_name" value="{{ $recipientLastName }}" placeholder="Nazwisko" autocomplete="family-name" required>
                        <input class="{{ $fieldClass }} sm:col-span-2" type="tel" name="recipient_phone" value="{{ $recipientPhone }}" placeholder="Numer telefonu" autocomplete="tel" required>
                    </div>
                </article>

                <article id="address-section" class="{{ $panelClass }}">
                    <div class="border-b border-white/20 bg-white/10 px-5 py-4 sm:px-8">
                        <h2 class="text-xl text-[#b7a8ff] sm:text-2xl">Adres dostawy</h2>
                    </div>

                    <div class="space-y-4 p-5 sm:p-8">
                        @auth
                            @php $selectedAddressId = old('selected_address_id', $addresses->first()->id ?? ''); @endphp
                            <input type="hidden" name="selected_address_id" id="selected-address-id" value="{{ $selectedAddressId }}">

                            @if ($addresses->isNotEmpty())
                                <div class="grid gap-3">
                                    @foreach ($addresses as $address)
                                        <label class="grid cursor-pointer gap-3 rounded-xl border border-white/15 bg-black/15 p-4 transition hover:border-purple-300/60 sm:grid-cols-[auto_1fr]">
                                            <input
                                                type="radio"
                                                name="address_mode_picker"
                                                value="existing"
                                                data-address-choice="existing"
                                                data-address-id="{{ $address->id }}"
                                                class="mt-1 h-4 w-4 accent-purple-400"
                                                @checked((string) $selectedAddressId === (string) $address->id && old('address_mode', 'existing') !== 'new')
                                            >
                                            <span>
                                                <span class="block text-sm font-semibold text-white">
                                                    {{ $address->street }}
                                                    @if ($address->is_default)
                                                        <span class="ml-2 rounded-full border border-cyan-300/30 bg-cyan-400/10 px-2 py-0.5 text-[10px] uppercase tracking-widest text-cyan-200">domyślny</span>
                                                    @endif
                                                </span>
                                                <span class="mt-1 block text-sm text-white/65">{{ $address->postal_code }} {{ $address->city }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-white/15 bg-black/15 p-4 transition hover:border-purple-300/60">
                                <input type="radio" name="address_mode_picker" value="new" data-address-choice="new" class="h-4 w-4 accent-purple-400" @checked($addresses->isEmpty() || old('address_mode') === 'new')>
                                <span class="text-sm font-semibold text-white">Dodaj nowy adres do konta</span>
                            </label>

                            <input type="hidden" name="address_mode" id="address-mode" value="{{ old('address_mode', $addresses->isNotEmpty() ? 'existing' : 'new') }}">

                            <div id="new-address-fields" class="grid gap-3 rounded-xl border border-white/15 bg-black/15 p-4 sm:grid-cols-2">
                                <input class="{{ $fieldClass }} sm:col-span-2" type="text" name="new_street" value="{{ old('new_street') }}" placeholder="Ulica i numer">
                                <input class="{{ $fieldClass }}" type="text" name="new_postal_code" value="{{ old('new_postal_code') }}" placeholder="Kod pocztowy">
                                <input class="{{ $fieldClass }}" type="text" name="new_city" value="{{ old('new_city') }}" placeholder="Miasto">
                            </div>
                        @else
                            <input type="hidden" name="address_mode" value="guest">
                            <div class="grid gap-3 sm:grid-cols-2">
                                <input class="{{ $fieldClass }} sm:col-span-2" type="text" name="guest_street" value="{{ old('guest_street') }}" placeholder="Ulica i numer" autocomplete="street-address" required>
                                <input class="{{ $fieldClass }}" type="text" name="guest_postal_code" value="{{ old('guest_postal_code') }}" placeholder="Kod pocztowy" autocomplete="postal-code" required>
                                <input class="{{ $fieldClass }}" type="text" name="guest_city" value="{{ old('guest_city') }}" placeholder="Miasto" autocomplete="address-level2" required>
                            </div>
                        @endauth
                    </div>
                </article>

                <article class="{{ $panelClass }}">
                    <div class="border-b border-white/20 bg-white/10 px-5 py-4 sm:px-8">
                        <h2 class="text-xl text-[#b7a8ff] sm:text-2xl">Sposób dostawy</h2>
                    </div>

                    <div class="space-y-4 p-5 sm:p-8">
                        <div class="grid gap-3 lg:grid-cols-2">
                            @foreach ($shippingMethods as $method)
                                @php $methodName = mb_strtolower($method->name); @endphp
                                <label class="cursor-pointer rounded-xl border border-white/15 bg-black/15 p-4 transition hover:border-purple-300/60">
                                    <span class="flex items-start gap-3">
                                        <input
                                            type="radio"
                                            name="shipping_method_id"
                                            value="{{ $method->id }}"
                                            data-shipping-price="{{ $method->price }}"
                                            data-shipping-name="{{ $methodName }}"
                                            class="mt-1 h-4 w-4 accent-purple-400"
                                            @checked((string) old('shipping_method_id', $shippingMethods->first()->id ?? '') === (string) $method->id)
                                        >
                                        <span>
                                            <span class="block text-sm font-semibold text-white">{{ $method->name }}</span>
                                            <span class="mt-1 block text-xs text-cyan-200">{{ (float) $method->price === 0.0 ? 'Darmowa' : number_format($method->price, 2, ',', ' ') . ' zł' }}</span>
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div id="courier-panel" class="hidden rounded-xl border border-purple-300/25 bg-black/20 p-4">
                            <p class="mb-3 text-sm font-semibold text-white/90">Wybierz kuriera</p>
                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                @foreach (['DHL', 'DPD', 'InPost Kurier', 'Poczta Polska'] as $courier)
                                    <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-white/15 bg-white/5 px-4 py-3 text-sm">
                                        <input type="radio" name="courier_provider" value="{{ $courier }}" class="h-4 w-4 accent-purple-400" @checked(old('courier_provider', 'DHL') === $courier)>
                                        <span>{{ $courier }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="personal-panel" class="hidden rounded-xl border border-purple-300/25 bg-black/20 p-4">
                            <p class="mb-2 text-sm font-semibold text-white/90">Odbiór w siedzibie firmy</p>
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white/15 bg-white/5 px-4 py-3 text-sm">
                                <input type="radio" name="personal_pickup_choice" value="Siedziba firmy - al. Tadeusza Rejtana 16C, Rzeszów" class="mt-1 h-4 w-4 accent-purple-400" checked>
                                <span>Siedziba firmy - al. Tadeusza Rejtana 16C, Rzeszów</span>
                            </label>
                        </div>

                        <div id="store-panel" class="hidden rounded-xl border border-purple-300/25 bg-black/20 p-4">
                            <p class="mb-3 text-sm font-semibold text-white/90">Wybierz salon</p>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ([
                                    'Galeria Rzeszów - al. Piłsudskiego 44',
                                    'Galeria Millenium - al. Kopisto 1',
                                ] as $point)
                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white/15 bg-white/5 px-4 py-3 text-sm">
                                        <input type="radio" name="store_pickup_choice" value="{{ $point }}" class="mt-1 h-4 w-4 accent-purple-400" @checked(old('pickup_point_info', 'Galeria Rzeszów - al. Piłsudskiego 44') === $point)>
                                        <span>{{ $point }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="locker-panel" class="hidden rounded-xl border border-purple-300/25 bg-black/20 p-4">
                            <p class="mb-3 text-sm font-semibold text-white/90">Wybierz paczkomat</p>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ([
                                    'Paczkomat RZE01M - ul. Rejtana 16',
                                    'Paczkomat RZE12A - ul. Kopisto 1',
                                    'Paczkomat RZE24N - ul. Krakowska 20',
                                    'Paczkomat RZE33M - ul. Hetmańska 73',
                                ] as $point)
                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-white/15 bg-white/5 px-4 py-3 text-sm">
                                        <input type="radio" name="locker_pickup_choice" value="{{ $point }}" class="mt-1 h-4 w-4 accent-purple-400" @checked(old('pickup_point_info', 'Paczkomat RZE01M - ul. Rejtana 16') === $point)>
                                        <span>{{ $point }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </article>

                <article class="{{ $panelClass }}">
                    <div class="border-b border-white/20 bg-white/10 px-5 py-4 sm:px-8">
                        <h2 class="text-xl text-[#b7a8ff] sm:text-2xl">Sposób płatności</h2>
                    </div>

                    <div class="space-y-4 p-5 sm:p-8">
                        <div class="grid gap-3 sm:grid-cols-3">
                            @foreach ($paymentLabels as $value => $label)
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-white/15 bg-black/15 p-4 transition hover:border-purple-300/60">
                                    <input type="radio" name="payment_method" value="{{ $value }}" class="h-4 w-4 accent-purple-400" @checked(old('payment_method', 'blik') === $value)>
                                    <span class="text-sm font-semibold text-white">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div id="payment-card-panel" class="hidden grid gap-3 rounded-xl border border-white/15 bg-black/15 p-4 sm:grid-cols-2">
                            <input class="{{ $fieldClass }} sm:col-span-2" type="text" name="card_holder" value="{{ old('card_holder') }}" placeholder="Imię i nazwisko na karcie">
                            <input class="{{ $fieldClass }} sm:col-span-2" type="text" name="card_number" value="{{ old('card_number') }}" placeholder="Numer karty">
                            <input class="{{ $fieldClass }}" type="text" name="card_expiry" value="{{ old('card_expiry') }}" placeholder="MM/RR">
                            <input class="{{ $fieldClass }}" type="text" name="card_cvv" value="{{ old('card_cvv') }}" placeholder="CVV">
                        </div>

                        <div id="payment-cod-panel" class="hidden rounded-xl border border-white/15 bg-black/15 p-4 text-sm text-white/75">
                            Zapłata gotówką przy odbiorze nie wymaga dodatkowych danych.
                        </div>

                        <input type="hidden" name="blik_code" id="blik-code" value="{{ old('blik_code') }}">
                    </div>
                </article>
            </div>

            <aside class="space-y-6 xl:sticky xl:top-6 xl:self-start">
                <article class="{{ $panelClass }} p-6 sm:p-8">
                    <h2 class="mb-2 text-xl">Podsumowanie</h2>
                    <p class="mb-6 text-sm text-[#b7a8ff]">Koszyk i dostawa</p>

                    <dl class="space-y-3 text-sm">
                        <div class="flex items-start justify-between gap-5 border-t border-white/10 pt-3">
                            <dt>Wartość produktów</dt>
                            <dd class="text-right font-semibold">{{ number_format($totalPrice, 2, ',', ' ') }} zł</dd>
                        </div>
                        @if ($insurance > 0)
                            <div class="flex justify-between gap-5">
                                <dt>Ubezpieczenie</dt>
                                <dd class="font-semibold text-cyan-300">+{{ number_format($insurance, 2, ',', ' ') }} zł</dd>
                            </div>
                        @endif
                        <div class="flex justify-between gap-5">
                            <dt>Dostawa</dt>
                            <dd id="summary-shipping" class="font-semibold text-green-300">{{ $initialShipping === 0.0 ? 'Darmowa' : number_format($initialShipping, 2, ',', ' ') . ' zł' }}</dd>
                        </div>
                        <div class="flex justify-between gap-5 border-t border-white/10 pt-3 text-lg font-bold">
                            <dt>Do zapłaty</dt>
                            <dd id="summary-total" class="font-bruno text-purple-300" data-base-total="{{ $totalPrice + $insurance }}">{{ number_format($initialTotal, 2, ',', ' ') }} zł</dd>
                        </div>
                    </dl>

                    <label class="mt-6 flex cursor-pointer items-start gap-3 rounded-xl border border-white/15 bg-black/15 p-4 text-sm text-white/80">
                        <input type="checkbox" name="terms_accepted" value="1" class="mt-1 h-4 w-4 accent-purple-400" required @checked(old('terms_accepted'))>
                        <span>Akceptuję umowę i warunki sklepu. Przyjmuję do wiadomości, że nie przyjmujemy zwrotów z powodu fizycznych uszkodzeń.</span>
                    </label>

                    <button type="submit" class="{{ $buttonClass }} mt-5 w-full text-sm">
                        Zapłać i zamów
                    </button>
                </article>

                <article class="{{ $panelClass }} overflow-hidden">
                    <div class="border-b border-white/20 bg-white/10 px-5 py-4">
                        <h2 class="text-lg text-[#b7a8ff]">Podgląd zamówienia</h2>
                    </div>

                    <div class="max-h-[520px] divide-y divide-white/10 overflow-y-auto">
                        @foreach ($cartItems as $item)
                            @php $isInsured = in_array($item['id'], $insuredProducts); @endphp
                            <div class="grid grid-cols-[72px_1fr] gap-4 p-4">
                                <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-white p-2">
                                    <img src="{{ asset('images/' . $item['image_url']) }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                                </div>
                                <div class="min-w-0">
                                    <p class="line-clamp-2 text-sm font-semibold text-white">{{ $item['name'] }}</p>
                                    <p class="mt-1 text-xs text-white/60">Ilość: {{ $item['quantity'] }}</p>
                                    @if ($isInsured)
                                        <p class="mt-1 text-xs text-cyan-200">Ubezpieczony</p>
                                    @endif
                                    <p class="mt-2 text-sm font-semibold text-cyan-300">{{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }} zł</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>
            </aside>
        </div>
    </section>

    <div id="blik-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 px-4">
        <div class="w-full max-w-md rounded-2xl border border-purple-300/30 bg-slate-950 p-6 text-white shadow-2xl">
            <h2 class="text-xl font-bold">Kod BLIK</h2>
            <p class="mt-2 text-sm text-white/65">Wpisz dowolne 6 cyfr. To tylko demonstracja płatności w projekcie.</p>
            <input id="blik-modal-code" type="text" inputmode="numeric" maxlength="6" pattern="[0-9]{6}" class="{{ $fieldClass }} mt-5 text-center text-2xl tracking-[0.45em]" placeholder="000000">
            <p id="blik-modal-error" class="mt-3 hidden text-sm text-rose-200">Kod musi mieć dokładnie 6 cyfr.</p>
            <div class="mt-5 flex gap-3">
                <button type="button" id="blik-cancel" class="w-full rounded-full border border-white/20 bg-white/5 px-4 py-3 text-sm font-semibold text-white/80 transition hover:bg-white/10">Anuluj</button>
                <button type="button" id="blik-confirm" class="{{ $buttonClass }} w-full">Potwierdź</button>
            </div>
        </div>
    </div>
</form>

@endsection
