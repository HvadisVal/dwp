<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./includes/admin_session.php'); 
require_once('./includes/connection.php');
require_once('./includes/functions.php');

ob_start();  // Start output buffering

$message = ""; // Initialize message variable

if (isset($_POST['submit'])) { // Form has been submitted
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);

    // Debugging output to check received email and password
    echo "<p>Debug: Entered email is '{$email}'</p>";
    
    try {
        // Case-insensitive email check
        $query = "SELECT Admin_ID, Email, Password FROM Admin WHERE LOWER(TRIM(Email)) = LOWER(:email) LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $found_admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debugging output to verify if admin is found
        if ($found_admin) {
            echo "<p>Debug: Admin found with email '{$found_admin['Email']}'</p>";
            
            // Verify the password if user is found
            if (password_verify($password, $found_admin['Password'])) {
                $_SESSION['admin_id'] = $found_admin['Admin_ID'];
                $_SESSION['admin_email'] = $found_admin['Email'];
                header("Location: /dwp/admin/dashboard");
                exit();
            } else {
                $message = "Incorrect email or password.";
            }
        } else {
            $message = "No account found with that email.";
        }
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
}

// Display error message if set
if (!empty($message)) {
    echo "<p style='color:red;'>{$message}</p>";
}

if (isset($connection)) { $connection = null; }
ob_end_flush();  // Flush the output buffer
?>
