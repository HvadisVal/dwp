<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/FetchModel.php';

class FetchController {
    private $model;

    public function __construct($connection) {
        $this->model = new MoviesModel($connection);
    }

    public function fetchMovies($data) {
        $date = $data['date'] ?? null;
        $movieId = $data['movieId'] ?? null;
        $versionId = $data['versionId'] ?? null;

        $movies = $this->model->getFilteredMovies($date, $movieId, $versionId);

        if (empty($movies)) {
            return []; 
        }

        return $movies; 
    }
}
