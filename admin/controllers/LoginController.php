<?php
require_once('./includes/admin_session.php');  
require_once('./admin/models/LoginModel.php');
require_once('./includes/functions.php');  

class LoginController {
    private $model;
    private $blockedTime;

    public function __construct($connection, $blockedTime = 600) {
        $this->model = new LoginModel($connection, $blockedTime);
        $this->blockedTime = $blockedTime;
    }

    public function handleRequest() {
        $csrfToken = generate_csrf_token();
        $_SESSION['csrf_token'] = $csrfToken; 

        $blockedUntil = $_SESSION['blocked_until'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                validate_csrf_token($_POST['csrf_token']);
                refresh_csrf_token();
                $this->handlePostRequest();
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => "Login failed: " . $e->getMessage()]);
                exit();
            }
        } else {
            $this->showLoginPage($csrfToken, $blockedUntil);
        }
    }

    private function handlePostRequest() {
        $ip = $_SERVER['REMOTE_ADDR'];
    
        // Check for too many failed attempts
        if ($this->model->hasExceededMaxAttempts($ip)) {
            $_SESSION['message'] = "Too many failed login attempts. Please try again in 10 minutes.";
            $_SESSION['blocked_until'] = time() + $this->blockedTime;
            header("Location: /dwp/admin/login", true, 303);
            exit();
        }
    
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($_POST['pass']), ENT_QUOTES, 'UTF-8');
        $captcha_response = $_POST['g-recaptcha-response'] ?? '';
    
        // CAPTCHA validation
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
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $response_keys = json_decode($verify);
    
        if (!$response_keys->success || $response_keys->score < 0.7) {
            $_SESSION['message'] = "CAPTCHA validation failed. Please try again.";
            header("Location: /dwp/admin/login", true, 303);
            exit();
        }
        
    
        if (!validate_email($email)) {
            $_SESSION['message'] = "Invalid email address.";
            header("Location: /dwp/admin/login", true, 303);
            exit();
        }
    
        $admin = $this->model->authenticate($email, $password);
        if (!$admin) {
            $this->model->logLoginAttempt($ip, false);
            $_SESSION['message'] = "Incorrect email or password.";
            header("Location: /dwp/admin/login", true, 303);
            exit();
        }
    
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['Admin_Id'];
        $_SESSION['admin_email'] = $admin['Email'];
    
        $this->model->logLoginAttempt($ip, true);
        header("Location: /dwp/admin/dashboard", true, 303);
        exit();
    }
    

    private function showLoginPage($csrfToken, $blockedUntil) {
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
        include('./admin/views/admin_login.php');
    }
}
