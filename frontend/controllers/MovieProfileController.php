<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/MovieProfileModel.php';



class MovieProfileController {
    private $model;

    public function __construct() {
        $this->model = new MovieModel();
    }

    public function handleRequest() {
        // Validate the `movie_id` parameter
        $movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
        if ($movieId <= 0) {
            echo "Invalid movie ID.";
            exit;
        }

        // Fetch data from the model
        $movieDetails = $this->model->getMovieDetails($movieId);
        if (!$movieDetails) {
            echo "Movie not found.";
            exit;
        }
        echo "<pre>";
print_r($movieDetails);
echo "</pre>";

        // Prepare additional data (e.g., dates for the next 7 days)
        $daysToShow = 7;
        $startDate = new DateTime();
        $endDate = (clone $startDate)->modify("+$daysToShow days");
        $allDates = [];
        $startDateClone = clone $startDate;
        for ($i = 0; $i < $daysToShow; $i++) {
            $allDates[] = $startDateClone->format('Y-m-d');
            $startDateClone->modify('+1 day');
        }

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/movie_profile/movie_content.php';
    }
}

