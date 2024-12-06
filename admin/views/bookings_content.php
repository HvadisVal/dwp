<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/bookings.css" />
</head>
<body>
<a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt="Back"></a>

<h1>Manage Bookings</h1>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert"><?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Movie</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Tickets</th>
            <th>Total Price</th>
            <th>Payment Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $index => $booking): ?>
            <tr>
                <td><?php echo htmlspecialchars($index + 1, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars_decode($booking['MovieTitle'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars_decode($booking['CustomerName'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars_decode($booking['BookingDate'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars_decode($booking['NumberOfTickets'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars_decode($booking['TotalPrice'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars_decode($booking['PaymentStatus'], ENT_QUOTES); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['Booking_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit" name="delete_booking">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
