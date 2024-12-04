<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/NewsModel.php';

class NewsController {
    private $model;

    public function __construct() {
        $this->model = new NewsModel();
    }

    public function handleRequest() {
        // Fetch news with media
        $news = $this->model->getNewsWithMedia();

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/news/news_content.php';
    }
}
