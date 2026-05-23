document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    const addressMode = document.getElementById('address-mode');
    const selectedAddressId = document.getElementById('selected-address-id');
    const newAddressFields = document.getElementById('new-address-fields');
    const pickupInput = document.getElementById('pickup-point-info');
    const summaryShipping = document.getElementById('summary-shipping');
    const summaryTotal = document.getElementById('summary-total');
    const baseTotal = parseFloat(summaryTotal?.dataset.baseTotal || '0');
    const addressSection = document.getElementById('address-section');
    const courierPanel = document.getElementById('courier-panel');
    const personalPanel = document.getElementById('personal-panel');
    const storePanel = document.getElementById('store-panel');
    const lockerPanel = document.getElementById('locker-panel');
    const cardPanel = document.getElementById('payment-card-panel');
    const codPanel = document.getElementById('payment-cod-panel');
    const blikModal = document.getElementById('blik-modal');
    const blikCodeInput = document.getElementById('blik-code');
    const blikModalCode = document.getElementById('blik-modal-code');
    const blikError = document.getElementById('blik-modal-error');
    let submitAfterBlik = false;

    const formatMoney = (value) => value === 0 ? 'Darmowa' : value.toFixed(2).replace('.', ',') + ' z\u0142';

    function syncAddressMode(choice) {
        if (!addressMode) return;
        addressMode.value = choice;
        newAddressFields?.classList.toggle('hidden', choice !== 'new');
    }

    function syncAddressRequirement(isRequired) {
        addressSection?.classList.toggle('hidden', !isRequired);
        const currentMode = addressMode?.value || 'guest';

        document.querySelectorAll('input[name^="guest_"]').forEach((input) => {
            input.required = isRequired && currentMode === 'guest';
        });

        document.querySelectorAll('input[name^="new_"]').forEach((input) => {
            input.required = isRequired && currentMode === 'new';
        });
    }

    document.querySelectorAll('[data-address-choice]').forEach((input) => {
        input.addEventListener('change', () => {
            if (input.dataset.addressId && selectedAddressId) {
                selectedAddressId.value = input.dataset.addressId;
            }
            syncAddressMode(input.dataset.addressChoice);
        });

        if (input.checked) {
            if (input.dataset.addressId && selectedAddressId) {
                selectedAddressId.value = input.dataset.addressId;
            }
            syncAddressMode(input.dataset.addressChoice);
        }
    });

    function syncDelivery() {
        const selected = document.querySelector('input[name="shipping_method_id"]:checked');
        if (!selected) return;

        const price = parseFloat(selected.dataset.shippingPrice || '0');
        const name = selected.dataset.shippingName || '';
        const isCourier = name.includes('kurier');
        const isPersonal = name.includes('osobist') || name.includes('siedzib');
        const isStore = name.includes('salon');
        const isLocker = name.includes('paczkomat');

        courierPanel?.classList.toggle('hidden', !isCourier);
        personalPanel?.classList.toggle('hidden', !isPersonal);
        storePanel?.classList.toggle('hidden', !isStore);
        lockerPanel?.classList.toggle('hidden', !isLocker);
        syncAddressRequirement(isCourier);

        if (summaryShipping) summaryShipping.textContent = formatMoney(price);
        if (summaryTotal) summaryTotal.textContent = (baseTotal + price).toFixed(2).replace('.', ',') + ' z\u0142';

        let point = '';
        if (isPersonal) point = document.querySelector('input[name="personal_pickup_choice"]:checked')?.value || '';
        if (isStore) point = document.querySelector('input[name="store_pickup_choice"]:checked')?.value || '';
        if (isLocker) point = document.querySelector('input[name="locker_pickup_choice"]:checked')?.value || '';
        if (pickupInput) pickupInput.value = point;
    }

    document.querySelectorAll('input[name="shipping_method_id"], input[name$="_pickup_choice"], input[name="courier_provider"], input[name="address_mode_picker"]').forEach((input) => {
        input.addEventListener('change', syncDelivery);
    });
    syncDelivery();

    function syncPayment() {
        const payment = document.querySelector('input[name="payment_method"]:checked')?.value;
        cardPanel?.classList.toggle('hidden', payment !== 'card');
        codPanel?.classList.toggle('hidden', payment !== 'cod');
    }

    document.querySelectorAll('input[name="payment_method"]').forEach((input) => input.addEventListener('change', syncPayment));
    syncPayment();

    form.addEventListener('submit', (event) => {
        const payment = document.querySelector('input[name="payment_method"]:checked')?.value;
        const terms = document.querySelector('input[name="terms_accepted"]');

        if (terms && !terms.checked) {
            event.preventDefault();
            terms.reportValidity();
            return;
        }

        if (payment === 'blik' && !submitAfterBlik && !/^\d{6}$/.test(blikCodeInput?.value || '')) {
            event.preventDefault();
            blikModal?.classList.remove('hidden');
            blikModal?.classList.add('flex');
            blikModalCode?.focus();
        }
    });

    document.getElementById('blik-cancel')?.addEventListener('click', () => {
        blikModal?.classList.add('hidden');
        blikModal?.classList.remove('flex');
    });

    document.getElementById('blik-confirm')?.addEventListener('click', () => {
        const code = blikModalCode?.value.trim() || '';
        if (!/^\d{6}$/.test(code)) {
            blikError?.classList.remove('hidden');
            return;
        }

        blikError?.classList.add('hidden');
        if (blikCodeInput) blikCodeInput.value = code;
        submitAfterBlik = true;
        form.requestSubmit();
    });
});
