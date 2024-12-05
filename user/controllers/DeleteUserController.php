<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/UserModel.php');

class DeleteUserController {
    private $model;

    public function __construct($connection) {
        $this->model = new UserModel($connection);
    }

    public function handleRequest() {
        session_start();
        header('Content-Type: application/json');

        // Enable error reporting for debugging
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];

            try {
                // Delete bookings and user
                $this->model->deleteUserBookings($user_id);
                $this->model->deleteUser($user_id);

                // Destroy session
                session_destroy();

                echo json_encode(['success' => true, 'message' => 'Account and associated bookings deleted successfully.']);
            } catch (Exception $e) {
                // Log the error
                error_log("Error in DeleteUserController: " . $e->getMessage());
                // Return the error message as JSON
                echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }
}
