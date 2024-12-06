<?php
session_start();
header('Content-Type: application/json'); // Ensure JSON content type

class SwitchUserController
{
    private $connection;

    // Constructor to accept the database connection
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function handleRequest()
    {
        // Clear guest session data
        unset($_SESSION['guest_user_id'], $_SESSION['guest_firstname'], $_SESSION['guest_lastname'], $_SESSION['guest_email']);

        // Return properly encoded JSON
        echo json_encode(['success' => true]);
        exit();
    }
}
