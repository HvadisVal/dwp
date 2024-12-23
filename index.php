<?php
require_once("./includes/connection.php"); 

// autoload classes 
spl_autoload_register(function ($class_name) {
    $paths = [
        'admin/controllers/',
        'admin/models/',
    ];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once($file);
            return;
        }
    }
});

$path = isset($_GET['path']) ? $_GET['path'] : 'landing';

// routes
$routes = [
    // admin pages
    'admin/login' => 'admin/controllers/LoginController.php',
    'admin/logout' => 'admin/controllers/LogoutController.php',
    'admin/dashboard' => 'admin/controllers/DashboardController.php',
    'admin/manage-company' => 'admin/controllers/CompanyController.php',
    'admin/manage-coupons' => 'admin/controllers/CouponController.php',
    'admin/manage-movies' => 'admin/controllers/MoviesController.php',
    'admin/manage-news' => 'admin/controllers/NewsController.php',
    'admin/manage-screenings' => 'admin/controllers/ScreeningController.php',
    'admin/manage-bookings' => 'admin/controllers/BookingController.php',
    'admin/manage-landing' => 'admin/controllers/LandingMoviesController.php',
    'admin/manage-messages' => 'admin/controllers/MessageController.php',

    // payment pages
    'payment/apply-coupon' => 'frontend/payment/apply_coupon.php',
    'payment/process-payment' => 'frontend/payment/process_payment.php',
    'payment/checkout' => 'frontend/payment/checkout.php',
    'payment/confirmation' => 'frontend/payment/confirmation.php',

    // user actions
    'user/guest' => 'user/controllers/GuestController.php',
    'user/login' => 'user/controllers/LoginController.php',
    'user/profiles' => 'user/controllers/ProfileController.php',
    'user/logout' => 'user/controllers/LogoutController.php',
    'user/new_user' => 'user/controllers/NewUserController.php',
    'user/switch' => 'user/controllers/SwitchUserController.php',
    'user/forgot-password' => 'frontend/user/forget_password.php',
    'user/edit_user' => 'user/controllers/EditUserController.php',
    'user/delete_user' => 'user/controllers/DeleteUserController.php',
    'admin/manage-messages/reply' => 'admin/controllers/MessageController.php',


    // main pages
    'about' => 'frontend/controllers/AboutController.php',
    'landing' => 'frontend/controllers/LandingController.php', 
    'news' => 'frontend/controllers/NewsController.php',
    'movies' => 'frontend/controllers/MoviesController.php',
    'overview' => 'frontend/controllers/OverviewController.php',
    'save-selection' => 'frontend/actions/save_selection.php',
    'seat' => 'frontend/controllers/SeatController.php',
    'validate-coupon' => 'frontend/actions/validate_coupon.php',
    'invoice' => 'frontend/controllers/InvoiceController.php',
    'movie'=> 'frontend/controllers/MovieProfileController.php',
    'guest-checkout' => 'frontend/controllers/GuestCheckoutController.php',
    'footer' => 'frontend/controllers/FooterController.php',   
    
];

// route the request based on the path
function routeRequest($path, $routes, $connection) {
    if (strpos($path, 'admin/') === 0 && $path !== 'admin/login') {
        require_once("./includes/admin_session.php"); 

        if (!admin_logged_in()) {
            header('Location: /dwp/admin/login'); 
            exit;
        }
    }
    if ($path == 'admin/dashboard') {
        loadController('DashboardController', $connection, 'getAdminEmail');
        include 'admin/views/dashboard.php';
        return;
    }

    if ($path == 'admin/logout') {
        loadController('LogoutController', $connection, 'logout');
        return;
    }
    
    if ($path === 'save-selection') {
        require_once 'frontend/actions/save_selection.php';
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
    
    if ($path === 'user/profiles') {
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

    if ($path === 'contact') {
        require_once 'frontend/controllers/ContactController.php';
        $controller = new ContactController($connection);
        $controller->showForm();
        exit;
    }
    
    if ($path === 'contact/submit') {
        require_once 'frontend/controllers/ContactController.php';
        $controller = new ContactController($connection);
        $controller->submitForm();
        exit;
    }

    if ($path === 'user/forgot-password') {
        require_once 'user/controllers/ForgotPasswordController.php';
        $controller = new ForgotPasswordController($connection);
        $controller->handleRequest();
        exit;
    }
    
    if ($path === 'user/reset-password') {
        require_once 'user/controllers/ResetPasswordController.php';
        $controller = new ResetPasswordController($connection);
        $controller->handleRequest();
        exit;
    }

    if (strpos($path, 'admin/manage-messages/reply') === 0) {
        $pathParts = explode('/', $path);
        $messageId = isset($pathParts[3]) ? (int)$pathParts[3] : null;
    
        require_once 'admin/controllers/MessageController.php';
        $controller = new MessageController($connection);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reply = $_POST['reply'] ?? '';
            $controller->replyToMessage($messageId, $reply);
            exit;
        } else {
            $controller->handleRequest();  
            exit;
        }
    }
    
 if (strpos($path, 'admin/manage-messages/reply') === 0) {
    $pathParts = explode('/', $path);
    $messageId = isset($pathParts[3]) ? (int)$pathParts[3] : null;
    if ($messageId) {
        require_once 'admin/controllers/MessageController.php';
        $controller = new MessageController($connection);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reply = $_POST['reply'] ?? '';
            $controller->replyToMessage($messageId, $reply);
        } else {
            $controller->handleRequest(); 
        }
        exit;
    }
}

    
     if (array_key_exists($path, $routes)) {
        require_once($routes[$path]);
        
        $controllerName = basename($routes[$path], '.php'); 
        $controllerClass = ucfirst($controllerName);  
        $controller = new $controllerClass($connection);
        $controller->handleRequest(); 
        return;
    }


    http_response_code(404);
    echo "404 - Page Not Found";
}

function loadController($controllerName, $connection, $methodName = 'handleRequest') {
    require_once("admin/controllers/{$controllerName}.php");
    $controller = new $controllerName($connection);
    $controller->$methodName();
}

routeRequest($path, $routes, $connection);

// footer
$pagesWithFooter = [
    'landing',
    'news',
    'movies',
    'movie',
];

if (in_array($path, $pagesWithFooter)) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/FooterController.php';
    $footer = new FooterController($connection);
    $footer->handleRequest();
}
