<?php
class NewUserModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function createNewUser($username, $email, $phone, $password) {
        try {
            $checkQuery = "SELECT COUNT(*) FROM User WHERE Name = :username OR Email = :email";
            $stmt = $this->connection->prepare($checkQuery);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                return ['success' => false, 'message' => 'Username or email already exists.'];
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $insertQuery = "INSERT INTO User (Name, Email, TelephoneNumber, Password) VALUES (:username, :email, :phone, :hashedPassword)";
            $stmt = $this->connection->prepare($insertQuery);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':hashedPassword', $hashedPassword);

            if ($stmt->execute()) {
                session_start();
                $_SESSION['user_id'] = $this->connection->lastInsertId();
                $_SESSION['user'] = $username;

                return ['success' => true, 'message' => 'Account created successfully!'];
            } else {
                return ['success' => false, 'message' => 'User could not be created.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
?>
