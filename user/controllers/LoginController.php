<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/LoginModel.php');

class LoginController {
    private $model;

    public function __construct($connection) {
        $this->model = new LoginModel($connection);
    }

    public function handleRequest() {
        session_start();
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['user'] ?? '';
            $password = $_POST['pass'] ?? '';

            try {
                $user = $this->model->getUserByUsername($username);

                if ($user && password_verify($password, $user['Password'])) {
                    // Set session variables for the logged-in user
                    $_SESSION['user_id'] = $user['User_ID'];
                    $_SESSION['user'] = $user['Name'];
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Incorrect username or password.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/login_form.php');
        }
    }
}
