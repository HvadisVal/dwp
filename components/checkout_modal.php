<div id="checkoutModal" class="modal">
    <div class="modal-content">
        <h4>Checkout</h4>
        <p>Review your details and confirm the payment below:</p>

        <!-- Display Total Price -->
        <div id="checkoutTotalSection">
            <p><strong>Total Price: </strong><span id="totalPriceDisplay">DKK <?= number_format($_SESSION['totalPrice'] ?? 0, 2) ?></span></p>
        </div>

        <!-- Coupon Code Section -->
        <div class="input-field">
            <input type="text" id="couponCode" name="couponCode" placeholder="Enter Coupon Code">
            <button id="applyCoupon" class="btn">Apply Coupon</button>
            <p id="couponMessage" style="color: red; display: none;"></p>
        </div>

        <!-- Payment Method Selection -->
        <h5>Payment Method</h5>
        <p>
            <label>
                <input name="paymentMethod" type="radio" value="card" checked />
                <span>Card</span>
            </label>
        </p>
        <p>
            <label>
                <input name="paymentMethod" type="radio" value="mobilepay" />
                <span>MobilePay</span>
            </label>
        </p>

        <!-- Payment Form -->
        <form id="checkoutForm">
            <div class="input-field">
                <input id="name" type="text" name="name" required>
                <label for="name">Full Name</label>
            </div>
            <div class="input-field">
                <input id="email" type="email" name="email" required>
                <label for="email">Email</label>
            </div>

            <!-- Card Details -->
            <div id="cardDetailsSection">
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

            <button type="submit" class="btn green">Confirm Payment</button>
        </form>
    </div>
    <div class="modal-footer">
        <button class="modal-close btn red">Close</button>
    </div>
</div>
