<?php
require_once('./includes/admin_session.php');  
require_once('./admin/models/LoginModel.php');
require_once('./includes/functions.php');  

class LoginController {
    private $model;
    private $blockedTime;

    // Constructor now accepts blockedTime as a parameter
    public function __construct($connection, $blockedTime = 600) {
        $this->model = new LoginModel($connection, $blockedTime); // Pass blocked time
        $this->blockedTime = $blockedTime; // Store blocked time in the controller
    }

    public function handleRequest() {
        $csrfToken = generate_csrf_token();
    
        // Check if the user is blocked
        $blockedUntil = $_SESSION['blocked_until'] ?? null;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                validate_csrf_token($_POST['csrf_token']);
                refresh_csrf_token();
                $this->handlePostRequest();
            } catch (Exception $e) {
                $_SESSION['message'] = "Login failed. " . $e->getMessage();
                header("Location: /dwp/admin/login", true, 303);
                exit();
            }
        } else {
            $this->showLoginPage($csrfToken, $blockedUntil); // Pass blockedUntil to the view
        }
    }

    private function handlePostRequest() {
        $ip = $_SERVER['REMOTE_ADDR'];

        // Check if the user has exceeded max login attempts
        if ($this->model->hasExceededMaxAttempts($ip)) {
            $_SESSION['message'] = "Too many failed login attempts. Please try again in 10 minutes.";
            $_SESSION['blocked_until'] = time() + $this->blockedTime;
            header("Location: /dwp/admin/login", true, 303);
            exit();
        }

        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($_POST['pass']), ENT_QUOTES, 'UTF-8');

        if (!validate_email($email)) {
            $_SESSION['message'] = "Invalid email address. Please enter a valid email.";
            header("Location: /dwp/admin/login", true, 303);
            exit();
        }

        $admin = $this->model->authenticate($email, $password);
        if (!$admin) {
            $this->model->logLoginAttempt($ip, false);
            throw new Exception("Incorrect email or password.");
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
