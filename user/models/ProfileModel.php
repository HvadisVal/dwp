<?php
class ProfileModel {
    private $db;

    public function __construct($connection) {
        $this->db = $connection; 
    }

    public function getUserDetails($userId) {
        $query = "SELECT Name, Email, TelephoneNumber FROM User WHERE User_ID = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBookingHistory($userId) {
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

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInvoices($userId) {
        $query = "
            SELECT i.Invoice_ID, i.InvoiceDate, i.TotalAmount, i.InvoiceStatus
            FROM Invoice i
            JOIN Booking b ON i.Invoice_ID = b.Invoice_ID
            WHERE b.User_ID = :user_id
            ORDER BY i.InvoiceDate DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
