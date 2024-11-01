<?php
session_start();
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Retrieve booking information from the session
$movie_id = $_SESSION['movie_id'] ?? null;
$cinema_hall_id = $_SESSION['cinema_hall_id'] ?? null;
$showtime = $_SESSION['time'] ?? null;

// Check if required session data is available
if (!$movie_id || !$cinema_hall_id || !$showtime) {
    die("Error: Booking information is missing. Please go back and select your movie and showtime.");
}

// Fetch movie details
$movieQuery = $dbCon->prepare("SELECT Title, Duration, Rating FROM Movie WHERE Movie_ID = :movie_id");
$movieQuery->bindParam(':movie_id', $movie_id, PDO::PARAM_INT);
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);

// Fetch cinema hall details
$cinemaHallQuery = $dbCon->prepare("SELECT Name FROM CinemaHall WHERE CinemaHall_ID = :cinema_hall_id");
$cinemaHallQuery->bindParam(':cinema_hall_id', $cinema_hall_id, PDO::PARAM_INT);
$cinemaHallQuery->execute();
$cinemaHall = $cinemaHallQuery->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Overview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: white;
        }
        .container {
            margin-top: 30px;
        }
        .movie-details, .seat-summary, .order-summary {
            background-color: #222;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .btn {
            background-color: #3B82F6;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #2563EB;
        }
        .ticket-icons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .ticket-icon {
            background-color: #3B82F6;
            color: white;
            border-radius: 5px;
            padding: 5px;
            font-size: 12px;
            text-align: center;
            width: 60px;
        }
    </style>
</head>
<body>

<div class="container">
    <h4>Booking Overview</h4>
    
    <!-- Movie and Showtime Details -->
    <div class="movie-details">
        <h5>Movie: <?= htmlspecialchars($movie['Title']); ?></h5>
        <p><strong>Duration:</strong> <?= htmlspecialchars($movie['Duration']); ?></p>
        <p><strong>Rating:</strong> <?= htmlspecialchars($movie['Rating']); ?> / 10</p>
        <p><strong>Cinema Hall:</strong> <?= htmlspecialchars($cinemaHall); ?></p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($showtime); ?></p>
    </div>

    <!-- Seat Summary -->
    <div class="seat-summary">
        <h5>Selected Seats</h5>
        <div class="ticket-icons-container" id="seat-icons"></div>
    </div>

    <!-- Order Summary -->
    <div class="order-summary">
        <h5>Order Summary</h5>
        <p id="ticket-count">Total Tickets: </p>
        <p id="total-price">Total Price: </p>
    </div>

    <!-- Options to Login or Continue as Guest -->
    <a href="login.php" class="btn">Log in or create an account</a>
    <a href="guest_checkout.php" class="btn">Continue as Guest</a>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
// Retrieve selected seats from sessionStorage
const selectedSeats = JSON.parse(sessionStorage.getItem('selectedSeats')) || [];
const ticketPrice = 135;

// Display seat icons and update order summary
const seatIconsContainer = document.getElementById('seat-icons');
const ticketCount = document.getElementById('ticket-count');
const totalPrice = document.getElementById('total-price');

// Display selected seats
selectedSeats.forEach(seat => {
    const [row, seatNumber] = seat.split('-');
    const seatIcon = document.createElement('div');
    seatIcon.classList.add('ticket-icon');
    seatIcon.innerHTML = `Row ${row.padStart(2, '0')}<br>Seat ${seatNumber.padStart(2, '0')}`;
    seatIconsContainer.appendChild(seatIcon);
});

// Update ticket count and total price
ticketCount.textContent = `Total Tickets: ${selectedSeats.length}`;
totalPrice.textContent = `Total Price: DKK ${selectedSeats.length * ticketPrice}`;

</script>
</body>
</html>
