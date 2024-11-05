<?php
session_start();
require_once("../includes/connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($firstname && $lastname && $email) {
        try {
            // Insert guest information into the database
            $query = "INSERT INTO GuestUser (Firstname, Lastname, Email) VALUES (:firstname, :lastname, :email)";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Get the last inserted ID for the guest
            $guest_user_id = $connection->lastInsertId();

            // Set guest information in the session
            $_SESSION['guest_info'] = [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email
            ];
            $_SESSION['guest_user_id'] = $guest_user_id;

            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
