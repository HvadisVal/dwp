<?php
// new_user.php (controller)
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/NewUserModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/functions.php';


class NewUserController {
    private $model; 

    public function __construct($connection) {
        $this->model = new NewUserModel($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            // Initialize $response to avoid undefined variable warnings
            $response = [
                'success' => false,
                'message' => 'An unexpected error occurred.'
            ];

            try {
                // Sanitize and retrieve form input
                $username = htmlspecialchars(trim($_POST['user'] ?? ''), ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
                $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
                $password = htmlspecialchars(trim($_POST['pass'] ?? ''), ENT_QUOTES, 'UTF-8');
                $captcha_response = $_POST['g-recaptcha-response'] ?? ''; // Get CAPTCHA response token

                // Validate required fields
                if (!$username || !$email || !$phone || !$password) {
                    $response['message'] = 'All fields are required.';
                    echo json_encode($response);
                    exit;
                }

                // Google reCAPTCHA verification
                $secret_key = '6Ld1cpoqAAAAAIrjjBueOyKBY7M_c-QgigVuEk84'; // Use your actual secret key
                $captcha_verify_url = 'https://www.google.com/recaptcha/api/siteverify';
                $captcha_data = [
                    'secret' => $secret_key,
                    'response' => $captcha_response
                ];

                $captcha_options = [
                    'http' => [
                        'method' => 'POST',
                        'content' => http_build_query($captcha_data),
                        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
                    ]
                ];

                $context = stream_context_create($captcha_options);
                $verify = file_get_contents($captcha_verify_url, false, $context);
                $captcha_result = json_decode($verify, true);

                if (!$captcha_result['success'] || $captcha_result['score'] < 0.5) {
                    $response['message'] = 'CAPTCHA validation failed. Please try again.';
                    echo json_encode($response);
                    exit;
                }

                // Check if user exists or create a new user
                $response = $this->model->createNewUser($username, $email, $phone, $password);

            } catch (Exception $e) {
                // Handle exceptions and errors
                $response['message'] = 'An error occurred: ' . $e->getMessage();
            }

            // Always send a JSON response
            echo json_encode($response);
            exit();
        }

        // If not POST, load the view (optional)
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/new_user_content.php';
    }
}
