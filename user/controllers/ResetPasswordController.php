<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/ForgotPasswordModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/functions.php'); // Ensure validate_password is included

class ResetPasswordController {
    private $model;

    public function __construct($connection) {
        $this->model = new ForgotPasswordModel($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Show reset password form
            $token = $_GET['token'] ?? null;
            if (!$token) {
                die("Invalid or missing token.");
            }
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/password_form/reset_password_form.php');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? null;
            $password = $_POST['password'] ?? null;

            if (!$token || !$password) {
                echo json_encode(['success' => false, 'message' => 'Invalid input.']);
                exit();
            }

            // Validate the password
            if (!validate_password($password)) {
                echo json_encode(['success' => false, 'message' => 'Invalid password. Use 8-20 characters, including uppercase, lowercase, numbers, and special characters.']);
                exit();
            }

            try {
                if ($this->model->resetPassword($token, $password)) {
                    echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
    }
}
?>
