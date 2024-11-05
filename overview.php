<?php
session_start();
require_once("includes/connection.php");

// Check if the user or guest is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = isset($_SESSION['guest_user_id']);

// Get movie, screening, and seat details from session
$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;
$selectedSeats = json_decode($_SESSION['selectedSeats'] ?? '[]', true);
$ticketPrice = 135;

// Fetch movie details
$movieQuery = $connection->prepare("SELECT * FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Overview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .modal { max-width: 600px; }
        .action-buttons { margin-top: 20px; }
        .order-summary, .movie-details, .user-info { padding: 15px; margin-top: 20px; background: #333; color: white; border-radius: 8px; }
        .login-info { display: flex; align-items: center; justify-content: space-between; }
        .login-links { display: flex; justify-content: space-between; margin-top: 15px; }
        .login-links a { color: #3B82F6; text-decoration: none; }
        .login-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h4>Booking Overview</h4>

    <!-- Movie Details Section -->
    <div class="movie-details">
        <h5>Movie: <?= htmlspecialchars($movie['Title'] ?? 'N/A'); ?></h5>
        <p><strong>Duration:</strong> <?= htmlspecialchars($movie['Duration'] ?? 'N/A'); ?></p>
        <p><strong>Rating:</strong> <?= htmlspecialchars($movie['Rating'] ?? 'N/A'); ?> / 10</p>
        <p><strong>Cinema Hall:</strong> Hall <?= htmlspecialchars($cinema_hall_id); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($showtime); ?></p>
    </div>

    <!-- Login, Guest Checkout, or User/Guest Information Display -->
    <?php if ($isLoggedIn): ?>
        <!-- Logged-in User Information and Logout Button -->
        <div id="userInfo" class="user-info login-info">
            <span>Welcome, <?= htmlspecialchars($_SESSION['user']); ?></span>
            <button id="logoutButton" class="btn red">Logout</button>
        </div>
    <?php elseif ($isGuest && isset($_SESSION['guest_firstname'], $_SESSION['guest_lastname'], $_SESSION['guest_email'])): ?>
        <!-- Guest Information -->
        <div class="user-info">
            <h5>Guest Information</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['guest_firstname'] . " " . $_SESSION['guest_lastname']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['guest_email']); ?></p>
        </div>
    <?php else: ?>
        <!-- Action Buttons for Login or Guest Checkout -->
        <div class="action-buttons">
            <button class="btn modal-trigger" data-target="loginModal">Login</button>
            <button class="btn modal-trigger" data-target="guestModal">Continue as Guest</button>
        </div>
    <?php endif; ?>

    <!-- Order Summary -->
    <div class="order-summary">
        <h5>Order Summary</h5>
        <p>Total Tickets: <?= count($selectedSeats); ?></p>
        <p>Total Price: DKK <?= count($selectedSeats) * $ticketPrice; ?></p>
    </div>
</div>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <h5>Login</h5>
        <form id="loginForm">
            <div class="input-field">
                <input id="username" type="text" name="user" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" name="pass" required>
                <label for="password">Password</label>
            </div>
            <button class="btn blue" type="submit">Login</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>

        <!-- Additional links for "Forgot Password" and "Create New User" -->
        <div class="login-links">
            <a href="User/forgot_password.php">Forgot Password?</a>
            <a class="modal-trigger" data-target="newUserModal" style="cursor:pointer;">Create New User</a>
        </div>
    </div>
</div>

<!-- Guest Checkout Modal -->
<div id="guestModal" class="modal">
    <div class="modal-content">
        <h5>Guest Checkout</h5>
        <form id="guestForm">
            <div class="row">
                <div class="input-field col s6">
                    <input id="firstname" type="text" name="firstname" required>
                    <label for="firstname">First Name</label>
                </div>
                <div class="input-field col s6">
                    <input id="lastname" type="text" name="lastname" required>
                    <label for="lastname">Surname</label>
                </div>
            </div>
            <div class="input-field">
                <input id="email" type="email" name="email" required>
                <label for="email">E-mail</label>
            </div>
            <button class="btn blue" type="submit">Further</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>

<!-- Create New User Modal -->
<div id="newUserModal" class="modal">
    <div class="modal-content">
        <h5>Create New User</h5>
        <form id="newUserForm">
            <div class="input-field">
                <input id="new_username" type="text" name="user" required>
                <label for="new_username">Username</label>
            </div>
            <div class="input-field">
                <input id="new_email" type="email" name="email" required>
                <label for="new_email">Email</label>
            </div>
            <div class="input-field">
                <input id="new_phone" type="text" name="phone" required>
                <label for="new_phone">Telephone Number</label>
            </div>
            <div class="input-field">
                <input id="new_password" type="password" name="pass" required>
                <label for="new_password">Password</label>
            </div>
            <button class="btn blue" type="submit">Create Account</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>

<!-- Materialize JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modals = document.querySelectorAll('.modal');
        M.Modal.init(modals);
    });

    // Login Form Submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'User/ajax_login.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    $('.error-message').text(response.message).show();
                }
            }
        });
    });

    // Guest Checkout Form Submission
    $('#guestForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'User/ajax_guest.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    $('.error-message').text(response.message).show();
                }
            }
        });
    });

    // New User Form Submission
    $('#newUserForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'User/ajax_new_user.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#newUserModal').modal('close'); // Close the modal after success
                    M.toast({html: 'User account created successfully! Please login.'});
                } else {
                    $('.error-message').text(response.message).show();
                }
            }
        });
    });

    // Logout AJAX request
    $('#logoutButton').on('click', function() {
        $.ajax({
            type: 'POST',
            url: 'User/ajax_logout.php',
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    location.reload();
                } else {
                    console.error("Logout failed");
                }
            },
            error: function() {
                console.error("An error occurred during logout");
            }
        });
    });
</script>
</body>
</html>
