<?php
session_start();
require_once("includes/connection.php");

$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;
$guest_user_id = $_SESSION['guest_user_id'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if (!$movie_id || !$cinema_hall_id || !$showtime) {
    // Reset to initial state if movie data is missing (e.g., user goes back after guest checkout)
    unset($_SESSION['guest_user_id'], $_SESSION['user_id']);
    header("Location: overview.php"); // Refresh the page to reset the session
    exit();
}

// Fetch movie details
$movieQuery = $connection->prepare("SELECT * FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);

// Determine if invoice was sent
$invoiceSent = $_SESSION['guest_invoice_sent'] ?? false;
if ($invoiceSent) {
    // Clear session data related to guest after confirmation is displayed
    unset($_SESSION['guest_user_id'], $_SESSION['guest_invoice_sent']);
}
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

    <?php if ($invoiceSent): ?>
        <!-- Invoice Sent Confirmation -->
        <div class="order-summary">
            <h5>Confirmation</h5>
            <p>Your invoice has been sent to your email.</p>
        </div>
    <?php elseif ($user_id): ?>
        <!-- Logged-in User Information -->
        <div class="order-summary">
            <h5>User Information</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user'] ?? 'N/A'); ?></p>
            <!-- Add other user details as needed -->
        </div>
    <?php else: ?>
        <!-- Action Buttons for Login or Guest Checkout -->
        <div class="action-buttons">
            <a href="User/logIn.php" class="btn">Log in or create an account</a>
            <a class="btn modal-trigger" data-target="guestModal">Continue as Guest</a>
        </div>
    <?php endif; ?>

    <!-- Order Summary -->
    <div class="order-summary">
        <h5>Order Summary</h5>
        <p id="ticket-count">Total Tickets: </p>
        <p id="total-price">Total Price: </p>
    </div>
</div>

<!-- Guest Checkout Modal -->
<div id="guestModal" class="modal">
    <div class="modal-content">
        <h5>Guest Checkout</h5>
        <form method="POST" action="User/guest_checkout.php">
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
            <div class="input-field">
                <input id="confirm_email" type="email" name="confirm_email" required>
                <label for="confirm_email">Confirm Email</label>
            </div>
            <div class="input-field">
                <input id="phone" type="text" name="phone" required>
                <label for="phone">Telephone</label>
            </div>
            <button class="btn blue" type="submit">Further</button>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn-flat">Close</a>
    </div>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        M.Modal.init(elems);
    });

    // Calculate and display total tickets and price
    const selectedSeats = JSON.parse(sessionStorage.getItem('selectedSeats')) || [];
    const ticketPrice = 135;
    document.getElementById('ticket-count').textContent = `Total Tickets: ${selectedSeats.length}`;
    document.getElementById('total-price').textContent = `Total Price: DKK ${selectedSeats.length * ticketPrice}`;
</script>
</body>
</html>
