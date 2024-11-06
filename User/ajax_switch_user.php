<?php
session_start();

// Clear only guest session data
unset($_SESSION['guest_user_id'], $_SESSION['guest_firstname'], $_SESSION['guest_lastname'], $_SESSION['guest_email']);

// Send JSON response
echo json_encode(['success' => true]);
?>
