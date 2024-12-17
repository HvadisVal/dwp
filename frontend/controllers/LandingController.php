<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/LandingModel.php';

class LandingController {
    private $model;
    public function __construct($connection) {
        $this->model = new LandingModel($connection);
    }

    public function handleRequest() {
        $dates = $this->model->getDistinctDates();
        $movies = $this->model->getMovies();
        $landingMovies = $this->model->getLandingMovies();  
        $versions = $this->model->getVersions();
        $description = $this->model->getCompanyDescription();
        $shortDescription = substr($description, 0, 352);
        $newsHTML = $this->model->generateNewsHTML();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/landing/landing_content.php';
    }
}
