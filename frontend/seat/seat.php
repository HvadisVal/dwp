<?php
session_start(); // Start the session

// Connect to the database
require_once("./dbcon.php");
$dbCon = dbCon($user, $pass);

// Retrieve booking session or query parameters
$movie_id = $_SESSION['booking']['movie_id'] ?? $_GET['movie_id'] ?? 0;
$time = $_SESSION['booking']['time'] ?? $_GET['time'] ?? 'N/A';
$cinemaHallID = $_SESSION['booking']['cinema_hall_id'] ?? $_GET['cinema_hall_id'] ?? 0;
$date = $_SESSION['booking']['date'] ?? $_GET['date'] ?? '';

// Validate movie_id and cinema hall
if (!$movie_id || !$cinemaHallID) {
    die("Invalid movie or cinema hall ID.");
}

// Fetch movie details
$movieQuery = $dbCon->prepare("SELECT Title FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    $movie = ['Title' => 'Unknown Movie'];
}

// Fetch cinema hall information
$hallQuery = $dbCon->prepare("SELECT * FROM CinemaHall WHERE CinemaHall_ID = :cinema_hall_id");
$hallQuery->bindParam(':cinema_hall_id', $cinemaHallID);
$hallQuery->execute();
$hall = $hallQuery->fetch(PDO::FETCH_ASSOC);

if (!$hall) {
    die("Cinema Hall not found.");
}

// Fetch seats for the cinema hall
$seatsQuery = $dbCon->prepare("SELECT * FROM Seat WHERE CinemaHall_ID = :cinema_hall_id ORDER BY Row, SeatNumber");
$seatsQuery->bindParam(':cinema_hall_id', $cinemaHallID);
$seatsQuery->execute();
$seats = $seatsQuery->fetchAll(PDO::FETCH_ASSOC);

if (!$seats) {
    die("No seats available for this cinema hall.");
}

// Fetch ticket prices
$ticketPricesQuery = $dbCon->prepare("SELECT * FROM TicketPrice");
$ticketPricesQuery->execute();
$ticketPrices = $ticketPricesQuery->fetchAll(PDO::FETCH_ASSOC);

$ticketPricesMap = [];
foreach ($ticketPrices as $ticketPrice) {
    $ticketPricesMap[$ticketPrice['Type']] = $ticketPrice['Price'];
}

// Fetch booked seats for the current screening
$bookedSeatsQuery = $dbCon->prepare("
    SELECT Seat.Row, Seat.SeatNumber 
    FROM Ticket
    INNER JOIN Seat ON Ticket.Seat_ID = Seat.Seat_ID
    WHERE Ticket.Screening_ID = (
        SELECT Screening_ID 
        FROM Screening 
        WHERE Movie_ID = :movie_id 
        AND CinemaHall_ID = :cinema_hall_id 
        AND ShowDate = :show_date 
        AND ShowTime = :show_time
    )
");
$bookedSeatsQuery->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
$bookedSeatsQuery->bindParam(':cinema_hall_id', $cinemaHallID, PDO::PARAM_INT);
$bookedSeatsQuery->bindParam(':show_date', $date, PDO::PARAM_STR);
$bookedSeatsQuery->bindParam(':show_time', $time, PDO::PARAM_STR);
$bookedSeatsQuery->execute();
$bookedSeats = $bookedSeatsQuery->fetchAll(PDO::FETCH_ASSOC);

// Convert booked seats to an array
$bookedSeatsArray = array_map(function ($seat) {
    return $seat['Row'] . '-' . $seat['SeatNumber'];
}, $bookedSeats);

include 'seat_content.php';
