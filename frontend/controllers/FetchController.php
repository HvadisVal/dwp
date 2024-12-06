<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/FetchModel.php';

class FetchController {
    private $model;

    public function __construct($connection) {
        // Pass the connection to the MoviesModel constructor
        $this->model = new MoviesModel($connection);
    }

    public function fetchMovies($data) {
        // Get the optional parameters from the input data
        $date = $data['date'] ?? null;
        $movieId = $data['movieId'] ?? null;
        $versionId = $data['versionId'] ?? null;

        // Fetch filtered movies using the model method
        $movies = $this->model->getFilteredMovies($date, $movieId, $versionId);

        // Ensure that the movies are returned as an array (empty array if no movies found)
        if (empty($movies)) {
            return []; // Return an empty array if no movies are found
        }

        return $movies; // Return the fetched movies
    }
}
