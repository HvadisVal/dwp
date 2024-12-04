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
const dateDropdown = document.getElementById("select-date");
const movieDropdown = document.getElementById("select-movie");
const versionDropdown = document.getElementById("select-version");

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
[dateDropdown, movieDropdown, versionDropdown].forEach((dropdown) => {
  dropdown.addEventListener("change", logSelectedFilters);
});

document.addEventListener("DOMContentLoaded", () => {
  const dateFilter = document.getElementById("select-date");
  const movieFilter = document.getElementById("select-movie");
  const versionFilter = document.getElementById("select-version");
  const movieGrid = document.querySelector(".movie-grid");

  const fetchMovies = () => {
    const date = dateFilter.value || "";
    const movieId = movieFilter.value || "";
    const versionId = versionFilter.value || "";

    // Send AJAX request to fetch filtered movies
    fetch("/dwp/frontend/fetch_movies.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ date, movieId, versionId }),
    })
      .then((response) => response.text()) // Use `.text()` to check the raw response
      .then((rawData) => {
        console.log("Raw response data:", rawData); // Log the raw data to inspect it
        const data = JSON.parse(rawData); // Then parse it as JSON
        // Update the movie grid
        movieGrid.innerHTML = data
          .map(
            (movie) => `
              <div class="movie-card">
                  <a href="/dwp/movie?movie_id=${movie.Movie_ID}">
                      ${
                        movie.FileName
                          ? `<img src="uploads/poster/${movie.FileName}" 
                            alt="${movie.Title}" 
                            style="width: 100%; border-radius: 8px; margin-bottom: 10px;">`
                          : "<p>No Image Available</p>"
                      }
                      <p>${movie.Title}</p>
                  </a>
              </div>
          `
          )
          .join("");
      })
      .catch((error) => console.error("Error fetching movies:", error));
  };

  // Attach change event listeners to filters
  dateFilter.addEventListener("change", fetchMovies);
  movieFilter.addEventListener("change", fetchMovies);
  versionFilter.addEventListener("change", fetchMovies);
});

document.getElementById("reset-filters").addEventListener("click", function () {
  // Reset the dropdown values to default (empty or first option)
  document.getElementById("select-date").selectedIndex = 0; // Reset Date filter
  document.getElementById("select-movie").selectedIndex = 0; // Reset Movie filter
  document.getElementById("select-version").selectedIndex = 0; // Reset Version filter

  // Optionally, reset the movie grid by reloading the page or calling fetch_movies with no filters
  resetMovieGrid();
});

function resetMovieGrid() {
  // You can reload the movie grid with all movies (no filters applied)
  // Here, you might want to re-fetch the data without any filters or reload the page to show all movies
  fetchMovies(); // Assuming fetchMovies handles the request and update
}

function updateMovieGrid(movies) {
  const movieGrid = document.querySelector(".movie-grid");
  movieGrid.innerHTML = ""; // Clear the existing movie grid

  // Iterate over the fetched movies and append them to the grid
  movies.forEach((movie) => {
    const movieCard = document.createElement("div");
    movieCard.classList.add("movie-card");

    // Movie content (e.g., image, title)
    movieCard.innerHTML = `
          <a href="/dwp/movie?movie_id=${movie.Movie_ID}">
              <img src="uploads/poster/${movie.FileName}" alt="${movie.Title}" style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
              <p>${movie.Title}</p>
          </a>
      `;

    movieGrid.appendChild(movieCard);
  });
}

function fetchMovies() {
  const filters = {
    date: "", // Empty date filter to show all movies
    movieId: "", // Empty movie filter to show all movies
    versionId: "", // Empty version filter to show all movies
  };

  // Send request to the backend with no filters
  fetch("/dwp/frontend/fetch_movies.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(filters),
  })
    .then((response) => response.json())
    .then((movies) => {
      // Update the movie grid with all movies
      updateMovieGrid(movies);
    });
}
