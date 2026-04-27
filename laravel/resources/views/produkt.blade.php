@extends('app')

@section('content')
@php
    $productId = request()->integer('product_id') ?: request()->integer('id');
    $specLabelMap = [
        'storage_capacity_gb' => 'Pojemność (GB)',
        'storage_interface' => 'Interfejs',
        'storage_type' => 'Typ nośnika',
        'storage_read_speed_mb_s' => 'Prędkość odczytu (MB/s)',
        'storage_write_speed_mb_s' => 'Prędkość zapisu (MB/s)',
        'storage_form_factor' => 'Format',
        'storage_controller' => 'Kontroler',
        'storage_has_heatsink' => 'Radiator',
        'ram_capacity_gb' => 'Pojemność (GB)',
        'ram_modules_count' => 'Liczba modułów',
        'ram_latency_cl' => 'Opóźnienie (CL)',
        'ram_type' => 'Typ pamięci',
        'ram_speed_mhz' => 'Taktowanie (MHz)',
        'cpu_cores' => 'Liczba rdzeni',
        'cpu_threads' => 'Liczba wątków',
        'cpu_base_clock_ghz' => 'Taktowanie bazowe (GHz)',
        'cpu_boost_clock_ghz' => 'Taktowanie turbo (GHz)',
        'base_clock' => 'Taktowanie bazowe (MHz)',
        'boost_clock' => 'Taktowanie turbo (MHz)',
        'cores' => 'Liczba rdzeni',
        'threads' => 'Liczba wątków',
        'cpu_type' => 'Typ procesora',
        'fan_included' => 'Chłodzenie w zestawie',
        'integrated_gpu' => 'Zintegrowany układ graficzny',
        'socket' => 'Socket',
        'gpu_memory_gb' => 'Pamięć VRAM (GB)',
        'gpu_chipset' => 'Chipset',
        'gpu_length_mm' => 'Długość (mm)',
        'psu_power_w' => 'Moc zasilacza (W)',
        'psu_wattage' => 'Moc zasilacza (W)',
        'psu_efficiency_rating' => 'Sprawność',
        'psu_standard' => 'Standard zasilacza',
        'motherboard_socket' => 'Socket',
        'motherboard_chipset' => 'Chipset',
        'board_standard' => 'Format płyty',
        'case_form_factor' => 'Obsługiwany format płyty',
        'case_type' => 'Typ obudowy',
        'max_gpu_length_mm' => 'Maks. długość GPU (mm)',
        'max_cpu_cooler_height_mm' => 'Maks. wysokość chłodzenia CPU (mm)',
        'graphics_card_series' => 'Seria karty graficznej',
        'chipset_manufacturer' => 'Producent chipsetu',
        'connector_type' => 'Typ złącza',
        'connectivity_type' => 'Typ łączności',
        'sensor_type' => 'Typ sensora',
        'switch_type' => 'Typ przełączników',
        'audio_channels' => 'Kanały audio',
        'cooler_type' => 'Typ chłodzenia',
        'network_standard' => 'Standard sieciowy',
        'interface_type' => 'Typ interfejsu',
        'monitor_resolution' => 'Rozdzielczość',
        'refresh_rate_hz' => 'Częstotliwość odświeżania (Hz)',
        'panel_type' => 'Typ matrycy',
        'screen_size_inch' => 'Przekątna ekranu (cale)',
        'fan_max_tdp' => 'Maks. TDP chłodzenia (W)',
    ];

    $product = null;
    $specs = collect();
    $reviews = collect();
    $rating = 0;
    $ratingColorSegments = array_fill(0, 5, 0);
    $topSpecs = [];
    $description = null;

    if ($productId) {
        $product = \App\Models\Product::query()
            ->with(['brand', 'category'])
            ->find($productId);
    }

    if ($product) {
        $specs = \Illuminate\Support\Facades\DB::table('product_attributes as pa')
            ->join('attribute_category as ac', 'ac.id', '=', 'pa.attribute_category_id')
            ->leftJoin('attribute_values as av', 'av.id', '=', 'pa.attribute_value_id')
            ->where('pa.product_id', $product->id)
            ->orderBy('ac.name')
            ->get([
                'ac.name as label',
                'av.value as value',
            ])
            ->map(function ($spec) use ($specLabelMap) {
                $spec->label = $specLabelMap[$spec->label] ?? $spec->label;
                if (is_string($spec->value)) {
                    $lowerValue = strtolower($spec->value);
                    if ($lowerValue === 'true') {
                        $spec->value = 'Tak';
                    } elseif ($lowerValue === 'false') {
                        $spec->value = 'Nie';
                    }
                }

                return $spec;
            })
            ->filter(static fn ($spec) => filled($spec->value))
            ->values();

        $reviews = \Illuminate\Support\Facades\DB::table('reviews as r')
            ->leftJoin('users as u', 'u.id', '=', 'r.user_id')
            ->where('r.product_id', $product->id)
            ->orderByDesc('r.created_at')
            ->get([
                'r.rating as stars',
                'r.comment as content',
                'u.first_name',
                'u.last_name',
            ])
            ->map(static function ($review) {
                $author = trim(collect([$review->first_name, $review->last_name])->filter()->implode(' '));

                return [
                    'author' => $author !== '' ? $author : 'Uzytkownik',
                    'content' => $review->content,
                    'stars' => (int) $review->stars,
                ];
            })
            ->filter(static fn ($review) => filled($review['content']))
            ->values();

        $rating = round((float) $reviews->avg('stars'), 2);

        for ($segment = 0; $segment < 5; $segment++) {
            $segmentFill = max(0, min(1, $rating - $segment));
            $ratingColorSegments[$segment] = $segmentFill >= 1
                ? 1
                : ($segmentFill <= 0 ? 0 : round(floor($segmentFill * 10) / 10, 1));
        }

        $topSpecs = array_values(array_filter([
            ['label' => 'Marka', 'value' => $product->brand->name ?? null],
            ['label' => 'Kategoria', 'value' => $product->category->name ?? null],
            ['label' => 'Stan magazynowy', 'value' => isset($product->stock_quantity) ? $product->stock_quantity : null],
            ['label' => 'Pobór mocy', 'value' => filled($product->power_draw_w) && (int) $product->power_draw_w !== 0 ? $product->power_draw_w . ' W' : null],
        ], static fn ($spec) => filled($spec['value'])));

        if (empty($topSpecs) && $specs->isNotEmpty()) {
            $topSpecs = $specs->take(4)
                ->map(fn ($spec) => ['label' => $spec->label, 'value' => $spec->value])
                ->all();
        }
    }

    $currentPrice = $product && $product->promo_price !== null && (float) $product->promo_price < (float) $product->base_price
        ? (float) $product->promo_price
        : ($product ? (float) $product->base_price : null);
    $originalPrice = $product ? (float) $product->base_price : null;
    $hasPromotion = $product && $product->promo_price !== null && (float) $product->promo_price < (float) $product->base_price;
    $imagePath = $product && filled($product->image_url) ? asset('images/' . ltrim($product->image_url, '/')) : null;
