<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="/dwp/frontend/user/profile/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/navbar/navbar_structure.php'; ?>

<div class="container" style="padding-top: 10%">
    <h3>Profile Overview</h3>
    <div class="user-details">
        <h5>Personal Information</h5>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['Name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['TelephoneNumber']) ?></p>
        <button id="editUserButton" class="btn blue" ">Edit Information</button>
    </div>

   <!-- Success Modal -->
   <?php if (!empty($bookingSuccessMessage)): ?>
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h4>Booking Successful</h4>
            <p><?= htmlspecialchars($bookingSuccessMessage); ?></p>
        </div>
        <div class="modal-footer">
            <button class="modal-close btn green">Okay</button>
        </div>
    </div>
<?php endif; ?>


<div class="container" style="padding-top: 10%">
    <!-- User and Booking History Content -->
    <div class="booking-history">
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
                <td><?= htmlspecialchars($booking['BookingDate']) ?></td>
                <td><?= htmlspecialchars($booking['MovieTitle']) ?></td>
                <td><?= htmlspecialchars($booking['ShowTime'] ?? 'N/A') ?> on <?= htmlspecialchars($booking['ShowDate'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($booking['CinemaHall'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($booking['Seats'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($booking['NumberOfTickets']) ?></td>
                <td>DKK <?= number_format($booking['TotalPrice'], 2) ?></td>
                <td><?= htmlspecialchars($booking['PaymentStatus']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
</div>


    <button id="deleteAccountButton" class="btn red">Delete Account</button>
</div>

<!-- Modals -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <h5>Edit Personal Information</h5>
        <form id="editUserForm">
            <div class="input-field">
                <input id="editName" name="name" type="text" value="<?= htmlspecialchars($user['Name']) ?>" required>
                <label for="editName">Name</label>
            </div>
            <div class="input-field">
                <input id="editEmail" name="email" type="email" value="<?= htmlspecialchars($user['Email']) ?>" required>
                <label for="editEmail">Email</label>
            </div>
            <div class="input-field">
                <input id="editPhone" name="phone" type="text" value="<?= htmlspecialchars($user['TelephoneNumber']) ?>" required>
                <label for="editPhone">Phone</label>
            </div>
            <div class="input-field">
                <input id="editPassword" name="password" type="password" placeholder="Enter new password (optional)">
                <label for="editPassword">New Password</label>
            </div>
            <button class="btn blue" type="submit">Save Changes</button>
        </form>
    </div>
</div>

<!-- Display Invoice Links -->
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
                <td>
                    <a href="/dwp/frontend/payment/invoice.php?invoice_id=<?= htmlspecialchars($invoice['Invoice_ID']); ?>" class="btn">View Invoice</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



<script src="/dwp/frontend/user/profile/javascript.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modals = document.querySelectorAll('.modal');
        M.Modal.init(modals);
    });
</script>
</body>
</html>