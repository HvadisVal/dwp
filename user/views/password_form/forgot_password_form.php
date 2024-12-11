<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form action="/dwp/user/forgot-password" method="POST">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
