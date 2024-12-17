<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/ContactModel.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = htmlspecialchars($_POST['message']);

    if (!$email) {
        die("Invalid email address.");
    }

    // Initialize ContactModel
    $contactModel = new ContactModel($connection);

    // Save the message
    if ($contactModel->saveMessage($name, $email, $subject, $message)) {
        echo "Thank you, $name. Your message has been sent successfully.";
    } else {
        die("Failed to send your message. Please try again later.");
    }
}
?>
