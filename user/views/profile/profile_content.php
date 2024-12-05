<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="/dwp/user/assets/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
$navbar = new NavbarController();
$navbar->handleRequest();
?>

<div class="container">
    <h3>Profile Overview</h3>
    <div class="user-details">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['Name']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['TelephoneNumber']); ?></p>
        <button id="editUserButton" class="btn blue">Edit Information</button>
    </div>

    <?php if (!empty($bookingSuccessMessage)): ?>
        <p class="success-message"><?= htmlspecialchars($bookingSuccessMessage); ?></p>
    <?php endif; ?>

    <h5>Booking History</h5>
    <?php if ($bookings): ?>
        <table>
            <thead>
                <tr>
                    <th>Booking Date</th>
                    <th>Movie</th>
                    <th>Showtime</th>
                    <th>Cinema Hall</th>
                    <th>Seats</th>
                    <th>Tickets</th>
                    <th>Total Price</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= htmlspecialchars($booking['BookingDate']); ?></td>
                        <td><?= htmlspecialchars($booking['MovieTitle']); ?></td>
                        <td><?= htmlspecialchars($booking['ShowTime']); ?> on <?= htmlspecialchars($booking['ShowDate']); ?></td>
                        <td><?= htmlspecialchars($booking['CinemaHall']); ?></td>
                        <td><?= htmlspecialchars($booking['Seats']); ?></td>
                        <td><?= htmlspecialchars($booking['NumberOfTickets']); ?></td>
                        <td>DKK <?= number_format($booking['TotalPrice'], 2); ?></td>
                        <td><?= htmlspecialchars($booking['PaymentStatus']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>

    <h5>Invoices</h5>
    <table>
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?= htmlspecialchars($invoice['Invoice_ID']); ?></td>
                    <td><?= htmlspecialchars($invoice['InvoiceDate']); ?></td>
                    <td>DKK <?= number_format($invoice['TotalAmount'], 2); ?></td>
                    <td><?= htmlspecialchars($invoice['InvoiceStatus']); ?></td>
                    <td><a href="/dwp/frontend/controllers/InvoiceController.php?invoice_id=<?= htmlspecialchars($invoice['Invoice_ID']); ?>" class="btn">View Invoice</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
