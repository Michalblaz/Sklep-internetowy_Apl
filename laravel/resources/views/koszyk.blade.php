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
    $productImage = asset('images/products/cpu/AMD_Ryzen_5_7600X.jpg');
@endphp


            <article class="{{ $panelClass }}">
                <div class="flex items-center justify-between border-b border-white/20 bg-white/10 px-5 py-4 sm:px-8">
                    <h2 class="text-xl text-[#8f78ff] sm:text-2xl">Koszyk</h2>
                    <span class="text-xs text-white/75">1 Produkt</span>
                </div>

                <div class="grid gap-6 p-5 sm:grid-cols-[144px_1fr_auto] sm:items-center sm:p-8">
                    <div class="flex h-36 w-36 items-center justify-center rounded-xl bg-white p-3">
                        <img src="{{ $productImage }}" alt="AMD Ryzen 5 7600X" class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="min-w-0 space-y-4">
                        <p class="text-lg text-white">AMD Ryzen 5 7600X</p>

                        <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-white/25 bg-black/15 px-4 py-2 text-[11px] text-white/85 transition hover:border-cyan-300/60 hover:bg-white/10">
                            <i class="fa-solid fa-plus text-cyan-200"></i>
                            Ubezpiecz urzadzenie
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 sm:justify-end">
                        <select class="h-11 rounded-lg border border-white/25 bg-black/20 px-4 text-sm text-white outline-none focus:border-purple-300">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>

                        <button type="button" class="text-xl text-white/55 transition hover:text-red-300" aria-label="Usun produkt">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>

                        <button type="button" class="text-xl text-white/55 transition hover:text-purple-300" aria-label="Dodaj do ulubionych">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                        <p class="w-full text-right text-xl text-white sm:w-auto">cena : 663.90</p>
                    </div>
                </div>
            </article>
        </div>

        <aside class="{{ $panelClass }} min-h-[460px] p-6 sm:p-8 xl:sticky xl:top-6">
            <h2 class="mb-2 text-xl">Dostawa i Platnosc</h2>
            <p class="mb-6 text-sm text-[#8f78ff]">Podsumowanie</p>

            <dl class="space-y-3 text-sm">
                <div class="flex items-start justify-between gap-5 border-t border-white/10 pt-3">
                    <dt>Razem</dt>
                    <dd class="text-right">
                        <span class="block">639.00</span>
                        <span class="text-[10px] text-white/60">rabat : 63.90</span>
                    </dd>
                </div>
                <div class="flex justify-between gap-5">
                    <dt>Dostawa</dt>
                    <dd>11.00</dd>
                </div>
                <div class="flex justify-between gap-5 text-white">
                    <dt>Do zaplaty</dt>
                    <dd>575.10</dd>
                </div>
            </dl>

            <div class="flex justify-end w-full">
            <a href="{{ route('transakcje') }}" class="inline-block w-64 text-center bg-neon-purple/80 hover:bg-neon-purple py-3 rounded font-bruno text-xs uppercase transition-all shadow-lg shadow-neon-purple/20">
                KUP
            </a>
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
</script>
@endsection
