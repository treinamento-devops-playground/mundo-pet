document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars .star');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const value = parseInt(star.getAttribute('data-value'));
            highlightStars(value);
        });

        star.addEventListener('mouseout', function() {
            const currentValue = parseInt(ratingInput.value);
            highlightStars(currentValue);
        });

        star.addEventListener('click', function() {
            const value = parseInt(star.getAttribute('data-value'));
            ratingInput.value = value;
            highlightStars(value);
        });
    });

    function highlightStars(value) {
        stars.forEach(star => {
            if (parseInt(star.getAttribute('data-value')) <= value) {
                star.classList.add('filled');
            } else {
                star.classList.remove('filled');
            }
        });
    }
});
