<?php
require_once('./includes/admin_session.php'); 
require_once( './includes/connection.php');
require_once('./includes/functions.php');


?>
<?php
// Check if admin is logged in, otherwise redirect to login page
// if (!isset($_SESSION['admin_id'])) {
//    redirect_to("admin_login.php"); // Redirect to the admin login page if not logged in
//}
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
       .logo{
            display: flex;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
       }
        body {
            padding: 20px;
            background: linear-gradient(0deg, rgba(5,15,99,1) 0%, rgba(255,255,255,0.5508578431372548) 100%);
        }
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        .card{
            border-radius: 15px;
            color: white;
            background: linear-gradient(to right, #243642, #1a252d)
        }
        .btn {
            margin-top: 20px;
            background: white;
            color: black;
            border-radius: 15px;
        }

        .btn-red{
            background: white;
            color: black;
            padding: 10px 30px;
            border-radius: 15px;
            border: none;
        }
        footer {
            text-align: center;
            color: white;
            margin-top: 50px;
        }


    .btn:hover {
    background: #1a252d; 
    color: white;
    transition:  0.3s ease, color 0.3s ease;
    }

    .btn-red:hover {
    background: #1a252d; 
    color: white;
    transition:  0.3s ease, color 0.3s ease; 
    }

    

   

    </style>
</head>
<body>
    <div class="logo">
        <img src="../images/12.png" alt="Logo" height = 70px>
    </div>

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
                        <a href="manage_bookings.php" class="btn waves-effect waves-light">Manage Bookings</a>
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

        <!-- Add more sections for admin tasks as needed -->
    </div>

    <!-- Logout Button -->
    <div class="container">
        <form action="/dwp/admin/logout" method="POST" style="text-align: center;">
            <button class="btn-red" type="submit">LogOut</button>
        </form>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Panel</p>
    </footer>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
