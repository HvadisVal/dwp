<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FilmFusion</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/about.css">
</head>
<body>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
$navbar = new NavbarController();
$navbar->handleRequest();
?>

<!-- Hero Section -->
<section class="hero">
    <div>
        <h1>Welcome to FilmFusion</h1>
        <p>Experience movies like never before in the heart of MovieTown.</p>
    </div>
</section>

<!-- About Section -->
<section class="about">
    <h2>About Us</h2>
    <p><?= htmlspecialchars($aboutData['Description']); ?></p>
</section>

<!-- Contact Information -->
<section class="contact">
    <h3>Contact Us</h3>
    <p><strong>Email:</strong>
        <a href="mailto:<?= htmlspecialchars($aboutData['Email']); ?>" style="color: white; text-decoration: underline;">
            <?= htmlspecialchars($aboutData['Email']); ?>
        </a>
    </p>
    <p><strong>Location:</strong> <?= htmlspecialchars($aboutData['Location']); ?></p>
    <p><strong>Opening Hours:</strong></p>
    <p class="openingH"><?= nl2br(htmlspecialchars($aboutData['OpeningHours'])); ?></p>
</section>

<!-- Footer -->
<footer>
    © 2024 FilmFusion. All rights reserved.
</footer>

</body>
</html>
