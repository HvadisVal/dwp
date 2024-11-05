<?php
session_start();
require_once("includes/connection.php");

$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;
$selectedSeats = json_decode($_SESSION['selectedSeats'] ?? '[]');
$totalPrice = count($selectedSeats) * 135; // Assuming ticket price is DKK 135 per seat

if (!$movie_id || !$cinema_hall_id || !$showtime || empty($selectedSeats)) {
    // If session data is missing, redirect to the overview page
    header("Location: overview.php");
    exit();
}

// Movie query to get movie details
$movieQuery = $connection->prepare("SELECT * FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Method</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body { background-color: #121212; color: white; }
        .container { margin-top: 20px; }
        .order-summary, .payment-method { padding: 15px; margin-top: 20px; background: #333; color: white; border-radius: 8px; }
        .payment-option { display: flex; align-items: center; margin-bottom: 15px; }
        .payment-option img { width: 50px; margin-right: 15px; }
        .payment-option label { font-size: 1.2em; cursor: pointer; }
        .total-price { font-weight: bold; font-size: 1.5em; }
    </style>
</head>
<body>

<div class="container">
    <h4>Complete Your Booking</h4>

    <!-- Order Summary Section -->
    <div class="order-summary">
        <h5>Order Summary</h5>
        <p><strong>Movie:</strong> <?= htmlspecialchars($movie['Title'] ?? 'N/A'); ?></p>
        <p><strong>Cinema Hall:</strong> Hall <?= htmlspecialchars($cinema_hall_id); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($showtime); ?></p>
        <p><strong>Total Tickets:</strong> <?= count($selectedSeats); ?></p>
        <p class="total-price">Total Price: DKK <?= htmlspecialchars($totalPrice); ?></p>
    </div>

    <!-- Payment Method Selection -->
    <div class="payment-method">
        <h5>Select Payment Method</h5>
        
        <form action="process_payment.php" method="post">
            <div class="payment-option">
                <input type="radio" id="mobilepay" name="payment_method" value="MobilePay" required>
                <label for="mobilepay"><img src="path-to-mobilepay-icon.png" alt="MobilePay Icon"> MobilePay</label>
            </div>

            <div class="payment-option">
                <input type="radio" id="credit_card" name="payment_method" value="Credit Card">
                <label for="credit_card"><img src="path-to-creditcard-icons.png" alt="Credit Card Icons"> Credit Card</label>
            </div>

            <div class="payment-option">
                <input type="radio" id="gift_card" name="payment_method" value="Gift Card">
                <label for="gift_card"><img src="path-to-giftcard-icon.png" alt="Gift Card Icon"> Redeem Gift Cards</label>
            </div>
            
            <p>
                <label>
                    <input type="checkbox" required />
                    <span>I accept the <a href="terms.php" target="_blank" style="color: #4FC3F7;">payment terms</a></span>
                </label>
            </p>

            <button class="btn waves-effect waves-light blue" type="submit">Pay DKK <?= htmlspecialchars($totalPrice); ?></button>
        </form>
    </div>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
