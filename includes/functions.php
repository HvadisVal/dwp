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

// Function to validate input for letters only
function validateLettersOnly($input) {
    return preg_match('/^[a-zA-Z\s]+$/', $input);
}

// Function to validate numeric input
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
// Function to validate coupon code (only letters and numbers)
function validate_for_letter_numbers($input) {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $input)) {
        return false; // Invalid input, contains characters other than letters or numbers
    }
    return true; // Valid input
}

// Function to validate date format
function validate_date($date) {
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date);
}

// Function to validate year
function validateYear($input) {
    return preg_match('/^\d{4}$/', $input) && $input >= 1000 && $input <= intval(date('Y'));
}

// Function to validate duration format
function validateDuration($input) {
    return preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $input);
}

// Function to validate rating
function validateRating($input) {
    return is_numeric($input) && $input >= 1 && $input <= 10;
}

// Function to validate age limit
function validateAgeLimit($input) {
    return is_numeric($input) && $input >= 0 && $input <= 18;
}

// Function to validate YouTube embed link
function validateYouTubeEmbedLink($input) {
    return strpos($input, "https://www.youtube.com/embed/") === 0;
}

// Function to validate email address
function validate_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}
