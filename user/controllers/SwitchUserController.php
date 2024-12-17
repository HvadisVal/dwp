<?php
session_start();
header('Content-Type: application/json'); 

class SwitchUserController
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function handleRequest()
    {
        unset($_SESSION['guest_user_id'], $_SESSION['guest_firstname'], $_SESSION['guest_lastname'], $_SESSION['guest_email']);

        echo json_encode(['success' => true]);
        exit();
    }
}
