<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= htmlspecialchars_decode($invoice['Invoice_ID']); ?></title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/invoice.css">
</head>
<body>
    <div class="invoice-container">
        <h2>Invoice #<?= htmlspecialchars_decode($invoice['Invoice_ID']); ?></h2>
        <p><strong>Date:</strong> <?= htmlspecialchars_decode($invoice['InvoiceDate']); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars_decode($invoice['InvoiceStatus']); ?></p>
        <hr>
        <h3>Booking Details</h3>
        <p><strong>Movie:</strong> <?= htmlspecialchars_decode($invoice['MovieTitle']); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars_decode($invoice['ShowTime']); ?> on <?= htmlspecialchars_decode($invoice['ShowDate']); ?></p>
        <p><strong>Cinema Hall:</strong> <?= htmlspecialchars_decode($invoice['CinemaHall']); ?></p>
        <p><strong>Seats:</strong> <?= htmlspecialchars_decode($invoice['Seats']); ?></p>
        <p><strong>Tickets:</strong> <?= htmlspecialchars_decode($invoice['NumberOfTickets']); ?></p>
        <hr>
        <h3>Payment</h3>
        <p><strong>Total Amount:</strong> DKK <?= number_format($invoice['TotalAmount'], 2); ?></p>
        <hr>
        <p>Thank you for booking with us!</p>
    </div>

    <button onclick="window.print()">Print Invoice</button>
</body>
</html>