document.addEventListener('DOMContentLoaded', () => {
    const reviewForm = document.querySelector('[data-review-form]');
    const ratingInput = reviewForm?.querySelector('[data-rating-input]');
    const ratingStars = reviewForm ? Array.from(reviewForm.querySelectorAll('[data-rating-star]')) : [];
    const reviewSubmit = reviewForm?.querySelector('[data-review-submit]');

    const syncRatingStars = (rating) => {
        ratingStars.forEach((star, index) => {
            const active = index < rating;
            star.innerHTML = active ? '&#9733;' : '&#9734;';
            star.classList.toggle('text-yellow-400', active);
            star.classList.toggle('text-white/45', !active);
        });

        if (reviewSubmit) {
            reviewSubmit.disabled = rating < 1;
            reviewSubmit.classList.toggle('opacity-30', rating < 1);
        }
    };

    if (ratingInput && ratingStars.length) {
        let currentRating = Number(ratingInput.value || 0);
        syncRatingStars(currentRating);

        ratingStars.forEach((star) => {
            star.addEventListener('click', () => {
                currentRating = Number(star.dataset.value || 0);
                ratingInput.value = String(currentRating);
                syncRatingStars(currentRating);
            });
        });
    }

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

    if (reviews.length) {
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
    }
});
