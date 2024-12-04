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

<style>
    .header {
        color: #2196F3;
    }
</style>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <h5 class="header">Login</h5>
        <form id="loginForm">
            <div class="input-field">
                <input id="username" type="text" name="user" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" name="pass" required>
                <label for="password">Password</label>
            </div>
            <!-- Google reCAPTCHA widget -->
            <div class="g-recaptcha" data-sitekey="6LcGh40qAAAAADJ9GhkbB2mb-3wNydnZ11-7ton6" data-callback="onLoginCaptchaCompleted"></div><br>
<!--             <button class="btn blue" type="submit" id="loginButton" disabled>Login</button> -->
            <button class="btn blue" type="submit" id="loginButton">Login</button>

        </form>
        <p class="error-message" style="color: red; display: none;"></p>

        <!-- Links for "Forgot Password" and "Create New User" -->
        <div class="login-links" style="display:flex; justify-content:space-between; padding-top:20px;">
            <a href="/dwp/user/forgot-password">Forgot Password?</a>
            <a class="modal-trigger" data-target="newUserModal" style="cursor:pointer;">Create New User</a>
        </div>
    </div>
</div>

<!-- Create New User Modal -->
<div id="newUserModal" class="modal">
    <div class="modal-content">
        <h5 class="header">Create New User</h5>
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
                <label for="new_phone">Phone</label>
            </div>
            <div class="input-field">
                <input id="new_password" type="password" name="pass" required>
                <label for="new_password">Password</label>
            </div>
            <!-- Google reCAPTCHA widget -->
            <div class="g-recaptcha" data-sitekey="6LcGh40qAAAAADJ9GhkbB2mb-3wNydnZ11-7ton6" data-callback="onCreateCaptchaCompleted"></div><br>
            <button class="btn blue" type="submit" id="createButton" disabled>Create Account</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>


<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
  function onLoginCaptchaCompleted() {
    $('#loginButton').prop('disabled', false);
    console.log('CAPTCHA verified. Login button enabled.');
}

function onCreateCaptchaCompleted() {
    $('#createButton').prop('disabled', false);
    console.log('CAPTCHA verified. Create Account button enabled.');
}



   $(document).ready(function() {
    // Handle the login form submission
    $('#loginForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var username = $('#username').val();
        var password = $('#password').val();
        var captchaResponse = grecaptcha.getResponse(); // Get the reCAPTCHA response

        // Ensure the CAPTCHA is completed
        if (!captchaResponse || captchaResponse.length === 0) {
            $('.error-message').text('Please verify that you are not a robot.').show();
            return; // Stop further execution if CAPTCHA is not filled
        }

        // Submit the form data using AJAX
        $.ajax({
            url: 'dwp/user/login',  // Use the current PHP file
            method: 'POST',
            data: {
                username: username,
                password: password,
                'g-recaptcha-response': captchaResponse
            },
            success: function(response) {
                if (response.trim() === 'CAPTCHA verified. Proceeding with login...') {
                    // Redirect or update UI for successful login
                    alert('Login successful!');
                } else {
                    // Handle error, for example invalid credentials or CAPTCHA failure
                    $('.error-message').text(response).show();
                }
            },
        });
    });
});


</script>
