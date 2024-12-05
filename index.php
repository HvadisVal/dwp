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
    'user/guest' => 'user/controllers/GuestController.php',
    'user/login' => 'user/controllers/LoginController.php',
    'user/profile' => 'user/controllers/ProfileController.php',
    'user/logout' => 'user/controllers/LogoutController.php',
    'user/new_user' => 'user/controllers/NewUserController.php',
    'user/switch' => 'user/controllers/SwitchUserController.php',
    'user/forgot-password' => 'frontend/user/forget_password.php',
    'user/edit_user' => 'user/controllers/EditUserController.php',
    'user/delete_user' => 'user/controllers/DeleteUserController.php',

    // Main pages
    'about' => 'frontend/controllers/AboutController.php',
    'landing' => 'frontend/controllers/LandingController.php', // default path if no path specified
    'news' => 'frontend/controllers/NewsController.php',
    /* 'movies' => 'frontend/movies.php', */
    'movies' => 'frontend/controllers/MoviesController.php',
    /* 'overview' => 'frontend/overview.php',*/
    'overview' => 'frontend/controllers/OverviewController.php',
    /* 'save-selection' => 'frontend/save_selection.php',
    'seat' => 'frontend/seat.php', */
    'save-selection' => 'frontend/save_selection.php',
    'seat' => 'frontend/controllers/SeatController.php',
    'validate-coupon' => 'frontend/validate_coupon.php',
    'invoice' => 'frontend/controllers/InvoiceController.php',
    'movie'=> 'frontend/controllers/MovieProfileController.php',
    'guest-checkout' => 'frontend/controllers/GuestCheckoutController.php',
    'footer' => 'frontend/controllers/FooterController.php',   
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
    
    if ($path === 'save-selection') {
        require_once 'frontend/save_selection.php';
        exit;
    }

    if ($path === 'user/guest') {
        require_once 'user/controllers/GuestController.php';
        $controller = new GuestController($connection);
        $controller->handleRequest();
        exit;
    }    
    
    if ($path === 'user/login') {
        require_once 'user/controllers/LoginController.php';
        $controller = new LoginController($connection);
        $controller->handleRequest();
        exit;
    }
    
    if ($path === 'user/logout') {
        require_once 'user/controllers/LogoutController.php';
        $controller = new LogoutController($connection);
        $controller->handleRequest();
        exit;
    }
    
    if ($path === 'user/switch') {
        require_once 'user/controllers/SwitchUserController.php';
        $controller = new SwitchUserController($connection);
        $controller->handleRequest();
        exit;
    }

    if ($path === 'user/new_user') {
        require_once 'user/controllers/NewUserController.php';
        $controller = new NewUserController($connection); //
        $controller->handleRequest();
        exit();
    }
    
    if ($path === 'user/profile') {
        require_once 'user/controllers/ProfileController.php';
        $controller = new ProfileController($connection);
        $controller->handleRequest();
        exit;
    }    

    if ($path === 'user/edit_user') {
        require_once 'user/controllers/EditUserController.php';
        $controller = new EditUserController($connection);
        $controller->handleRequest();
        exit;
    }

    if ($path === 'user/delete_user') {
        require_once 'user/controllers/DeleteUserController.php';
        $controller = new DeleteUserController($connection);
        $controller->handleRequest();
        exit;
    }
    
  /*   if ($path === 'user/booking_process') {
        require_once 'user/controllers/BookingProcessController.php';
        $controller = new BookingProcessController($connection);
        $controller->handleRequest();
        exit;
    } */
    
    
    

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
// Footer
/* require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/FooterController.php';
$footer = new FooterController($connection);
$footer->handleRequest(); */
// Pages where footer should appear
$pagesWithFooter = [
    'landing',
    'news',
    'movies',
    'movie',
];// Conditionally include footer
if (in_array($path, $pagesWithFooter)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/FooterController.php';
    $footer = new FooterController($connection);
    $footer->handleRequest();
}
