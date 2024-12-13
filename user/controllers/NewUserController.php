<?php
// new_user.php (controller)
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
            $captcha_response = $_POST['g-recaptcha-response'] ?? ''; // Get CAPTCHA response token

            // Your secret key from Google reCAPTCHA v3
            $secret_key = '6Ld1cpoqAAAAAIrjjBueOyKBY7M_c-QgigVuEk84'; // Use your actual secret key

            // Verify the CAPTCHA response
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => $secret_key,
                'response' => $captcha_response
            ];

            $options = [
                'http' => [
                    'method' => 'POST',
                    'content' => http_build_query($data),
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
                ]
            ];
            $context = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $response_keys = json_decode($verify);

            // Check if CAPTCHA verification is successful
            if ($response_keys->success !== true || $response_keys->score < 0.5) {
                echo json_encode(['success' => false, 'message' => 'CAPTCHA validation failed. Please try again.']);
                exit;
            }

            // Validate the input fields
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
