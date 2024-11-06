<?php
require_once("../includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'] ?? null;
    $lastname = $_POST['lastname'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;

    if ($firstname && $lastname && $email && $phone) {
        try {
            $stmt = $connection->prepare("INSERT INTO GuestUser (Firstname, Lastname, Email, TelephoneNumber) VALUES (:firstname, :lastname, :email, :phone)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['guest_user_id'] = $connection->lastInsertId();
                $_SESSION['guest_firstname'] = $firstname;
                $_SESSION['guest_lastname'] = $lastname;
                $_SESSION['guest_email'] = $email;

                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create guest user.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
