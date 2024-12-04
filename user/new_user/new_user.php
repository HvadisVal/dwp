<?php
session_start();
require_once("../../../includes/connection.php");
require_once("../../../includes/functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle AJAX form submission for user creation
    header('Content-Type: application/json');

    $username = trim($_POST['user'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    // Validate required fields
    if (!$username || !$email || !$phone || !$password) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    try {
        // Check if username or email already exists
        $checkQuery = "SELECT COUNT(*) FROM User WHERE Name = :username OR Email = :email";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => 'Username or email already exists.']);
            exit();
        }

        // Hash the password and insert the new user into the database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO User (Name, Email, TelephoneNumber, Password) VALUES (:username, :email, :phone, :hashed_password)";
        $stmt = $connection->prepare($insertQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':hashed_password', $hashed_password);

        if ($stmt->execute()) {
            // Log the user in by setting session variables
            $_SESSION['user_id'] = $connection->lastInsertId();
            $_SESSION['user'] = $username;

            echo json_encode(['success' => true, 'message' => 'Account created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User could not be created.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}
include 'new_user_content.php';
?>

 
