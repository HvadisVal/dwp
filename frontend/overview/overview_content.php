<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Overview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/dwp/frontend/overview/overview.css">
</head>
<body>
    <div class="logo">
        <a href="/dwp/"><img src="images/11.png" alt="Logotype" height="40px" width="145px"></a>
    </div>

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



<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/dwp/frontend/overview/overview.js"></script>
