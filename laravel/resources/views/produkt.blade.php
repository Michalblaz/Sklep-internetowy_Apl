@extends('app')

@section('content')
@php
    $panelClass = 'relative overflow-hidden rounded-[2rem] border border-[rgba(123,213,255,0.14)] bg-[linear-gradient(145deg,rgba(82,101,115,0.88),rgba(20,59,86,0.92)_44%,rgba(30,37,82,0.96)_100%)] shadow-[0_24px_60px_rgba(5,9,29,0.45),inset_0_1px_0_rgba(255,255,255,0.06)]';
    $panelGlowClass = 'after:pointer-events-none after:absolute after:bottom-[-40%] after:right-[-12%] after:h-[18rem] after:w-[18rem] after:rounded-full after:bg-[radial-gradient(circle,rgba(154,96,255,0.28),transparent_68%)] max-lg:after:h-56 max-lg:after:w-56';
    $panelCardClass = $panelClass . ' ' . $panelGlowClass;
    $buttonClass = 'w-60 py-3 bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold rounded-full transition';
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
        @if (session('success'))
            <div class="rounded-[1.8rem] border border-emerald-400/40 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100" data-page-flash-success>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-[1.8rem] border border-rose-400/40 bg-rose-500/10 px-5 py-4 text-sm text-rose-100" data-page-flash-error>
                {{ session('error') }}
            </div>
        @endif

        <div class="hidden rounded-[1.8rem] px-5 py-4 text-sm" data-observed-notice></div>

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

                    <div class="flex items-center gap-3">
                        <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">

                            <button type="submit" class="{{ $buttonClass }} profile-direct-cart-btn relative z-10 w-full shrink-0 py-3 text-base">
                                Do koszyka
                            </button>
                        </form>

                        <button
                            type="button"
                            id="open-wishlist-modal-btn"
                            class="flex h-[3.2rem] w-[3.2rem] shrink-0 items-center justify-center rounded-full border transition {{ $isObserved ? 'border-rose-300/45 bg-rose-500/15 text-rose-300 shadow-[0_0_18px_rgba(244,63,94,0.25)]' : 'border-white/15 bg-white/5 text-white/80 hover:bg-white/10' }}"
                        >
                            <span class="text-[1.45rem] leading-none" id="wishlist-heart-icon">{{ $isObserved ? '♥' : '♡' }}</span>
                        </button>
                    </div>
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
                <p class="mb-3 text-lg text-white/90">{{ $currentUserReview ? 'Edytuj opinię' : 'Dodaj opinię' }}</p>

                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-400/30 bg-red-500/15 px-4 py-3 text-sm text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form class="grid gap-4" action="{{ route('products.reviews.store', $product->id) }}" method="POST" data-review-form>
                    @csrf
                    <textarea
                        name="comment"
                        rows="6"
                        placeholder="Treść opinii..."
                        class="w-full rounded-xl border border-white/25 bg-white/4 px-4 py-3 text-white placeholder:text-white/45 focus:outline-none"
                    >{{ old('comment', $currentUserReview->comment ?? '') }}</textarea>

                    <input type="hidden" name="rating" value="{{ old('rating', $currentUserReview->rating ?? '') }}" data-rating-input>

                    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div class="flex items-center gap-2" data-rating-stars>
                            @for ($i = 0; $i < 5; $i++)
                                <button
                                    type="button"
                                    class="text-4xl leading-none text-white/45 transition hover:scale-105"
                                    data-rating-star
                                    data-value="{{ $i + 1 }}"
                                    aria-label="Oceń na {{ $i + 1 }} gwiazdek"
                                >&#9734;</button>
                            @endfor
                        </div>

                        <button type="submit" class="{{ $buttonClass }} min-w-[11rem] self-end opacity-30" data-review-submit disabled>
                            {{ $currentUserReview ? 'Zapisz zmiany' : 'Opublikuj' }}
                        </button>
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


