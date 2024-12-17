<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/AboutModel.php';

class AboutController {
    private $model;

    public function __construct($connection) {
        $this->model = new AboutModel($connection);
    }

    public function handleRequest() {
        $aboutData = $this->model->getAboutData();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/about/about_content.php';
    }
}