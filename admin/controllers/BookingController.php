<?php 
require_once("./includes/functions.php");
require_once("./includes/admin_session.php");
require_once("./admin/models/BookingModel.php");

class BookingController {
    private $model;

    public function __construct($connection) {
        $this->model = new BookingModel($connection);
    }

    public function handleRequest() {
        generate_csrf_token();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf_token($_POST['csrf_token']);
            refresh_csrf_token();

            if (isset($_POST['delete_booking'])) {
                $this->deleteBooking((int)$_POST['booking_id']);
            }
        }
    }

    private function deleteBooking($bookingId) {
        if ($this->model->deleteBooking($bookingId)) {
            $_SESSION['message'] = "Booking deleted successfully!";
            header("Location: /dwp/admin/manage-bookings");
            exit();
        }
    }

    public function getAllBookings() {
        return $this->model->getAllBookings();
    }

    public function getBookingDetails($bookingId) {
        return $this->model->getBookingDetails($bookingId);
    }
}

$controller = new BookingController($connection);
$controller->handleRequest();
$bookings = $controller->getAllBookings();
include('./admin/views/bookings_content.php');
