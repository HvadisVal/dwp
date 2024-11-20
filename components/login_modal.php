<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the user or guest is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = isset($_SESSION['guest_user_id']);
?>

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
                <label for="new_phone">Phone</label>
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


