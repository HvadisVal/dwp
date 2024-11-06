<?php
session_start();

// Clear only user-related session data, not movie selection data
unset($_SESSION['user_id']);
unset($_SESSION['user']);

echo json_encode(["success" => true]);
