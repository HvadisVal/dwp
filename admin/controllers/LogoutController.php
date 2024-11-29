<?php
// admin/controllers/LogoutController.php
require_once('./includes/functions.php'); // Include functions if necessary

class LogoutController {
    public function logout() {
        // Initialize the session
        session_start();

        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        redirect_to('/dwp/admin/login');
    }
}
