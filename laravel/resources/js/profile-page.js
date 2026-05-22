document.addEventListener('DOMContentLoaded', () => {
    const profileForm = document.getElementById('profile-form');
    const profileSubmitButton = document.getElementById('profile-submit-button');
    const profileToggleEditButton = document.getElementById('profile-toggle-edit-button');
    const passwordSection = document.getElementById('password-section');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const passwordMismatchMessage = document.getElementById('password-mismatch-message');
    const profileFields = document.querySelectorAll('.profile-edit-field');
    const showDeliveredToggle = document.getElementById('show-delivered-toggle');
    const shipmentCards = Array.from(document.querySelectorAll('[data-shipment-card]'));
    const filteredShipmentsEmpty = document.getElementById('filtered-shipments-empty');
    const complaintForm = document.getElementById('complaint-form');
    const complaintOrderIdInput = document.getElementById('complaint-order-id');
    const complaintOrderMessage = document.getElementById('complaint-order-message');
    const selectedShipmentBox = document.getElementById('selected-shipment-box');
    const shipmentSelectors = document.querySelectorAll('[data-order-select]');

    const updatePasswordState = () => {
        if (!passwordInput || !passwordConfirmationInput || !passwordMismatchMessage) {
            return true;
        }

        const password = passwordInput.value;
        const confirmation = passwordConfirmationInput.value;
        const mismatch = password !== '' || confirmation !== ''
            ? password !== confirmation
            : false;

        passwordMismatchMessage.classList.toggle('hidden', !mismatch);

        if (profileSubmitButton) {
            profileSubmitButton.disabled = mismatch;
        }

        return !mismatch;
    };

    if (profileToggleEditButton) {
        profileToggleEditButton.addEventListener('click', () => {
            profileFields.forEach((target) => {
                target.readOnly = false;
                target.classList.remove('opacity-95');
            });

            if (passwordSection) {
                passwordSection.classList.remove('hidden');
            }

            if (profileSubmitButton) {
                profileSubmitButton.classList.remove('hidden');
            }

            profileToggleEditButton.classList.add('hidden');

            if (profileFields.length > 0) {
                profileFields[0].focus();
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', updatePasswordState);
    }

    if (passwordConfirmationInput) {
        passwordConfirmationInput.addEventListener('input', updatePasswordState);
    }

    if (profileForm) {
        profileForm.addEventListener('submit', (event) => {
            if (!updatePasswordState()) {
                event.preventDefault();
            }
        });
    }

    const updateShipmentVisibility = () => {
        if (!showDeliveredToggle || shipmentCards.length === 0) {
            return;
        }

        const showDelivered = showDeliveredToggle.checked;
        let visibleCount = 0;

        shipmentCards.forEach((card) => {
            const isDelivered = card.dataset.delivered === 'true';
            const shouldShow = showDelivered || !isDelivered;

            card.classList.toggle('hidden', !shouldShow);

            if (shouldShow) {
                visibleCount += 1;
            }
        });

        if (filteredShipmentsEmpty) {
            filteredShipmentsEmpty.classList.toggle('hidden', visibleCount !== 0);
        }
    };

    if (showDeliveredToggle) {
        showDeliveredToggle.addEventListener('change', updateShipmentVisibility);
        updateShipmentVisibility();
    }

    shipmentSelectors.forEach((selector) => {
        selector.addEventListener('click', () => {
            const orderId = selector.dataset.orderSelect || '';
            const orderTitle = selector.dataset.orderTitle || `Przesyłka #${orderId}`;

            shipmentSelectors.forEach((card) => {
                card.classList.remove('border-cyan-300/60', 'bg-white/15');
            });

            selector.classList.add('border-cyan-300/60', 'bg-white/15');

            if (complaintOrderIdInput) {
                complaintOrderIdInput.value = orderId;
            }

            if (selectedShipmentBox) {
                selectedShipmentBox.textContent = `Wybrana przesyłka: ${orderTitle}`;
            }

            if (complaintOrderMessage) {
                complaintOrderMessage.classList.add('hidden');
            }
        });
    });

    if (complaintForm) {
        complaintForm.addEventListener('submit', (event) => {
            if (!complaintOrderIdInput || complaintOrderIdInput.value !== '') {
                return;
            }

            event.preventDefault();

            if (complaintOrderMessage) {
                complaintOrderMessage.classList.remove('hidden');
            }
        });
    }
});
