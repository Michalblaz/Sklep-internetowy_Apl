const COOKIE_NOTICE_KEY = 'techblef_cookie_notice_seen';

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('cookie-notice-modal');

    if (!modal) {
        return;
    }

    const openTriggers = document.querySelectorAll('[data-cookie-open]');
    const closeTriggers = modal.querySelectorAll('[data-cookie-close], [data-cookie-accept]');
    const acceptButton = modal.querySelector('[data-cookie-accept]');

    const openModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        acceptButton?.focus({ preventScroll: true });
    };

    const closeModal = () => {
        localStorage.setItem(COOKIE_NOTICE_KEY, '1');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
    };

    openTriggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            openModal();
        });
    });

    closeTriggers.forEach((trigger) => {
        trigger.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
            closeModal();
        }
    });

    if (!localStorage.getItem(COOKIE_NOTICE_KEY)) {
        openModal();
    }
});
