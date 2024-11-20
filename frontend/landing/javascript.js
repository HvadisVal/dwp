let slideIndex = 0;

function showSlides() {
  let slides = document.querySelectorAll(".slider-item");
  if (slideIndex >= slides.length) {
    slideIndex = 0;
  }
  if (slideIndex < 0) {
    slideIndex = slides.length - 1;
  }
  let slide = document.querySelector(".slider");
  slide.style.transform = "translateX(" + -slideIndex * 100 + "%)";
}

function moveSlide(step) {
  slideIndex += step;
  showSlides();
}

document.addEventListener("DOMContentLoaded", function () {
  showSlides();
});
