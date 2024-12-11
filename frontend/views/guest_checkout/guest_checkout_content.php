<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Checkout</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/guest_checkout.css">
</head>
<body>
    <div class="container">
        <h2>Thank You for Your Order!</h2>
        <p>Your booking has been completed successfully.</p>

        <!-- Booking Details -->
        <h3>Booking Details</h3>
        <p><strong>Movie:</strong> <?= htmlspecialchars_decode($invoice['MovieTitle']); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars_decode($invoice['ShowTime']); ?> on <?= htmlspecialchars_decode($invoice['ShowDate']); ?></p>
        <p><strong>Cinema Hall:</strong> <?= htmlspecialchars_decode($invoice['CinemaHall']); ?></p>
        <p><strong>Number of Tickets:</strong> <?= htmlspecialchars_decode($invoice['NumberOfTickets']); ?></p>
        <p><strong>Seats:</strong> <?= htmlspecialchars_decode($invoice['Seats']); ?></p>

        <!-- Invoice Details -->
        <h3>Invoice Details</h3>
        <p><strong>Invoice ID:</strong> <?= htmlspecialchars_decode($invoice['Invoice_ID']); ?></p>
        <p><strong>Invoice Date:</strong> <?= htmlspecialchars_decode($invoice['InvoiceDate']); ?></p>
        <p><strong>Total Amount:</strong> DKK <?= number_format($invoice['TotalAmount'], 2); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars_decode($invoice['InvoiceStatus']); ?></p>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="/dwp/invoice?invoice_id=<?= htmlspecialchars_decode($invoice['Invoice_ID']); ?>" class="btn">View Full Invoice</a>
            <a href="/dwp/user/profiles" class="btn">Back to Profile</a>
        </div>
    </div>
</body>
</html>