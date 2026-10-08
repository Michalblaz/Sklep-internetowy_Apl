document.addEventListener('DOMContentLoaded', () => {
    const observedNotice = document.querySelector('[data-observed-notice]');
    const observedButton = document.querySelector('[data-observed-button]');
    const observedIcon = document.querySelector('[data-observed-icon]');

    const setObservedState = (isObserved) => {
        if (!observedButton || !observedIcon) {
            return;
        }

        observedButton.dataset.observedActive = isObserved ? 'true' : 'false';
        observedButton.setAttribute('aria-label', isObserved ? 'Usuń z obserwowanych' : 'Dodaj do obserwowanych');
        observedIcon.textContent = isObserved ? '♥' : '♡';

        observedButton.classList.toggle('border-rose-300/45', isObserved);
        observedButton.classList.toggle('bg-rose-500/15', isObserved);
        observedButton.classList.toggle('text-rose-300', isObserved);
        observedButton.classList.toggle('shadow-[0_0_18px_rgba(244,63,94,0.25)]', isObserved);
        observedButton.classList.toggle('border-white/15', !isObserved);
        observedButton.classList.toggle('bg-white/5', !isObserved);
        observedButton.classList.toggle('text-white/80', !isObserved);
        observedButton.classList.toggle('hover:bg-white/10', !isObserved);
    };

    const showObservedNotice = (message, type = 'success') => {
        if (!observedNotice) {
            return;
        }

        observedNotice.textContent = message;
        observedNotice.classList.remove(
            'hidden',
            'border',
            'border-emerald-400/40',
            'bg-emerald-500/10',
            'text-emerald-100',
            'border-rose-400/40',
            'bg-rose-500/10',
            'text-rose-100',
        );

        if (type === 'error') {
            observedNotice.classList.add('border', 'border-rose-400/40', 'bg-rose-500/10', 'text-rose-100');
        } else {
            observedNotice.classList.add('border', 'border-emerald-400/40', 'bg-emerald-500/10', 'text-emerald-100');
        }
    };

    if (observedButton) {
        observedButton.addEventListener('click', async () => {
            const token = observedButton.dataset.observedToken;
            const endpoint = observedButton.dataset.observedEndpoint;

            if (!token || !endpoint) {
                return;
            }

            observedButton.disabled = true;

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    showObservedNotice(data.message || 'Nie udało się zaktualizować obserwowanych.', 'error');
                    return;
                }

                setObservedState(Boolean(data.isObserved));
                showObservedNotice(data.message || 'Zaktualizowano obserwowane.');
            } catch (error) {
                console.error('Błąd:', error);
                showObservedNotice('Nie udało się zaktualizować obserwowanych.', 'error');
            } finally {
                observedButton.disabled = false;
            }
        });
    }

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
