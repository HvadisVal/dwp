<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="logo">
            <a href="/dwp/"><img src="/dwp/images/11.png" alt="Logotype" height="40px" width="145px"></a>
        </div>
        <div class="nav-links">
            <a href="/dwp/news">NEWS</a>
            <a href="/dwp/movies">MOVIES</a>
            <a href="/dwp/about">ABOUT US</a>
            <a href="/dwp/contact">CONTACT US</a>
        </div>
        <div class="nav-actions">
            <?php if ($isLoggedIn): ?>
                <!-- Logout Button -->
                <span class="user-info">Welcome, <?= htmlspecialchars($_SESSION['user']); ?></span>
                <a href="/dwp/user/profiles" class="btn blue">Profile</a>

                <button id="logoutButton" class="btn red">Logout</button>
            <?php else: ?>
                <!-- Login Modal Trigger -->
                <button class="btn modal-trigger" data-target="loginModal">Login</button>
            <?php endif; ?>
        </div>
    </nav>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/dwp/components/login_modal.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="/dwp/components/login_modal.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);
        });
    </script>
</body>
</html>
<script src="https://www.google.com/recaptcha/api.js?render=6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1" async defer></script>
