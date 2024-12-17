<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/NewUserModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/functions.php';


class NewUserController {
    private $model; 

    public function __construct($connection) {
        $this->model = new NewUserModel($connection);
    }

    public function handleRequest() {
         session_start();
        header('Content-Type: application/json');
        $csrfToken = generate_csrf_token();
        $_SESSION['csrf_token'] = $csrfToken; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                validate_csrf_token($_POST['csrf_token']);
            header('Content-Type: application/json');

            $response = [
                'success' => false,
                'message' => 'An unexpected error occurred.'
            ];

            try {
                $username = htmlspecialchars(trim($_POST['user'] ?? ''), ENT_QUOTES, 'UTF-8');
                $email = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
                $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
                $password = htmlspecialchars(trim($_POST['pass'] ?? ''), ENT_QUOTES, 'UTF-8');

                if (!validate_username($username)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid username. Use only letters, numbers, and underscores (3-20 characters).']);
                    exit;
                }
                if (!validate_email($email)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
                    exit;
                }
                if (!validate_phone($phone)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid phone number.']);
                    exit;
                }
                if (!validate_password($password)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid password. Use only letters, numbers, and special characters (8-20 characters).']);
                    exit;
                }
                $captcha_response = $_POST['g-recaptcha-response'] ?? ''; 

                if (!$username || !$email || !$phone || !$password) {
                    $response['message'] = 'All fields are required.';
                    echo json_encode($response);
                    exit;
                }

                $secret_key = '6Ld1cpoqAAAAAIrjjBueOyKBY7M_c-QgigVuEk84'; 
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

                $response = $this->model->createNewUser($username, $email, $phone, $password);

            } catch (Exception $e) {
                $response['message'] = 'An error occurred: ' . $e->getMessage();
            }

            echo json_encode($response);
            exit();
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/new_user_content.php';
    }
}
