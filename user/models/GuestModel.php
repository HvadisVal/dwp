<?php
class GuestModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function createGuest($firstname, $lastname, $email, $phone) {
        try {
            $stmt = $this->db->prepare("INSERT INTO GuestUser (Firstname, Lastname, Email, TelephoneNumber) VALUES (:firstname, :lastname, :email, :phone)");
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);

            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new Exception("Error creating guest: " . $e->getMessage());
        }
    }
}
