@extends('app')

@section('content')
@php
    $maxCategoryValue = max(1, $categoryChartData->max('value') ?? 1);
    $categoryScale = collect([1, 0.66, 0.33, 0])
        ->map(fn ($step) => (int) round($maxCategoryValue * $step))
        ->unique()
        ->values();
    $chartColors = [
        '#38bdf8', '#6366f1', '#8b5cf6', '#d946ef', '#ec4899', '#f97316',
        '#facc15', '#84cc16', '#22c55e', '#14b8a6', '#06b6d4', '#3b82f6',
        '#a855f7', '#e879f9', '#f43f5e', '#0ea5e9',
    ];
@endphp

<div class="w-full px-2 lg:px-6 py-8 flex flex-col xl:flex-row gap-8">
    <div class="flex-1 min-w-0 space-y-8">
        <div class="flex flex-col gap-3">
            <p class="text-sm uppercase tracking-[0.35em] text-cyan-300/80">Panel administratora</p>
            <h1 class="text-3xl lg:text-4xl text-white font-bruno">Centrum zarządzania sklepem</h1>
            <p class="text-sm lg:text-base text-gray-300 max-w-3xl">
                Podgląd najważniejszych danych sklepu, reklamacji i użytkowników w jednym miejscu.
            </p>
        </div>

        @if (session('admin_status'))
            <div class="rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-emerald-200">
                {{ session('admin_status') }}
            </div>
        @endif

        @if (session('admin_error'))
            <div class="rounded-2xl border border-red-400/30 bg-red-500/10 px-5 py-4 text-red-200">
                {{ session('admin_error') }}
            </div>
        @endif

        <section class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-xl space-y-8">
            @if(request('action') === 'add-product')
                {{-- SEKCJA FORMULARZA (DODAWANIE/EDYCJA) --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-cyan-400 text-xl font-bruno">
                            {{ request('edit_id') ? 'Edycja produktu' : 'Nowy produkt' }}
                        </h2>
                        <a href="{{ route('admin') }}" class="text-xs text-gray-400 hover:text-white uppercase tracking-widest">
                            ✕ Wróć do statystyk
                        </a>
                    </div>

                    @livewire('admin.product-form', ['productId' => request('edit_id')])
                </div>
            @else
                {{-- SEKCJA STATYSTYK --}}
                <div id="sklep" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-purple-400 text-xl font-bruno">Sklep</h2>
                        <span class="text-xs uppercase tracking-[0.3em] text-gray-400">Podstawowe dane</span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 lg:gap-6 text-gray-200">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-gray-400 mb-2">Liczba klientów</p>
                            <p class="text-3xl text-white">{{ number_format($storeStats['customers']) }}</p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-gray-400 mb-2">Liczba wyświetleń</p>
                            <p class="text-3xl text-white">{{ number_format($storeStats['views']) }}</p>
                            <p class="mt-2 text-xs text-gray-500">{{ $storeStats['views_note'] }}</p>
                        </div>
                    </div>
                </div>

                <div id="konta" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-purple-400 text-xl font-bruno">Konta</h2>
                        <span class="text-xs uppercase tracking-[0.3em] text-gray-400">Status klientów</span>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4 lg:gap-6 text-gray-200">
                        <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/5 p-5">
                            <p class="text-sm text-gray-400 mb-2">Aktywne</p>
                            <p class="text-3xl text-white">{{ number_format($accountStats['active']) }}</p>
                        </div>

                        <div class="rounded-2xl border border-amber-400/20 bg-amber-500/5 p-5">
                            <p class="text-sm text-gray-400 mb-2">Zawieszone</p>
                            <p class="text-3xl text-white">{{ number_format($accountStats['suspended']) }}</p>
                        </div>

                        <div class="rounded-2xl border border-red-400/20 bg-red-500/5 p-5">
                            <p class="text-sm text-gray-400 mb-2">Zbanowane</p>
                            <p class="text-3xl text-white">{{ number_format($accountStats['banned']) }}</p>
                        </div>
                    </div>
                </div>

                <div id="statystyki" class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <h2 class="text-purple-400 text-xl font-bruno">Statystyki</h2>
                        <span class="text-xs uppercase tracking-[0.3em] text-gray-400">Aktywność sklepu</span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 lg:gap-6 text-gray-200">
                        <div class="rounded-2xl border border-cyan-400/20 bg-cyan-500/5 p-5">
                            <p class="text-sm text-gray-400 mb-4">Zamówienia</p>
                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl border border-sky-400/20 bg-sky-500/10 px-3 py-3">
                                    <p class="text-[10px] uppercase tracking-[0.18em] text-sky-200/70">Nowe</p>
                                    <p class="mt-2 text-2xl text-white">{{ number_format($shopStats['orders_new']) }}</p>
                                </div>

                                <div class="rounded-xl border border-amber-400/20 bg-amber-500/10 px-3 py-3">
                                    <p class="text-[10px] uppercase tracking-[0.18em] text-amber-200/70">W trakcie</p>
                                    <p class="mt-2 text-2xl text-white">{{ number_format($shopStats['orders_in_progress']) }}</p>
                                </div>

                                <div class="rounded-xl border border-emerald-400/20 bg-emerald-500/10 px-3 py-3">
                                    <p class="text-[10px] uppercase tracking-[0.18em] text-emerald-200/70">Dostarczone</p>
                                    <p class="mt-2 text-2xl text-white">{{ number_format($shopStats['orders_delivered']) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-gray-400 mb-2">Wszystkie produkty</p>
                            <p class="text-3xl text-white">{{ number_format($shopStats['products']) }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>

            <section id="wykresy" class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-xl space-y-8">
                <div class="space-y-2">
                    <h2 class="text-purple-400 text-xl font-bruno">Wykresy</h2>
                    <p class="text-sm text-gray-400">
                        Kliknij słupek kategorii, aby zobaczyć stany magazynowe modeli w wybranej kategorii.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="min-w-0 rounded-3xl border border-white/10 bg-white/5 p-5">
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <h3 class="text-white text-lg">Produkty w kategoriach</h3>
                            <span class="text-xs uppercase tracking-[0.3em] text-gray-500">Wykres 1</span>
                        </div>

                        @if ($categoryChartData->isEmpty())
                            <div class="min-h-72 rounded-2xl border border-dashed border-white/10 flex items-center justify-center text-gray-500 text-center px-6">
                                Brak danych o produktach i kategoriach do wyświetlenia wykresu.
                            </div>
                        @else
                            <div
                                id="category-chart"
                                class="admin-chart-scroll max-w-full rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-cyan-500/5 px-4 lg:px-6 py-5 overflow-x-auto overflow-y-hidden"
                            >
                                <div class="mb-8 flex items-start justify-between gap-4">
                                    <p class="text-xs uppercase tracking-[0.28em] text-gray-400">Ilość produktów</p>
                                    <p class="text-[11px] text-gray-500">Najedź na słupek, aby zobaczyć szczegóły</p>
                                </div>

                                <div class="relative min-w-max pb-36 pt-3">
                                    <div class="absolute left-0 top-0 bottom-28 w-14">
                                        @foreach ($categoryScale as $index => $tick)
                                            @php
                                                $position = count($categoryScale) > 1 ? ($index / (count($categoryScale) - 1)) * 100 : 0;
                                            @endphp
                                            <span
                                                class="absolute right-2 -translate-y-1/2 text-[11px] text-gray-400"
                                                style="top: {{ $position }}%;"
                                            >
                                                {{ number_format($tick) }}
                                            </span>
                                        @endforeach
                                    </div>

                                    <div class="ml-14 min-w-max">
                                        <div class="relative flex h-[250px] min-h-[250px] items-end gap-5 border-l border-b border-white/20 px-4 pr-6">
                                            @foreach ($categoryScale as $index => $tick)
                                                @php
                                                    $position = count($categoryScale) > 1 ? ($index / (count($categoryScale) - 1)) * 100 : 0;
                                                @endphp
                                                <div
                                                    class="pointer-events-none absolute left-0 right-0 border-t {{ $tick === 0 ? 'border-white/20' : 'border-dashed border-white/10' }}"
                                                    style="top: {{ $position }}%;"
                                                ></div>
                                            @endforeach

                                            @foreach ($categoryChartData as $index => $category)
                                                @php
                                                    $barHeight = max(20, (int) round(($category['value'] / $maxCategoryValue) * 198));
                                                    $color = $chartColors[$index % count($chartColors)];
                                                @endphp
                                                <button
                                                    type="button"
                                                    class="category-bar group relative w-[96px] shrink-0 rounded-2xl px-3 pt-2 pb-3 text-center transition hover:bg-white/5"
                                                    data-category-id="{{ $category['id'] }}"
                                                    data-category-name="{{ $category['label'] }}"
                                                    data-category-value="{{ $category['value'] }}"
                                                >
                                                    <div class="h-[250px] flex flex-col justify-end items-center">
                                                        <div class="pointer-events-none absolute left-1/2 top-2 z-10 hidden -translate-x-1/2 rounded-xl border border-cyan-300/20 bg-slate-950/95 px-3 py-2 text-left shadow-xl group-hover:block">
                                                            <p class="text-[11px] leading-4 text-white whitespace-nowrap">{{ $category['label'] }}</p>
                                                            <p class="text-[11px] leading-4 text-cyan-300 whitespace-nowrap">Ilość: {{ $category['value'] }}</p>
                                                        </div>
                                                        <span class="mb-2 text-[11px] font-semibold text-gray-200">{{ $category['value'] }}</span>
                                                        <div
                                                            class="chart-bar w-12 rounded-t-xl border border-white/15 shadow-[0_0_20px_rgba(0,0,0,0.18)] transition duration-150 group-hover:-translate-y-1 group-hover:brightness-110"
                                                            style="height: {{ $barHeight }}px; background: linear-gradient(180deg, {{ $color }} 0%, rgba(15, 23, 42, 0.9) 100%);"
                                                        ></div>
                                                    </div>
                                                    <span class="admin-chart-label absolute left-1/2 top-full mt-4 ml-10 block w-28 origin-top-left text-left text-[12px] leading-[1.15rem] text-gray-200">
                                                        {{ $category['label'] }}
                                                    </span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 rounded-3xl border border-white/10 bg-white/5 p-5">
                        <div class="flex items-center justify-between gap-4 mb-5">
                            <div>
                                <h3 id="model-chart-title" class="text-white text-lg">Stany magazynowe modeli</h3>
                                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-1">Wykres 2</p>
                            </div>
                        </div>

                        <div id="model-chart-empty" class="min-h-72 rounded-2xl border border-dashed border-white/10 flex items-center justify-center text-gray-500 text-center px-6">
                            Wybierz kategorię z pierwszego wykresu.
                        </div>

                        <div id="model-chart" class="admin-chart-scroll hidden max-w-full rounded-2xl border border-white/10 bg-gradient-to-br from-white/5 to-cyan-500/5 px-4 lg:px-6 py-5 overflow-x-auto overflow-y-hidden"></div>
                    </div>
                </div>
            </section>

            <div
                id="admin-chart-data"
                data-models='@json($modelChartDataByCategory)'
                data-colors='@json($chartColors)'
                class="hidden"
            ></div>
            @if(request('action') !== 'add-product')
            <section id="stany-magazynowe" class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-purple-400 text-xl font-bruno">Kończące się modele</h2>
                        <p class="text-sm text-gray-400">Produkty, których stan magazynowy spadł do ustawionego progu lub mniej.</p>
                    </div>
                    <form action="{{ route('admin') }}#stany-magazynowe" method="GET" class="flex flex-wrap items-end gap-3">
                        <div>
                            <label for="low_stock_threshold" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                Próg bazowy: 5 szt.
                            </label>
                            <input
                                id="low_stock_threshold"
                                name="low_stock_threshold"
                                type="number"
                                min="0"
                                max="999"
                                value="{{ $lowStockThreshold }}"
                                class="w-28 rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-white outline-none focus:border-amber-300/60"
                            >
                        </div>
                        <button
                            type="submit"
                            class="rounded-xl border border-amber-300/25 bg-amber-500/10 px-4 py-2 text-sm text-amber-200 transition hover:bg-amber-500/20"
                        >
                            Zmień próg
                        </button>
                    </form>
                </div>

                @if($lowStockProducts->isEmpty())
                    <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-8 text-center text-emerald-200">
                        Wszystkie modele mają bezpieczny stan magazynowy.
                    </div>
                @else
                    <div class="admin-low-stock-scroll grid max-h-[34rem] gap-4 overflow-y-auto pr-2 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($lowStockProducts as $product)
                            @php
                                $isOutOfStock = (int) $product->stock_quantity === 0;
                            @endphp

                            <div class="rounded-2xl border {{ $isOutOfStock ? 'border-red-400/25 bg-red-500/10' : 'border-amber-400/25 bg-amber-500/10' }} p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-white font-semibold leading-snug">{{ $product->name }}</p>
                                        <p class="mt-1 text-xs text-gray-400">
                                            {{ $product->category->name ?? 'Brak kategorii' }}
                                            @if($product->brand)
                                                · {{ $product->brand->name }}
                                            @endif
                                        </p>
                                    </div>

                                    <span class="shrink-0 rounded-full border px-3 py-1 text-xs font-bold uppercase {{ $isOutOfStock ? 'border-red-300/30 text-red-200 bg-red-500/15' : 'border-amber-300/30 text-amber-200 bg-amber-500/15' }}">
                                        {{ $isOutOfStock ? 'Brak' : 'Mało' }}
                                    </span>
                                </div>

                                <div class="mt-5 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500">Na stanie</p>
                                        <p class="text-3xl text-white">{{ number_format($product->stock_quantity) }}</p>
                                    </div>

                                    <a href="{{ route('admin', ['action' => 'add-product', 'edit_id' => $product->id]) }}"
                                       class="rounded-xl border border-cyan-400/20 bg-cyan-500/10 px-4 py-2 text-sm text-cyan-200 transition hover:bg-cyan-500/20">
                                        Edytuj
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section id="reklamacje" class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-purple-400 text-xl font-bruno">Reklamacje i zwroty</h2>
                        <p class="text-sm text-gray-400">Lista zgłoszeń z nazwą użytkownika, powodem i opisem.</p>
                    </div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gray-500">Przewijanie włączone</span>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500">Wszystkie zgłoszenia</p>
                        <p class="mt-2 text-3xl text-white">{{ number_format($complaintStats['all']) }}</p>
                    </div>
                    <div class="rounded-2xl border border-cyan-400/20 bg-cyan-500/10 p-4">
                        <p class="text-xs uppercase tracking-[0.25em] text-cyan-200/70">Reklamacje</p>
                        <p class="mt-2 text-3xl text-white">{{ number_format($complaintStats['complaints']) }}</p>
                    </div>
                    <div class="rounded-2xl border border-fuchsia-400/20 bg-fuchsia-500/10 p-4">
                        <p class="text-xs uppercase tracking-[0.25em] text-fuchsia-200/70">Zwroty</p>
                        <p class="mt-2 text-3xl text-white">{{ number_format($complaintStats['returns']) }}</p>
                    </div>
                </div>

                <form action="{{ route('admin') }}#reklamacje" method="GET" class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    @if(request()->filled('low_stock_threshold'))
                        <input type="hidden" name="low_stock_threshold" value="{{ request('low_stock_threshold') }}">
                    @endif

                    <div class="grid gap-4 xl:grid-cols-[1fr_1fr_0.8fr_0.9fr_auto_auto] xl:items-end">
                        <div>
                            <label for="complaint_name" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                Imię i nazwisko
                            </label>
                            <input
                                id="complaint_name"
                                name="complaint_name"
                                type="text"
                                value="{{ request('complaint_name') }}"
                                placeholder="np. Jan Kowalski"
                                class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white placeholder:text-white/35 outline-none transition focus:border-cyan-300/60 focus:bg-cyan-400/5"
                            >
                        </div>

                        <div>
                            <label for="complaint_email" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                E-mail
                            </label>
                            <input
                                id="complaint_email"
                                name="complaint_email"
                                type="text"
                                value="{{ request('complaint_email') }}"
                                placeholder="np. klient@email.pl"
                                class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white placeholder:text-white/35 outline-none transition focus:border-cyan-300/60 focus:bg-cyan-400/5"
                            >
                        </div>

                        <div>
                            <label for="complaint_type" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                Typ
                            </label>
                            <select
                                id="complaint_type"
                                name="complaint_type"
                                class="admin-filter-select w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition focus:border-purple-300/60"
                            >
                                <option value="">Wszystkie</option>
                                <option value="Reklamacja" @selected(request('complaint_type') === 'Reklamacja')>Reklamacja</option>
                                <option value="Zwrot" @selected(request('complaint_type') === 'Zwrot')>Zwrot</option>
                            </select>
                        </div>

                        <div>
                            <label for="complaint_status" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                Status
                            </label>
                            <select
                                id="complaint_status"
                                name="complaint_status"
                                class="admin-filter-select w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition focus:border-purple-300/60"
                            >
                                <option value="">Wszystkie</option>
                                <option value="oczekujące" @selected(request('complaint_status') === 'oczekujące')>Oczekujące</option>
                                <option value="zaakceptowane" @selected(request('complaint_status') === 'zaakceptowane')>Zaakceptowane</option>
                                <option value="odrzucone" @selected(request('complaint_status') === 'odrzucone')>Odrzucone</option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="rounded-xl border border-purple-300/25 bg-purple-600/40 px-5 py-3 text-sm font-bold text-white transition hover:bg-purple-500/60 hover:shadow-[0_0_18px_rgba(168,85,247,0.35)]"
                        >
                            Filtruj
                        </button>

                        <a
                            href="{{ route('admin', request()->filled('low_stock_threshold') ? ['low_stock_threshold' => request('low_stock_threshold')] : []) }}#reklamacje"
                            class="rounded-xl border border-cyan-300/20 bg-cyan-500/10 px-5 py-3 text-center text-sm font-bold text-cyan-200 transition hover:bg-cyan-500/20"
                        >
                            Reset
                        </a>
                    </div>
                </form>

                <div class="admin-record-scroll space-y-4 max-h-[34rem] overflow-y-auto pr-2">
                    @forelse ($complaints as $complaint)
                        @php
                            $complaintStatusClasses = match ($complaint->status) {
                                'zaakceptowane' => 'border-emerald-400/25 bg-emerald-500/10 shadow-[0_0_24px_rgba(16,185,129,0.14)]',
                                'odrzucone' => 'border-red-400/25 bg-red-500/10 shadow-[0_0_24px_rgba(248,113,113,0.14)]',
                                default => 'border-cyan-400/25 bg-cyan-500/10 shadow-[0_0_24px_rgba(34,211,238,0.14)]',
                            };

                            $complaintStatusTextClasses = match ($complaint->status) {
                                'zaakceptowane' => 'text-emerald-200',
                                'odrzucone' => 'text-red-200',
                                default => 'text-cyan-200',
                            };
                        @endphp

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="flex flex-col lg:flex-row lg:items-start gap-5">
                                <div class="lg:w-64 shrink-0">
                                    <p class="text-white text-lg">{{ $complaint->customer_name }}</p>
                                    <p class="text-sm text-gray-400">{{ $complaint->email ?? 'Brak adresu e-mail' }}</p>
                                    <p class="mt-3 text-xs uppercase tracking-[0.25em] text-gray-500">
                                        Zamówienie #{{ $complaint->order_id ?? 'brak' }}
                                    </p>
                                   <div class="mt-3 flex flex-wrap items-center gap-2">
                                       <span class="rounded-full border px-3 py-1 text-xs font-bold uppercase {{ $complaint->type_label === 'Zwrot' ? 'border-fuchsia-300/30 bg-fuchsia-500/15 text-fuchsia-100' : 'border-cyan-300/30 bg-cyan-500/15 text-cyan-100' }}">
                                           {{ $complaint->type_label }}
                                        </span>
                                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-300">
                                            {{ $complaint->order_created_at_label }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex-1 grid gap-4 md:grid-cols-2">
                                    <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-2">Powód</p>
                                        <p class="text-gray-100">{{ $complaint->reason ?: 'Brak powodu' }}</p>
                                    </div>

                                    <div class="rounded-2xl p-4 md:col-span-1 {{ $complaintStatusClasses }}">
                                        <p class="text-xs uppercase tracking-[0.25em] mb-2 {{ $complaintStatusTextClasses }}">Status</p>
                                        <p class="text-lg font-semibold {{ $complaintStatusTextClasses }}">{{ $complaint->status_label }}</p>
                                    </div>

                                    <div class="rounded-2xl border border-white/10 bg-black/20 p-4 md:col-span-2">
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-2">Opis</p>
                                        <p class="text-gray-200 whitespace-pre-line">{{ $complaint->description ?: 'Brak opisu reklamacji.' }}</p>
                                    </div>
                                    @if($complaint->latest_message)
                                        <div class="mt-4 rounded-2xl border border-cyan-400/15 bg-cyan-500/10 p-4">
                                            <p class="text-xs uppercase tracking-[0.25em] text-cyan-200/70 mb-2">
                                                Ostatnia wiadomość
                                            </p>

                                            <p class="text-cyan-50 whitespace-pre-line">
                                                {{ $complaint->latest_message['message'] }}
                                            </p>
                                        </div>
                                    @endif

                                    <div
                                        id="chat-history-{{ $complaint->id }}"
                                        class="hidden mt-4 space-y-3"
                                    >

                                        <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                            <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-4">
                                                Historia konwersacji
                                            </p>

                                            <div class="space-y-3">

                                                @forelse($complaint->messages as $message)

                                                    <div class="
                                                        rounded-2xl p-4 border
                                                        {{ $message['sender_type'] === 'admin'
                                                            ? 'ml-8 border-cyan-400/20 bg-cyan-500/10'
                                                            : 'mr-8 border-fuchsia-400/20 bg-fuchsia-500/10'
                                                        }}
                                                    ">

                                                        <div class="flex items-center justify-between gap-3 mb-2">

                                                            <span class="
                                                                text-xs uppercase tracking-[0.25em]
                                                                {{ $message['sender_type'] === 'admin'
                                                                    ? 'text-cyan-200'
                                                                    : 'text-fuchsia-200'
                                                                }}
                                                            ">
                                                                {{ $message['sender_type'] === 'admin'
                                                                    ? 'Administrator'
                                                                    : 'Klient'
                                                                }}
                                                            </span>

                                                            <span class="text-[11px] text-gray-400">
                                                                {{ $message['created_at'] }}
                                                            </span>

                                                        </div>

                                                        <p class="text-white whitespace-pre-line">
                                                            {{ $message['message'] }}
                                                        </p>

                                                    </div>

                                                @empty

                                                    <div class="text-sm text-gray-500">
                                                        Brak wiadomości.
                                                    </div>

                                                @endforelse

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="flex lg:flex-col gap-3 lg:w-44">
                                    <button
                                        type="button"
                                        data-complaint-action-open
                                        data-action-url="{{ route('admin.complaints.update', $complaint->id) }}"
                                        data-action-type="respond"
                                        data-action-title="Odpowiedź do klienta"
                                        data-action-label="Wyślij odpowiedź"
                                        class="flex-1 rounded-xl border border-cyan-400/20 px-4 py-2 text-sm text-cyan-200 bg-cyan-500/10 transition hover:bg-cyan-500/20"
                                    >
                                        Odpowiedz
                                    </button>
                                    <button
                                        type="button"
                                        data-complaint-action-open
                                        data-action-url="{{ route('admin.complaints.update', $complaint->id) }}"
                                        data-action-type="accept"
                                        data-action-title="Akceptacja zgłoszenia"
                                        data-action-label="Akceptuj"
                                        class="flex-1 rounded-xl border border-emerald-400/20 px-4 py-2 text-sm text-emerald-200 bg-emerald-500/10 transition hover:bg-emerald-500/20"
                                    >
                                        Akceptuj
                                    </button>
                                    <button
                                        type="button"
                                        data-complaint-action-open
                                        data-action-url="{{ route('admin.complaints.update', $complaint->id) }}"
                                        data-action-type="reject"
                                        data-action-title="Odrzucenie zgłoszenia"
                                        data-action-label="Odrzuć"
                                        class="flex-1 rounded-xl border border-red-400/20 px-4 py-2 text-sm text-red-200 bg-red-500/10 transition hover:bg-red-500/20"
                                    >
                                        Odrzuć
                                    </button>
                                    <button
                                        type="button"
                                        onclick="toggleChatHistory({{ $complaint->id }})"
                                        class="rounded-full border border-cyan-400/20 bg-cyan-500/10 px-3 py-1 text-xs text-cyan-200 transition hover:bg-cyan-500/20"
                                    >
                                        Historia czatu
                                    </button>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-white/10 p-10 text-center text-gray-500">
                            Brak reklamacji do wyświetlenia.
                        </div>
                    @endforelse
                </div>

            </section>

            <section id="uzytkownicy" class="bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 lg:p-8 shadow-xl space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-purple-400 text-xl font-bruno">Użytkownicy</h2>
                        <p class="text-sm text-gray-400">Status kont oraz szybkie akcje zawieszenia i bana.</p>
                    </div>
                    <span class="text-xs uppercase tracking-[0.3em] text-gray-500">Przewijanie włączone</span>
                </div>

                <form action="{{ route('admin') }}#uzytkownicy" method="GET" class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    @if(request()->filled('low_stock_threshold'))
                        <input type="hidden" name="low_stock_threshold" value="{{ request('low_stock_threshold') }}">
                    @endif

                    <div class="grid gap-4 lg:grid-cols-[1fr_1fr_0.8fr_auto_auto] lg:items-end">
                        <div>
                            <label for="user_name" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                Imię i nazwisko
                            </label>
                            <input
                                id="user_name"
                                name="user_name"
                                type="text"
                                value="{{ request('user_name') }}"
                                placeholder="np. Jan Kowalski"
                                class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white placeholder:text-white/35 outline-none transition focus:border-cyan-300/60 focus:bg-cyan-400/5"
                            >
                        </div>

                        <div>
                            <label for="user_email" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                E-mail
                            </label>
                            <input
                                id="user_email"
                                name="user_email"
                                type="text"
                                value="{{ request('user_email') }}"
                                placeholder="np. klient@email.pl"
                                class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white placeholder:text-white/35 outline-none transition focus:border-cyan-300/60 focus:bg-cyan-400/5"
                            >
                        </div>

                        <div>
                            <label for="user_status" class="mb-2 block text-[10px] uppercase tracking-[0.25em] text-gray-500">
                                Status
                            </label>
                            <select
                                id="user_status"
                                name="user_status"
                                class="admin-filter-select w-full rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition focus:border-purple-300/60"
                            >
                                <option value="">Wszystkie</option>
                                <option value="aktywny" @selected(request('user_status') === 'aktywny')>Aktywny</option>
                                <option value="zawieszony" @selected(request('user_status') === 'zawieszony')>Zawieszony</option>
                                <option value="zbanowany" @selected(request('user_status') === 'zbanowany')>Zbanowany</option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="rounded-xl border border-purple-300/25 bg-purple-600/40 px-5 py-3 text-sm font-bold text-white transition hover:bg-purple-500/60 hover:shadow-[0_0_18px_rgba(168,85,247,0.35)]"
                        >
                            Filtruj
                        </button>

                        <a
                            href="{{ route('admin', request()->filled('low_stock_threshold') ? ['low_stock_threshold' => request('low_stock_threshold')] : []) }}#uzytkownicy"
                            class="rounded-xl border border-cyan-300/20 bg-cyan-500/10 px-5 py-3 text-center text-sm font-bold text-cyan-200 transition hover:bg-cyan-500/20"
                        >
                            Reset
                        </a>
                    </div>
                </form>

                <div class="admin-record-scroll space-y-4 max-h-[34rem] overflow-y-auto pr-2">
                    @forelse ($users as $user)
                        @php
                            $statusClasses = match ($user->account_status) {
                                'zawieszony' => 'border-amber-400/20 bg-amber-500/10 text-amber-200',
                                'zbanowany' => 'border-red-400/20 bg-red-500/10 text-red-200',
                                default => 'border-emerald-400/20 bg-emerald-500/10 text-emerald-200',
                            };
                        @endphp

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                                <div class="flex-1 grid gap-4 md:grid-cols-3">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-2">Imię i nazwisko</p>
                                        <p class="text-white">{{ $user->full_name }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-2">E-mail</p>
                                        <p class="text-gray-200 break-all">{{ $user->email }}</p>
                                    </div>

                                    <div>
                                        <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-2">Status</p>
                                        <span class="inline-flex rounded-full border px-3 py-1 text-sm capitalize {{ $statusClasses }}">
                                            {{ $user->account_status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 lg:w-[480px]">
                                    <form method="POST" action="{{ route('admin.users.unban', $user->id) }}" data-admin-confirm data-confirm-title="Odblokować konto?" data-confirm-message="Czy na pewno chcesz odblokować konto {{ $user->email }}?">
                                        @csrf
                                        <button
                                            type="submit"
                                            @disabled($user->account_status === 'aktywny')
                                            class="inline-flex min-h-12 w-full items-center justify-center rounded-xl border border-cyan-400/20 bg-cyan-500/10 px-4 py-2 text-center text-sm leading-tight text-cyan-200 transition enabled:hover:bg-cyan-500/20 disabled:opacity-40 disabled:cursor-not-allowed"
                                        >
                                            Odblokuj
                                        </button>
                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.suspend', $user->id) }}"
                                        data-admin-confirm
                                        data-confirm-title="{{ $user->account_status === 'zbanowany' ? 'Zmienić ban na zawieszenie?' : 'Zawiesić konto?' }}"
                                        data-confirm-message="{{ $user->account_status === 'zbanowany' ? 'Czy na pewno chcesz zmienić ban konta ' . $user->email . ' na zawieszenie na 7 dni?' : 'Czy na pewno chcesz zawiesić konto ' . $user->email . ' na 7 dni?' }}"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            @disabled($user->account_status === 'zawieszony')
                                            class="inline-flex min-h-12 w-full items-center justify-center rounded-xl border border-amber-400/20 bg-amber-500/10 px-4 py-2 text-center text-sm leading-tight text-amber-200 transition enabled:hover:bg-amber-500/20 disabled:opacity-40 disabled:cursor-not-allowed"
                                        >
                                            Zawieś na 7 dni
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.users.ban', $user->id) }}" data-admin-confirm data-confirm-title="Zbanować konto?" data-confirm-message="Czy na pewno chcesz zbanować konto {{ $user->email }} bezterminowo?">
                                        @csrf
                                        <button
                                            type="submit"
                                            @disabled($user->account_status === 'zbanowany')
                                            class="inline-flex min-h-12 w-full items-center justify-center rounded-xl border border-red-400/20 bg-red-500/10 px-4 py-2 text-center text-sm leading-tight text-red-200 transition enabled:hover:bg-red-500/20 disabled:opacity-40 disabled:cursor-not-allowed"
                                        >
                                            Ban bezterminowy
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-white/10 p-10 text-center text-gray-500">
                            Brak użytkowników do wyświetlenia.
                        </div>
                    @endforelse
                </div>

            </section>
        @endif
    </div>

    <aside class="w-full xl:w-[260px] xl:sticky xl:top-8 self-start bg-black/40 backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-xl">
        <h2 class="text-white text-xl mb-6 font-bruno">Menu</h2>
        <div class="flex flex-col gap-3 text-sm uppercase tracking-[0.25em] text-purple-300">
            <a href="{{ route('admin') }}#sklep" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Sklep</a>
            <a href="{{ route('admin') }}#konta" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Konta</a>
            <a href="{{ route('admin') }}#statystyki" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Statystyki</a>
            <a href="{{ route('admin') }}#wykresy" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Wykresy</a>
            <a href="{{ route('admin') }}#stany-magazynowe" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Stany</a>
            <a href="{{ route('admin') }}#reklamacje" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Reklamacje</a>
            <a href="{{ route('admin') }}#uzytkownicy" class="rounded-xl border border-transparent px-3 py-2 hover:text-white hover:border-white/10 hover:bg-white/5 transition">Użytkownicy</a>
            <hr class="border-white/10 my-2">
           <a href="{{ route('admin', ['action' => 'add-product']) }}"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition">
                <i class="fa-solid fa-plus text-cyan-400"></i>
                <span>Dodaj produkt</span>
            </a>
        </div>
    </aside>
</div>

<div id="complaint-action-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/70 px-4 backdrop-blur-sm" aria-hidden="true">
    <form method="POST" id="complaint-action-form" class="w-full max-w-xl rounded-3xl border border-white/10 bg-slate-950/95 p-6 shadow-[0_24px_70px_rgba(0,0,0,0.55)]">
        @csrf
        <input type="hidden" name="action_type" id="complaint-action-type" value="respond">

        <p class="text-[10px] uppercase tracking-[0.35em] text-cyan-300">Reklamacje i zwroty</p>
        <h2 id="complaint-action-title" class="mt-2 text-xl text-white font-bruno">Odpowiedź do klienta</h2>
        <p class="mt-3 text-sm leading-6 text-gray-300">
            Wpisz treść decyzji. Klient zobaczy ją w swoim profilu przy tym zgłoszeniu.
        </p>

        <label for="complaint-action-response" class="mt-5 mb-2 block text-xs uppercase tracking-[0.25em] text-gray-500">
            Decyzja / odpowiedź
        </label>
        <textarea
            id="complaint-action-response"
            name="admin_response"
            rows="6"
            required
            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition focus:border-cyan-300/60 focus:ring-2 focus:ring-cyan-300/20"
            placeholder="Napisz odpowiedź dla klienta..."
        ></textarea>

        <div class="mt-7 grid grid-cols-2 gap-3">
            <button
                type="button"
                id="complaint-action-cancel"
                class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-gray-200 transition hover:bg-white/10"
            >
                Anuluj
            </button>
            <button
                type="submit"
                id="complaint-action-submit"
                class="rounded-xl border border-purple-300/30 bg-purple-600/80 px-4 py-3 text-sm font-bold text-white transition hover:bg-purple-500"
            >
                Wyślij odpowiedź
            </button>
        </div>
    </form>
</div>

<div id="admin-confirm-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/70 px-4 backdrop-blur-sm" aria-hidden="true">
    <div class="w-full max-w-md rounded-3xl border border-white/10 bg-slate-950/95 p-6 shadow-[0_24px_70px_rgba(0,0,0,0.55)]">
        <p id="admin-confirm-title" class="text-xl text-white font-bruno">Potwierdź akcję</p>
        <p id="admin-confirm-message" class="mt-4 text-sm leading-6 text-gray-300">Czy na pewno chcesz wykonać tę akcję?</p>

        <div class="mt-7 grid grid-cols-2 gap-3">
            <button
                type="button"
                id="admin-confirm-cancel"
                class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-gray-200 transition hover:bg-white/10"
            >
                Anuluj
            </button>
            <button
                type="button"
                id="admin-confirm-submit"
                class="rounded-xl border border-purple-300/30 bg-purple-600/80 px-4 py-3 text-sm font-bold text-white transition hover:bg-purple-500"
            >
                Potwierdź
            </button>
        </div>
    </div>
</div>

<script>

function toggleChatHistory(id)
{
    const element = document.getElementById('chat-history-' + id);

    if (!element) {
        return;
    }

    element.classList.toggle('hidden');
}

</script>
@endsection
