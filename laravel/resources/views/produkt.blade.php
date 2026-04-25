@extends('app')

@section('content')
@php
    $productPage = [
        'name' => 'Samsung 1TB M.2 PCIe Gen5 NVMe 990 EVO PLUS',
        'price' => '699.00',
        'capacity' => '1000 GB',
        'interface' => 'PCIe NVMe 5.0 x2',
        'read_speed' => '7150 MB/s',
        'write_speed' => '6300 MB/s',
        'rating' => 4.89,
        'image' => asset('images/products/storage/GOODRAM_512GB_M.2.jpg'),
        'description' => 'Poznaj nowa generacje wydajnosci z dyskiem Samsung 990 EVO PLUS, ktory zapewnia sekwencyjny odczyt danych az do 7 150 MB/s. To zauwazalny wzrost szybkosci wzgledem poprzednika. Zwarta konstrukcja M.2, pojemnosc 1 TB i technologia Intelligent TurboWrite 2.0 sprawiaja, ze model dobrze odnajdzie sie zarowno w komputerze do pracy, jak i w wydajnym zestawie gamingowym.',
        'specs' => [
            ['label' => 'Przeznaczenie produktu', 'value' => 'PC'],
            ['label' => 'Pojemnosc', 'value' => '1000 GB'],
            ['label' => 'Format', 'value' => 'M.2'],
            ['label' => 'Interfejs', 'value' => 'PCIe NVMe 5.0 x2'],
            ['label' => 'Max. predkosc odczytu', 'value' => '7150 MB/s'],
            ['label' => 'Min. predkosc zapisu', 'value' => '6300 MB/s'],
            ['label' => 'Kontroler', 'value' => 'Samsung in-house controller'],
            ['label' => 'Radiator', 'value' => 'Nie'],
        ],
        'reviews' => [
            [
                'author' => 'BARTUS2137',
                'content' => 'Mega kosta, teraz moge grac w Fortnite bez przyciec. Start systemu jest blyskawiczny, a kopiowanie duzych plikow wreszcie ma sens.',
                'stars' => 5,
            ],
            [
                'author' => 'Adam',
                'content' => 'System uruchamia sie bardzo szybko, a dysk nie lapie zadyszek przy wiekszych plikach. Cena moglaby byc troche nizsza, ale wydajnosc robi swoje.',
                'stars' => 4,
            ],
            [
                'author' => 'TechFan89',
                'content' => 'Bardzo dobry dysk pod nowa platforme. Montaz bezproblemowy, temperatury w normie, a transfery w codziennym uzyciu sa wyraznie lepsze niz w starszym NVMe.',
                'stars' => 5,
            ],
        ],
    ];

    $topSpecs = [
        ['label' => 'Pojemnosc', 'value' => $productPage['capacity']],
        ['label' => 'Interfejs', 'value' => $productPage['interface']],
        ['label' => 'Predkosc odczytu', 'value' => $productPage['read_speed']],
        ['label' => 'Predkosc zapisu', 'value' => $productPage['write_speed']],
    ];

    $rating = $productPage['rating'];
    $ratingSegments = [];

    for ($segment = 0; $segment < 5; $segment++) {
        $segmentFill = max(0, min(1, $rating - $segment));
        $ratingSegments[] = round($segmentFill, 2);
    }

    $ratingColorSegments = array_map(static function ($segmentFill) {
        if ($segmentFill >= 1) {
            return 1;
        }

        if ($segmentFill <= 0) {
            return 0;
        }

        return round(floor($segmentFill * 10) / 10, 1);
    }, $ratingSegments);

    $reviewStars = array_map(static fn ($review) => (int) $review['stars'], $productPage['reviews']);
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

    .product-button[disabled] {
        opacity: 0.3;
        cursor: default;
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

<section
    class="product-shell mx-auto flex w-full max-w-6xl flex-col gap-6 text-[#f2f4ff]"
    data-review-widget
    data-reviews='@json($productPage["reviews"])'
>
    <div class="px-4 md:px-6">
        <h1 class="mx-auto max-w-4xl text-center text-2xl leading-tight md:text-[2rem]">
            {{ $productPage['name'] }}
        </h1>
    </div>

    <section class="grid gap-6 xl:grid-cols-[1.35fr_0.8fr] xl:items-stretch">
        <article class="product-panel flex p-6 md:p-10 xl:min-h-[34rem]">
            <div class="mx-auto flex w-full items-center justify-center rounded-[1.75rem] border border-white/8 bg-white p-6 shadow-[inset_0_0_0_1px_rgba(255,255,255,0.1)]">
                <img
                    src="{{ $productPage['image'] }}"
                    alt="{{ $productPage['name'] }}"
                    class="block h-auto max-h-[26rem] w-auto max-w-full object-contain"
                >
            </div>
        </article>

        <aside class="flex flex-col gap-6 xl:h-full">
            <div class="product-panel p-6 md:p-7 xl:flex-1">
                <h2 class="mb-5 text-center text-[1.55rem] text-[#8b89ff]">Specyfikacje</h2>
                <dl class="grid gap-3">
                    @foreach ($topSpecs as $spec)
                        <div class="flex items-center justify-between gap-4">
                            <dt class="product-label">{{ $spec['label'] }}:</dt>
                            <dd class="product-value text-right">{{ $spec['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="product-panel flex flex-col justify-between gap-6 p-6 md:p-7 xl:flex-1">
                <div class="flex flex-1 flex-col items-center justify-center gap-3 rounded-[1.5rem] border border-white/10 bg-white/5 px-5 py-6 text-center">
                    <p class="text-sm uppercase tracking-[0.2em] text-white/65">Cena</p>
                    <p class="whitespace-nowrap text-center text-[2.5rem] font-semibold leading-none md:text-[3.7rem]">{{ $productPage['price'] }} zl</p>
                </div>
                <button type="button" class="product-button w-full text-lg">Dodaj do koszyka</button>
            </div>
        </aside>
    </section>

    <article class="product-panel p-6 md:p-8">
        <h2 class="mb-4 text-center text-xl text-[#8b89ff] md:text-[2rem]">{{ $productPage['name'] }}</h2>
        <p class="product-description mx-auto max-w-4xl text-sm leading-7 text-white/90 md:text-base" data-description-text>
            {{ $productPage['description'] }}
        </p>

        <div class="mt-6 flex justify-center">
            <button type="button" class="product-button min-w-[13rem]" data-description-toggle>Rozwin</button>
        </div>
    </article>

    <article id="specyfikacja" class="product-panel p-6 md:p-8">
        <h2 class="mb-6 text-2xl text-[#7e86ff] md:pl-6 md:text-[2.15rem]">Specyfikacja</h2>

        <div class="mx-auto flex max-w-5xl flex-col gap-0" data-spec-list>
            @foreach ($productPage['specs'] as $index => $spec)
                <div class="spec-row {{ $index >= 5 ? 'spec-hidden' : '' }}" @if ($index >= 5) data-spec-extra @endif>
                    <span class="product-label">{{ $spec['label'] }}</span>
                    <span class="product-value text-right">{{ $spec['value'] }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            <button type="button" class="product-button min-w-[13rem]" data-spec-toggle>Rozwin</button>
        </div>
    </article>

    <article class="product-panel p-6 md:p-8">
        <h2 class="mb-6 text-2xl text-[#7e86ff] md:pl-6 md:text-[2.15rem]">Opinie</h2>

        <div class="grid items-center gap-8 md:grid-cols-[0.8fr_1.2fr]">
            <div class="flex justify-center text-6xl md:text-[5.5rem]">
                {{ number_format($productPage['rating'], 2) }}
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
        <div class="grid gap-4 md:grid-cols-[1fr_auto]">
            <div>
                <p class="mb-3 text-sm uppercase tracking-[0.12em] text-white/85" data-review-author>{{ $productPage['reviews'][0]['author'] }}</p>

                <div class="rounded-xl border border-white/25 bg-white/3 p-4">
                    <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-start">
                        <p class="text-sm leading-7 text-white/92 md:text-base" data-review-content>{{ $productPage['reviews'][0]['content'] }}</p>

                        <div class="flex justify-center md:justify-end">
                            <div class="segmented-star small" data-review-star>
                                <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false">
                                    <defs>
                                        <polygon id="review-star-arm-shape" points="50,50 38,33 50,6 62,33" />
                                    </defs>
                                    @for ($i = 0; $i < 5; $i++)
                                        @php
                                            $reviewSegmentStyle = '--arm-fill:' . ($i < $reviewStars[0] ? '1' : '0') . ';';
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
                    <button type="button" class="comment-arrow flex h-[4.6rem] w-[4.6rem] items-center justify-center self-center md:mt-auto" data-review-next>&#9662;</button>
                </div>
            </div>
        </div>
    </article>

    <article class="product-panel p-4 md:p-5">
        <p class="mb-3 text-lg text-white/90">Adam</p>

        <form class="grid gap-4">
            <textarea
                rows="6"
                placeholder="Text..."
                class="w-full rounded-xl border border-white/25 bg-white/4 px-4 py-3 text-white placeholder:text-white/45 focus:outline-none"
            ></textarea>

            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex items-center gap-2">
                    @for ($i = 0; $i < 5; $i++)
                        <span class="text-4xl leading-none text-white/92">&#9734;</span>
                    @endfor
                </div>

                <button type="submit" class="product-button min-w-[11rem] self-end">Opublikuj</button>
            </div>
        </form>
    </article>
</section>

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

                specToggle.textContent = specsExpanded ? 'Zwin' : 'Rozwin';
            });
        }

        const reviewWidget = document.querySelector('[data-review-widget]');

        if (!reviewWidget) {
            return;
        }

        const reviews = JSON.parse(reviewWidget.dataset.reviews || '[]');
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
