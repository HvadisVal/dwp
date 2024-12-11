<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/ProfileModel.php');

class ProfileController {
    private $model;

    public function __construct($connection) {
        $this->model = new ProfileModel($connection);
    }

    public function handleRequest() {
        session_start();
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: /dwp/landing");
            exit();
        }
    
        $userId = $_SESSION['user_id'];
    
        try {
            $user = $this->model->getUserDetails($userId);
            $bookings = $this->model->getBookingHistory($userId);
            $invoices = $this->model->getInvoices($userId);
    
            require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/profiles/profile_content.php';
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
    
}
