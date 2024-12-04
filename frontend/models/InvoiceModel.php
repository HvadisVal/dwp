<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class InvoiceModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", ""); // Update with actual credentials
    }

    public function getInvoiceDetails($invoiceId) {
        $query = "
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
            GROUP BY i.Invoice_ID
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
