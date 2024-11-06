<?php
session_start(); // Start the session at the beginning

// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);



// Get movie, time, and cinema hall from query parameters
$movie_id = isset($_GET['movie_id']) ? $_GET['movie_id'] : 0;
$time = isset($_GET['time']) ? $_GET['time'] : '';
$cinemaHallID = isset($_GET['cinema_hall_id']) ? $_GET['cinema_hall_id'] : 0;



// Store movie, time, and cinema hall in the session for later use
$_SESSION['movie_id'] = $movie_id;
$_SESSION['time'] = $time;
$_SESSION['cinema_hall_id'] = $cinemaHallID;

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
        background-color: #4CAF50; /* Green for available seats */
        border-radius: 5px;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition for hover */
    }

    .seat:hover {
        background-color: #FFD700; /* Yellow on hover */
    }

    .seat.selected {
        background-color: yellow; /* Yellow when selected */
    }

    .seat.sold {
        background-color: red; /* Red for sold seats */
        cursor: not-allowed;
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

    .seat-info .selected-legend {
        background-color: yellow; /* Fixed yellow for the "Selected" legend */
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 5px;
    }

    .ticket-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #1a1a1a;
        color: white;
        font-size: 16px;
        position: fixed;
        bottom: 0;
        width: 100%;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
    }

    .ticket-details {
        display: flex;
        align-items: center;
    }

    .ticket-icons-container {
    display: flex;
    gap: 5px; /* Space between each ticket icon */
    align-items: center;
}

.ticket-icon {
    background-color: #3B82F6;
    color: white;
    border-radius: 5px;
    padding: 4px; /* Smaller padding to reduce size */
   /* width: 40px; /* Adjust width to fit the smaller size */
    font-size: 12px; /* Smaller font size */
    text-align: center;
}


    .ticket-info {
        margin-right: 20px;
    }

    .ticket-info p {
        margin: 0;
    }

    .total-info {
        font-weight: bold;
    }

    .continue-button {
        background-color: #3B82F6;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .continue-button:hover {
        background-color: #2563EB;
    }

    .seat.preview {
        background-color: #FFD700; /* Yellow color for the preview */
        opacity: 0.5;
    }
</style>

</head>
<body>

<div class="container">
    <h4><?= htmlspecialchars($hall['Name']); ?> - Seat Selection</h4>
    <p>Movie: <?= htmlspecialchars($movie_id); ?> | Time: <?= htmlspecialchars($time); ?></p>

<!-- Ticket Type Selection -->
<div class="ticket-selection">
    <h5>Select Ticket Type</h5>
    <div class="input-field">
        <select id="ticket-type">
            <?php foreach ($ticketPricesMap as $type => $price): ?>
                <option value="<?= htmlspecialchars($type); ?>" data-price="<?= htmlspecialchars($price); ?>">
                    <?= htmlspecialchars($type); ?> - DKK <?= number_format($price, 2); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>


    <!-- Seat Quantity Controls -->
    <div class="ticket-selection">
        <h5>Select Number of Seats</h5>
        <div class="ticket-controls">
            <button class="btn-small" id="decrease-seats">-</button>
            <span class="ticket-count" id="seat-count-display">1</span>
            <button class="btn-small" id="increase-seats">+</button>
        </div>
        <p>Max 5 seats can be selected per booking.</p>
    </div>

    <div class="screen">
        <strong>SCREEN</strong>
    </div>

    <!-- Seat Layout -->
    <?php
    $currentRow = 0;
    foreach ($seats as $seat) {
        if ($seat['Row'] != $currentRow) {
            if ($currentRow != 0) {
                echo "<br>"; 
            }
            $currentRow = $seat['Row'];
            echo "<span class='row-label'>" . str_pad($currentRow, 2, '0', STR_PAD_LEFT) . "</span>";
        }

        echo "<div class='seat' data-seat-id='" . htmlspecialchars($seat['Seat_ID']) . "' data-seat-number='" . htmlspecialchars($seat['SeatNumber']) . "' data-row='" . htmlspecialchars($seat['Row']) . "'>" . str_pad($seat['SeatNumber'], 2, '0', STR_PAD_LEFT) . "</div>";
    }
    ?>

    <div class="seat-info">
        <p><span class="seat"></span> Available</p>
        <p><span class="seat selected"></span> Selected</p>
    </div>
</div>

<div class="ticket-summary">
    <div class="ticket-details">
    <div class="ticket-icons-container" id="ticket-icons"></div>
        <div class="ticket-info">
            <p id="ticket-count">0 tickets</p>
            <p id="total-price">DKK 0</p>
        </div>
    </div>
    <button class="continue-button" id="continue-button">Continue</button>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>



