<?php
// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Get movie, time, and cinema hall from query parameters
$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : 0;
$time = isset($_GET['time']) ? $_GET['time'] : '';
$cinemaHallID = isset($_GET['cinema_hall_id']) ? $_GET['cinema_hall_id'] : 0;

// Debug: Print the cinema hall ID
echo "CinemaHall_ID being used: " . htmlspecialchars($cinemaHallID) . "<br>";

// Fetch cinema hall information
$hallQuery = $dbCon->prepare("SELECT * FROM CinemaHall WHERE CinemaHall_ID = :cinema_hall_id");
$hallQuery->bindParam(':cinema_hall_id', $cinemaHallID);
$hallQuery->execute();
$hall = $hallQuery->fetch(PDO::FETCH_ASSOC);

// Check if hall was found
if (!$hall) {
    die("Cinema Hall not found.");
} else {
    echo "Cinema Hall found: " . htmlspecialchars($hall['Name']) . "<br>";
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: white;
        }
        .seat {
            width: 30px;
            height: 30px;
            margin: 5px;
            background-color: #4CAF50;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
            line-height: 30px;
            cursor: pointer;
        }
        .seat.sold {
            background-color: red;
        }
        .seat.handicap {
            background-color: blue;
        }
        .seat.selected {
            background-color: yellow;
        }
        .row-label {
            display: inline-block;
            width: 30px;
            text-align: center;
        }
        .screen {
            margin-bottom: 20px;
            text-align: center;
        }
        .seat-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h4><?= $hall['Name']; ?> - Seat Selection</h4>
    <p>Movie: <?= $movie_id; ?> | Time: <?= $time; ?></p>

    <div class="screen">
        <strong>SCREEN</strong>
    </div>

    <!-- Seat Layout -->
    <?php
    $currentRow = 0;
    foreach ($seats as $seat) {
        // Start a new row
        if ($seat['Row'] != $currentRow) {
            if ($currentRow != 0) {
                echo "<br>"; // End previous row
            }
            $currentRow = $seat['Row'];
            echo "<span class='row-label'>" . str_pad($currentRow, 2, '0', STR_PAD_LEFT) . "</span>"; // Row number
        }

        // Set seat status class (e.g., sold, handicap)
        $seatClass = '';
        if ($seat['Status'] == 'Sold') {
            $seatClass = 'sold';
        } elseif ($seat['Status'] == 'Handicap') {
            $seatClass = 'handicap';
        }

        // Display seat
        echo "<div class='seat $seatClass' data-seat-id='" . $seat['Seat_ID'] . "'>" . str_pad($seat['SeatNumber'], 2, '0', STR_PAD_LEFT) . "</div>";
    }
    ?>

    <!-- Seat Info Legend -->
    <div class="seat-info">
        <p><span class="seat"></span> Available</p>
        <p><span class="seat sold"></span> Sold</p>
        <p><span class="seat handicap"></span> Handicap</p>
    </div>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    // Handle seat selection
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function() {
            if (!seat.classList.contains('sold') && !seat.classList.contains('handicap')) {
                seat.classList.toggle('selected');
            }
        });
    });
</script>

</body>
</html>
