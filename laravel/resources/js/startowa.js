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
});
