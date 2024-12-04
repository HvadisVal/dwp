<?php
session_start();

// Set the content type to JSON
header('Content-Type: application/json');

// Clear only user-related session data, not movie selection data
unset($_SESSION['user_id']);
unset($_SESSION['user']);

// Send success response
echo json_encode(["success" => true]);
exit();
?>
