<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/LoginModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/functions.php');

class LoginController {
    private $model;

    public function __construct($connection) {
        $this->model = new LoginModel($connection);
    }

    public function handleRequest(): void {
        session_start();
        header('Content-Type: application/json');
        $csrfToken = generate_csrf_token();
        $_SESSION['csrf_token'] = $csrfToken; 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                validate_csrf_token($_POST['csrf_token']);
                refresh_csrf_token();
    
            $username = htmlspecialchars(trim($_POST['user'] ?? ''), ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars(trim($_POST['pass'] ?? ''), ENT_QUOTES, 'UTF-8');
    
            if (!validate_username($username)) {
                echo json_encode(['success' => false, 'message' => 'Invalid username. Use only letters, numbers, and underscores (3-20 characters).']);
                exit;
            }
            if (!validate_password($password)) {
                echo json_encode(['success' => false, 'message' => 'Invalid password. Use only letters, numbers, and special characters (8-20 characters).']);
                exit;
            }
    
            $captcha_response = $_POST['g-recaptcha-response'] ?? '';
            $secret_key = '6Ld1cpoqAAAAAIrjjBueOyKBY7M_c-QgigVuEk84';
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
    
            if (!$response_keys->success || $response_keys->score < 0.5) {
                echo json_encode(['success' => false, 'message' => 'CAPTCHA validation failed. Please try again.']);
                exit;
            }
    
            try {
                $user = $this->model->getUserByUsername($username);
                if ($user && password_verify($password, $user['Password'])) {
                    $_SESSION['user_id'] = $user['User_ID'];
                    $_SESSION['user'] = $user['Name'];
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Incorrect username or password.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'An unexpected error occurred. Please try again later.']);
            }
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/login_form.php');
        }
    }
    
}
?>
