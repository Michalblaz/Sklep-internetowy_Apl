@extends('app')

@section('content')
@php
    $panelClass = 'relative overflow-hidden rounded-[2rem] border border-[rgba(123,213,255,0.14)] bg-[linear-gradient(145deg,rgba(82,101,115,0.88),rgba(20,59,86,0.92)_44%,rgba(30,37,82,0.96)_100%)] shadow-[0_24px_60px_rgba(5,9,29,0.45),inset_0_1px_0_rgba(255,255,255,0.06)]';
    $panelGlowClass = 'after:pointer-events-none after:absolute after:bottom-[-40%] after:right-[-12%] after:h-[18rem] after:w-[18rem] after:rounded-full after:bg-[radial-gradient(circle,rgba(154,96,255,0.28),transparent_68%)] max-lg:after:h-56 max-lg:after:w-56';
    $panelCardClass = $panelClass . ' ' . $panelGlowClass;
    $buttonClass = 'inline-flex min-h-12 items-center justify-center rounded-[0.95rem] bg-[linear-gradient(90deg,rgba(124,152,255,0.95),rgba(150,72,255,0.95))] px-[1.7rem] py-[0.8rem] text-[0.9rem] uppercase tracking-[0.04em] text-[#eef3ff] shadow-[0_0_22px_rgba(124,126,255,0.35),inset_0_0_16px_rgba(255,255,255,0.18)]';
@endphp

<style>
    .segmented-star__arm {
        fill: rgb(calc(243 * var(--arm-fill)), calc(255 * var(--arm-fill)), 0);
        stroke: rgba(6, 8, 14, 1);
        stroke-width: 1.6;
        stroke-linejoin: round;
        vector-effect: non-scaling-stroke;
    }
</style>

