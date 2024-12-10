<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/dwp/admin/assets/css/admin_login.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>

        <!-- Displaying session message (if any) -->
        <?php if (!empty($message)): ?>
            <p style="color: red;"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="index.php?path=admin/login" method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">

            <!-- Email Input -->
            <div class="input-field">
                <input id="email" type="email" name="email" required />
                <label for="email">Email</label>
            </div>

            <!-- Password Input -->
            <div class="input-field">
                <input id="pass" type="password" name="pass" required />
                <label for="pass">Password</label>
            </div>

            <!-- Login Button -->
            <button class="btn waves-effect waves-light" type="submit" name="submit" id="loginBtn">
                Login
            </button>
        </form>
    </div>

    <!-- Including Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
        // Get blockedUntil value from PHP (if any)
        var blockedUntil = <?php echo json_encode($blockedUntil); ?>;
        var now = new Date();

        if (blockedUntil) {
            var cooldownTime = new Date(blockedUntil * 1000); // Convert to milliseconds
            if (now < cooldownTime) {
                // Disable the login button if still blocked
                document.getElementById('loginBtn').disabled = true;

                // Calculate remaining time
                var remainingTime = cooldownTime - now;

                // Re-enable the button after the cooldown period
                setTimeout(function () {
                    document.getElementById('loginBtn').disabled = false;
                }, remainingTime);
            }
        }
    </script>
</body>
</html>
