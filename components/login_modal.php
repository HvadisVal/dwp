<style>
    .header {
        color: #2196F3;
    }
</style>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <h5 class="header">Login</h5>
        <form id="loginForm">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
            <div class="input-field">
                <input id="username" type="text" name="user" required>
                <label for="username">Username</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" name="pass" required>
                <label for="password">Password</label>
            </div>
            <!-- Google reCAPTCHA widget -->
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <button class="btn blue" type="submit" id="loginButton">Login</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>

        <!-- Links for "Forgot Password" and "Create New User" -->
        <div class="login-links" style="display:flex; justify-content:space-between; padding-top:20px;">
            <a href="/dwp/user/forgot-password">Forgot Password?</a>
            <!-- Modal Trigger for Create New User -->
            <a href="#newUserModal" class="modal-trigger" style="cursor:pointer;">Create New User</a>
        </div>
    </div>
</div>

<!-- Create New User Modal -->
<div id="newUserModal" class="modal">
    <div class="modal-content">
        <h5 class="header">Create New User</h5>
        <form id="newUserForm">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
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

            <!-- Hidden reCAPTCHA response field -->
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

            <br>
            <button class="btn blue" type="submit" id="createButton">Create Account</button>
        </form>
        <p class="error-message" style="color: red; display: none;"></p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/dwp/components/login_modal.js"></script> <!-- new_user_modal.php -->
