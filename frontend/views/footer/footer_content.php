
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/dwp/frontend/assets/css/footer.css">
    <title>Footer</title>
</head>
<body>
<footer>
    <div class="footer-links">
        <a href="/dwp/news">News</a>
        <a href="/dwp/movies">Movies</a>
        <a href="/dwp/about">About Us</a>
    </div>
    <div class="contact-info">
        <h3>Contact Us</h3>
        <p>
            <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="email icon" style="width: 18px; margin-right: 8px;">
            <a href="mailto:<?= htmlspecialchars_decode($footerData['Email']); ?>" style="color: white; text-decoration: underline;">
            <?= htmlspecialchars_decode($footerData['Email']); ?>
            </a>
        </p>
        <p>
            <a href="https://www.google.com/maps/search/<?= htmlspecialchars_decode($footerData['Location']); ?>" target="_blank">
                <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="location icon" style="width: 18px; margin-right: 8px;">
                <?= htmlspecialchars_decode($footerData['Location']); ?>
            </a>
        </p>
    </div>
    <div class="social-icons">
        <a href="https://www.instagram.com"><img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" style="width: 60px;"></a>
        <a href="https://www.snapchat.com"><img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/c4/Snapchat_logo.svg/1024px-Snapchat_logo.svg.png" alt="Snapchat" style="width: 60px;"></a>
    </div>
</footer>

</body>
</html>
