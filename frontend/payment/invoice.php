<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

$dbCon = dbCon($user, $pass);

// Get the Invoice ID from the URL
$invoiceId = $_GET['invoice_id'] ?? null;
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

// Debugging: Confirm query result
var_dump($invoice);
exit();


if (!$invoice) {
    die("Invoice not found.");
}

echo "<h2>Invoice #" . htmlspecialchars($invoice['Invoice_ID']) . "</h2>";
echo "<p><strong>Date:</strong> " . htmlspecialchars($invoice['InvoiceDate']) . "</p>";
echo "<p><strong>Total Amount:</strong> DKK " . number_format($invoice['TotalAmount'], 2) . "</p>";
echo "<p><strong>Status:</strong> " . htmlspecialchars($invoice['InvoiceStatus']) . "</p>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= htmlspecialchars($invoice['Invoice_ID']); ?></title>
    <link rel="stylesheet" href="/dwp/frontend/payment/invoice.css">
</head>
<body>
    <div class="invoice-container">
        <h2>Invoice #<?= htmlspecialchars($invoice['Invoice_ID']); ?></h2>
        <p><strong>Date:</strong> <?= htmlspecialchars($invoice['InvoiceDate']); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($invoice['InvoiceStatus']); ?></p>
        <hr>
        <h3>Booking Details</h3>
        <p><strong>Movie:</strong> <?= htmlspecialchars($invoice['MovieTitle']); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($invoice['ShowTime']); ?> on <?= htmlspecialchars($invoice['ShowDate']); ?></p>
        <p><strong>Cinema Hall:</strong> <?= htmlspecialchars($invoice['CinemaHall']); ?></p>
        <p><strong>Seats:</strong> <?= htmlspecialchars($invoice['Seats']); ?></p>
        <p><strong>Tickets:</strong> <?= htmlspecialchars($invoice['NumberOfTickets']); ?></p>
        <hr>
        <h3>Payment</h3>
        <p><strong>Total Amount:</strong> DKK <?= number_format($invoice['TotalAmount'], 2); ?></p>
        <hr>
        <p>Thank you for booking with us!</p>
    </div>

    <button onclick="window.print()">Print Invoice</button>
</body>
</html>
