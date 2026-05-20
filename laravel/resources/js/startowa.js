const carouselPositions = {
    recommended: 0,
    promo: 0,
};

const getCarouselParts = (id) => {
    const track = document.getElementById(`${id}-track`);
    const container = document.getElementById(`${id}-container`);
    const items = track?.querySelectorAll('.carousel-item') ?? [];

    return { track, container, items };
};

const updateArrows = (id, maxScroll) => {
    const prevBtn = document.getElementById(`${id}-prev`);
    const nextBtn = document.getElementById(`${id}-next`);

    if (!prevBtn || !nextBtn) {
        return;
    }

    const current = carouselPositions[id] ?? 0;

    prevBtn.style.opacity = current <= 0 ? '0' : '0.4';
    prevBtn.style.pointerEvents = current <= 0 ? 'none' : 'auto';

    nextBtn.style.opacity = current >= maxScroll ? '0' : '0.4';
    nextBtn.style.pointerEvents = current >= maxScroll ? 'none' : 'auto';
};

const refreshCarousel = (id) => {
    const { track, container } = getCarouselParts(id);

    if (!track || !container) {
        return;
    }

    const maxScroll = Math.max(0, track.scrollWidth - container.offsetWidth);

    if ((carouselPositions[id] ?? 0) > maxScroll) {
        carouselPositions[id] = maxScroll;
    }

    track.style.transform = `translateX(-${carouselPositions[id] ?? 0}px)`;
    updateArrows(id, maxScroll);
};

const moveCarousel = (id, direction) => {
    const { track, container, items } = getCarouselParts(id);

    if (!track || !container || !items.length) {
        return;
    }

    const gap = 40;
    const itemWidth = items[0].offsetWidth + gap;
    const maxScroll = Math.max(0, track.scrollWidth - container.offsetWidth);

    carouselPositions[id] = (carouselPositions[id] ?? 0) + direction * itemWidth;
    carouselPositions[id] = Math.max(0, Math.min(carouselPositions[id], maxScroll));

    track.style.transform = `translateX(-${carouselPositions[id]}px)`;
    updateArrows(id, maxScroll);
};

