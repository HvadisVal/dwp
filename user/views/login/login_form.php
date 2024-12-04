<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/dwp/user/assets/login.css">
</head>
<body>
    <div class="login-container">
        <form id="loginForm" method="POST" action="/dwp/user/login">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="user" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="pass" required>
            <button type="submit">Login</button>
            <p id="loginMessage" style="color: red;"></p>
        </form>
    </div>

    <script src="/dwp/user/assets/login.js"></script>
</body>
</html>
