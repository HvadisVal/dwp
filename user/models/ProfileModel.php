<?php
class ProfileModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getUserData($user_id) {
        try {
            $query = "SELECT Name, Email, TelephoneNumber FROM User WHERE User_ID = :user_id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching user data: " . $e->getMessage());
        }
    }

    public function getBookingHistory($user_id) {
        try {
            $query = "
                SELECT 
                    b.BookingDate, 
                    b.NumberOfTickets, 
                    b.TotalPrice, 
                    b.PaymentStatus, 
                    m.Title AS MovieTitle,
                    s.ShowTime,
                    s.ShowDate,
                    c.Name AS CinemaHall,
                    GROUP_CONCAT(DISTINCT CONCAT(seat.Row, '-', seat.SeatNumber) ORDER BY seat.Row, seat.SeatNumber) AS Seats
                FROM Booking b
                JOIN Movie m ON b.Movie_ID = m.Movie_ID
                JOIN Ticket t ON b.Booking_ID = t.Booking_ID
                JOIN Seat seat ON t.Seat_ID = seat.Seat_ID
                JOIN Screening s ON t.Screening_ID = s.Screening_ID
                JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
                WHERE b.User_ID = :user_id
                GROUP BY b.Booking_ID
                ORDER BY b.BookingDate DESC";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching booking history: " . $e->getMessage());
        }
    }

    public function getUserInvoices($user_id) {
        try {
            $query = "
                SELECT i.Invoice_ID, i.InvoiceDate, i.TotalAmount, i.InvoiceStatus
                FROM Invoice i
                JOIN Booking b ON i.Invoice_ID = b.Invoice_ID
                WHERE b.User_ID = :user_id
                ORDER BY i.InvoiceDate DESC";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching invoices: " . $e->getMessage());
        }
    }
}
