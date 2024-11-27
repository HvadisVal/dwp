<?php
session_start();
require_once("./includes/connection.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /dwp/frontend/landing/landing.php");
    exit();
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

// Fetch booking history for the logged-in user
try {
    $bookingQuery = "
        SELECT 
            b.Booking_ID, 
            b.BookingDate, 
            b.NumberOfTickets, 
            b.TotalPrice, 
            b.PaymentStatus, 
            m.Title AS MovieTitle 
        FROM Booking b
        JOIN Movie m ON b.Movie_ID = m.Movie_ID
        WHERE b.User_ID = :user_id
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


