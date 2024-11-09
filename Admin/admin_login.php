<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../includes/admin_session.php');  // Admin session management
require_once('../includes/connection.php');
require_once('../includes/functions.php');

// Ensure no output before header() functions
ob_start();  // Start output buffering

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-field {
            margin-bottom: 20px;
        }
        .btn {
            width: 100%;
        }
        p {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>

    <?php
    if (isset($_POST['submit'])) { // Form has been submitted.
        $email = trim($_POST['email']);
        $password = trim($_POST['pass']);
        
        try {
            // Prepare SQL query using PDO to match the "Admin" table structure
            $query = "SELECT Admin_ID, Email, Password FROM Admin WHERE Email = :email LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $found_admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if admin exists and verify the hashed password
            if ($found_admin && password_verify($password, $found_admin['Password'])) {
                // Set session variables for admin login
                $_SESSION['admin_id'] = $found_admin['Admin_ID'];
                $_SESSION['admin_email'] = $found_admin['Email'];
                redirect_to("admin_dashboard.php");
            } else {
                $message = "Incorrect email or password.";
            }
        } catch (PDOException $e) {
            die("Database query failed: " . $e->getMessage());
        }
    }

    // Display error message if set
    if (!empty($message)) {
        echo "<p>{$message}</p>";
    }
    ?>

    <form action="" method="post">
        <div class="input-field">
            <input id="email" type="email" name="email" required>
            <label for="email">Email</label>
        </div>
        <div class="input-field">
            <input id="pass" type="password" name="pass" required>
            <label for="pass">Password</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="submit">Login</button>
    </form>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>

<?php
if (isset($connection)) { $connection = null; }
ob_end_flush();  // Flush the output buffer
?>