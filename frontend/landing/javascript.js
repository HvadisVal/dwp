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



document.addEventListener('DOMContentLoaded', () => {
  const dateFilter = document.getElementById('select-date');
  const movieFilter = document.getElementById('select-movie');
  const versionFilter = document.getElementById('select-version');
  const movieGrid = document.querySelector('.movie-grid');

  const fetchMovies = () => {
      const date = dateFilter.value || '';
      const movieId = movieFilter.value || '';
      const versionId = versionFilter.value || '';

      // Send AJAX request to fetch filtered movies
      fetch('/dwp/frontend/landing/fetch_movies.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ date, movieId, versionId })
      })
      .then(response => response.json())
      .then(data => {
          // Update the movie grid
          movieGrid.innerHTML = data.map(movie => `
              <div class="movie-card">
                  <a href="/dwp/movie?movie_id=${movie.Movie_ID}">
                      ${movie.FileName ? `<img src="uploads/poster/${movie.FileName}" 
                            alt="${movie.Title}" 
                            style="width: 100%; border-radius: 8px; margin-bottom: 10px;">` 
                      : '<p>No Image Available</p>'}
                      <p>${movie.Title}</p>
                  </a>
              </div>
          `).join('');
      })
      .catch(error => console.error('Error fetching movies:', error));
  };

  // Attach change event listeners to filters
  dateFilter.addEventListener('change', fetchMovies);
  movieFilter.addEventListener('change', fetchMovies);
  versionFilter.addEventListener('change', fetchMovies);
});


