<?php
class LoginModel {
    private $connection;
    private $blockedTime; // Store blocked time

    // Constructor now accepts blockedTime as a parameter
    public function __construct($connection, $blockedTime) {
        $this->connection = $connection;
        $this->blockedTime = $blockedTime; // Assign the blocked time
    }

    // Authenticate user credentials
    public function authenticate($email, $password) {
        $query = "SELECT Admin_Id, Email, Password FROM Admin WHERE Email = :email";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['Password'])) {
            return $admin;
        }

        return false;
    }

    // Check if user has exceeded maximum login attempts
    public function hasExceededMaxAttempts($ip) {
        $maxAttempts = 10;
        $timeFrame = '10 MINUTE';

        // Query to check failed attempts within the last 15 minutes
        $query = "SELECT COUNT(*), MAX(Attempt_Time) AS Last_Attempt_Time, MAX(Blocked_Until) AS Blocked_Until
                  FROM Login_Attempts WHERE Ip_Address = :ip AND Success = 0 
                  AND Attempt_Time > NOW() - INTERVAL $timeFrame";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $attempts = $result['COUNT(*)'];
        $lastAttemptTime = $result['Last_Attempt_Time'];
        $blockedUntil = $result['Blocked_Until'];

        // If user is blocked, check if cooldown has expired
        if ($blockedUntil && time() > strtotime($blockedUntil)) {
            // Reset failed attempts after cooldown
            $this->resetFailedAttempts($ip);
            return false; // User is no longer blocked
        }

        // If attempts exceed the max, block the user
        if ($attempts >= $maxAttempts) {
            $blockUntil = strtotime($lastAttemptTime) + $this->blockedTime; // Use dynamic blocked time
            if (time() < $blockUntil) {
                return true; // User is still blocked
            }
        }

        return false; // User has not exceeded the max attempts
    }

    // Log the login attempt (success or failure)
    public function logLoginAttempt($ip, $success) {
        $query = "INSERT INTO Login_Attempts (Ip_Address, Success) VALUES (:ip, :success)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindParam(':success', $success, PDO::PARAM_BOOL);
        $stmt->execute();

        // If the login was unsuccessful, set the blocked time
        if (!$success) {
            $this->setBlockedUntil($ip);
        }
    }

    // Set the blocked time for failed login attempts using dynamic blocked time
    private function setBlockedUntil($ip) {
        $query = "UPDATE Login_Attempts SET Blocked_Until = NOW() + INTERVAL :blockedTime SECOND 
                  WHERE Ip_Address = :ip AND Success = 0";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindParam(':blockedTime', $this->blockedTime, PDO::PARAM_INT); // Use dynamic blocked time
        $stmt->execute();
    }

    // Reset failed login attempts after cooldown expires
    private function resetFailedAttempts($ip) {
        $query = "DELETE FROM Login_Attempts WHERE Ip_Address = :ip AND Success = 0";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();
    }
}