const escapeHtml = (value) => String(value ?? '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

const displayFilterValue = (value) => {
    const normalized = String(value ?? '').toLowerCase();

    if (normalized === 'true') {
        return 'Posiada';
    }

    if (normalized === 'false' || normalized === '0') {
        return 'Nie posiada';
    }

    return value;
};

const normalizeSearchPhrase = (value) => String(value ?? '')
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .trim();

const initHomeFilters = () => {
    const filterForm = document.getElementById('home-filter-form');

    if (!filterForm) {
        return;
    }

    const categorySelect = filterForm.querySelector('select[name="category_id"]');
    const sortSelect = filterForm.querySelector('select[name="sort"]');
    const minPriceInput = filterForm.querySelector('input[name="min_price"]');
    const maxPriceInput = filterForm.querySelector('input[name="max_price"]');
    const brandToggle = filterForm.querySelector('[data-brand-dropdown-toggle]');
    const brandDropdown = document.getElementById('home-brand-dropdown');
    const brandSearch = document.getElementById('home-brand-search');
    const brandOptions = document.getElementById('home-brand-options');
    const hiddenSelectedBrands = document.getElementById('home-brand-hidden-selected');
    const brandSummary = document.getElementById('home-brand-summary');
    const brandIcon = filterForm.querySelector('[data-brand-dropdown-icon]');
    const attributesContainer = document.getElementById('home-attribute-filters');
    const filterDataElement = document.getElementById('home-filter-data');
    let filterData = { allBrands: [], categories: {} };

    if (filterDataElement?.textContent) {
        try {
            filterData = JSON.parse(filterDataElement.textContent);
        } catch (error) {
            filterData = { allBrands: [], categories: {} };
        }
    }

    const selectedBrandIds = new Set(
        Array.from(brandOptions?.querySelectorAll('input[name="brands[]"]:checked') ?? [])
            .map((input) => input.value),
    );

    const renderHiddenSelectedBrands = (visibleIds = new Set()) => {
        if (!hiddenSelectedBrands) {
            return;
        }

        hiddenSelectedBrands.innerHTML = Array.from(selectedBrandIds)
            .filter((brandId) => !visibleIds.has(String(brandId)))
            .map((brandId) => `<input type="hidden" name="brands[]" value="${escapeHtml(brandId)}">`)
            .join('');
    };

    const updateBrandSummary = () => {
        if (!brandSummary) {
            return;
        }

        brandSummary.textContent = selectedBrandIds.size ? `Wybrano marek: ${selectedBrandIds.size}` : 'Wybierz marki';
    };

    const setBrandDropdownOpen = (isOpen) => {
        if (!brandDropdown) {
            return;
        }

        brandDropdown.classList.toggle('hidden', !isOpen);

        if (brandIcon) {
            brandIcon.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        }
    };

    const renderBrands = (categoryId) => {
        if (!brandOptions) {
            return;
        }

        const categoryData = filterData.categories?.[categoryId];
        const brands = categoryId && categoryData ? categoryData.brands : filterData.allBrands;
        const phrase = normalizeSearchPhrase(brandSearch?.value);
        const visibleBrands = phrase.length >= 1
            ? brands.filter((brand) => normalizeSearchPhrase(brand.name).includes(phrase))
            : brands;

        if (!brands?.length) {
            brandOptions.innerHTML = '<p class="col-span-full rounded-xl border border-dashed border-white/10 bg-white/[0.03] px-3 py-3 text-xs text-white/45">Brak marek dla tej kategorii.</p>';
            renderHiddenSelectedBrands();
            updateBrandSummary();
            return;
        }

        if (!visibleBrands.length) {
            brandOptions.innerHTML = '<p class="col-span-full rounded-xl border border-dashed border-white/10 bg-white/[0.03] px-3 py-3 text-xs text-white/45">Nie znaleziono marki dla tej frazy.</p>';
            renderHiddenSelectedBrands();
            updateBrandSummary();
            return;
        }

        const visibleIds = new Set(visibleBrands.map((brand) => String(brand.id)));

        brandOptions.innerHTML = visibleBrands.map((brand) => `
            <label class="flex items-center gap-3 rounded-xl border border-white/5 bg-white/[0.03] px-3 py-2 cursor-pointer group transition hover:border-purple-400/40 hover:bg-purple-500/10">
                <input type="checkbox" name="brands[]" value="${escapeHtml(brand.id)}" ${selectedBrandIds.has(String(brand.id)) ? 'checked' : ''} class="w-3 h-3 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500">
                <span class="text-xs text-white/60 group-hover:text-white transition">${escapeHtml(brand.name)}</span>
            </label>
        `).join('');

        renderHiddenSelectedBrands(visibleIds);
        updateBrandSummary();
    };

    const renderAttributes = (categoryId) => {
        if (!attributesContainer) {
            return;
        }

        const attributes = filterData.categories?.[categoryId]?.attributes ?? [];

        if (!categoryId) {
            attributesContainer.innerHTML = `
                <div class="rounded-2xl border border-dashed border-white/10 bg-white/5 p-5 text-sm text-gray-400">
                    Wybierz kategorię, aby zobaczyć filtry atrybutów.
                </div>
            `;
            return;
        }

        if (!attributes.length) {
            attributesContainer.innerHTML = `
                <div class="rounded-2xl border border-dashed border-white/10 bg-white/5 p-5 text-sm text-gray-400">
                    Ta kategoria nie ma dodatkowych filtrów.
                </div>
            `;
            return;
        }

        attributesContainer.innerHTML = `
            <div class="space-y-5">
                <p class="text-[10px] text-gray-400 uppercase tracking-[0.25em] font-bold">Atrybuty kategorii</p>
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    ${attributes.map((attribute) => `
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="mb-3 text-[10px] text-purple-300 uppercase tracking-[0.2em] font-bold">
                                ${escapeHtml(attribute.display_name)}
                            </p>
                            <div class="space-y-2">
                                ${(attribute.values ?? []).map((value, index) => `
                                    <label class="home-filter-option flex items-center gap-3 group cursor-pointer ${index >= 3 ? 'hidden' : ''}" ${index >= 3 ? `data-filter-extra="${escapeHtml(attribute.id)}"` : ''}>
                                        <input type="checkbox" name="attrs[${escapeHtml(attribute.id)}][]" value="${escapeHtml(value.id)}" class="w-3 h-3 rounded border-white/20 bg-white/5 text-cyan-400 focus:ring-cyan-400">
                                        <span class="text-[11px] text-white/65 group-hover:text-cyan-300 transition uppercase font-bruno">
                                            ${escapeHtml(displayFilterValue(value.value))}
                                        </span>
                                    </label>
                                `).join('')}
                            </div>
                            ${(attribute.values?.length ?? 0) > 3 ? `
                                <button type="button" data-filter-toggle="${escapeHtml(attribute.id)}" class="mt-3 text-[10px] text-cyan-300 hover:text-white transition uppercase font-bold">
                                    + Pokaż więcej (${attribute.values.length - 3})
                                </button>
                            ` : ''}
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    };

    filterForm.addEventListener('click', (event) => {
        const toggleButton = event.target.closest('[data-filter-toggle]');

        if (!toggleButton || !filterForm.contains(toggleButton)) {
            return;
        }

        const attributeId = toggleButton.dataset.filterToggle;
        const hiddenOptions = filterForm.querySelectorAll(`[data-filter-extra="${attributeId}"]`);
        const isOpening = Array.from(hiddenOptions).some((option) => option.classList.contains('hidden'));

        hiddenOptions.forEach((option) => {
            option.classList.toggle('hidden', !isOpening);
        });

        toggleButton.textContent = isOpening ? '- Pokaż mniej' : `+ Pokaż więcej (${hiddenOptions.length})`;
    });

    brandToggle?.addEventListener('click', () => {
        setBrandDropdownOpen(brandDropdown?.classList.contains('hidden') ?? false);
    });

    brandOptions?.addEventListener('change', (event) => {
        if (!event.target.matches('input[name="brands[]"]')) {
            return;
        }

        if (event.target.checked) {
            selectedBrandIds.add(event.target.value);
        } else {
            selectedBrandIds.delete(event.target.value);
        }

        renderBrands(categorySelect?.value ?? '');
    });

    brandSearch?.addEventListener('input', () => {
        renderBrands(categorySelect?.value ?? '');
    });

    document.addEventListener('click', (event) => {
        if (!brandDropdown || brandDropdown.classList.contains('hidden')) {
            return;
        }

        if (!brandDropdown.contains(event.target) && !brandToggle?.contains(event.target)) {
            setBrandDropdownOpen(false);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setBrandDropdownOpen(false);
        }
    });

    categorySelect?.addEventListener('change', () => {
        filterForm.querySelectorAll('input[name="brands[]"], input[name^="attrs["]').forEach((input) => {
            input.checked = false;
        });
        selectedBrandIds.clear();

        if (minPriceInput) {
            minPriceInput.value = '';
        }

        if (maxPriceInput) {
            maxPriceInput.value = '';
        }

        if (sortSelect) {
            sortSelect.value = 'newest';
        }

        if (brandSearch) {
            brandSearch.value = '';
        }

        renderBrands(categorySelect.value);
        renderAttributes(categorySelect.value);
        setBrandDropdownOpen(false);
    });

    updateBrandSummary();
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-carousel][data-carousel-direction]').forEach((button) => {
        button.addEventListener('click', () => {
            moveCarousel(button.dataset.carousel, Number(button.dataset.carouselDirection));
        });
    });

    ['recommended', 'promo'].forEach(refreshCarousel);

    window.addEventListener('resize', () => {
        ['recommended', 'promo'].forEach(refreshCarousel);
    });

    initHomeFilters();
});
