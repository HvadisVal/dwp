<div id="checkoutModal" class="modal">
    <div class="modal-content">
        <h4>Checkout</h4>
        <p>Review your details and confirm the payment below:</p>

        <div id="checkoutTotalSection">
            <p><strong>Total Price: </strong><span id="totalPriceDisplay">DKK <?= number_format($_SESSION['totalPrice'] ?? 0, 2) ?></span></p>
        </div>

        <div id="couponSection">
            <div class="input-field">
                <input type="text" id="couponCode" name="couponCode" placeholder="Enter Coupon Code">
                <label for="couponCode">Coupon Code</label>
            </div>
            <button id="applyCoupon" class="btn blue">Apply Coupon</button>
            <p id="couponMessage" style="color: red; display: none;"></p>
        </div>
        

        <h5>Payment Method</h5>
<div class="payment-container" style="display: flex; align-items: center; gap: 20px;">
    <label style="display: flex; align-items: center; gap: 10px;">
        <input name="paymentMethod" type="radio" value="card" class="with-gap payment-radio" />
        <span>Pay with Card</span>
    </label>
    <div id="cardDetails" class="payment-content" style="display: none; margin-left: 20px;">
        <div class="input-field">
            <input id="cardNumber" type="text" name="cardNumber" required>
            <label for="cardNumber">Card Number</label>
        </div>
        <div class="input-field">
            <input id="expiryDate" type="text" name="expiryDate" placeholder="MM/YY" required>
            <label for="expiryDate">Expiry Date</label>
        </div>
        <div class="input-field">
            <input id="cvv" type="password" name="cvv" required>
            <label for="cvv">CVV</label>
        </div>
    </div>

    <label style="display: flex; align-items: center; gap: 10px; margin-left: 20px;">
        <input name="paymentMethod" type="radio" value="mobilepay" class="with-gap payment-radio" />
        <span>MobilePay</span>
    </label>
    <div id="mobilePayDetails" class="payment-content" style="display: none; margin-left: 20px;">
        <div class="input-field">
            <input id="countryCode" type="text" name="countryCode" value="+45" readonly>
            <label for="countryCode">Country Code</label>
        </div>
        <div class="input-field">
            <input id="mobileNumber" type="text" name="mobileNumber" required>
            <label for="mobileNumber">Mobile Number</label>
        </div>
    </div>
</div>

<form action="/dwp/user/actions/booking_process.php" method="post">
    <?php if ($isGuest): ?>
        <input type="hidden" name="guest" value="1">
    <?php elseif ($isLoggedIn): ?>
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user_id']); ?>">
    <?php endif; ?>
    <input type="hidden" name="couponCode" id="hiddenCouponCode" value="">
    <button type="submit" class="btn green" style="margin-top: 20px;">Checkout</button>
</form>

