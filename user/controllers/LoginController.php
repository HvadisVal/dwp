<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
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
            // Get form data
            $username = $_POST['user'] ?? '';
            $password = $_POST['pass'] ?? '';
            $captcha_response = $_POST['g-recaptcha-response'] ?? '';

            // Your secret key from Google reCAPTCHA
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
            
            

            try {
                // Proceed with user credentials verification
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
            // Load the login form view if not a POST request
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/login_form.php');
        }
    }
}
?>
