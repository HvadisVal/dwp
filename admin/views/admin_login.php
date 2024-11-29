<!-- admin/views/admin_login.php -->
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

        <?php
        // Display the error message if it's set
        if (!empty($message)) {
            echo "<p style='color: red;'>" . $message . "</p>";
        }
        ?>

<form action="index.php?path=admin/login" method="post">
            <div class="input-field">
                <input id="email" type="email" name="email" required />
                <label for="email">Email</label>
            </div>
            <div class="input-field">
                <input id="pass" type="password" name="pass" required />
                <label for="pass">Password</label>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="submit">
                Login
            </button>
        </form>
    </div>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
