<?php
session_start();
require_once("../../../includes/connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']); // Optional field

    // Validate input
    if (empty($name) || empty($email) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'All fields except password are required.']);
        exit();
    }

    // Validate that phone is an integer
    if (!filter_var($phone, FILTER_VALIDATE_INT)) {
        echo json_encode(['success' => false, 'message' => 'Phone must be a valid number.']);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit();
    }

    try {
        // Update query
        $updateQuery = "UPDATE User SET Name = :name, Email = :email, TelephoneNumber = :phone WHERE User_ID = :user_id";

        if (!empty($password)) {
            // Hash the new password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $updateQuery = "UPDATE User SET Name = :name, Email = :email, TelephoneNumber = :phone, Password = :password WHERE User_ID = :user_id";
        }

        $stmt = $connection->prepare($updateQuery);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);

        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        }

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Information updated successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
