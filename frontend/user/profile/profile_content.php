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
<?php include './frontend/navbar/navbar_structure.php'; ?>

<div class="container" style="padding-top: 10%">
    <h3>Profile Overview</h3>
    <div class="user-details">
        <h5>Personal Information</h5>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['Name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['Email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['TelephoneNumber']) ?></p>
        <button id="editUserButton" class="btn blue" ">Edit Information</button>
    </div>

    <div class="booking-history">
        <h5>Booking History</h5>
        <?php if ($bookings): ?>
            <table class="highlight">
                <thead>
                    <tr>
                        <th>Booking Date</th>
                        <th>Movie</th>
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