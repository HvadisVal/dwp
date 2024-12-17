<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/FooterModel.php';

class FooterController {
    private $model;

    public function __construct($connection) {
        $this->model = new FooterModel($connection);
    }

    public function handleRequest() {
        $footerData = $this->model->getFooterData();

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/footer/footer_content.php';
    }
}
?>
