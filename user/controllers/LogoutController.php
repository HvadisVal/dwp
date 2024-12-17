<?php
class LogoutController {
    public function handleRequest() {
        session_start();

        header('Content-Type: application/json');

        unset($_SESSION['user_id']);
        unset($_SESSION['user']);

        echo json_encode(["success" => true]);
        exit();
    }
}
