<?php
session_start();
require_once("includes/connection.php");

// Check if user or guest is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest_user_id'])) {
    header("Location: /dwp/overview"); // Redirect to overview if not logged in
    exit();
}

// Retrieve necessary session data
$selectedSeats = json_decode($_SESSION['selectedSeats'] ?? '[]', true);
$ticketPrice = 135; // Set your ticket price here
$totalPrice = count($selectedSeats) * $ticketPrice;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .order-summary, .payment-method { padding: 15px; margin-top: 20px; background: #333; color: white; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container">
    <h4>Checkout</h4>
    
    <!-- Order Summary -->
    <div class="order-summary">
        <h5>Order Summary</h5>
        <p>Total Tickets: <?= count($selectedSeats); ?></p>
        <p>Total Price: DKK <?= number_format($totalPrice, 2); ?></p>
    </div>

    <!-- Coupon Code Section -->
    <div class="input-field">
        <input type="text" id="couponCode" name="couponCode" placeholder="Enter Coupon Code">
        <button id="applyCoupon" class="btn">Apply Coupon</button>
        <p id="couponMessage" style="color: red; display: none;"></p>
    </div>

    <!-- Payment Method Section -->
    <div class="payment-method">
        <h5>Select Payment Method</h5>
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

<!-- jQuery and AJAX Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Apply Coupon
    $('#applyCoupon').click(function() {
        const couponCode = $('#couponCode').val();
        if (couponCode) {
            $.ajax({
                url: '/dwp/payment/apply-coupon',
                type: 'POST',
                data: { couponCode: couponCode },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        $('#couponMessage').hide();
                        $('#totalPrice').text('DKK ' + response.newTotalPrice);
                    } else {
                        $('#couponMessage').text(response.message).show();
                    }
                }
            });
        }
    });

    // Handle Payment
    $('#payButton').click(function() {
        const paymentMethod = $('input[name="paymentMethod"]:checked').val();
        $.ajax({
            url: '/dwp/payment/process-payment',
            type: 'POST',
            data: { paymentMethod: paymentMethod, totalPrice: <?= $totalPrice; ?> },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    window.location.href = '/dwp/payment/confirmation';
                } else {
                    $('#paymentMessage').text(response.message).show();
                }
            }
        });
    });
});
</script>
</body>
</html>
