<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php  
   // if (logged_in()) { redirect_to("../landing.php"); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        p.error-message {
            text-align: center;
            color: red;
        }
        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .links a {
            color: #3B82F6;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Please login</h2>

    <?php
    if (isset($_POST['submit'])) { // Form has been submitted.
        $username = trim($_POST['user']);
        $password = trim($_POST['pass']);
        
        try {
            // Prepare SQL query using PDO to match the "User" table structure
            $query = "SELECT User_ID, Name, Password FROM User WHERE Name = :username LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $found_user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if user exists and verify the hashed password
            if ($found_user && password_verify($password, $found_user['Password'])) {
                $_SESSION['user_id'] = $found_user['User_ID'];
                $_SESSION['user'] = $found_user['Name'];
                redirect_to("../landing.php");
            } else {
                $message = "Incorrect username or password.";
            }
        } catch (PDOException $e) {
            die("Database query failed: " . $e->getMessage());
        }
    }

    // Display error message if set
    if (!empty($message)) {
        echo "<p class='error-message'>{$message}</p>";
    }
    ?>

    <form action="" method="post">
        <div class="input-field">
            <input id="user" type="text" name="user" required>
            <label for="user">Username</label>
        </div>
        <div class="input-field">
            <input id="pass" type="password" name="pass" required>
            <label for="pass">Password</label>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="submit">Login</button>
    </form>

    <!-- Additional Links for Forgot Password and Create User -->
    <div class="links">
        <a href="forgot_password.php">Forgot Password?</a>
        <a href="newUser.php">Create User</a>
    </div>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>

<?php
if (isset($connection)) { $connection = null; }
?>
