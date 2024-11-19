<?php
session_start(); // Start the session at the beginning

// Connect to the database
require_once("./dbcon.php");
$dbCon = dbCon($user, $pass);

// Get movie, time, and cinema hall from query parameters
$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : 0;
$time = isset($_GET['time']) ? $_GET['time'] : '';
$cinemaHallID = isset($_GET['cinema_hall_id']) ? $_GET['cinema_hall_id'] : 0;

// Store movie, time, and cinema hall in the session for later use
$_SESSION['movie_id'] = $movie_id;
$_SESSION['time'] = $time;
$_SESSION['cinema_hall_id'] = $cinemaHallID;

// Check if movie_id is valid
if ($movie_id == 0) {
    die("Invalid movie ID.");
}

// Fetch movie details
$movieQuery = $dbCon->prepare("SELECT Title FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);

// If movie not found, set a default message
if (!$movie) {
    $movie = ['Title' => 'Unknown Movie'];
}


// Fetch cinema hall information
$hallQuery = $dbCon->prepare("SELECT * FROM CinemaHall WHERE CinemaHall_ID = :cinema_hall_id");
$hallQuery->bindParam(':cinema_hall_id', $cinemaHallID);
$hallQuery->execute();
$hall = $hallQuery->fetch(PDO::FETCH_ASSOC);

// Check if hall was found
if (!$hall) {
    die("Cinema Hall not found.");
}

// Fetch seats for the cinema hall
$seatsQuery = $dbCon->prepare("SELECT * FROM Seat WHERE CinemaHall_ID = :cinema_hall_id ORDER BY Row, SeatNumber");
$seatsQuery->bindParam(':cinema_hall_id', $cinemaHallID);
$seatsQuery->execute();
$seats = $seatsQuery->fetchAll(PDO::FETCH_ASSOC);

// Check if seats were found
if (!$seats) {
    die("No seats available for this cinema hall.");
}

// Fetch ticket prices from the TicketPrice table
$ticketPricesQuery = $dbCon->prepare("SELECT * FROM TicketPrice");
$ticketPricesQuery->execute();
$ticketPrices = $ticketPricesQuery->fetchAll(PDO::FETCH_ASSOC);
$ticketPricesMap = [];
foreach ($ticketPrices as $ticketPrice) {
    $ticketPricesMap[$ticketPrice['Type']] = $ticketPrice['Price'];
}
include 'seat_content.php';
?>