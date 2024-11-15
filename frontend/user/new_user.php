<?php
session_start();
require_once("../includes/connection.php");
require_once("../includes/functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle AJAX form submission for user creation
    header('Content-Type: application/json');

    $username = trim($_POST['user'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    // Validate required fields
    if (!$username || !$email || !$phone || !$password) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    try {
        // Check if username or email already exists
        $checkQuery = "SELECT COUNT(*) FROM User WHERE Name = :username OR Email = :email";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(['success' => false, 'message' => 'Username or email already exists.']);
            exit();
        }

        // Hash the password and insert the new user into the database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO User (Name, Email, TelephoneNumber, Password) VALUES (:username, :email, :phone, :hashed_password)";
        $stmt = $connection->prepare($insertQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':hashed_password', $hashed_password);

        if ($stmt->execute()) {
            // Log the user in by setting session variables
            $_SESSION['user_id'] = $connection->lastInsertId();
            $_SESSION['user'] = $username;

            echo json_encode(['success' => true, 'message' => 'Account created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User could not be created.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .container { max-width: 600px; }
        h2 { text-align: center; }
        .success-message { color: green; }
        .error-message { color: red; }
    </style>
</head>
<body>

<div class="container">
    <h2>Create New User</h2>
    <div id="message" class="error-message"></div>

    <!-- User Registration Form -->
    <form id="newUserForm" class="col s12">
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
        <button class="btn waves-effect waves-light" type="submit">Create</button>
    </form>
</div>

<!-- Materialize JS and jQuery for AJAX -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#newUserForm').on('submit', function(event) {
            event.preventDefault();
            $('#message').removeClass('success-message error-message').text('');

            $.ajax({
                url: '', // Submitting to the same page
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#message').addClass('success-message').text(response.message);
                        $('#newUserForm')[0].reset(); // Reset the form
                    } else {
                        $('#message').addClass('error-message').text(response.message);
                    }
                },
                error: function() {
                    $('#message').addClass('error-message').text("An error occurred while processing the request.");
                }
            });
        });
    });
</script>

</body>
</html>
