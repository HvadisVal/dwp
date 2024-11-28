<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /dwp/frontend/landing/landing.php");
    exit();
}

// Check for booking success message
$bookingSuccessMessage = null;
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $bookingSuccessMessage = "Your booking has been successfully completed!";
}

// Fetch user data
$user_id = $_SESSION['user_id'];
try {
    $query = "SELECT Name, Email, TelephoneNumber FROM User WHERE User_ID = :user_id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}

// Fetch detailed booking history
try {
    $bookingQuery = "
    SELECT 
        b.BookingDate, 
        b.NumberOfTickets, 
        b.TotalPrice, 
        b.PaymentStatus, 
        m.Title AS MovieTitle,
        s.ShowTime,
        s.ShowDate,
        c.Name AS CinemaHall,
        GROUP_CONCAT(CONCAT(seat.Row, '-', seat.SeatNumber) ORDER BY seat.Row, seat.SeatNumber) AS Seats
    FROM Booking b
    JOIN Movie m ON b.Movie_ID = m.Movie_ID
    JOIN Screening s ON s.Movie_ID = b.Movie_ID AND s.CinemaHall_ID = (
        SELECT CinemaHall_ID FROM Screening WHERE Movie_ID = b.Movie_ID LIMIT 1
    )
    JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
    LEFT JOIN Ticket t ON t.Screening_ID = s.Screening_ID
    LEFT JOIN Seat seat ON t.Seat_ID = seat.Seat_ID
    WHERE b.User_ID = :user_id
    GROUP BY b.Booking_ID
    ORDER BY b.BookingDate DESC";

    $stmt = $connection->prepare($bookingQuery);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Error fetching booking history: " . $e->getMessage());
}


include 'profile_content.php';
?>