<div id="wishlistModal" style="display: none !important;" class="fixed inset-0 z-50 items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="relative mx-4 w-full max-w-md rounded-2xl border border-gray-700 bg-[#1a202c] p-6 text-white shadow-[0_24px_60px_rgba(0,0,0,0.5)]">
        <h3 class="mb-4 font-bruno text-xl text-[#8b89ff]">Dodaj do listy obserwowanych</h3>
        <p class="mb-4 text-sm text-gray-400">Wybierz listę, do której chcesz dodać produkt, lub utwórz nową.</p>

        <form id="wishlist-form">
            @csrf
            <div id="wishlist-options-container" class="mb-5 max-h-48 space-y-2 overflow-y-auto pr-2">
                <div class="text-sm text-gray-500">Ładowanie list...</div>
            </div>

            <div class="mb-6 border-t border-white/10 pt-5">
                <label class="mb-2 block text-sm font-semibold text-gray-300">...albo stwórz nową listę</label>
                <input type="text" id="wishlist-new-name" name="new_list_name" placeholder="Np. Sprzęt do biura"
                       class="w-full rounded-xl border border-white/20 bg-black/30 px-4 py-3 text-sm text-white placeholder:text-white/40 focus:border-purple-400 focus:outline-none focus:ring-1 focus:ring-purple-400">
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeWishlistModal()" class="w-1/2 rounded-full border border-white/20 bg-transparent px-4 py-3 text-sm font-bold transition hover:bg-white/10">
                    Anuluj
                </button>
                <button type="submit" class="w-1/2 rounded-full bg-linear-to-r from-indigo-500 to-purple-600 px-4 py-3 text-sm font-bold text-white transition hover:scale-[1.02]">
                    Zapisz
                </button>
            </div>
        </form>

        <button type="button" onclick="closeWishlistModal()" class="absolute right-4 top-4 text-xl text-gray-400 hover:text-white">✕</button>
    </div>
</div>

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
function closeModal() {
    const modal = document.getElementById('cartModal');
    if (modal) {
        modal.style.setProperty('display', 'none', 'important');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const cartModal = document.getElementById('cartModal');

    if (cartModal) {
        cartModal.addEventListener('click', function (event) {
            if (event.target === this) {
                closeModal();
            }
        });
    }

    document.querySelectorAll('.profile-direct-cart-btn').forEach((button) => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const form = this.closest('form');
            if (!form) {
                return;
            }

            const formData = new FormData(form);
            const token = form.querySelector('input[name="_token"]')?.value || document.querySelector('input[name="_token"]')?.value;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (!data.success) {
                        return;
                    }

                    const modal = document.getElementById('cartModal');
                    const recContainer = document.getElementById('modal-recommendations');

                    if (recContainer && data.recommended) {
                        recContainer.innerHTML = '';

                        data.recommended.forEach((item) => {
                            const basePrice = parseFloat(item.base_price);
                            const promoPrice = item.promo_price ? parseFloat(item.promo_price) : null;
                            const hasDiscount = promoPrice && basePrice > 0;
                            const discountPercent = hasDiscount ? Math.round(((basePrice - promoPrice) / basePrice) * 100) : 0;

                            const cardHtml = `
                                <div class="group relative flex h-full flex-col justify-between rounded-xl border border-white/5 bg-black/40 p-3 transition duration-300 hover:border-purple-500/40">
                                    <div>
                                        <div class="relative mb-2 flex aspect-square w-full items-center justify-center overflow-hidden rounded-lg bg-white/5">
                                            <img src="/images/${item.image_url}" alt="${item.name}" class="h-4/5 w-4/5 object-contain transition duration-300 group-hover:scale-105">
                                            ${hasDiscount ? `<span class="absolute right-1 top-1 animate-pulse rounded-md bg-red-600 px-1.5 py-0.5 text-[9px] font-bold text-white">-${discountPercent}%</span>` : ''}
                                        </div>

                                        <h5 class="line-clamp-2 h-8 text-xs font-bold uppercase tracking-tighter text-white/80 transition group-hover:text-purple-400">
                                            <a href="/produkt/${item.id}">${item.name}</a>
                                        </h5>
                                    </div>

                                    <div class="mt-2">
                                        <div class="mb-2 text-xs">
                                            ${hasDiscount ? `
                                                <span class="font-black text-green-400">${promoPrice.toFixed(2).replace('.', ',')} zł</span>
                                                <span class="block text-[10px] text-gray-500 line-through">${basePrice.toFixed(2).replace('.', ',')} zł</span>
                                            ` : `
                                                <span class="font-black text-white">${basePrice.toFixed(2).replace('.', ',')} zł</span>
                                            `}
                                        </div>

                                        <a href="/produkt/${item.id}" class="block w-full rounded-lg border border-purple-500/30 bg-purple-900/40 py-1.5 text-center text-[10px] font-bold text-purple-300 transition duration-200 hover:border-purple-500 hover:bg-purple-600 hover:text-white">
                                            Zobacz produkt
                                        </a>
                                    </div>
                                </div>
                            `;

                            recContainer.insertAdjacentHTML('beforeend', cardHtml);
                        });
                    }

                    if (modal) {
                        modal.style.setProperty('display', 'flex', 'important');
                    }
                })
                .catch((error) => console.error('Błąd:', error));
        });
    });
});


