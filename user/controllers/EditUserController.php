<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/UserModel.php');

class EditUserController {
    private $model;

    public function __construct($connection) {
        $this->model = new UserModel($connection);
    }
 
    public function handleRequest() {
        session_start();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = trim($_POST['password']); // Optional field
        
            error_log("Edit Request Received: User ID = $user_id, Name = $name, Email = $email, Phone = $phone");
        
            try {
                $this->model->editUser($user_id, $name, $email, $phone, $password);
                echo json_encode(['success' => true, 'message' => 'Information updated successfully.']);
            } catch (Exception $e) {
                error_log("Error in EditUserController: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
        
    }
}
