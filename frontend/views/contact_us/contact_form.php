<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $captcha_response = $_POST['g-recaptcha-response'];

    $secret_key = '6LcGh40qAAAAAA3ZkV5HXoWBeZFOt7LzGmXwUKGH';

    // Verify CAPTCHA
    $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$captcha_response");
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        echo json_encode(['success' => false, 'message' => 'Please verify that you are not a robot.']);
        exit;
    }

    // Proceed with form handling logic
    // Save data or send email
    // ...

    echo json_encode(['success' => true, 'message' => 'Your message has been successfully sent.']);
}
?>



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
            <div class="g-recaptcha" data-sitekey="6LcGh40qAAAAADJ9GhkbB2mb-3wNydnZ11-7ton6" data-callback="onFormCaptchaCompleted"></div><br>
            <button class="SendMessage" id="sendMessage" type="submit" disabled>Send Message</button>
            <a href="/dwp/" class="back-to-dashboard">Go Back</a>
        </form>
    </div>
</body>
</html>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function onFormCaptchaCompleted() {
    document.getElementById('sendMessage').disabled = false;
  }
</script>
