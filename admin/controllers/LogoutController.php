<?php
require_once('./includes/functions.php'); 
class LogoutController {
    public function logout() {
        session_start();

        $_SESSION = array();

        session_destroy();

        redirect_to('/dwp/admin/login');
    }
}
