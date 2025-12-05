import './bootstrap';

document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.getElementById("carouselProducts");
    const btnRight = document.getElementById("btnRight");
    const btnLeft = document.getElementById("btnLeft");

    if (!carousel) return;

    const cardWidth = 280; // tamaño + gap aprox

    btnRight.addEventListener("click", () => {
        carousel.scrollBy({ left: cardWidth, behavior: "smooth" });
    });

    btnLeft.addEventListener("click", () => {
        carousel.scrollBy({ left: -cardWidth, behavior: "smooth" });
    });
});