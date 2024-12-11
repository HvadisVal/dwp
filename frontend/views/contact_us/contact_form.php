<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/contact.css">
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

        <!-- Contact Form -->
        <form method="POST" action="/dwp/contact/submit">
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
            <button type="submit">Send Message</button>
        </form>
    </div>
</body>
</html>
