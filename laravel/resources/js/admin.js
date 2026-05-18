const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

const buildScaleTicks = (maxValue) => Array.from(new Set([
    maxValue,
    Math.round(maxValue * 0.66),
    Math.round(maxValue * 0.33),
    0,
]));

const renderBars = (items, maxValue, chartColors) => {
    return items.map((item, index) => {
        const height = Math.max(20, Math.round(((Number(item.value) || 0) / maxValue) * 198));
        const label = escapeHtml(item.label ?? 'Brak nazwy');
        const value = Number(item.value) || 0;
        const color = chartColors[index % chartColors.length];

        const productId = item.id;
        const editUrl = `?action=add-product&edit_id=${productId}`;

        return `
            <div class="group relative w-[96px] shrink-0 rounded-2xl px-3 pt-2 pb-3 text-center transition hover:bg-white/5">
                <div class="h-[250px] flex flex-col justify-end items-center">

                    <div class="pointer-events-none group-hover:pointer-events-auto absolute left-1/2 top-2 z-20 hidden -translate-x-1/2 rounded-xl border border-cyan-300/20 bg-slate-950/95 px-3 py-3 text-left shadow-xl group-hover:block min-w-[120px]">
                        <p class="text-[11px] leading-4 text-white font-bold mb-1">${label}</p>
                        <p class="text-[10px] leading-4 text-cyan-300 mb-3">Dostępne: ${value} szt.</p>

                        <button
                            onclick="window.location.href='${editUrl}'"
                            class="w-full bg-cyan-500 hover:bg-cyan-400 text-black text-[9px] font-bold py-1.5 rounded uppercase tracking-wider transition-colors"
                        >
                            Edytuj produkt
                        </button>
                    </div>

                    <span class="mb-2 text-[11px] font-semibold text-gray-200">${value}</span>

                    <div
                        class="w-12 rounded-t-xl border border-white/15 shadow-[0_0_20px_rgba(0,0,0,0.18)] transition-all duration-150 group-hover:-translate-y-1 group-hover:brightness-110"
                        style="height: ${height}px; background: linear-gradient(180deg, ${color} 0%, rgba(15, 23, 42, 0.9) 100%);"
                    ></div>
                </div>
                <span class="admin-chart-label absolute left-1/1 top-full mt-4 ml-6 block w-50 origin-top-left text-left text-[12px] leading-[1.15rem] text-gray-200">${label}</span>
            </div>
        `;
    }).join('');
};

const renderChartFrame = (items, maxValue, chartColors) => {
    const scaleTicks = buildScaleTicks(maxValue);

    return `
        <div class="mb-8 flex items-start justify-between gap-4">
            <p class="text-xs uppercase tracking-[0.28em] text-gray-400">Ilość produktów</p>
            <p class="text-[11px] text-gray-500">Najedź na słupek, aby zobaczyć szczegóły</p>
        </div>
        <div class="relative min-w-max pb-36 pt-3">
            <div class="absolute left-0 top-0 bottom-28 w-14">
                ${scaleTicks.map((tick, index) => {
                    const position = scaleTicks.length > 1 ? (index / (scaleTicks.length - 1)) * 100 : 0;
                    return `<span class="absolute right-2 -translate-y-1/2 text-[11px] text-gray-400" style="top: ${position}%;">${tick}</span>`;
                }).join('')}
            </div>

            <div class="ml-14 min-w-max">
                <div class="relative flex h-[250px] min-h-[250px] items-end gap-5 border-l border-b border-white/20 px-4 pr-6">
                    ${scaleTicks.map((tick, index) => {
                        const position = scaleTicks.length > 1 ? (index / (scaleTicks.length - 1)) * 100 : 0;
                        const borderClass = tick === 0 ? 'border-white/20' : 'border-dashed border-white/10';
                        return `<div class="pointer-events-none absolute left-0 right-0 border-t ${borderClass}" style="top: ${position}%;"></div>`;
                    }).join('')}
                    ${renderBars(items, maxValue, chartColors)}
                </div>
            </div>
        </div>
    `;
};

const initAdminConfirmModal = () => {
    const modal = document.getElementById('admin-confirm-modal');
    const title = document.getElementById('admin-confirm-title');
    const message = document.getElementById('admin-confirm-message');
    const confirmButton = document.getElementById('admin-confirm-submit');
    const cancelButton = document.getElementById('admin-confirm-cancel');
    const forms = document.querySelectorAll('[data-admin-confirm]');

    if (!modal || !title || !message || !confirmButton || !cancelButton || !forms.length) {
        return;
    }

    let pendingForm = null;

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        pendingForm = null;
    };

    const openModal = (form) => {
        pendingForm = form;
        title.textContent = form.dataset.confirmTitle || 'Potwierdź akcję';
        message.textContent = form.dataset.confirmMessage || 'Czy na pewno chcesz wykonać tę akcję?';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        confirmButton.focus();
    };

    forms.forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            openModal(form);
        });
    });

    confirmButton.addEventListener('click', () => {
        if (pendingForm) {
            pendingForm.submit();
        }
    });

    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    initAdminConfirmModal();

    const categoryChart = document.getElementById('category-chart');
    const modelChart = document.getElementById('model-chart');
    const emptyState = document.getElementById('model-chart-empty');
    const title = document.getElementById('model-chart-title');
    const chartData = document.getElementById('admin-chart-data');

    if (!categoryChart || !modelChart || !emptyState || !title || !chartData) {
        return;
    }

    let modelsByCategory = {};
    let chartColors = [];

    try {
        modelsByCategory = JSON.parse(chartData.dataset.models ?? '{}');
    } catch (error) {
        modelsByCategory = {};
    }

    try {
        chartColors = JSON.parse(chartData.dataset.colors ?? '[]');
    } catch (error) {
        chartColors = [];
    }

    if (!chartColors.length) {
        chartColors = ['#38bdf8'];
    }

    const buttons = Array.from(categoryChart.querySelectorAll('.category-bar'));

    const renderModelChart = (categoryId, categoryName) => {
        const items = modelsByCategory[categoryId] || [];
        title.textContent = `Stany magazynowe modeli: ${categoryName}`;

        buttons.forEach((button) => {
            const active = button.dataset.categoryId === String(categoryId);
            button.classList.toggle('is-active', active);
            button.classList.toggle('bg-white/10', active);
            button.classList.toggle('shadow-[0_0_0_1px_rgba(56,189,248,0.55)]', active);
            const bar = button.querySelector('.chart-bar');
            if (bar) {
                bar.classList.toggle('ring-2', active);
                bar.classList.toggle('ring-cyan-300/70', active);
            }
        });

        if (!items.length) {
            modelChart.innerHTML = '';
            modelChart.classList.add('hidden');
            emptyState.classList.remove('hidden');
            emptyState.textContent = `Brak modeli do wyświetlenia dla kategorii ${categoryName}.`;
            return;
        }

        const maxValue = Math.max(...items.map((item) => Number(item.value) || 0), 1);
        modelChart.innerHTML = renderChartFrame(items, maxValue, chartColors);
        emptyState.classList.add('hidden');
        modelChart.classList.remove('hidden');
    };

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            renderModelChart(button.dataset.categoryId, button.dataset.categoryName || 'Wybrana kategoria');
        });
    });

    if (buttons.length > 0) {
        const firstButton = buttons[0];
        renderModelChart(firstButton.dataset.categoryId, firstButton.dataset.categoryName || 'Wybrana kategoria');
    }
});
