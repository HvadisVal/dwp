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
    let selectedCount = 0;
    const maxTickets = 9;

    // Function to update seat selection display and logic
    function updateSeats() {
        document.querySelectorAll('.seat').forEach(seat => {
            const row = seat.getAttribute('data-row');
            const seatNumber = seat.getAttribute('data-seat-number');

            if (selectedSeats.some(s => s.row === row && s.seatNumber === seatNumber)) {
                seat.classList.add('selected');
            } else {
                seat.classList.remove('selected');
            }
        });
    }

    // Handle seat selection and dynamically assign seats in the same row
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('click', function () {
            const row = seat.getAttribute('data-row');
            const seatNumber = parseInt(seat.getAttribute('data-seat-number'));

            // If clicking on a new row, clear existing selection and allocate new seats
            if (selectedSeats.length > 0 && selectedSeats[0].row !== row) {
                allocateSeatsInRow(row, seatNumber);
            } else {
                // Standard seat selection
                if (seat.classList.contains('selected')) {
                    // Remove seat from selected list
                    selectedSeats = selectedSeats.filter(s => !(s.row === row && s.seatNumber === seatNumber));
                    selectedCount--;
                } else if (selectedCount < maxTickets) {
                    // Add seat to selected list
                    selectedSeats.push({ row, seatNumber });
                    selectedCount++;
                }
            }

            // Update seat selection
            updateSeats();
            document.querySelector('.ticket-count').textContent = selectedCount;
        });
    });

    // Function to allocate seats dynamically in the selected row
    function allocateSeatsInRow(row, startingSeat) {
        selectedSeats = [];

        // Find available seats in the new row
        const newRowSeats = document.querySelectorAll(`.seat[data-row="${row}"]`);

        // Calculate how many seats we can select starting from the clicked seat
        for (let i = startingSeat - 1; i < newRowSeats.length && selectedSeats.length < selectedCount; i++) {
            const seatNumber = newRowSeats[i].getAttribute('data-seat-number');
            selectedSeats.push({ row, seatNumber });
        }

        // If we couldn't allocate enough seats starting from the clicked seat, reset
        if (selectedSeats.length < selectedCount) {
            alert("Not enough seats available from this position in the row.");
            selectedSeats = [];
        }

        updateSeats();
    }

    // Update ticket counter based on button clicks
    document.querySelector('.increment').addEventListener('click', function () {
        if (selectedCount < maxTickets) {
            selectedCount++;
            document.querySelector('.ticket-count').textContent = selectedCount;
        }
    });

    document.querySelector('.decrement').addEventListener('click', function () {
        if (selectedCount > 1) {
            selectedCount--;
            document.querySelector('.ticket-count').textContent = selectedCount;
        }
    });

</script>


</body>
</html>
