<?php
// admin/controllers/LoginController.php
require_once('./admin/models/LoginModel.php');
require_once('./includes/connection.php');  // Ensure connection is available

class LoginController {

    public function login() {
        session_start();  // Start the session

        $message = ""; // To hold error message

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['pass']);

            // Instantiate LoginModel
            $loginModel = new LoginModel();
            $found_admin = $loginModel->authenticate($email, $password);

            if ($found_admin) {
                // If successful, set session variables and redirect
                $_SESSION['admin_id'] = $found_admin['Admin_ID'];
                $_SESSION['admin_email'] = $found_admin['Email'];

                // Redirect to the dashboard (adjust URL as needed)
                header("Location: /dwp/admin/dashboard");
                exit(); // Stop the script after redirection
            } else {
                // If authentication failed, set error message
                $message = "Incorrect email or password.";
            }
        }

        // Include the login view and pass the message
        include('./admin/views/admin_login.php');
    }
}

?>
