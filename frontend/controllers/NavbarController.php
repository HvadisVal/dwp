<?php
class NavbarController {
    public function handleRequest() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check login state
        $isLoggedIn = isset($_SESSION['user_id']);
        $user = $isLoggedIn ? $_SESSION['user'] : null;

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/navbar/navbar_content.php';
    }
}
