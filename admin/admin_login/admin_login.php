<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./includes/admin_session.php'); 
require_once('./includes/connection.php');
require_once('./includes/functions.php');

// Ensure no output before header() functions
ob_start();  // Start output buffering

if (isset($_POST['submit'])) { // Form has been submitted.
    $email = trim($_POST['email']);
    $password = trim($_POST['pass']);
    
    try {
        // Prepare SQL query using PDO to match the "Admin" table structure
        $query = "SELECT Admin_ID, Email, Password FROM Admin WHERE Email = :email LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $found_admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if admin exists and verify the hashed password
        if ($found_admin && password_verify($password, $found_admin['Password'])) {
            // Set session variables for admin login
            $_SESSION['admin_id'] = $found_admin['Admin_ID'];
            $_SESSION['admin_email'] = $found_admin['Email'];
            redirect_to("/dwp/admin/dashboard");
        } else {
            $message = "Incorrect email or password.";
        }
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
}

// Display error message if set
if (!empty($message)) {
    echo "<p>{$message}</p>";
}

if (isset($connection)) { $connection = null; }
ob_end_flush();  // Flush the output buffer