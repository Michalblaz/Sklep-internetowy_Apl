document.addEventListener('DOMContentLoaded', () => {
    const specToggle = document.querySelector('[data-spec-toggle]');
    const extraSpecs = document.querySelectorAll('[data-spec-extra]');
    let specsExpanded = false;

    if (specToggle && extraSpecs.length) {
        specToggle.addEventListener('click', () => {
            specsExpanded = !specsExpanded;

            extraSpecs.forEach((item) => {
                item.classList.toggle('hidden', !specsExpanded);
                item.classList.toggle('flex', specsExpanded);
            });

            specToggle.textContent = specsExpanded ? 'Zwiń' : 'Rozwiń';
        });
    }

    const reviewWidget = document.querySelector('[data-review-widget]');

    if (!reviewWidget) {
        return;
    }

    const reviews = JSON.parse(reviewWidget.dataset.reviews || '[]');

    if (!reviews.length) {
        return;
    }

    const authorNode = reviewWidget.querySelector('[data-review-author]');
    const contentNode = reviewWidget.querySelector('[data-review-content]');
    const starNode = reviewWidget.querySelector('[data-review-star]');
    const starArms = starNode ? Array.from(starNode.querySelectorAll('.segmented-star__arm')) : [];
    const prevButton = reviewWidget.querySelector('[data-review-prev]');
    const nextButton = reviewWidget.querySelector('[data-review-next]');
    let currentReviewIndex = 0;

    const syncReview = () => {
        const review = reviews[currentReviewIndex];

        if (!review || !authorNode || !contentNode || !prevButton || !nextButton) {
            return;
        }

        authorNode.textContent = review.author;
        contentNode.textContent = review.content;

        starArms.forEach((arm, index) => {
            arm.style.setProperty('--arm-fill', index < review.stars ? '1' : '0');
        });

        prevButton.disabled = currentReviewIndex === 0;
        nextButton.disabled = currentReviewIndex === reviews.length - 1;
    };

    prevButton?.addEventListener('click', () => {
        if (currentReviewIndex === 0) {
            return;
        }

        currentReviewIndex -= 1;
        syncReview();
    });

    nextButton?.addEventListener('click', () => {
        if (currentReviewIndex >= reviews.length - 1) {
            return;
        }

        currentReviewIndex += 1;
        syncReview();
    });

    syncReview();
});
