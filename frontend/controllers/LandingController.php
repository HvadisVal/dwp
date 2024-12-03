<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/LandingModel.php';

class LandingController {
    private $model;

    public function __construct() {
        $this->model = new LandingModel();
    }

    // Entry point for the controller
    public function handleRequest() {
        $dates = $this->model->getDistinctDates();
        $movies = $this->model->getMovies();
        $versions = $this->model->getVersions();
        $description = $this->model->getCompanyDescription();
        $shortDescription = substr($description, 0, 352);
        $newsHTML = $this->model->generateNewsHTML();

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/landing/landing_content.php';
    }
}
