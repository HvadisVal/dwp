<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/MoviesModel.php';

class FetchController {
    private $model;

    public function __construct() {
        $this->model = new MoviesModel();
    }

    public function fetchMovies($data) {
        $date = $data['date'] ?? null;
        $movieId = $data['movieId'] ?? null;
        $versionId = $data['versionId'] ?? null;

        // Fetch filtered movies using the model
        return $this->model->getFilteredMovies($date, $movieId, $versionId);
    }
}
