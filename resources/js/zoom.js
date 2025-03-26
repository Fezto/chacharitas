document.addEventListener('DOMContentLoaded', function () {
    const magnifier = document.getElementById('magnifier');
    const zoomableImages = document.querySelectorAll('.zoomable');

    let currentImg = zoomableImages[0];

    function updateMagnifierPosition(e, img) {
        const rect = img.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const xPercent = (x / img.width) * 100;
        const yPercent = (y / img.height) * 100;

        // Posicionar la lupa a la derecha de la imagen
        magnifier.style.left = `${rect.right + 20}px`;
        const verticalOffset = Math.min(
            window.innerHeight - magnifier.offsetHeight - 20,
            Math.max(20, e.clientY - magnifier.offsetHeight / 2)
        );
        magnifier.style.top = `${verticalOffset}px`;

        // Ajustar tamaño y posición del background en la lupa
        magnifier.style.backgroundSize = `${img.naturalWidth * 4}px ${img.naturalHeight * 4}px`;
        magnifier.style.backgroundPosition = `${xPercent}% ${yPercent}%`;
    }

    zoomableImages.forEach(function (img) {
        img.addEventListener('mouseenter', function (e) {
            magnifier.classList.remove('hidden');
            magnifier.style.backgroundImage = `url(${img.src})`;
            currentImg = img;
        });

        img.addEventListener('mousemove', function (e) {
            updateMagnifierPosition(e, img);
        });

        img.addEventListener('mouseleave', function () {
            magnifier.classList.add('hidden');
        });
    });

    // Actualizar la imagen de fondo al cambiar de imagen en el carrusel
    const carouselItems = document.querySelectorAll('.carousel-item');
    carouselItems.forEach(item => {
        item.addEventListener('transitionend', () => {
            const visibleImg = item.querySelector('.zoomable');
            if (visibleImg) {
                currentImg = visibleImg;
                magnifier.style.backgroundImage = `url(${currentImg.src})`;
            }
        });
    });
});
