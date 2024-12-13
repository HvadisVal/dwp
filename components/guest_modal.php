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

            <!-- Google reCAPTCHA widget -->
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

            <button class="btn blue" type="submit" id="continueBtn">Continue</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
