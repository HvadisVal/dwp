<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

// Ensure booking session exists
if (!isset($_SESSION['booking']) || empty($_SESSION['booking'])) {
    die("No booking information found. Please start a new booking.");
}

// Database connection
$dbCon = dbCon($user, $pass);

// Fetch Invoice_ID from session
$invoiceId = $_SESSION['invoice_id'] ?? null;

if (!$invoiceId) {
    die("Invoice not found.");
}

// Fetch Invoice Details
$invoiceQuery = $dbCon->prepare("
    SELECT i.Invoice_ID, i.InvoiceDate, i.TotalAmount, i.InvoiceStatus,
           b.BookingDate, b.NumberOfTickets,
           m.Title AS MovieTitle, s.ShowDate, s.ShowTime, c.Name AS CinemaHall,
           GROUP_CONCAT(CONCAT(seat.Row, '-', seat.SeatNumber) ORDER BY seat.Row, seat.SeatNumber) AS Seats
    FROM Invoice i
    JOIN Booking b ON i.Invoice_ID = b.Invoice_ID
    JOIN Movie m ON b.Movie_ID = m.Movie_ID
    JOIN Ticket t ON b.Booking_ID = t.Booking_ID
    JOIN Seat seat ON t.Seat_ID = seat.Seat_ID
    JOIN Screening s ON t.Screening_ID = s.Screening_ID
    JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
    WHERE i.Invoice_ID = :invoice_id
    GROUP BY i.Invoice_ID
");
$invoiceQuery->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
$invoiceQuery->execute();

$invoice = $invoiceQuery->fetch(PDO::FETCH_ASSOC);

// If no invoice is found
if (!$invoice) {
    die("Invoice not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="/dwp/frontend/checkout.css">
</head>
<body>
    <div class="container">
        <h2>Thank You for Your Order!</h2>
        <p>Your booking has been completed successfully.</p>

        <!-- Booking Details -->
        <h3>Booking Details</h3>
        <p><strong>Movie:</strong> <?= htmlspecialchars($invoice['MovieTitle']); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($invoice['ShowTime']); ?> on <?= htmlspecialchars($invoice['ShowDate']); ?></p>
        <p><strong>Cinema Hall:</strong> <?= htmlspecialchars($invoice['CinemaHall']); ?></p>
        <p><strong>Number of Tickets:</strong> <?= htmlspecialchars($invoice['NumberOfTickets']); ?></p>
        <p><strong>Seats:</strong> <?= htmlspecialchars($invoice['Seats']); ?></p>

        <!-- Invoice Details -->
        <h3>Invoice Details</h3>
        <p><strong>Invoice ID:</strong> <?= htmlspecialchars($invoice['Invoice_ID']); ?></p>
        <p><strong>Invoice Date:</strong> <?= htmlspecialchars($invoice['InvoiceDate']); ?></p>
        <p><strong>Total Amount:</strong> DKK <?= number_format($invoice['TotalAmount'], 2); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($invoice['InvoiceStatus']); ?></p>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="/dwp/frontend/payment/invoice.php?invoice_id=<?= htmlspecialchars($invoice['Invoice_ID']); ?>" class="btn">View Full Invoice</a>
            <a href="/dwp/frontend/user/profile/profile.php" class="btn">Back to Profile</a>
        </div>
    </div>
</body>
</html>
