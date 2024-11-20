<?php
session_start();
require_once("../../../includes/connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    try {
        $deleteQuery = "DELETE FROM User WHERE User_ID = :user_id";
        $stmt = $connection->prepare($deleteQuery);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Clear session and redirect
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Account deleted successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
