@extends('app')

@section('content')
@php
    $user = auth()->user();
    $recipientName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
    $recipientPhone = $user->phone ?? '';
    $panelClass = 'relative overflow-hidden rounded-2xl border border-white/10 bg-[linear-gradient(145deg,rgba(83,107,121,0.82),rgba(18,64,83,0.88)_46%,rgba(20,36,75,0.94)_100%)] shadow-[0_24px_60px_rgba(0,0,0,0.35),inset_0_1px_0_rgba(255,255,255,0.08)]';
    $fieldClass = 'w-full border border-white/25 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/75 outline-none transition focus:border-purple-300 focus:bg-black/30';
    $softFieldClass = 'w-full rounded-xl border border-white/20 bg-black/20 px-4 py-3 text-sm text-white placeholder:text-white/55 outline-none transition focus:border-purple-300 focus:bg-black/30';
    $buttonClass = 'inline-flex items-center justify-center rounded-full bg-linear-to-r from-indigo-500 to-purple-600 px-6 py-2 text-xs font-bold uppercase tracking-widest text-white shadow-[0_0_22px_rgba(124,92,255,0.45)] transition hover:from-indigo-400 hover:to-purple-500';
    $insuredProducts = session('insured_products', []);
    $insurance = 0;

    foreach ($cartItems as $item) {
        if (in_array($item['id'], $insuredProducts)) {
            // Bierze 10% ceny przedmiotu i mnoży przez liczbę sztuk w koszyku
            $insurance += ($item['price'] * 0.10) * $item['quantity'];
        }
    }
    $finalTotal = $totalPrice + $insurance;
@endphp

