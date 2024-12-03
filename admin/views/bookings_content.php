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
    <div class="alert"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
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
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($booking['MovieTitle']); ?></td>
                <td><?php echo htmlspecialchars($booking['CustomerName']); ?></td>
                <td><?php echo htmlspecialchars($booking['BookingDate']); ?></td>
                <td><?php echo htmlspecialchars($booking['NumberOfTickets']); ?></td>
                <td><?php echo htmlspecialchars($booking['TotalPrice']); ?></td>
                <td><?php echo htmlspecialchars($booking['PaymentStatus']); ?></td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="booking_id" value="<?php echo $booking['Booking_ID']; ?>">
                        <button type="submit" name="delete_booking">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
