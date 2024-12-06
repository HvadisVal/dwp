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
// Function to validate coupon code (only letters and numbers)
function validate_for_letter_numbers($input) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $input)) {
        return false; // Invalid input, contains characters other than letters or numbers
    }
    return true; // Valid input
}
function validate_numeric($value, $positive = true) {
    if (is_numeric($value)) {
        if ($positive && $value >= 0) {
            return true;
        } elseif (!$positive && $value != 0) {
            return true;
        }
    }
    return false;
}
function validate_date($date) {
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
}

// Function to validate email address
function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}
