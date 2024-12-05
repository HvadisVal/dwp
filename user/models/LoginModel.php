<?php
class LoginModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    } 

    public function getUserByUsername($username) {
        try {
            $query = "SELECT User_ID, Name, Password FROM User WHERE Name = :username LIMIT 1";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }
}
