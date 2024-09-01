// script.js
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;
const slideContainer = document.querySelector('.slides');

function showSlides() {
    slideIndex++;
    if (slideIndex >= totalSlides) {slideIndex = 0}
    slideContainer.style.transform = `translateX(${-slideIndex * 100}%)`;
    setTimeout(showSlides, 10000); // Cambia cada 10 segundos
}

function changeSlide(n) {
    slideIndex += n;
    if (slideIndex >= totalSlides) {slideIndex = 0}
    if (slideIndex < 0) {slideIndex = totalSlides - 1}
    slideContainer.style.transform = `translateX(${-slideIndex * 100}%)`;
}

document.addEventListener('DOMContentLoaded', function() {
    showSlides();
});
