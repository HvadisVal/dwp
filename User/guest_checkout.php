<?php
session_start();
require_once("../includes/connection.php"); // Include database connection
require_once("../includes/functions.php"); // Include functions if needed

$message = ""; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get guest user details from form submission
    $firstname = $_POST['firstname'] ?? null;
    $lastname = $_POST['lastname'] ?? null;
    $email = $_POST['email'] ?? null;

    if ($firstname && $lastname && $email) {
        // Insert guest user into database
        $query = "INSERT INTO GuestUser (Firstname, Lastname, Email) VALUES (:firstname, :lastname, :email)";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            // Simulate sending an invoice email (for demonstration purposes)
            // You would use a mail function here to actually send the email.
            $_SESSION['guest_invoice_sent'] = true;

            // Clear guest-related session data to reset overview page on navigation back
            unset($_SESSION['guest_user_id'], $_SESSION['movie_id'], $_SESSION['cinema_hall_id'], $_SESSION['time']);

            // Redirect to a confirmation page
            header("Location: guest_confirmation.php");
            exit();
        } else {
            $error = "Failed to save guest information. Please try again.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guest Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h4>Guest Checkout</h4>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="guest_checkout.php">
        <div class="input-field">
            <input type="text" name="firstname" required>
            <label for="firstname">First Name</label>
        </div>
        <div class="input-field">
            <input type="text" name="lastname" required>
            <label for="lastname">Last Name</label>
        </div>
        <div class="input-field">
            <input type="email" name="email" required>
            <label for="email">Email</label>
        </div>
        <button class="btn" type="submit">Submit</button>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
