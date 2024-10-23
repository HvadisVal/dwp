<?php require_once "../dbcon.php"; ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php //confirm_logged_in(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .container {
            max-width: 800px;
        }
        form {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create New User</h2>

    <?php
$message = ""; // Initialize message variable

// START FORM PROCESSING
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if form is submitted
    $username = isset($_POST['user']) ? trim($_POST['user']) : null;  // Grabbing the username from the form
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;  // Grabbing the email from the form
    $telephone = isset($_POST['phone']) ? trim($_POST['phone']) : null;  // Grabbing the telephone number from the form
    $password = isset($_POST['pass']) ? trim($_POST['pass']) : null;  // Grabbing the password from the form

    // Check if any required field is missing
    if (!$username || !$email || !$telephone || !$password) {
        $message = "All fields are required.";
    } else {
        // Hash the password using bcrypt with a cost factor of 15
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 15]);

        try {
            // Prepare the SQL query to insert user into the "User" table
            $query = "INSERT INTO User (Name, Email, TelephoneNumber, Password) VALUES (:username, :email, :phone, :hashed_password)";
            $stmt = $connection->prepare($query);

            // Bind parameters to the SQL query to protect against SQL injection
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $telephone);
            $stmt->bindParam(':hashed_password', $hashed_password);

            // Execute the query to insert the new user into the database
            if ($stmt->execute()) {
                // Redirect to the login page if user creation is successful
                header("Location: login.php");
                exit();
            } else {
                $message = "User could not be created.";
            }
        } catch (PDOException $e) {
            // If an error occurs, show the error message
            $message = "User could not be created. Error: " . htmlspecialchars($e->getMessage());
        }
    }
}

// Display any messages (errors or success) if they are set
if (!empty($message)) {
    echo "<div class='card-panel teal lighten-4'>" . htmlspecialchars($message) . "</div>";
}
?>


    <!-- Form for creating a new user -->
    <form class="col s12" action="" method="post">
    <div class="row">
        <div class="input-field col s12">
            <input id="username" name="user" type="text" class="validate" required>
            <label for="username">Username</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="email" name="email" type="email" class="validate" required>
            <label for="email">Email</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="phone" name="phone" type="text" class="validate" required>
            <label for="phone">Telephone Number</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <input id="password" name="pass" type="password" class="validate" required>
            <label for="password">Password</label>
        </div>
    </div>
    <button class="btn waves-effect waves-light" type="submit" name="submit">Create</button>
</form>

</div>

<!-- Materialize JS for form interaction -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

<?php 
// Close the database connection if it's open
if (isset($connection)) {
    $connection = null; 
}
?>