@if (!$product)
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 text-[#f2f4ff] max-md:text-[14px]">
        <article class="{{ $panelCardClass }} p-6 text-center md:p-8">
            <h1 class="text-2xl md:text-[2rem]">Nie znaleziono produktu</h1>
            <p class="mt-4 text-white/80">Wybrany produkt jest niedostępny lub nie istnieje.</p>
        </article>
    </section>
@else
    <section
        class="mx-auto flex w-full max-w-6xl flex-col gap-6 text-[#f2f4ff] max-md:text-[14px]"
        data-review-widget
        data-reviews='@json($reviews)'
    >
        <div class="px-4 md:px-6">
            <h1 class="mx-auto max-w-4xl text-center text-2xl leading-tight md:text-[2rem]">
                {{ $product->name }}
            </h1>
        </div>

        <section class="grid gap-6 xl:grid-cols-[1.35fr_0.8fr] xl:items-stretch">
            <article class="{{ $panelCardClass }} flex p-6 md:p-10 xl:min-h-[34rem]">
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
                <div class="{{ $panelCardClass }} p-6 md:p-7 xl:flex-1">
                    <h2 class="mb-5 text-center text-[1.55rem] text-[#8b89ff]">Szczegóły</h2>
                    <dl class="grid gap-3">
                        @forelse ($topSpecs as $spec)
                            <div class="flex items-center justify-between gap-4">
                                <dt class="text-[0.96rem] text-[rgba(235,241,255,0.94)]">{{ $spec['label'] }}:</dt>
                                <dd class="text-right text-base text-[rgba(255,255,255,0.98)]">{{ $spec['value'] }}</dd>
                            </div>
                        @empty
                            <div class="text-center text-white/70">Brak dodatkowych danych.</div>
                        @endforelse
                    </dl>
                </div>

                <div class="{{ $panelCardClass }} flex flex-col gap-4 p-5 md:p-6 xl:flex-1">
                    <div class="flex flex-col items-center justify-center gap-3 px-2 py-1 text-center">
                        <p class="text-[0.8rem] uppercase tracking-[0.18em] text-white/65">
                            {{ $hasPromotion ? 'Cena promocyjna' : 'Cena' }}
                        </p>
                        <div class="flex w-full flex-col items-center gap-[0.7rem]">
                            <p class="max-w-full whitespace-nowrap text-center text-[clamp(1.95rem,3.35vw,3.15rem)] font-semibold leading-[1.05]">
                                {{ number_format($currentPrice, 2, '.', ' ') }} zł
                            </p>
                            @if ($hasPromotion)
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    <p class="inline-flex min-h-[2.15rem] items-center justify-center whitespace-nowrap rounded-full border border-white/12 bg-[rgba(7,13,32,0.22)] px-[0.85rem] py-[0.3rem] text-[0.9rem] leading-none text-[rgba(232,238,255,0.64)] line-through decoration-[1.5px] decoration-[rgba(255,255,255,0.5)]">
                                        {{ number_format($originalPrice, 2, '.', ' ') }} zł
                                    </p>
                                    <span class="inline-flex items-center justify-center rounded-full bg-red-600/90 px-3 py-1 text-sm font-bold text-white shadow-[0_0_15px_rgba(220,38,38,0.5)]">
                                        -{{ $discountPercent }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="{{ $buttonClass }} relative z-10 w-full shrink-0 py-3 text-base">Dodaj do koszyka</button>
                </div>
            </aside>
        </section>

        <article class="{{ $panelCardClass }} hidden p-6 md:p-8">
            <h2 class="mb-4 text-center text-xl text-[#8b89ff] md:text-[2rem]">{{ $product->name }}</h2>
            <p class="mx-auto max-w-4xl text-sm leading-7 text-white/90 md:text-base">
                {{ $description }}
            </p>

            <div class="mt-6 flex justify-center">
                <button type="button" class="{{ $buttonClass }} min-w-[13rem]">Rozwiń</button>
            </div>
        </article>

        @if ($specs->isNotEmpty())
            <article id="specyfikacja" class="{{ $panelCardClass }} p-6 md:p-8">
                <h2 class="mb-6 text-2xl text-[#7e86ff] md:pl-6 md:text-[2.15rem]">Specyfikacja</h2>

                <div class="mx-auto flex max-w-5xl flex-col gap-0" data-spec-list>
                    @foreach ($specs as $index => $spec)
                        <div class="flex items-center justify-between gap-6 border-b border-white/8 py-[0.55rem] {{ $index >= 5 ? 'hidden' : 'flex' }}" @if ($index >= 5) data-spec-extra @endif>
                            <span class="text-[0.96rem] text-[rgba(235,241,255,0.94)]">{{ $spec['label'] }}</span>
                            <span class="text-right text-base text-[rgba(255,255,255,0.98)]">{{ $spec['value'] }}</span>
                        </div>
                    @endforeach
                </div>

                @if ($specs->count() > 5)
                    <div class="mt-8 flex justify-center">
                        <button type="button" class="{{ $buttonClass }} min-w-[13rem]" data-spec-toggle>Rozwiń</button>
                    </div>
                @endif
            </article>
        @endif

        <article class="{{ $panelCardClass }} p-6 md:p-8">
            <h2 class="mb-6 text-2xl text-[#7e86ff] md:pl-6 md:text-[2.15rem]">Opinie</h2>

            <div class="grid items-center gap-8 md:grid-cols-[0.8fr_1.2fr]">
                <div class="flex justify-center text-6xl md:text-[5.5rem]">
                    {{ number_format($rating, 2) }}
                </div>

                <div class="flex justify-center">
                    <div class="mx-auto aspect-square w-[15rem] max-w-full">
                        <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false" class="block h-full w-full overflow-visible">
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

        <article class="{{ $panelCardClass }} p-4 md:p-5">
            @if ($reviews->isNotEmpty())
                <div class="grid gap-4 md:grid-cols-[1fr_auto]">
                    <div>
                        <p class="mb-3 text-sm uppercase tracking-[0.12em] text-white/85" data-review-author>{{ $reviews[0]['author'] }}</p>

                        <div class="rounded-xl border border-white/25 bg-white/3 p-4">
                            <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-start">
                                <p class="text-sm leading-7 text-white/92 md:text-base" data-review-content>{{ $reviews[0]['content'] }}</p>

                                <div class="flex justify-center md:justify-end">
                                    <div class="aspect-square w-[5.25rem]" data-review-star>
                                        <svg viewBox="0 0 100 100" aria-hidden="true" focusable="false" class="block h-full w-full overflow-visible">
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
                            <button type="button" class="flex h-[4.6rem] w-[4.6rem] items-center justify-center self-center text-[4.2rem] leading-none text-[#bb8dff] transition hover:scale-105 hover:text-[#efe8ff] disabled:cursor-default disabled:text-[rgba(181,181,181,0.75)] max-md:text-[3.35rem]" data-review-prev disabled>&#9652;</button>
                            <button type="button" class="flex h-[4.6rem] w-[4.6rem] items-center justify-center self-center text-[4.2rem] leading-none text-[#bb8dff] transition hover:scale-105 hover:text-[#efe8ff] disabled:cursor-default disabled:text-[rgba(181,181,181,0.75)] max-md:mt-auto max-md:text-[3.35rem] md:mt-auto" data-review-next @if ($reviews->count() < 2) disabled @endif>&#9662;</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center text-white/75">Brak opinii dla tego produktu.</div>
            @endif
        </article>

        <article class="{{ $panelCardClass }} p-4 md:p-5">
            @if (auth()->check())
                <p class="mb-3 text-lg text-white/90">Dodaj opinię</p>

                <form class="grid gap-4" action="#" method="POST">
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

                        <button type="submit" class="{{ $buttonClass }} min-w-[11rem] self-end opacity-30" disabled>Opublikuj</button>
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

    <script src="{{ asset('js/product-page.js') }}" defer></script>
@endif
@endsection
