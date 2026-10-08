@php
    $selectable = $selectable ?? true;
@endphp

@if ($selectable)
    <button
        type="button"
        data-order-select="{{ $shipment['id'] }}"
        data-order-title="Zamówienie #{{ $shipment['display_id'] }} - {{ $shipment['status'] }}"
        data-shipment-card
        data-delivered="{{ $shipment['is_delivered'] ? 'true' : 'false' }}"
        class="shipment-card w-full rounded-[1.8rem] border border-white/15 bg-slate-950/15 p-4 text-left transition hover:border-cyan-300/40 hover:bg-white/10"
    >
@else
    <div
        data-shipment-card
        data-delivered="{{ $shipment['is_delivered'] ? 'true' : 'false' }}"
        class="shipment-card w-full rounded-[1.8rem] border border-white/15 bg-slate-950/15 p-4 text-left transition"
    >
@endif
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
                    <p class="mt-2 font-['Bruno_Ace'] text-lg text-white">#{{ $shipment['display_id'] }}</p>
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
                <p class="text-[11px] uppercase tracking-[0.25em] text-cyan-100/60">Adres lub punkt odbioru</p>
                <p class="mt-2 text-sm text-white">{{ $shipment['address'] !== '' ? $shipment['address'] : 'Brak adresu dostawy' }}</p>
                @if (!empty($shipment['pickup_point']))
                    <p class="mt-2 text-sm text-cyan-100/85">Punkt: {{ $shipment['pickup_point'] }}</p>
                @endif
                <p class="mt-2 text-xs text-white/60">
                    Odbiorca: {{ $shipment['recipient'] !== '' ? $shipment['recipient'] : 'Brak danych' }}
                    @if (!empty($shipment['phone']))
                        · {{ $shipment['phone'] }}
                    @endif
                </p>
                <p class="mt-1 text-xs text-white/60">Płatność: {{ $shipment['payment_method'] }}</p>
                @if ($shipment['complaint_label'])
                    <p class="mt-2 text-xs uppercase tracking-[0.2em] text-fuchsia-200/80">
                        Ostatnie zgłoszenie: {{ $shipment['complaint_label'] }}
                    </p>
                @endif
            </div>
        </div>
    </div>
@if ($selectable)
    </button>
@else
    </div>
@endif
