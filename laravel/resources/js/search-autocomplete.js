const hideSuggestions = (box) => {
    box.classList.add('hidden');
    box.innerHTML = '';
};

const escapeHtml = (value) => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

const showSuggestions = (box, input, suggestions) => {
    if (!suggestions.length) {
        hideSuggestions(box);
        return;
    }

    box.innerHTML = suggestions.map((name) => `
        <button
            type="button"
            class="search-suggestion-item"
            role="option"
            data-product-name="${escapeHtml(name)}"
        >
            ${escapeHtml(name)}
        </button>
    `).join('');

    box.classList.remove('hidden');

    box.querySelectorAll('.search-suggestion-item').forEach((button) => {
        button.addEventListener('mousedown', (event) => {
            event.preventDefault();
            input.value = button.dataset.productName || button.textContent.trim();
            hideSuggestions(box);
            input.form?.submit();
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('site-search-input');
    const box = document.getElementById('site-search-suggestions');

    if (!input || !box || !input.dataset.suggestionsUrl) {
        return;
    }

    let timeoutId;
    let controller;

    input.addEventListener('input', () => {
        clearTimeout(timeoutId);
        controller?.abort();

        const phrase = input.value.trim();
        const minimumLength = Number(input.dataset.minimumLength || 2);
        const requestDelay = Number(input.dataset.requestDelay || 1000);

        if (phrase.length < minimumLength) {
            hideSuggestions(box);
            return;
        }

        timeoutId = setTimeout(async () => {
            controller?.abort();
            controller = new AbortController();

            const url = new URL(input.dataset.suggestionsUrl, window.location.origin);
            url.searchParams.set('search', phrase);

            try {
                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                    signal: controller.signal,
                });

                if (!response.ok) {
                    hideSuggestions(box);
                    return;
                }

                const suggestions = await response.json();
                showSuggestions(box, input, Array.isArray(suggestions) ? suggestions : []);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    hideSuggestions(box);
                }
            }
        }, requestDelay);
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            hideSuggestions(box);
        }
    });

    input.addEventListener('blur', () => {
        setTimeout(() => hideSuggestions(box), 120);
    });
});
