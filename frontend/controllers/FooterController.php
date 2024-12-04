<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/FooterModel.php';

class FooterController {
    private $model;

    public function __construct($connection) {
        // Pass the connection to the FooterModel constructor
        $this->model = new FooterModel($connection);
    }

    public function handleRequest() {
        // Get the footer information
        $footerData = $this->model->getFooterData();

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/footer/footer_content.php';
    }
}
?>
