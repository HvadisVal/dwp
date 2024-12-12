<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle login if POST request is made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha_response = $_POST['g-recaptcha-response'];

    // Your secret key from Google reCAPTCHA
    $secret_key = '6LcGh40qAAAAAA3ZkV5HXoWBeZFOt7LzGmXwUKGH';  // Use your actual secret key here

    // Verify the CAPTCHA response
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret_key,
        'response' => $captcha_response
    ];

    // Send the POST request to verify the CAPTCHA
    $options = [
        'http' => [
            'method' => 'POST',
            'content' => http_build_query($data),
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $response_keys = json_decode($verify);

    // Check if CAPTCHA verification is successful
    if (intval($response_keys->success) !== 1) {
        echo "Please verify that you are not a robot.";
        exit;  // Stop the script if CAPTCHA fails
    } else {
        // CAPTCHA passed, continue with login logic (replace with your actual logic)
        // For example, you could check the credentials in your database
        
        // If credentials are correct, proceed with session creation and login
        // $_SESSION['user_id'] = $user_id; // Example login logic
        
        echo "CAPTCHA verified. Proceeding with login...";
    }
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
            <!-- Google reCAPTCHA widget -->
            <div class="g-recaptcha" data-sitekey="6LcGh40qAAAAADJ9GhkbB2mb-3wNydnZ11-7ton6" data-callback="onCaptchaCompleted"></div><br>
            <button class="btn blue" type="submit" id="continueButton" disabled>Continue</button>
            <!-- <button class="btn blue" type="submit" id="continueButton">Continue</button> -->

        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