function closeWishlistModal() {
    const modal = document.getElementById('wishlistModal');
    if (modal) modal.style.setProperty('display', 'none', 'important');
}
    const openWishlistBtn = document.getElementById('open-wishlist-modal-btn');
    const wishlistModal = document.getElementById('wishlistModal');
    const wishlistForm = document.getElementById('wishlist-form');
    const optionsContainer = document.getElementById('wishlist-options-container');
    const productId = '{{ $product ? $product->id : '' }}';

    if (openWishlistBtn && wishlistModal) {
        wishlistModal.addEventListener('click', function(e) {
            if (e.target === this) closeWishlistModal();
        });

        openWishlistBtn.addEventListener('click', () => {
            @if(!auth()->check())
                window.location.href = '{{ route("log_in") }}';
                return;
            @endif

            wishlistModal.style.setProperty('display', 'flex', 'important');
            optionsContainer.innerHTML = '<div class="text-sm text-gray-500">Ładowanie list...</div>';
            document.getElementById('wishlist-new-name').value = '';

            fetch(`/products/${productId}/wishlists`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    optionsContainer.innerHTML = '';
                    if (data.wishlists.length > 0) {
                        data.wishlists.forEach(list => {
                            const isChecked = data.active_ids.includes(list.id);
                            optionsContainer.innerHTML += `
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border ${isChecked ? 'border-purple-500/50 bg-purple-500/10' : 'border-white/10 bg-white/5'} p-3 hover:border-purple-400/50 transition">
                                    <input type="radio" name="wishlist_id" value="${list.id}" class="h-4 w-4 accent-purple-500">
                                    <span class="text-sm font-medium ${isChecked ? 'text-purple-300' : 'text-white'}">
                                        ${list.name} ${isChecked ? '<span class="text-xs text-purple-400 ml-1 font-normal">- Kliknij zapisz by usunąć</span>' : ''}
                                    </span>
                                </label>
                            `;
                        });
                    } else {
                        optionsContainer.innerHTML = '<div class="text-sm text-purple-300/80">Nie masz jeszcze żadnych list. Utwórz nową poniżej.</div>';
                    }
                }
            });
        });

        wishlistForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(wishlistForm);

            fetch(`/products/${productId}/wishlists`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeWishlistModal();

                    const btn = document.getElementById('open-wishlist-modal-btn');
                    const icon = document.getElementById('wishlist-heart-icon');

                    if (data.isObserved) {
                        btn.className = 'flex h-[3.2rem] w-[3.2rem] shrink-0 items-center justify-center rounded-full border transition border-rose-300/45 bg-rose-500/15 text-rose-300 shadow-[0_0_18px_rgba(244,63,94,0.25)]';
                        icon.innerHTML = '♥';
                    } else {
                        btn.className = 'flex h-[3.2rem] w-[3.2rem] shrink-0 items-center justify-center rounded-full border transition border-white/15 bg-white/5 text-white/80 hover:bg-white/10';
                        icon.innerHTML = '♡';
                    }
                } else {
                    alert(data.message);
                }
            });
        });
    }

</script>
@endsection
