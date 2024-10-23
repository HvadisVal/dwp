<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
// Check if admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_id'])) {
    redirect_to("adminLogin.php"); // Redirect to the admin login page if not logged in
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        .btn {
            margin-top: 20px;
        }
        footer {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <header>
        <h2>Welcome, Admin!</h2>
        <p>You are logged in as <?php echo htmlspecialchars($_SESSION['admin_email']); ?></p>
    </header>

    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Manage Users</span>
                        <p>View, edit, or remove users in the system.</p>
                    </div>
                    <div class="card-action">
                        <a href="manage_users.php" class="btn waves-effect waves-light">Manage Users</a>
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
                        <a href="manage_movies.php" class="btn waves-effect waves-light">Manage Movies</a>
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
                        <a href="manage_bookings.php" class="btn waves-effect waves-light">Manage Bookings</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add more sections for admin tasks as needed -->
    </div>

    <!-- Logout Button -->
    <div class="container">
        <form action="logout.php" method="POST" style="text-align: center;">
            <button class="btn red" type="submit">Logout</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Panel</p>
    </footer>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
