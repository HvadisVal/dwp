<?php
// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Get movie, time, and cinema hall from query parameters
$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : 0;
$time = isset($_GET['time']) ? $_GET['time'] : '';
$cinemaHallID = isset($_GET['cinema_hall_id']) ? $_GET['cinema_hall_id'] : 0;

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
        .ticket-controls {
            display: flex;
            align-items: center;
        }
        .ticket-count {
            font-size: 18px;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h4><?= htmlspecialchars($hall['Name']); ?> - Seat Selection</h4>
    <p>Movie: <?= htmlspecialchars($movie_id); ?> | Time: <?= htmlspecialchars($time); ?></p>

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

        // Display seat
        echo "<div class='seat' data-seat-id='" . htmlspecialchars($seat['Seat_ID']) . "' data-seat-number='" . htmlspecialchars($seat['SeatNumber']) . "' data-row='" . htmlspecialchars($seat['Row']) . "'>" . str_pad($seat['SeatNumber'], 2, '0', STR_PAD_LEFT) . "</div>";
    }
    ?>

    <!-- Seat Info Legend -->
    <div class="seat-info">
        <p><span class="seat"></span> Available</p>
        <p><span class="seat selected"></span> Selected</p>
    </div>

    <!-- Ticket Selection -->
    <div class="ticket-selection">
        <h5>Select Tickets</h5>
        <div class="ticket-controls">
            <button class="btn-small" id="decrease-tickets">-</button>
            <span class="ticket-count" id="ticket-count">0</span>
            <button class="btn-small" id="increase-tickets">+</button>
        </div>
        <p>Max 9 tickets can be purchased per booking.</p>
    </div>

</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
    let selectedSeats = [];
    let maxTickets = 9;
    let currentTickets = 0;
    let currentRow = null;

    // Handle seat selection
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function() {
            if (!seat.classList.contains('sold')) {
                if (seat.classList.contains('selected')) {
                    // Deselect seat
                    seat.classList.remove('selected');
                    selectedSeats = selectedSeats.filter(s => s !== seat.dataset.seatNumber);
                    currentTickets--;
                } else {
                    // Check if we are selecting a new row
                    if (currentRow === null || currentRow === seat.dataset.row) {
                        if (currentTickets < maxTickets && areSeatsContiguous(seat.dataset.seatNumber)) {
                            // Select seat in the same row
                            seat.classList.add('selected');
                            selectedSeats.push(seat.dataset.seatNumber);
                            currentTickets++;
                            currentRow = seat.dataset.row; // Set the current row
                        }
                    } else {
                        // Deselect previous row, but keep the same number of seats
                        clearSelectedSeats();
                        seat.classList.add('selected');
                        selectSeatsInNewRow(seat.dataset.row, currentTickets);
                        currentRow = seat.dataset.row; // Set the new row
                    }
                }
                document.getElementById('ticket-count').innerText = currentTickets;
            }
        });
    });

    // Function to check if the selected seats are contiguous
    function areSeatsContiguous(newSeat) {
        if (selectedSeats.length === 0) {
            return true; // No seats selected yet
        }
        const seatNumbers = selectedSeats.map(Number).concat(Number(newSeat)).sort((a, b) => a - b);
        for (let i = 1; i < seatNumbers.length; i++) {
            if (seatNumbers[i] - seatNumbers[i - 1] !== 1) {
                return false; // Non-contiguous seats detected
            }
        }
        return true; // All seats are contiguous
    }

    // Function to select seats in a new row
    function selectSeatsInNewRow(row, numSeats) {
        let availableSeats = document.querySelectorAll('.seat[data-row="' + row + '"]:not(.sold)');
        let seatsToSelect = [];
        for (let i = 0; i < availableSeats.length && seatsToSelect.length < numSeats; i++) {
            seatsToSelect.push(availableSeats[i]);
        }

        seatsToSelect.forEach(seat => {
            seat.classList.add('selected');
            selectedSeats.push(seat.dataset.seatNumber);
        });
    }

    // Function to clear selected seats
    function clearSelectedSeats() {
        document.querySelectorAll('.seat.selected').forEach(seat => {
            seat.classList.remove('selected');
        });
        selectedSeats = [];
    }

    // Ticket counter
    document.getElementById('increase-tickets').addEventListener('click', () => {
        if (currentTickets < maxTickets) {
            currentTickets++;
            document.getElementById('ticket-count').innerText = currentTickets;
        }
    });

    document.getElementById('decrease-tickets').addEventListener('click', () => {
        if (currentTickets > 0) {
            currentTickets--;
            document.getElementById('ticket-count').innerText = currentTickets;
        }
    });
</script>

</body>
</html>
