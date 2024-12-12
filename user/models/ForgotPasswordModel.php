<?php

class ForgotPasswordModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection;
    }

    public function generateResetToken($email) {
        try {
            // Check if the email exists in the users table
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM User WHERE Email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if ($stmt->fetchColumn() == 0) {
                return false; // Email not found
            }

            // Generate a unique token
            $token = bin2hex(random_bytes(16));
            $expiry = (new DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');

            // Save the token and expiry to the database
            $stmt = $this->db->prepare("
                INSERT INTO PasswordResets (Email, Token, Expiry)
                VALUES (:email, :token, :expiry)
                ON DUPLICATE KEY UPDATE Token = :token, Expiry = :expiry
            ");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expiry', $expiry);
            $stmt->execute();

            return $token;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
    public function resetPassword($token, $password) {
        try {
            // Verify the token and check expiry
            $stmt = $this->db->prepare("SELECT Email FROM PasswordResets WHERE Token = :token AND Expiry > NOW()");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $email = $stmt->fetchColumn();
    
            if (!$email) {
                return false; // Invalid or expired token
            }
    
            // Update the password in the users table
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("UPDATE User SET Password = :password WHERE Email = :email");
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            // Delete the token after use
            $stmt = $this->db->prepare("DELETE FROM PasswordResets WHERE Token = :token");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }
    
}
?>