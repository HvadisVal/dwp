<?php
session_start();
require_once("includes/connection.php");
require_once("dbcon.php");

$isLoggedIn = isset($_SESSION['user_id']);
$isGuest = isset($_SESSION['guest_user_id']);

// Fetch selected seats and ticket types from session
$selectedSeats = $_SESSION['selectedSeats'] ?? [];
$selectedTickets = $_SESSION['selectedTickets'] ?? [];

// Validate ticket selection
if (empty($selectedTickets) || empty($selectedSeats)) {
    die("No tickets or seats selected. Please go back to select tickets.");
}

// Calculate the total price
$totalPrice = 0;
$ticketDetails = [];
try {
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
    $_SESSION['totalPrice'] = $totalPrice;
} catch (PDOException $e) {
    die("Error retrieving ticket prices: " . $e->getMessage());
}

// Get movie details
$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;

try {
    $movieQuery = $dbCon->prepare("SELECT * FROM Movie WHERE Movie_ID = :movie_id");
    $movieQuery->bindParam(':movie_id', $movie_id);
    $movieQuery->execute();
    $movie = $movieQuery->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving movie details: " . $e->getMessage());
}

include 'overview_content.php';