<script>
    let maxSeats = 1;
    let selectedSeats = [];

    // Function to preview seats during hover
    function previewSeats(row, startSeat) {
        // Clear existing preview
        document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview'));

        // Preview the selected number of seats
        for (let i = 0; i < maxSeats; i++) {
            const seatPosition = `${row}-${startSeat + i}`;
            const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
            if (seatElement) {
                seatElement.classList.add('preview');
            }
        }
    }

    // Function to place the seats at the chosen position on click
    function placeSeats(row, startSeat) {
        // Clear current selection
        selectedSeats.forEach(pos => {
            const [r, s] = pos.split('-').map(Number);
            const seatElement = document.querySelector(`.seat[data-row='${r}'][data-seat-number='${s}']`);
            if (seatElement) seatElement.classList.remove('selected');
        });

        // Update selectedSeats with new positions
        selectedSeats = [];
        for (let i = 0; i < maxSeats; i++) {
            const seatPosition = `${row}-${startSeat + i}`;
            selectedSeats.push(seatPosition);
            const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
            if (seatElement) seatElement.classList.add('selected');
        }
    }

    // Event listener for seat hover and click
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('mouseenter', () => {
            const row = parseInt(seat.getAttribute('data-row'));
            const startSeat = parseInt(seat.getAttribute('data-seat-number'));
            previewSeats(row, startSeat); // Show preview on hover
        });

        seat.addEventListener('mouseleave', () => {
            document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview')); // Clear preview on mouse leave
        });

        seat.addEventListener('click', () => {
            const row = parseInt(seat.getAttribute('data-row'));
            const startSeat = parseInt(seat.getAttribute('data-seat-number'));
            placeSeats(row, startSeat); // Place seats on click
        });
    });

    // Update maxSeats and reset selection
    const seatCountDisplay = document.getElementById('seat-count-display');
    document.getElementById('increase-seats').addEventListener('click', () => {
        if (maxSeats < 5) {
            maxSeats++;
            seatCountDisplay.textContent = maxSeats;
            resetSeatSelection();
        } else {
            alert("Maximum of 5 seats can be selected.");
        }
    });

    document.getElementById('decrease-seats').addEventListener('click', () => {
        if (maxSeats > 1) {
            maxSeats--;
            seatCountDisplay.textContent = maxSeats;
            resetSeatSelection();
        } else {
            alert("You must select at least 1 seat.");
        }
    });

    function resetSeatSelection() {
        selectedSeats = [];
        document.querySelectorAll('.seat.selected, .seat.preview').forEach(seat => seat.classList.remove('selected', 'preview'));
        document.getElementById('ticket-count').textContent = 0;
    }

    const ticketPrice = 135; // Price per ticket

function updateTicketSummary() {
    const ticketCount = selectedSeats.length;
    const totalPrice = ticketCount * ticketPrice;
    const ticketIcons = document.getElementById("ticket-icons");
    const ticketCountText = document.getElementById("ticket-count");
    const totalPriceText = document.getElementById("total-price");

    // Update ticket count and total price display
    ticketCountText.textContent = `${ticketCount} ticket${ticketCount > 1 ? 's' : ''}`;
    totalPriceText.textContent = `DKK ${totalPrice}`;

    // Clear previous ticket icons
    ticketIcons.innerHTML = "";

    // Generate ticket icons for each selected seat
    selectedSeats.forEach(seat => {
        const [row, seatNumber] = seat.split('-');
        const ticketDiv = document.createElement("div");
        ticketDiv.classList.add("ticket-icon");
        ticketDiv.innerHTML = `<p>Row ${row.padStart(2, '0')} <br> Seat ${seatNumber.padStart(2, '0')}</p>`;
        ticketIcons.appendChild(ticketDiv);
    });
}

// Call updateTicketSummary after placing seats
function placeSeats(row, startSeat) {
    // Clear current selection
    selectedSeats.forEach(pos => {
        const [r, s] = pos.split('-').map(Number);
        const seatElement = document.querySelector(`.seat[data-row='${r}'][data-seat-number='${s}']`);
        if (seatElement) seatElement.classList.remove('selected');
    });

    // Update selectedSeats with new positions
    selectedSeats = [];
    for (let i = 0; i < maxSeats; i++) {
        const seatPosition = `${row}-${startSeat + i}`;
        selectedSeats.push(seatPosition);
        const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
        if (seatElement) seatElement.classList.add('selected');
    }

    // Update ticket summary with new selections
    updateTicketSummary();
}

document.getElementById('continue-button').addEventListener('click', () => {
        if (selectedSeats.length === 0) {
            alert("Please select at least one seat.");
            return;
        }

        // Save selected seats to sessionStorage for next page
        sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));

        // Redirect to overview page
        window.location.href = 'overview.php';
    });

</script>



</body>
</html>
