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



// Get dropdown elements
const dateDropdown = document.getElementById('select-date');
const movieDropdown = document.getElementById('select-movie');
const versionDropdown = document.getElementById('select-version');

// Example function: Log selected values
const logSelectedFilters = () => {
  const selectedDate = dateDropdown.value;
  const selectedMovie = movieDropdown.value;
  const selectedVersion = versionDropdown.value;

  console.log(`Selected Date: ${selectedDate}`);
  console.log(`Selected Movie: ${selectedMovie}`);
  console.log(`Selected Version: ${selectedVersion}`);
};

// Add event listeners
[dateDropdown, movieDropdown, versionDropdown].forEach(dropdown => {
  dropdown.addEventListener('change', logSelectedFilters);
});


