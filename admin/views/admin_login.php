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

        <form id="loginForm" method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
            <div class="input-field">
                <input id="email" type="email" name="email" value="" required />
                <label for="email">Email</label>
            </div>

            <div class="input-field">
                <input id="pass" type="password" name="pass" value="" required />
                <label for="pass">Password</label>
            </div>
            
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <button class="btn waves-effect waves-light" type="submit" name="login" id="loginBtn">
                Login
            </button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1" async defer></script>

    <script>
        var blockedUntil = <?php echo json_encode($blockedUntil); ?>;
        var now = new Date();

        if (blockedUntil) {
            var cooldownTime = new Date(blockedUntil * 1000); 
            if (now < cooldownTime) {
                document.getElementById('loginBtn').disabled = true;

                var remainingTime = cooldownTime - now;

                setTimeout(function () {
                    document.getElementById('loginBtn').disabled = false;
                }, remainingTime);
            }
        }
        $(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault(); 

        grecaptcha.ready(function () {
            grecaptcha.execute('6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1', { action: 'login' }).then(function (token) {
                $('#g-recaptcha-response').val(token); 
                $('#loginForm').off('submit').submit(); 
            });
        });
    });
});


   </script>
</body>
</html>
