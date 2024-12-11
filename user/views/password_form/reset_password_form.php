<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form id="resetPasswordForm" method="POST" action="/dwp/user/reset-password">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']); ?>">
        <div>
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
    <script src="/dwp/user/assets/js/reset_password.js"></script>
</body>
</html>
