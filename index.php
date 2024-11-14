<?php
// Get the path from the URL, e.g., "admin/manage_movies"
$path = isset($_GET['path']) ? $_GET['path'] : 'landing';

// Define routes - mapping URL paths to file locations
$routes = [
    // Admin pages
    'admin/login' => 'admin/admin_login.php',
    'admin/logout' => 'admin/admin_logout.php',
    'admin/dashboard' => 'admin/admin_dashboard.php',
    'admin/manage-company' => 'admin/manage_company.php',
    'admin/manage-coupons' => 'admin/manage_coupons.php',
    'admin/manage-movies' => 'admin/manage_movies.php',
    'admin/manage-news' => 'admin/manage_news.php',
    'admin/manage-screenings' => 'admin/manage_screenings.php',

    // Payment pages
    'payment/apply-coupon' => 'Payment/ajax_apply_coupon.php',
    'payment/process-payment' => 'Payment/ajax_process_payment.php',
    'payment/checkout' => 'Payment/checkout.php',
    'payment/confirmation' => 'Payment/confirmation.php',

    // User actions
    'user/guest' => 'User/ajax_guest.php',
    'user/login' => 'User/ajax_login.php',
    'user/logout' => 'User/ajax_logout.php',
    'user/new' => 'User/ajax_new_user.php',
    'user/switch' => 'User/ajax_switch_user.php',

    // Main pages
    'about' => 'about_us.php',
    'landing' => 'landing.php', // default path if no path specified
    'movies' => 'movies.php',
    'overview' => 'overview.php',
    'save-selection' => 'save_selection.php',
    'seat' => 'Seat.php',
    'validate-coupon' => 'validate_coupon.php',
];

// Check if the requested path exists in the routes array
if (array_key_exists($path, $routes)) {
    include $routes[$path];
} else {
    // Display 404 page if route not found
    http_response_code(404);
    echo "404 - Page Not Found";
}
