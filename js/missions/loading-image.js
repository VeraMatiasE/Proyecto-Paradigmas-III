document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll('.lazy-load');

    images.forEach(img => {
        const skeleton = img.previousElementSibling;

        img.onload = function() {
            skeleton.style.display = 'none';
            img.style.display = 'block';
        };

        img.src = img.src;
    });
});