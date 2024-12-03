<?php
require_once("./includes/connection.php"); 

// Autoload classes (optional but recommended)
spl_autoload_register(function ($class_name) {
    $paths = [
        'admin/controllers/',
        'admin/models/',
        // Add other paths if necessary
    ];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once($file);
            return;
        }
    }
});

// Get the path from the URL, e.g., "admin/manage_movies"
$path = isset($_GET['path']) ? $_GET['path'] : 'landing';

// Define routes - mapping URL paths to file locations
$routes = [
    // Admin pages
    'admin/login' => 'admin/controllers/LoginController.php',
    'admin/logout' => 'admin/controllers/LogoutController.php',
    'admin/dashboard' => 'admin/controllers/DashboardController.php',
    'admin/manage-company' => 'admin/controllers/CompanyController.php',
    'admin/manage-coupons' => 'admin/controllers/CouponController.php',
    'admin/manage-movies' => 'admin/controllers/MoviesController.php',
    'admin/manage-news' => 'admin/controllers/NewsController.php',
    'admin/manage-screenings' => 'admin/controllers/ScreeningController.php',
    'admin/manage-bookings' => 'admin/controllers/BookingController.php',


    // payment pages
    'payment/apply-coupon' => 'frontend/payment/apply_coupon.php',
    'payment/process-payment' => 'frontend/payment/process_payment.php',
    'payment/checkout' => 'frontend/payment/checkout.php',
    'payment/confirmation' => 'frontend/payment/confirmation.php',

    // user actions
    'user/guest' => 'frontend/user/guest.php',
    'user/login' => 'frontend/user/login.php',
    'user/profile' => 'frontend/user/profile/profile.php',
    'user/logout' => 'frontend/user/logout.php',
    'user/new_user' => 'frontend/user/new_user/new_user.php',
    'user/switch' => 'frontend/user/switch_user.php',
    'user/forgot-password' => 'frontend/user/forget_password.php',

    // Main pages
    'about' => 'frontend/about_us.php',
    'landing' => 'frontend/controllers/LandingController.php', // default path if no path specified
    'news' => 'frontend/news.php',
    /* 'movies' => 'frontend/movies.php', */
    'movies' => 'frontend/movies/movies.php',
    /* 'overview' => 'frontend/overview.php',*/
    'overview' => 'frontend/overview/overview.php',
    /* 'save-selection' => 'frontend/save_selection.php',
    'seat' => 'frontend/seat.php', */
    'save-selection' => 'frontend/seat/save_selection.php',
    'seat' => 'frontend/seat/seat.php',
    'validate-coupon' => 'frontend/payment/validate_coupon.php',
    'movie'=> 'frontend/controllers/MovieProfileController.php',
    'checkout'=> 'frontend/checkout.php',
];

// Define a function to handle the routing process
function routeRequest($path, $routes, $connection) {
    // Check for login route
    if ($path == 'admin/login') {
        loadController('LoginController', $connection, 'login');
        return;
    }

    // Check for dashboard route
    if ($path == 'admin/dashboard') {
        loadController('DashboardController', $connection, 'getAdminEmail');
        include 'admin/views/dashboard.php';
        return;
    }

    // Check for logout route
    if ($path == 'admin/logout') {
        loadController('LogoutController', $connection, 'logout');
        return;
    }
    

     // Handle other dynamic routes based on the $routes array
     if (array_key_exists($path, $routes)) {
        // Dynamically include the controller
        require_once($routes[$path]);
        
        // Instantiate the controller class and handle the request
        $controllerName = basename($routes[$path], '.php'); // Get class name based on file
        $controllerClass = ucfirst($controllerName);  // Convert to PascalCase
        $controller = new $controllerClass($connection);
        $controller->handleRequest(); // Let the controller handle the rendering
        return;
    }

    // Default to 404 if no route matched
    http_response_code(404);
    echo "404 - Page Not Found";
}

// Helper function to load a controller method dynamically
function loadController($controllerName, $connection, $methodName = 'handleRequest') {
    require_once("admin/controllers/{$controllerName}.php");
    $controller = new $controllerName($connection);
    $controller->$methodName();
}

// Example usage (you would call this function based on the current request path)
routeRequest($path, $routes, $connection);
