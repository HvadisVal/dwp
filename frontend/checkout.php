<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

// Check if the session contains GuestUser_ID
if (!isset($_SESSION['guest_user_id'])) {
    // Redirect to homepage if no guest user is logged in
    header('Location: /dwp/movies');
    exit;
}

$guestUserId = $_SESSION['guest_user_id'];

// Connect to the database
try {
    $dbCon = dbCon($user, $pass);

    // Fetch booking information for the guest user
    $stmt = $dbCon->prepare("
        SELECT b.BookingDate, b.NumberOfTickets, b.TotalPrice, m.Title AS MovieTitle, m.Duration AS MovieDuration, m.Rating AS MovieRating
        FROM Booking b
        JOIN Movie m ON b.Movie_ID = m.Movie_ID
        WHERE b.GuestUser_ID = :guestUserId
        ORDER BY b.BookingDate DESC
        LIMIT 1
    ");
    $stmt->bindParam(':guestUserId', $guestUserId);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        $error = "No booking information found.";
    }
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Complete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .booking-info {
            margin-top: 20px;
        }
        .booking-info p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            text-align: center;
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You for Your Order</h1>
        <h2>Your Booking is Now Complete</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php else: ?>
            <div class="booking-info">
                <p><strong>Movie:</strong> <?= htmlspecialchars($booking['MovieTitle']) ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($booking['MovieDuration']) ?> minutes</p>
                <p><strong>Rating:</strong> <?= htmlspecialchars($booking['MovieRating']) ?>/10</p>
                <p><strong>Booking Date:</strong> <?= htmlspecialchars($booking['BookingDate']) ?></p>
                <p><strong>Number of Tickets:</strong> <?= htmlspecialchars($booking['NumberOfTickets']) ?></p>
                <p><strong>Total Price:</strong> DKK <?= number_format($booking['TotalPrice'], 2) ?></p>
            </div>
        <?php endif; ?>

        <div class="button-container">
            <a href="/dwp/movies" class="btn">Back to Home</a>
        </div>
    </div>
</body>
</html>