@endphp

<style>
    .product-shell {
        --panel-border: rgba(123, 213, 255, 0.14);
        --panel-shadow: 0 24px 60px rgba(5, 9, 29, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.06);
        --panel-bg: linear-gradient(145deg, rgba(82, 101, 115, 0.88), rgba(20, 59, 86, 0.92) 44%, rgba(30, 37, 82, 0.96) 100%);
    }

    .product-panel {
        position: relative;
        overflow: hidden;
        border-radius: 2rem;
        border: 1px solid var(--panel-border);
        background: var(--panel-bg);
        box-shadow: var(--panel-shadow);
    }

    .product-panel::after {
        content: "";
        position: absolute;
        right: -12%;
        bottom: -40%;
        width: 18rem;
        height: 18rem;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(154, 96, 255, 0.28), transparent 68%);
        pointer-events: none;
    }

    .product-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 3rem;
        padding: 0.8rem 1.7rem;
        border-radius: 0.95rem;
        background: linear-gradient(90deg, rgba(124, 152, 255, 0.95), rgba(150, 72, 255, 0.95));
        color: #eef3ff;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-size: 0.9rem;
        box-shadow: 0 0 22px rgba(124, 126, 255, 0.35), inset 0 0 16px rgba(255, 255, 255, 0.18);
    }

    .product-label {
        color: rgba(235, 241, 255, 0.94);
        font-size: 0.96rem;
    }

    .product-value {
        color: rgba(255, 255, 255, 0.98);
        font-size: 1rem;
    }

    .spec-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 0.55rem 0;
    }

    .spec-hidden {
        display: none;
    }

    .spec-hidden.is-visible {
        display: flex;
    }

    .product-description {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
        overflow: hidden;
    }

    .product-description.is-expanded {
        display: block;
        -webkit-line-clamp: unset;
        overflow: visible;
    }

    .segmented-star {
        width: var(--star-size, 12rem);
        aspect-ratio: 1;
        margin-inline: auto;
    }

    .segmented-star svg {
        display: block;
        width: 100%;
        height: 100%;
        overflow: visible;
    }

    .segmented-star__arm {
        fill: rgb(calc(243 * var(--arm-fill)), calc(255 * var(--arm-fill)), 0);
        stroke: rgba(6, 8, 14, 1);
        stroke-width: 1.6;
        stroke-linejoin: round;
        vector-effect: non-scaling-stroke;
    }

    .segmented-star.small {
        --star-size: 5.25rem;
    }

    .comment-arrow {
        font-size: 4.2rem;
        line-height: 1;
        color: #bb8dff;
        transition: opacity 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .comment-arrow:not([disabled]):hover {
        color: #efe8ff;
        transform: scale(1.05);
    }

    .comment-arrow[disabled] {
        color: rgba(181, 181, 181, 0.75);
        cursor: default;
    }

    .price-current {
        white-space: nowrap;
        text-align: center;
        font-size: clamp(1.95rem, 3.35vw, 3.15rem);
        font-weight: 600;
        line-height: 1.05;
        max-width: 100%;
    }

    .price-original {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 2.15rem;
        padding: 0.3rem 0.85rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(7, 13, 32, 0.22);
        color: rgba(232, 238, 255, 0.64);
        font-size: 0.9rem;
        line-height: 1;
        text-decoration: line-through;
        text-decoration-thickness: 1.5px;
        text-decoration-color: rgba(255, 255, 255, 0.5);
        white-space: nowrap;
    }

    .price-stack {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.7rem;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .product-panel::after {
            width: 14rem;
            height: 14rem;
        }
    }

    @media (max-width: 768px) {
        .product-shell {
            font-size: 14px;
        }

        .comment-arrow {
            font-size: 3.35rem;
        }
    }
</style>

@if (!$product)
    <section class="product-shell mx-auto flex w-full max-w-6xl flex-col gap-6 text-[#f2f4ff]">
        <article class="product-panel p-6 text-center md:p-8">
            <h1 class="text-2xl md:text-[2rem]">Nie znaleziono produktu</h1>
            <p class="mt-4 text-white/80">Wybrany produkt jest niedostępny lub nie istnieje.</p>
        </article>
    </section>
@else
    <section
        class="product-shell mx-auto flex w-full max-w-6xl flex-col gap-6 text-[#f2f4ff]"
        data-review-widget
        data-reviews='@json($reviews)'
    >
        <div class="px-4 md:px-6">
            <h1 class="mx-auto max-w-4xl text-center text-2xl leading-tight md:text-[2rem]">
                {{ $product->name }}
            </h1>
        </div>

        <section class="grid gap-6 xl:grid-cols-[1.35fr_0.8fr] xl:items-stretch">
            <article class="product-panel flex p-6 md:p-10 xl:min-h-[34rem]">
                <div class="mx-auto flex w-full items-center justify-center rounded-[1.75rem] border border-white/8 bg-white p-6 shadow-[inset_0_0_0_1px_rgba(255,255,255,0.1)]">
                    @if ($imagePath)
                        <img
                            src="{{ $imagePath }}"
                            alt="{{ $product->name }}"
                            class="block h-auto max-h-[26rem] w-auto max-w-full object-contain"
                        >
                    @else
                        <div class="text-center text-white/60">Brak zdjęcia</div>
                    @endif
                </div>
            </article>

            <aside class="flex flex-col gap-6 xl:h-full">
                <div class="product-panel p-6 md:p-7 xl:flex-1">
                    <h2 class="mb-5 text-center text-[1.55rem] text-[#8b89ff]">Szczegóły</h2>
                    <dl class="grid gap-3">
                        @forelse ($topSpecs as $spec)
                            <div class="flex items-center justify-between gap-4">
                                <dt class="product-label">{{ $spec['label'] }}:</dt>
                                <dd class="product-value text-right">{{ $spec['value'] }}</dd>
                            </div>
                        @empty
                            <div class="text-center text-white/70">Brak dodatkowych danych.</div>
                        @endforelse
                    </dl>
                </div>

                <div class="product-panel flex flex-col gap-4 p-5 md:p-6 xl:flex-1">
                    <div class="flex flex-col items-center justify-center gap-3 px-2 py-1 text-center">
                        <p class="text-[0.8rem] uppercase tracking-[0.18em] text-white/65">{{ $hasPromotion ? 'Cena promocyjna' : 'Cena' }}</p>
                        <div class="price-stack">
                            <p class="price-current">
                                {{ number_format($currentPrice, 2, '.', ' ') }} zł
                            </p>
                            @if ($hasPromotion)
                                <p class="price-original">
                                    {{ number_format($originalPrice, 2, '.', ' ') }} zł
                                </p>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="product-button relative z-10 w-full shrink-0 py-3 text-base">Dodaj do koszyka</button>
                </div>
            </aside>
        </section>

        <article class="product-panel hidden p-6 md:p-8">
            <h2 class="mb-4 text-center text-xl text-[#8b89ff] md:text-[2rem]">{{ $product->name }}</h2>
            <p class="product-description mx-auto max-w-4xl text-sm leading-7 text-white/90 md:text-base" data-description-text>
                {{ $description }}
            </p>

            <div class="mt-6 flex justify-center">
                <button type="button" class="product-button min-w-[13rem]" data-description-toggle>Rozwin</button>
            </div>
        </article>

        @if ($specs->isNotEmpty())
            <article id="specyfikacja" class="product-panel p-6 md:p-8">
            <h2 class="mb-6 text-2xl text-[#7e86ff] md:pl-6 md:text-[2.15rem]">Specyfikacja</h2>

                <div class="mx-auto flex max-w-5xl flex-col gap-0" data-spec-list>
                    @foreach ($specs as $index => $spec)
                        <div class="spec-row {{ $index >= 5 ? 'spec-hidden' : '' }}" @if ($index >= 5) data-spec-extra @endif>
                            <span class="product-label">{{ $spec->label }}</span>
                            <span class="product-value text-right">{{ $spec->value }}</span>
                        </div>
                    @endforeach
                </div>

                @if ($specs->count() > 5)
                    <div class="mt-8 flex justify-center">
                        <button type="button" class="product-button min-w-[13rem]" data-spec-toggle>Rozwiń</button>
                    </div>
                @endif
            </article>
        @endif

        <article class="product-panel p-6 md:p-8">
            <h2 class="mb-6 text-2xl text-[#7e86ff] md:pl-6 md:text-[2.15rem]">Opinie</h2>

            <div class="grid items-center gap-8 md:grid-cols-[0.8fr_1.2fr]">
                <div class="flex justify-center text-6xl md:text-[5.5rem]">
                    {{ number_format($rating, 2) }}
                </div>

                <div class="flex justify-center">
                    <div class="segmented-star" style="--star-size: 15rem;">
                        <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false">
                            <defs>
                                <polygon id="star-arm-shape" points="50,50 38,33 50,6 62,33" />
                            </defs>
                            @foreach ($ratingColorSegments as $segmentFill)
                                @php
                                    $segmentStyle = '--arm-fill:' . number_format($segmentFill, 2, '.', '') . ';';
                                @endphp
                                <use
                                    href="#star-arm-shape"
                                    class="segmented-star__arm"
                                    style="{{ $segmentStyle }}"
                                    transform="rotate({{ $loop->index * 72 }} 50 50)"
                                />
                            @endforeach
                        </svg>
                    </div>
                </div>
            </div>
        </article>

        <article class="product-panel p-4 md:p-5">
            @if ($reviews->isNotEmpty())
                <div class="grid gap-4 md:grid-cols-[1fr_auto]">
                    <div>
                        <p class="mb-3 text-sm uppercase tracking-[0.12em] text-white/85" data-review-author>{{ $reviews[0]['author'] }}</p>

                        <div class="rounded-xl border border-white/25 bg-white/3 p-4">
                            <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-start">
                                <p class="text-sm leading-7 text-white/92 md:text-base" data-review-content>{{ $reviews[0]['content'] }}</p>

                                <div class="flex justify-center md:justify-end">
                                    <div class="segmented-star small" data-review-star>
                                        <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false">
                                            <defs>
                                                <polygon id="review-star-arm-shape" points="50,50 38,33 50,6 62,33" />
                                            </defs>
                                            @for ($i = 0; $i < 5; $i++)
                                                @php
                                                    $reviewSegmentStyle = '--arm-fill:' . ($i < $reviews[0]['stars'] ? '1' : '0') . ';';
                                                @endphp
                                                <use
                                                    href="#review-star-arm-shape"
                                                    class="segmented-star__arm"
                                                    style="{{ $reviewSegmentStyle }}"
                                                    transform="rotate({{ $i * 72 }} 50 50)"
                                                />
                                            @endfor
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex min-h-full items-stretch justify-center md:w-[5.25rem]">
                        <div class="flex min-h-full w-full flex-row items-center justify-between md:flex-col md:items-center">
                            <button type="button" class="comment-arrow flex h-[4.6rem] w-[4.6rem] items-center justify-center self-center" data-review-prev disabled>&#9652;</button>
                            <button type="button" class="comment-arrow flex h-[4.6rem] w-[4.6rem] items-center justify-center self-center md:mt-auto" data-review-next @if ($reviews->count() < 2) disabled @endif>&#9662;</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-white/75">Brak opinii dla tego produktu.</div>
            @endif
        </article>

        <article class="product-panel p-4 md:p-5">
            @if (auth()->check())
                <p class="mb-3 text-lg text-white/90">Dodaj opinię</p>

                <form class="grid gap-4" action="#" method="POST" onsubmit="return false;">
                    <textarea
                        rows="6"
                        placeholder="Treść opinii..."
                        class="w-full rounded-xl border border-white/25 bg-white/4 px-4 py-3 text-white placeholder:text-white/45 focus:outline-none"
                    ></textarea>

                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div class="flex items-center gap-2">
                            @for ($i = 0; $i < 5; $i++)
                                <span class="text-4xl leading-none text-white/92">&#9734;</span>
                            @endfor
                        </div>

                        <button type="submit" class="product-button min-w-[11rem] self-end" disabled>Opublikuj</button>
                    </div>
                </form>
            @else
                <div class="py-4 text-center text-white/85">
                    <a href="{{ route('log_in') }}" class="text-white underline decoration-white/60 underline-offset-4 hover:text-[#cfd8ff]">Zaloguj się</a>
                    aby zostawić ocenę.
                </div>
            @endif
        </article>
    </section>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const descriptionText = document.querySelector('[data-description-text]');
        const descriptionToggle = document.querySelector('[data-description-toggle]');
        let descriptionExpanded = false;

        if (descriptionText && descriptionToggle) {
            descriptionToggle.addEventListener('click', () => {
                descriptionExpanded = !descriptionExpanded;
                descriptionText.classList.toggle('is-expanded', descriptionExpanded);
                descriptionToggle.textContent = descriptionExpanded ? 'Zwin' : 'Rozwin';
            });
        }

        const specToggle = document.querySelector('[data-spec-toggle]');
        const extraSpecs = document.querySelectorAll('[data-spec-extra]');
        let specsExpanded = false;

        if (specToggle && extraSpecs.length) {
            specToggle.addEventListener('click', () => {
                specsExpanded = !specsExpanded;

                extraSpecs.forEach((item) => {
                    item.classList.toggle('is-visible', specsExpanded);
                });

                specToggle.textContent = specsExpanded ? 'Zwiń' : 'Rozwiń';
            });
        }

        const reviewWidget = document.querySelector('[data-review-widget]');

        if (!reviewWidget) {
            return;
        }

        const reviews = JSON.parse(reviewWidget.dataset.reviews || '[]');

        if (!reviews.length) {
            return;
        }

        const authorNode = reviewWidget.querySelector('[data-review-author]');
        const contentNode = reviewWidget.querySelector('[data-review-content]');
        const starNode = reviewWidget.querySelector('[data-review-star]');
        const starArms = starNode ? Array.from(starNode.querySelectorAll('.segmented-star__arm')) : [];
        const prevButton = reviewWidget.querySelector('[data-review-prev]');
        const nextButton = reviewWidget.querySelector('[data-review-next]');
        let currentReviewIndex = 0;

        const syncReview = () => {
            const review = reviews[currentReviewIndex];

            if (!review || !authorNode || !contentNode || !prevButton || !nextButton) {
                return;
            }

            authorNode.textContent = review.author;
            contentNode.textContent = review.content;

            starArms.forEach((arm, index) => {
                arm.style.setProperty('--arm-fill', index < review.stars ? '1' : '0');
            });

            prevButton.disabled = currentReviewIndex === 0;
            nextButton.disabled = currentReviewIndex === reviews.length - 1;
        };

        prevButton?.addEventListener('click', () => {
            if (currentReviewIndex === 0) {
                return;
            }

            currentReviewIndex -= 1;
            syncReview();
        });

        nextButton?.addEventListener('click', () => {
            if (currentReviewIndex >= reviews.length - 1) {
                return;
            }

            currentReviewIndex += 1;
            syncReview();
        });

        syncReview();
    });
</script>
@endsection
