<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/NewUserModel.php';

class NewUserController {
    private $model;

    public function __construct($connection) {
        $this->model = new NewUserModel($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            
            $username = trim($_POST['user'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = trim($_POST['pass'] ?? '');

            if (!$username || !$email || !$phone || !$password) {
                echo json_encode(['success' => false, 'message' => 'All fields are required.']);
                exit();
            }

            $response = $this->model->createNewUser($username, $email, $phone, $password);

            echo json_encode($response);
            exit();
        }

        // Include the view for the new user registration form
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/user/new_user/new_user_content.php';
    }
}
