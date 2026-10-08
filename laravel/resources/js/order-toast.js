document.addEventListener('DOMContentLoaded', () => {
    const toast = document.getElementById('order-success-toast');
    if (!toast) return;

    requestAnimationFrame(() => {
        toast.classList.add('is-visible');
    });

    window.setTimeout(() => {
        toast.classList.remove('is-visible');
    }, 4000);
});
