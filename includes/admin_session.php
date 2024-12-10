<?php

// Start secure session
session_start([
    'cookie_secure' => true,
    'cookie_httponly' => true,
    'cookie_samesite' => 'Strict',
]);
function admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

function confirm_admin_logged_in() {
    if (!admin_logged_in()) {
        redirect_to("admin_dashboard.php");
    }
}
