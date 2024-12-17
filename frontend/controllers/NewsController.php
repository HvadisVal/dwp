<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/NewsModel.php';

class NewsController {
    private $model;

    public function __construct($connection) {
        $this->model = new NewsModel($connection);
    }

    public function handleRequest() {
        $news = $this->model->getNewsWithMedia();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/news/news_content.php';
    }
}
