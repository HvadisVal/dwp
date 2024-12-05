<?php
class UserModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    } 
    
    public function editUser($user_id, $name, $email, $phone, $password = null) {
        if (empty($name) || empty($email) || empty($phone)) {
            throw new Exception("All fields except password are required.");
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
    
        if (!filter_var($phone, FILTER_VALIDATE_INT)) {
            throw new Exception("Phone must be a valid number.");
        }
    
        try {
            $query = "UPDATE User SET Name = :name, Email = :email, TelephoneNumber = :phone";
    
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $query .= ", Password = :password";
            }
    
            $query .= " WHERE User_ID = :user_id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':user_id', $user_id);
    
            if (!empty($password)) {
                $stmt->bindParam(':password', $hashed_password);
            }
    
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function deleteUser($user_id) {
        try {
            $query = "DELETE FROM User WHERE User_ID = :user_id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting user: " . $e->getMessage());
        }
    }

    public function deleteUserBookings($user_id) {
        try {
            $this->connection->beginTransaction();

            // Delete tickets associated with the user's bookings
            $deleteTicketsQuery = "
                DELETE FROM Ticket
                WHERE Booking_ID IN (
                    SELECT Booking_ID FROM Booking WHERE User_ID = :user_id
                )";
            $stmt = $this->connection->prepare($deleteTicketsQuery);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete the user's bookings
            $deleteBookingsQuery = "DELETE FROM Booking WHERE User_ID = :user_id";
            $stmt = $this->connection->prepare($deleteBookingsQuery);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $this->connection->commit();
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw new Exception("Error deleting user bookings: " . $e->getMessage());
        }
    }
    
}