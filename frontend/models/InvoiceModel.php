<?php
require_once("./includes/connection.php");

class InvoiceModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getInvoiceDetails($invoiceId, $isGuest = false) {
        $sql = "
            SELECT i.Invoice_ID, i.InvoiceDate, i.TotalAmount, i.InvoiceStatus,
                   b.BookingDate, b.NumberOfTickets,
                   m.Title AS MovieTitle, s.ShowDate, s.ShowTime, c.Name AS CinemaHall,
                   GROUP_CONCAT(CONCAT(seat.Row, '-', seat.SeatNumber) ORDER BY seat.Row, seat.SeatNumber) AS Seats
            FROM Invoice i
            JOIN Booking b ON i.Invoice_ID = b.Invoice_ID
            JOIN Movie m ON b.Movie_ID = m.Movie_ID
            JOIN Ticket t ON b.Booking_ID = t.Booking_ID
            JOIN Seat seat ON t.Seat_ID = seat.Seat_ID
            JOIN Screening s ON t.Screening_ID = s.Screening_ID
            JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
            WHERE i.Invoice_ID = :invoice_id
        ";
    
        // Add guest-specific condition
        if ($isGuest) {
            $sql .= " AND b.GuestUser_ID IS NOT NULL";  // Corrected to use GuestUser_ID
        } else {
            $sql .= " AND b.User_ID IS NOT NULL";
        }
    
        $sql .= " GROUP BY i.Invoice_ID";
    
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserEmail($invoiceId) {
        try {
            $query = "
                SELECT u.Email
                FROM Invoice i
                JOIN Booking b ON i.Invoice_ID = b.Invoice_ID
                JOIN User u ON b.User_ID = u.User_ID
                WHERE i.Invoice_ID = :invoice_id
                LIMIT 1
            ";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch user email: " . $e->getMessage());
        }
    }
    
    public function getGuestEmail($invoiceId) {
        try {
            $query = "
                SELECT g.Email
                FROM Invoice i
                JOIN Booking b ON i.Invoice_ID = b.Invoice_ID
                JOIN GuestUser g ON b.GuestUser_ID = g.GuestUser_ID
                WHERE i.Invoice_ID = :invoice_id
                LIMIT 1
            ";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch guest email: " . $e->getMessage());
        }
    }
    
    
    
    
}