<section class="container mx-auto px-4 py-8 text-white">
    <div class="grid gap-8 xl:grid-cols-[1fr_380px]">
        <div class="space-y-6">
            <article class="{{ $panelClass }}">
                <div class="flex items-center justify-between border-b border-white/20 bg-white/10 px-5 py-4 sm:px-8">
                    <h2 class="text-xl text-[#8f78ff] sm:text-2xl">Koszyk</h2>
                        <div class="flex items-center gap-4">
                                {{-- Przycisk pojawia się tylko, gdy koszyk nie jest pusty --}}
                                @if(count($cartItems) > 0)
                                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć WSZYSTKIE produkty z koszyka?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-red-500/30 bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-400 transition hover:bg-red-500/20 hover:text-red-300">
                                            <i class="fa-regular fa-trash-can"></i>
                                            Wyczyść koszyk
                                        </button>
                                    </form>
                                @endif
                        <span class="text-xs text-white/75">
                            {{ count($cartItems) }} {{ count($cartItems) == 1 ? 'Produkt' : (count($cartItems) > 1 && count($cartItems) < 5 ? 'Produkty' : 'Produktów') }}
                        </span>
                    </div>
                </div>

                @if(count($cartItems) > 0)
                    {{-- Pętla generująca dynamicznie produkty dodane do koszyka --}}
                    @foreach($cartItems as $item)
                        <div class="grid gap-6 p-5 sm:grid-cols-[144px_1fr_auto] sm:items-center sm:p-8 border-b border-white/10 last:border-b-0">

                            <div class="flex h-36 w-36 items-center justify-center rounded-xl bg-white p-3 overflow-hidden aspect-square">
                                <img
                                    src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : asset('images/' . $item['image_url']) }}"
                                    alt="{{ $item['name'] }}"
                                    class="block max-h-full max-w-full object-contain mx-auto"
                                >
                            </div>

                            <div class="min-w-0 space-y-4">
                                <p class="text-lg text-white">{{ $item['name'] }}</p>
                                @php
                                    $isInsured = in_array($item['id'], $insuredProducts);
                                @endphp

                                <button type="button" onclick="toggleInsurance({{ $item['id'] }})"class="inline-flex items-center gap-2 rounded-xl border {{ $isInsured ? 'border-cyan-400 bg-cyan-500/20 text-cyan-200' : 'border-white/25 bg-black/15 text-white/85' }} px-4 py-2 text-[11px] transition hover:border-cyan-300/60 hover:bg-white/10">
                                <i class="fa-solid {{ $isInsured ? 'fa-check text-cyan-300' : 'fa-plus text-cyan-200' }}"></i>
                                {{ $isInsured ? 'Urządzenie ubezpieczone możesz śmiało rzucać' : 'Ubezpiecz urządzenie' }}
                            </button>
                            </div>

                            <div class="flex flex-wrap items-center gap-4 sm:justify-end">
                               <div class="flex items-center border border-white/25 bg-black/20 rounded-lg overflow-hidden h-11">
                                    <input type="number"
                                        id="quantity-{{ $item['id'] }}"
                                        value="{{ $item['quantity'] }}"
                                        min="1"
                                        max="{{ $item['stock'] ?? 99 }}"
                                        onchange="updateCartQuantity({{ $item['id'] }}, this.value, {{ $item['stock'] ?? 99 }})"
                                        class="w-12 bg-transparent text-center text-sm text-white outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">

                                    <div class="flex flex-col border-l border-white/25 h-full w-8 divide-y divide-white/25">
                                        <button type="button"
                                                onclick="changeQuantity({{ $item['id'] }}, 1, {{ $item['stock'] ?? 99 }})"
                                                class="flex items-center justify-center h-1/2 text-[10px] text-white/70 hover:bg-white/10 transition">
                                            <i class="fa-solid fa-chevron-up"></i>
                                        </button>
                                        <button type="button"
                                                onclick="changeQuantity({{ $item['id'] }}, -1, {{ $item['stock'] ?? 99 }})"
                                                class="flex items-center justify-center h-1/2 text-[10px] text-white/70 hover:bg-white/10 transition">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </div>
                                </div>

                                <form action="{{ route('cart.remove') }}" method="POST" class="inline flex items-center">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" class="text-xl text-white/55 transition hover:text-red-300" aria-label="Usuń produkt">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>

                                <button type="button" class="text-xl text-white/55 transition hover:text-purple-300" aria-label="Dodaj do ulubionych">
                                    <i class="fa-regular fa-heart"></i>
                                </button>

                                <div class="text-right min-w-[100px]">
                                @if(isset($item['promo_price']) && $item['promo_price'] && $item['promo_price'] < $item['base_price'])
                                    <span class="block text-xs text-white/40 line-through">
                                        {{ number_format($item['base_price'] * $item['quantity'], 2, ',', ' ') }} zł
                                    </span>
                                    <span class="block text-sm font-semibold text-cyan-400 font-bruno">
                                        {{ number_format($item['promo_price'] * $item['quantity'], 2, ',', ' ') }} zł
                                    </span>
                                @else
                                    <span class="block text-sm font-semibold text-white/90">
                                        {{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }} zł
                                    </span>
                                @endif
                            </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-8 text-center text-white/50">
                        Twój koszyk jest pusty.
                    </div>
                @endif
            </article>
        </div>

        <aside class="{{ $panelClass }} min-h-[460px] p-6 sm:p-8 xl:sticky xl:top-6">
            <h2 class="mb-2 text-xl">Przejdź do transakcji</h2>
            <p class="mb-6 text-sm text-[#8f78ff]">Podsumowanie</p>

            <dl class="space-y-3 text-sm">
                <div class="flex items-start justify-between gap-5 border-t border-white/10 pt-3">
                    <dt>Razem</dt>
                    <dd class="text-right">
                        <span class="block text-lg font-semibold">{{ number_format($totalPrice, 2, ',', ' ') }} zł</span>
                    </dd>
                </div>
                <div class="flex items-start justify-between gap-5 border-t border-white/10 pt-3">

                <dt>Ubezpieczenie</dt>
                <dd class="text-right">
                    <span class="block text-lg font-semibold">{{ number_format($insurance, 2, ',', ' ') }} zł</span>
                </dd>
                </div>
                <div class="flex justify-between gap-5 text-white border-t border-white/10 pt-3 font-bold text-base">
                    <dt>Do zapłaty</dt>
                    <dd>{{ number_format($finalTotal, 2, ',', ' ') }} zł</dd>
                </div>
            </dl>

            <div class="flex justify-end w-full">
                <button type="button"
                        onclick="window.location.href='{{ route('transakcje') }}'"
                        class="{{ $buttonClass }} mt-7 w-full">
                    KUP
                </button>
            </div>


        </aside>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toggle-panel]').forEach((button) => {
        button.addEventListener('click', () => {
            const panel = document.getElementById(button.dataset.togglePanel);
            panel?.classList.toggle('hidden');
        });
    });

    document.querySelectorAll('[data-toggle-checkbox]').forEach((checkbox) => {
        const panel = document.getElementById(checkbox.dataset.toggleCheckbox);
        const syncPanel = () => panel?.classList.toggle('hidden', !checkbox.checked);

        checkbox.addEventListener('change', syncPanel);
        syncPanel();
    });

    const deliveryOptions = document.querySelectorAll('[data-delivery-option]');
    const deliveryPanels = document.querySelectorAll('[data-delivery-panel]');

    function syncDeliveryPanels() {
        const selected = document.querySelector('[data-delivery-option]:checked')?.value;

        deliveryPanels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.id !== `delivery-panel-${selected}`);
        });
    }

    deliveryOptions.forEach((option) => option.addEventListener('change', syncDeliveryPanels));
    syncDeliveryPanels();
});
function changeQuantity(productId, delta, maxStock) {
    const input = document.getElementById(`quantity-${productId}`);
    let currentVal = parseInt(input.value) || 1;
    let newVal = currentVal + delta;

    if (newVal < 1) newVal = 1;
    if (newVal > maxStock) newVal = maxStock;

    input.value = newVal;
    sendQuantityUpdate(productId, newVal);
}

function updateCartQuantity(productId, value, maxStock) {
    let newVal = parseInt(value) || 1;

    if (newVal < 1) newVal = 1;
    if (newVal > maxStock) {
        alert(`Niestety, na magazynie posiadamy tylko ${maxStock} szt. tego produktu.`);
        newVal = maxStock;
    }

    const input = document.getElementById(`quantity-${productId}`);
    input.value = newVal;
    sendQuantityUpdate(productId, newVal);
}

function sendQuantityUpdate(productId, quantity) {
    fetch("{{ route('cart.update') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        // Przeładowujemy stronę, aby automatycznie zaktualizować ceny globalne i podsumowanie
        window.location.reload();
    })
    .catch(error => console.error('Błąd aktualizacji koszyka:', error));
}
function toggleInsurance(productId) {
    fetch("{{ route('cart.insurance') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Przeładowujemy stronę
            window.location.reload();
        }
    })
    .catch(error => console.error('Błąd ubezpieczenia:', error));
}
</script>
@endsection
