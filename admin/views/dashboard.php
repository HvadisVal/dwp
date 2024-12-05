<?php
// admin/views/dashboard.php
require_once('includes/admin_session.php'); 
require_once('./admin/controllers/DashboardController.php');

$controller = new DashboardController();
$adminEmail = $controller->getAdminEmail();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/dwp/admin/assets/css/dashboard.css">
</head>
<body>
<div class="logo">
        <img src="../images/12.png" alt="Logo" height = 70px>
    </div>

    <header>
        <h2>Welcome, Admin!</h2>
        <p>You are logged in as <?= htmlspecialchars($adminEmail); ?></p>
    </header>

    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Landing Movies</span>
                        <p>View, edit, or remove users in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-landing" class="btn waves-effect waves-light">Manage Landing Movies</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Movies</span>
                        <p>View, edit, or add movies to the database.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-movies" class="btn waves-effect waves-light">Manage Movies</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Bookings</span>
                        <p>View or manage customer bookings.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-bookings" class="btn waves-effect waves-light">Manage Bookings</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage News</span>
                        <p>View, edit, or remove news in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-news" class="btn waves-effect waves-light">Manage News</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Screenings</span>
                        <p>View, edit, or remove screenings in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-screenings" class="btn waves-effect waves-light">Manage Screenings</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Company</span>
                        <p>View, edit, or remove companies in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-company" class="btn waves-effect waves-light">Manage companies</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Coupons</span>
                        <p>View, edit, or remove coupons in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="/dwp/admin/manage-coupons" class="btn waves-effect waves-light">Manage Coupons</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Contact Forms</span>
                        <p>View, edit, or remove contact forms in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="manage_users.php" class="btn waves-effect waves-light">Manage Contact Forms</a>
                    </div>
                </div>
            </div>
        </div>

    <!-- Logout Button -->
    <div class="container">
        <form action="/dwp/admin/logout" method="POST" style="text-align: center;">
            <button class="btn-red" type="submit">LogOut</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?= date("Y"); ?> Admin Panel</p>
    </footer>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>