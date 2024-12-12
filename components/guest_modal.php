<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $captcha_response = $_POST['g-recaptcha-response'];

    $secret_key = '6LcGh40qAAAAAA3ZkV5HXoWBeZFOt7LzGmXwUKGH';

    // Verify CAPTCHA
    $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha_response");
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        echo json_encode(['success' => false, 'message' => 'Please verify that you are not a robot.']);
        exit;
    }

    // Proceed with form handling logic (e.g., saving data to the database)
    // ...

    echo json_encode(['success' => true, 'message' => 'Guest checkout successful.']);
}
?>





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
    <div class="g-recaptcha" data-sitekey="6LcGh40qAAAAADJ9GhkbB2mb-3wNydnZ11-7ton6" data-callback="onGuestCaptchaCompleted"></div><br>
    <button class="btn blue" type="submit" id="continueBtn" disabled>Continue</button>
</form>
<p class="error-message" style="color: red; display: none;"></p>

    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


