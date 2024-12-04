<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/AboutModel.php';

class AboutController {
    private $model;

    public function __construct($connection) {
        // Pass the connection to the AboutModel constructor
        $this->model = new AboutModel($connection);
    }

    public function handleRequest() {
        // Get the about information
        $aboutData = $this->model->getAboutData();

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/about/about_content.php';
    }
}