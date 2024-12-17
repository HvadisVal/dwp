<?php 
require_once("./includes/connection.php");

class BookingModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAllBookings() {
        $sql = "SELECT * FROM DetailedBookings";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingDetails($bookingId) {
        $sql = "SELECT * FROM DetailedBookings WHERE Booking_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$bookingId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteBooking($bookingId) {
        $sql = "DELETE FROM Booking WHERE Booking_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$bookingId]);
    }
}
