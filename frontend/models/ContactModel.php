<?php
require_once("./includes/connection.php");

class ContactModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getCompanyDetails() {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Company LIMIT 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch company details: " . $e->getMessage());
        }
    }

    public function saveMessage($name, $email, $subject, $message) {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO ContactMessages (Name, Email, Subject, Message)
                VALUES (:name, :email, :subject, :message)
            ");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to save the message: " . $e->getMessage());
        }
    }
}
?>
