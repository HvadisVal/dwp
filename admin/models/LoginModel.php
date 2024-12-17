<?php

class LoginModel {
    private $connection;
    private $blockedTime; 

    public function __construct($connection, $blockedTime) {
        $this->connection = $connection;
        $this->blockedTime = $blockedTime; 
    }

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

    public function hasExceededMaxAttempts($ip) {
        $maxAttempts = 10;
        $timeFrame = '10 MINUTE';

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

        if ($blockedUntil && time() > strtotime($blockedUntil)) {
            $this->resetFailedAttempts($ip);
            return false;
        }

        if ($attempts >= $maxAttempts) {
            $blockUntil = strtotime($lastAttemptTime) + $this->blockedTime; 
            if (time() < $blockUntil) {
                return true; 
            }
        }

        return false;
    }

    public function logLoginAttempt($ip, $success) {
        $query = "INSERT INTO Login_Attempts (Ip_Address, Success) VALUES (:ip, :success)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindParam(':success', $success, PDO::PARAM_BOOL);
        $stmt->execute();

        if (!$success) {
            $this->setBlockedUntil($ip);
        }
    }

    private function setBlockedUntil($ip) {
        $query = "UPDATE Login_Attempts SET Blocked_Until = NOW() + INTERVAL :blockedTime SECOND 
                  WHERE Ip_Address = :ip AND Success = 0";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindParam(':blockedTime', $this->blockedTime, PDO::PARAM_INT); 
        $stmt->execute();
    }

    private function resetFailedAttempts($ip) {
        $query = "DELETE FROM Login_Attempts WHERE Ip_Address = :ip AND Success = 0";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt->execute();
    }
}
