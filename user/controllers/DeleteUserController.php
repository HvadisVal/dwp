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

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];

            try {
                $this->model->deleteUserBookings($user_id);
                $this->model->deleteUser($user_id);

                session_destroy();

                echo json_encode(['success' => true, 'message' => 'Account and associated bookings deleted successfully.']);
            } catch (Exception $e) {
               
                error_log("Error in DeleteUserController: " . $e->getMessage());
               
                echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }
}
