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

        // Check if the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /dwp/frontend/controllers/LandingController.php");
            exit();
        }

        // Check for booking success message
        $bookingSuccessMessage = isset($_GET['success']) && $_GET['success'] == '1' ? "Your booking has been successfully completed!" : null;

        // Fetch user data
        $user_id = $_SESSION['user_id'];
        $user = $this->model->getUserData($user_id);

        // Fetch booking history
        $bookings = $this->model->getBookingHistory($user_id);

        // Fetch invoices
        $invoices = $this->model->getUserInvoices($user_id);

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/profile/profile_content.php';
    }
}
