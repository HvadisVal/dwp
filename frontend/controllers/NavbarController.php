<?php
class NavbarController {
    public function handleRequest() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $isLoggedIn = isset($_SESSION['user_id']);
        $user = $isLoggedIn ? $_SESSION['user'] : null;

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/navbar/navbar_content.php';
    }
}
