<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php");

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    if (isset($_POST['edit_company'])) {
        // Handle editing company information
        $companyId = 1; // Assuming there is only one company and its ID is 1
        $name = htmlspecialchars(trim($_POST['name']));
        $description = htmlspecialchars(trim($_POST['description']));
        $openingHours = htmlspecialchars(trim($_POST['opening_hours']));
        $email = htmlspecialchars(trim($_POST['email']));
        $location = htmlspecialchars(trim($_POST['location']));

        // Update query with prepared statement
        $sql = "UPDATE Company SET Name = ?, Description = ?, OpeningHours = ?, Email = ?, Location = ? WHERE Company_ID = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt->execute([$name, $description, $openingHours, $email, $location, $companyId])) {
            $_SESSION['message'] = "Company information updated successfully!";
            header("Location: /dwp/admin/manage-company"); 
            exit();
        } else {
            echo "Error updating company information.";
        }
    }
}

// Fetch company information
$sql = "SELECT * FROM Company WHERE Company_ID = 1"; // Assuming there's only one company with ID 1
$stmt = $connection->prepare($sql);
$stmt->execute();
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); 
}