<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/contact.css">
    <!-- Google reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js?render=6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1" async defer></script>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <!-- Success/Error Message -->
        <?php if (!empty($successMessage)): ?>
            <p class="success-message"><?= htmlspecialchars($successMessage); ?></p>
        <?php elseif (!empty($errorMessage)): ?>
            <p class="error-message"><?= htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
        <!-- Company Details -->
        <?php if (!empty($company)): ?>
            <div class="company-details">
                <p><strong>Name:</strong> <?= htmlspecialchars($company['Name']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($company['Location']); ?></p>
                <p><strong>Opening Hours:</strong> <?= htmlspecialchars($company['OpeningHours']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($company['Email']); ?></p>
            </div>
        <?php endif; ?>
        
        <form id="contactForm" method="POST" action="/dwp/contact/submit">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div>
                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            
            <!-- Hidden reCAPTCHA response field -->
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

            <button class="SendMessage" id="sendMessage" type="submit">Send Message</button>
            <a href="/dwp/" class="back-to-dashboard">Go Back</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/dwp/frontend/assets/js/contact.js"></script>
</body>
</html>
