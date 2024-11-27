<?php
function redirect_to($location) {
	header("Location: " . $location);
	exit;
}
// CSRF Protection: Generate token if not set
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to validate CSRF token
function validate_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Invalid CSRF token.");
    }
}

// Function to refresh CSRF token
function refresh_csrf_token() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}