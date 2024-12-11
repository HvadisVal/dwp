<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Overview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/dwp/frontend/assets/css/overview.css">
</head>
<body>
    <div class="logo">
        <a href="/dwp/"><img src="images/11.png" alt="Logotype" height="40px" width="145px"></a>
    </div>

    <div class="container">
        <h4>Booking Overview</h4>

        <!-- Movie Details Section -->
        <div class="movie-details">
            <h5>Movie: <?= htmlspecialchars_decode($movie['Title'] ?? 'N/A'); ?></h5>
            <p><strong>Duration:</strong> <?= htmlspecialchars_decode($movie['Duration'] ?? 'N/A'); ?></p>
            <p><strong>Rating:</strong> <?= htmlspecialchars_decode($movie['Rating'] ?? 'N/A'); ?> / 10</p>
            <p><strong>Cinema Hall:</strong> Hall <?= htmlspecialchars_decode($cinema_hall_id); ?></p>
            <p><strong>Showtime:</strong> <?= htmlspecialchars_decode($showtime); ?></p>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h5>Order Summary</h5>
            <?php foreach ($ticketDetails as $ticket): ?>
                <p><?= htmlspecialchars_decode($ticket['quantity']) ?> x <?= htmlspecialchars_decode($ticket['type']) ?></p>
            <?php endforeach; ?>
            <p><strong>Total Price: DKK <?= number_format($totalPrice, 2); ?></strong></p>
        </div>

        <?php if ($isLoggedIn || $isGuest): ?>
            <button class="btn blue modal-trigger" data-target="checkoutModal" style="margin-top: 20px;">Proceed to Checkout</button>
<?php else: ?>
    <div class="action-buttons">
        <button class="btn modal-trigger" data-target="loginModal">Login</button>
        <button class="btn modal-trigger" data-target="guestModal">Continue as Guest</button>
    </div>
<?php endif; ?>

<?php if ($isLoggedIn): ?>
    <div class="logout-section">
        <button id="logoutButton" class="btn red">Logout</button>
    </div>
<?php elseif ($isGuest): ?>
    <div class="switch-user-section">
        <button id="switchUserButton" class="btn orange">Switch User</button>
    </div>
<?php endif; ?>




        <!-- Include Modals -->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/dwp/components/login_modal.php'; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/dwp/components/guest_modal.php'; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/dwp/components/checkout_modal.php'; ?>

    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/dwp/frontend/assets/js/overview.js"></script>
        <script src="/dwp/components/login_modal.js"></script>
    <script src="/dwp/components/guest_modal.js"></script>
    <script src="/dwp/components/checkout_modal.js"></script>
</body>
</html>
