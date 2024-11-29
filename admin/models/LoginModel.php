<?php
// admin/models/LoginModel.php
require_once('./includes/connection.php');  // Ensure connection is available

class LoginModel {

    public function authenticate($email, $password) {
        global $connection;  // Use the global $connection variable

        if (!$connection) {
            die("Database connection failed.");  // Ensure that the database connection is available
        }

        try {
            // Prepare SQL query to match the "Admin" table structure
            $query = "SELECT Admin_ID, Email, Password FROM Admin WHERE Email = :email LIMIT 1";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $found_admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if admin exists and verify the password
            if ($found_admin && password_verify($password, $found_admin['Password'])) {
                return $found_admin; // Return admin data on successful authentication
            } else {
                return false; // Return false if authentication failed
            }
        } catch (PDOException $e) {
            die("Database query failed: " . $e->getMessage());
        }
    }
}
