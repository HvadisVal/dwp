<?php
session_start();
require_once("includes/connection.php");
require_once("dbcon.php");


// Check if the user or guest is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = isset($_SESSION['guest_user_id']);

// Fetch selected seats and ticket types from session (stored from seat selection page)
$selectedSeats = $_SESSION['selectedSeats'] ?? [];
$selectedTickets = $_SESSION['selectedTickets'] ?? [];


// Check if any tickets were selected
if (empty($selectedTickets) || empty($selectedSeats)) {
    die("No tickets or seats selected. Please go back to select tickets.");
}


// Calculate the total price by retrieving prices from the TicketPrice table
$totalPrice = 0;
$ticketDetails = [];


try {
    // Prepare database query to fetch ticket prices for each selected type
    $dbCon = dbCon($user, $pass);
    foreach ($selectedTickets as $type => $quantity) {
        $priceQuery = $dbCon->prepare("SELECT Price FROM TicketPrice WHERE Type = :type");
        $priceQuery->bindParam(':type', $type);
        $priceQuery->execute();
        $priceResult = $priceQuery->fetch(PDO::FETCH_ASSOC);

        if ($priceResult) {
            $pricePerTicket = $priceResult['Price'];
            $totalForType = $pricePerTicket * $quantity;
            $totalPrice += $totalForType;
            $ticketDetails[] = [
                'type' => $type,
                'price' => $pricePerTicket,
                'quantity' => $quantity,
                'total' => $totalForType
            ];
        }
    }
     // Store the total price in the session for later use (e.g., in the coupon discount)
     $_SESSION['totalPrice'] = $totalPrice;
} catch (PDOException $e) {
    die("Error retrieving ticket prices: " . $e->getMessage());
}

// Get movie details
$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;
$movieQuery = $dbCon->prepare("SELECT * FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);

include 'overview_content.php';
?>
