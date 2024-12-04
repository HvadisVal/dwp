<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= htmlspecialchars($invoice['Invoice_ID']); ?></title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/invoice.css">
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