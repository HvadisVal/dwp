<?php
session_start();
require_once("includes/connection.php");
require_once("dbcon.php");


// Check if the user or guest is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = isset($_SESSION['guest_user_id']);

// Fetch selected seats and ticket types from session (stored from seat selection page)
$selectedSeats = $_SESSION['selectedSeats'] ?? [];
$selectedTickets = $_SESSION['selectedTickets'] ?? [];


// Check if any tickets were selected
if (empty($selectedTickets) || empty($selectedSeats)) {
    die("No tickets or seats selected. Please go back to select tickets.");
}


// Calculate the total price by retrieving prices from the TicketPrice table
$totalPrice = 0;
$ticketDetails = [];


try {
    // Prepare database query to fetch ticket prices for each selected type
    $dbCon = dbCon($user, $pass);
    foreach ($selectedTickets as $type => $quantity) {
        $priceQuery = $dbCon->prepare("SELECT Price FROM TicketPrice WHERE Type = :type");
        $priceQuery->bindParam(':type', $type);
        $priceQuery->execute();
        $priceResult = $priceQuery->fetch(PDO::FETCH_ASSOC);

        if ($priceResult) {
            $pricePerTicket = $priceResult['Price'];
            $totalForType = $pricePerTicket * $quantity;
            $totalPrice += $totalForType;
            $ticketDetails[] = [
                'type' => $type,
                'price' => $pricePerTicket,
                'quantity' => $quantity,
                'total' => $totalForType
            ];
        }
    }
     // Store the total price in the session for later use (e.g., in the coupon discount)
     $_SESSION['totalPrice'] = $totalPrice;
} catch (PDOException $e) {
    die("Error retrieving ticket prices: " . $e->getMessage());
}

