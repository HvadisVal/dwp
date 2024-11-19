<?php
// Get the path from the URL, e.g., "admin/manage_movies"
$path = isset($_GET['path']) ? $_GET['path'] : 'landing';

// Define routes - mapping URL paths to file locations
$routes = [
    // Admin pages
    'admin/login' => 'admin/admin_login/admin_login.html',
    'admin/processed-login'=> 'admin/admin_login/processed_login.php',
    'admin/logout' => 'admin/admin_logout.php',
    'admin/dashboard' => 'admin/admin_dashboard/admin_dashboard.php',
    'admin/manage-company' => 'admin/company/company_structure.php',
    'admin/processed-company' => 'admin/company/manage_company.php',
    'admin/manage-coupons' => 'admin/coupons/coupons_structure.php',
    'admin/processed-coupons' => 'admin/coupons/manage_coupons.php',
    'admin/manage-movies' => 'admin/movies/movies_structure.php',
    'admin/processed-movies' => 'admin/movies/manage_movies.php',
    'admin/manage-news' => 'admin/news/news_structure.php',
    'admin/processed-news' => 'admin/news/manage_news.php',
    'admin/manage-screenings' => 'admin/screenings/screenings_structure.php',
    'admin/processed-screenings' => 'admin/screenings/manage_screenings.php',


    // payment pages
    'payment/apply-coupon' => 'frontend/payment/apply_coupon.php',
    'payment/process-payment' => 'frontend/payment/process_payment.php',
    'payment/checkout' => 'frontend/payment/checkout.php',
    'payment/confirmation' => 'frontend/payment/confirmation.php',

    // user actions
    'user/guest' => 'frontend/user/guest.php',
    'user/login' => 'frontend/user/login.php',
    'user/logout' => 'frontend/user/logout.php',
    'user/new_user' => 'frontend/user/new_user.php',
    'user/switch' => 'frontend/user/switch_user.php',
    'user/forgot-password' => 'frontend/user/forget_password.php',

    // Main pages
    'about' => 'frontend/about_us.php',
    'landing' => 'frontend/landing.php', // default path if no path specified
    'news' => 'frontend/news.php',
    /* 'movies' => 'frontend/movies.php', */
    'movies' => 'frontend/movies/movies.php',
    'overview' => 'frontend/overview.php',
    /* 'save-selection' => 'frontend/save_selection.php',
    'seat' => 'frontend/seat.php', */
    'save-selection' => 'frontend/seat/save_selection.php',
    'seat' => 'frontend/seat/seat.php',
    'validate-coupon' => 'frontend/validate_coupon.php',
];

// Check if the requested path exists in the routes array
if (array_key_exists($path, $routes)) {
    include $routes[$path];
} else {
    // Display 404 page if route not found
    http_response_code(404);
    echo "404 - Page Not Found";
}