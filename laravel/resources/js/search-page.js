const carouselPositions = { recommended: 0 };

function escapeHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function closeCartModal() {
    const modal = document.getElementById('cartModal');
    if (modal) {
        modal.style.setProperty('display', 'none', 'important');
    }
}

function updateArrows(id, maxScroll) {
    const prevBtn = document.getElementById(`${id}-prev`);
    const nextBtn = document.getElementById(`${id}-next`);
    const current = carouselPositions[id] || 0;

    if (prevBtn) {
        prevBtn.style.opacity = current <= 0 ? '0' : '0.4';
        prevBtn.style.pointerEvents = current <= 0 ? 'none' : 'auto';
    }

    if (nextBtn) {
        nextBtn.style.opacity = current >= maxScroll ? '0' : '0.4';
        nextBtn.style.pointerEvents = current >= maxScroll ? 'none' : 'auto';
    }
}

function moveCarousel(id, direction) {
    const track = document.getElementById(`${id}-track`);
    const container = document.getElementById(`${id}-container`);
    const items = track?.querySelectorAll('.carousel-item') || [];

    if (!track || !container || !items.length) return;

    const itemWidth = items[0].offsetWidth + 40;
    const maxScroll = track.scrollWidth - container.offsetWidth;

    carouselPositions[id] = (carouselPositions[id] || 0) + direction * itemWidth;

    if (carouselPositions[id] < 0) carouselPositions[id] = 0;
    if (carouselPositions[id] > maxScroll) carouselPositions[id] = maxScroll;

    track.style.transform = `translateX(-${carouselPositions[id]}px)`;
    updateArrows(id, maxScroll);
}

function renderRecommendation(item) {
    const basePrice = parseFloat(item.base_price);
    const promoPrice = item.promo_price ? parseFloat(item.promo_price) : null;
    const hasDiscount = promoPrice && basePrice > 0;
    const discountPercent = hasDiscount ? Math.round(((basePrice - promoPrice) / basePrice) * 100) : 0;
    const finalPrice = hasDiscount ? promoPrice : basePrice;
    const name = escapeHtml(item.name);
    const imageUrl = escapeHtml(item.image_url);
    const productUrl = `/produkt/${encodeURIComponent(item.id)}`;

    return `
        <div class="relative bg-black/40 border border-white/5 rounded-xl p-3 flex flex-col justify-between h-full group hover:border-purple-500/40 transition duration-300">
            <div>
                <div class="w-full aspect-square bg-white/5 rounded-lg overflow-hidden mb-2 relative flex items-center justify-center">
                    <img src="/images/${imageUrl}" alt="${name}" class="object-contain w-4/5 h-4/5 group-hover:scale-105 transition duration-300">
                    ${hasDiscount ? `<span class="absolute top-1 right-1 bg-red-600 text-[9px] text-white font-bold px-1.5 py-0.5 rounded-md font-bruno animate-pulse">-${discountPercent}%</span>` : ''}
                </div>

                <h5 class="text-xs font-bold text-white/80 line-clamp-2 h-8 group-hover:text-purple-400 transition uppercase tracking-tighter">
                    <a href="${productUrl}">${name}</a>
                </h5>
            </div>

            <div class="mt-2">
                <div class="text-xs font-bruno mb-2">
                    ${hasDiscount ? `
                        <span class="text-green-400 font-black">${promoPrice.toFixed(2).replace('.', ',')} z\u0142</span>
                        <span class="text-[10px] text-gray-500 line-through block">${basePrice.toFixed(2).replace('.', ',')} z\u0142</span>
                    ` : `
                        <span class="text-white font-black">${finalPrice.toFixed(2).replace('.', ',')} z\u0142</span>
                    `}
                </div>

                <a href="${productUrl}" class="block text-center w-full py-1.5 bg-purple-900/40 hover:bg-purple-600 border border-purple-500/30 hover:border-purple-500 text-purple-300 hover:text-white text-[10px] font-bold font-bruno rounded-lg transition duration-200">
                    Zobacz produkt
                </a>
            </div>
        </div>
    `;
}

document.addEventListener('DOMContentLoaded', () => {
    const isSearchPage = document.getElementById('filter-form');

    if (!isSearchPage) return;

    document.querySelectorAll('[data-carousel][data-direction]').forEach((button) => {
        button.addEventListener('click', () => {
            moveCarousel(button.dataset.carousel, Number(button.dataset.direction || 0));
        });
    });

    document.querySelectorAll('[data-cart-modal-close]').forEach((button) => {
        button.addEventListener('click', closeCartModal);
    });

    const track = document.getElementById('recommended-track');
    const container = document.getElementById('recommended-container');
    if (track && container) {
        const maxScroll = track.scrollWidth - container.offsetWidth;
        updateArrows('recommended', maxScroll);
    }

    const filterPanel = document.getElementById('filter-panel');
    const resultsList = document.getElementById('search-results-list');
    const firstResultCard = document.querySelector('.search-result-card');

    function syncFilterPanelHeight() {
        if (!filterPanel || !resultsList || !firstResultCard || window.innerWidth < 1024) {
            if (filterPanel) {
                filterPanel.style.maxHeight = '';
                filterPanel.style.minHeight = '';
            }
            return;
        }

        const cardHeight = firstResultCard.offsetHeight;
        const resultCards = resultsList.querySelectorAll('.search-result-card').length;
        const resultListStyles = window.getComputedStyle(resultsList);
        const cardGap = parseFloat(resultListStyles.rowGap || resultListStyles.gap) || 16;
        const visibleCards = Math.min(Math.max(resultCards, 2), 8);
        const maxPanelHeight = (cardHeight * visibleCards) + (cardGap * (visibleCards - 1));

        filterPanel.style.minHeight = `${(cardHeight * 2) + cardGap}px`;
        filterPanel.style.maxHeight = `${maxPanelHeight}px`;
    }

    syncFilterPanelHeight();
    window.addEventListener('resize', syncFilterPanelHeight);

    const cartModal = document.getElementById('cartModal');
    cartModal?.addEventListener('click', (event) => {
        if (event.target === cartModal) {
            closeCartModal();
        }
    });

    document.querySelectorAll('.add-to-cart-btn').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const form = button.closest('form');
            if (!form) return;

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
                    if (!data.success) return;

                    const recContainer = document.getElementById('modal-recommendations');
                    if (recContainer && data.recommended) {
                        recContainer.innerHTML = '';
                        data.recommended.forEach((item) => {
                            recContainer.insertAdjacentHTML('beforeend', renderRecommendation(item));
                        });
                    }

                    cartModal?.style.setProperty('display', 'flex', 'important');
                })
                .catch((error) => console.error('Blad:', error));
        });
    });
});