// Get movie details
$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;
$movieQuery = $dbCon->prepare("SELECT * FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Overview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
         * {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        body { background: black; }
        .container { margin-top: 40px; color: white; font-weight: bold; }
        .modal { max-width: 600px; background: linear-gradient(to right, #243642, #1a252d); }
        .modal input { color: white; }
        .action-buttons { margin-top: 20px;}
        .action-buttons button { margin-right: 10px; background-color: #3498db; color: white; }
        .action-buttons button:hover { background-color: white;  color:black}
        .order-summary, .movie-details, .user-info { padding: 20px; margin-top: 20px; background: linear-gradient(to right, #243642, #1a252d); color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .login-info { display: flex; align-items: center; justify-content: space-between; }
        .modal-content { padding: 20px; }
        .btn.blue { background-color: #3498db; }
        .btn.red { background-color: #e74c3c; }
        .error-message { color: red; margin-top: 10px; }
        .input-field label { color: #34495e !important; }
        #applyCoupon { margin-top: 10px; background-color: #3498db; color: white; }
        #payButton { margin-left: 15px; background-color: #3498db; color: white; }
        .modal-footer { background: linear-gradient(to right, #243642, #1a252d); }
        .modal-footer a { color: white; }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h4>Booking Overview</h4>

   <!-- Movie Details Section -->
   <div class="movie-details">
        <h5>Movie: <?= htmlspecialchars($movie['Title'] ?? 'N/A'); ?></h5>
        <p><strong>Duration:</strong> <?= htmlspecialchars($movie['Duration'] ?? 'N/A'); ?></p>
        <p><strong>Rating:</strong> <?= htmlspecialchars($movie['Rating'] ?? 'N/A'); ?> / 10</p>
        <p><strong>Cinema Hall:</strong> Hall <?= htmlspecialchars($cinema_hall_id); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($showtime); ?></p>
    </div>

      <!-- Login, Guest Checkout, or User/Guest Information Display -->
      <?php if ($isLoggedIn): ?>
        <div id="userInfo" class="user-info login-info">
            <span>Welcome, <?= htmlspecialchars($_SESSION['user']); ?></span>
            <button id="logoutButton" class="btn red">Logout</button>
        </div>
    <?php elseif ($isGuest && isset($_SESSION['guest_firstname'], $_SESSION['guest_lastname'], $_SESSION['guest_email'])): ?>
        <div class="user-info">
            <h5>Guest Information</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['guest_firstname'] . " " . $_SESSION['guest_lastname']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['guest_email']); ?></p>
            <button id="switchUserButton" class="btn grey">Switch User</button>
        </div>
    <?php else: ?>
        <div class="action-buttons">
            <button class="btn modal-trigger" data-target="loginModal">Login</button>
            <button class="btn modal-trigger" data-target="guestModal">Continue as Guest</button>
        </div>
    <?php endif; ?>

    <!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <h5>Login</h5>
        <form id="loginForm">
            <div class="input-field">
                <input id="username" type="text" name="user" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" name="pass" required>
                <label for="password">Password</label>
            </div>
            <button class="btn blue" type="submit">Login</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>

        <!-- Links for "Forgot Password" and "Create New User" -->
        <div class="login-links" style="display:flex; justify-content:space-between; padding-top:20px;">
            <a href="/dwp/user/forgot-password">Forgot Password?</a>
            <a class="modal-trigger" data-target="newUserModal" style="cursor:pointer;">Create New User</a>
        </div>
    </div>
</div>

<!-- Guest Checkout Modal -->
<div id="guestModal" class="modal">
    <div class="modal-content">
        <h5>Guest Checkout</h5>
        <form id="guestForm">
            <div class="row">
                <div class="input-field col s6">
                    <input id="firstname" type="text" name="firstname" required>
                    <label for="firstname">First Name</label>
                </div>
                <div class="input-field col s6">
                    <input id="lastname" type="text" name="lastname" required>
                    <label for="lastname">Last Name</label>
                </div>
            </div>
            <div class="input-field">
                <input id="email" type="email" name="email" required>
                <label for="email">E-mail</label>
            </div>
            <div class="input-field">
                <input id="phone" type="text" name="phone" required>
                <label for="phone">Telephone Number</label>
            </div>
            <button class="btn blue" type="submit">Continue</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>

<!-- Create New User Modal -->
<div id="newUserModal" class="modal">
    <div class="modal-content">
        <h5>Create New User</h5>
        <form id="newUserForm">
            <div class="input-field">
                <input id="new_username" type="text" name="user" required>
                <label for="new_username">Username</label>
            </div>
            <div class="input-field">
                <input id="new_email" type="email" name="email" required>
                <label for="new_email">Email</label>
            </div>
            <div class="input-field">
                <input id="new_phone" type="text" name="phone" required>
                <label for="new_phone">Telephone Number</label>
            </div>
            <div class="input-field">
                <input id="new_password" type="password" name="pass" required>
                <label for="new_password">Password</label>
            </div>
            <button class="btn blue" type="submit">Create Account</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>

    <!-- Order Summary -->
    <div class="order-summary">
        <h5>Order Summary</h5>
        <?php foreach ($ticketDetails as $ticket): ?>
            <p><?= htmlspecialchars($ticket['quantity']) ?> x <?= htmlspecialchars($ticket['type']) ?> </p>
        <?php endforeach; ?>
        <p><strong>Total Price: DKK <?= number_format($totalPrice, 2); ?></strong></p>
    </div>



   <!-- Payment Button to Open Modal, shown only if logged in as user or guest -->
   <?php if ($isLoggedIn || $isGuest): ?>
        <button class="btn blue modal-trigger" style=" margin-top: 20px;" data-target="checkoutModal">Proceed to Checkout</button>
    <?php endif; ?>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="modal">
    <div class="modal-content" style="color: white;">
        <h5>Checkout</h5>
        
        <!-- Coupon Code Section -->
       <div class="input-field">
            <input type="text" id="couponCode" name="couponCode" placeholder="Enter Coupon Code">
            <button id="applyCoupon" class="btn">Apply Coupon</button>
            <p id="couponMessage" style="color: red; display: none;"></p>
        </div>
  
         <!-- Updated Total Price -->
         <div class="payment-method">
            <h5>Total Price: <span id="modalTotalPrice">DKK <?= number_format($totalPrice, 2); ?></span></h5>
            <h6>Select Payment Method</h6>
            <label>
                <input name="paymentMethod" type="radio" value="Credit Card" checked/>
                <span>Credit Card</span>
            </label>
            <label>
                <input name="paymentMethod" type="radio" value="MobilePay"/>
                <span>MobilePay</span>
            </label>
            <button id="payButton" class="btn blue">Proceed to Pay</button>
            <p id="paymentMessage" style="color: red; display: none;"></p>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn-flat">Close</a>
    </div>
</div>

<!-- Payment Confirmation Modal -->
<div id="paymentConfirmationModal" class="modal">
    <div class="modal-content">
        <h5>Payment Status</h5>
        <p>Payment method will be installed soon.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn blue">Close</a>
    </div>
</div>


<!-- Materialize JS and jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modals = document.querySelectorAll('.modal');
        M.Modal.init(modals);
    });

    // Login Form Submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/dwp/user/login',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    $('.error-message').text(response.message).show();
                }
            }
        });
    });

    // Guest Checkout Form Submission
    $('#guestForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/dwp/user/guest',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    location.reload(); // Reload page to display guest info
                } else {
                    $('.error-message').text(response.message).show();
                }
            }
        });
    });

   // New User Form Submission
