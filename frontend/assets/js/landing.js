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

const dateDropdown = document.getElementById("select-date");
const movieDropdown = document.getElementById("select-movie");
const versionDropdown = document.getElementById("select-version");

const logSelectedFilters = () => {
  const selectedDate = dateDropdown.value;
  const selectedMovie = movieDropdown.value;
  const selectedVersion = versionDropdown.value;

  console.log(`Selected Date: ${selectedDate}`);
  console.log(`Selected Movie: ${selectedMovie}`);
  console.log(`Selected Version: ${selectedVersion}`);
};

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
 
    fetch("/dwp/frontend/actions/fetch_movies.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ date, movieId, versionId }),
    })
      .then((response) => response.text()) 
      .then((rawData) => {
        console.log("Raw response data:", rawData); 
        const data = JSON.parse(rawData); 

        if (data.length === 0) {
          movieGrid.innerHTML = `
            <div class="no-movies-message">
              <p>No movies available for the selected filters.</p>
            </div>`;
          return;
        }
        
        
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
  

  dateFilter.addEventListener("change", fetchMovies);
  movieFilter.addEventListener("change", fetchMovies);
  versionFilter.addEventListener("change", fetchMovies);
});

document.getElementById("reset-filters").addEventListener("click", function () {
  document.getElementById("select-date").selectedIndex = 0;
  document.getElementById("select-movie").selectedIndex = 0; 
  document.getElementById("select-version").selectedIndex = 0; 

  resetMovieGrid();
});

function resetMovieGrid() {
  fetchMovies(); 
}

function updateMovieGrid(movies) {
  const movieGrid = document.querySelector(".movie-grid");
  movieGrid.innerHTML = ""; 

  movies.forEach((movie) => {
    const movieCard = document.createElement("div");
    movieCard.classList.add("movie-card");

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
    date: "", 
    movieId: "", 
    versionId: "", 
  };

  fetch("/dwp/frontend/actions/fetch_movies.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(filters),
  })
    .then((response) => response.json())
    .then((movies) => {
      updateMovieGrid(movies);
    });
}