$('#newUserForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '/dwp/user/new_user',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',  // Ensure response is expected as JSON
        success: function(response) {
            if (response.success) {
                const modalInstance = M.Modal.getInstance(document.getElementById('newUserModal'));
                modalInstance.close(); // Close the modal after success
                M.toast({html: 'User account created successfully! Please login.'});
            } else {
                $('.error-message').text(response.message).show();
            }
        },
        error: function(xhr, status, error) {
            console.error("An error occurred:", status, error);
            $('.error-message').text("An error occurred while creating the account. Please try again.").show();
        }
    });
});


    // Logout AJAX request
    $('#logoutButton').on('click', function() {
        $.ajax({
            type: 'POST',
            url: '/dwp/user/logout',
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    location.reload();
                } else {
                    console.error("Logout failed");
                }
            },
            error: function() {
                console.error("An error occurred during logout");
            }
        });
    });

    // Switch User AJAX request
    $('#switchUserButton').on('click', function() {
        $.ajax({
            type: 'POST',
            url: '/dwp/user/switch',
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success) {
                    location.reload(); // Reload page to reset to the initial state
                } else {
                    console.error("Failed to switch user");
                }
            },
            error: function() {
                console.error("An error occurred while switching user");
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Initialize Materialize modals
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    // Apply Coupon Code
    document.getElementById('applyCoupon').addEventListener('click', function() {
        const couponCode = document.getElementById('couponCode').value.trim();

        if (!couponCode) {
            const couponMessage = document.getElementById('couponMessage');
            couponMessage.style.color = 'red';
            couponMessage.textContent = "Please enter a coupon code.";
            couponMessage.style.display = 'block';
            return;
        }

        fetch('/dwp/validate-coupon', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ couponCode })
        })
        .then(response => response.json())
        .then(data => {
            const couponMessage = document.getElementById('couponMessage');
            const modalTotalPrice = document.getElementById('modalTotalPrice');

            if (data.valid) {
                couponMessage.style.color = 'green';
                couponMessage.textContent = `Coupon applied! You saved DKK ${data.discount}.`;
                modalTotalPrice.textContent = `DKK ${data.newTotalPrice}`;
            } else {
                couponMessage.style.color = 'red';
                couponMessage.textContent = data.message;
            }
            couponMessage.style.display = 'block';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Materialize modals
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    // Payment Button Click Event
    document.getElementById('payButton').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent any form submission

        // Show the payment confirmation modal
        const paymentConfirmationModal = document.getElementById('paymentConfirmationModal');
        const modalInstance = M.Modal.getInstance(paymentConfirmationModal);
        modalInstance.open();
    });
});



</script>
</body>
</html>
