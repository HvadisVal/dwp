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

// Fetch ticket prices from the TicketPrice table
$ticketPricesQuery = $dbCon->prepare("SELECT * FROM TicketPrice");
$ticketPricesQuery->execute();
$ticketPrices = $ticketPricesQuery->fetchAll(PDO::FETCH_ASSOC);
$ticketPricesMap = [];
foreach ($ticketPrices as $ticketPrice) {
    $ticketPricesMap[$ticketPrice['Type']] = $ticketPrice['Price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #111;
        color: white;
    }
    .seat-row {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
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
        transition: background-color 0.3s ease;
    }
    .seat:hover {
        background-color: #FFD700;
    }
    .seat.preview {
        background-color: #FFD700;
        opacity: 0.6;
    }
    .seat.selected {
        background-color: yellow;
    }
    .seat.sold {
        background-color: red;
        cursor: not-allowed;
    }
    .seat.disabled {
        pointer-events: none;
        background-color: #555;
    }
    .screen {
        margin-bottom: 20px;
        text-align: center;
    }
    .ticket-selection {
        margin-bottom: 20px;
    }
    .ticket-type-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .counter-controls {
        display: flex;
        align-items: center;
    }
    .counter-controls button {
        margin: 0 5px;
    }
    .ticket-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #1a1a1a;
        color: white;
        font-size: 16px;
/*         position: fixed;
 */        bottom: 0;
        width: 100%;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
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
</style>
</head>
<body>

<div class="container">
    <h4><?= htmlspecialchars($hall['Name']); ?> - Seat Selection</h4>
    <p>Movie: <?= htmlspecialchars($movie_id); ?> | Time: <?= htmlspecialchars($time); ?></p>

    <!-- Ticket Type Selection with Counters -->
    <div class="ticket-selection">
        <h5>Select Ticket Type and Quantity (Max 5 seats total)</h5>
        <?php foreach ($ticketPrices as $ticketPrice): ?>
            <div class="ticket-type-row">
                <h6><?= htmlspecialchars($ticketPrice['Type']); ?> - DKK <?= number_format($ticketPrice['Price'], 2); ?></h6>
                <div class="counter-controls">
                    <button class="btn-small decrease-seat" data-type="<?= $ticketPrice['Type']; ?>" data-price="<?= $ticketPrice['Price']; ?>">-</button>
                    <span id="count-<?= $ticketPrice['Type']; ?>">0</span>
                    <button class="btn-small increase-seat" data-type="<?= $ticketPrice['Type']; ?>" data-price="<?= $ticketPrice['Price']; ?>">+</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="screen">
        <strong>SCREEN</strong>
    </div>

    <!-- Seat Layout with initial "disabled" class -->
    <?php
    $currentRow = null;
    foreach ($seats as $seat) {
        if ($seat['Row'] !== $currentRow) {
            if ($currentRow !== null) {
                echo '</div>';
            }
            $currentRow = $seat['Row'];
            echo "<div class='seat-row'><span class='row-label'>Row {$currentRow}</span>";
        }
        echo "<div class='seat disabled' data-seat-id='" . htmlspecialchars($seat['Seat_ID']) . "' data-seat-number='" . htmlspecialchars($seat['SeatNumber']) . "' data-row='" . htmlspecialchars($seat['Row']) . "'>" . str_pad($seat['SeatNumber'], 2, '0', STR_PAD_LEFT) . "</div>";
    }
    echo '</div>';
    ?>

    <div class="ticket-summary">
        <div>
            <p id="ticket-count">0 tickets</p>
            <p id="total-price">DKK 0</p>
        </div>
        <button class="continue-button" id="continue-button">Continue</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    let selectedTickets = {};  // Store the selected count for each ticket type
    let maxSeats = 0;
    let selectedSeats = []; // Store selected seats
    const maxAllowedSeats = 5;

    // Disable seat selection until a ticket is chosen
    function toggleSeatSelection(enable) {
        document.querySelectorAll('.seat').forEach(seat => {
            if (enable) {
                seat.classList.remove('disabled');
            } else {
                seat.classList.add('disabled');
            }
        });
    }
    toggleSeatSelection(false); // Initially disable seats

    // Add event listeners to the increase and decrease seat buttons for each ticket type
    document.querySelectorAll('.increase-seat').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            const price = parseFloat(this.dataset.price);
            const currentCount = selectedTickets[type] || 0;
            const totalCount = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

            if (totalCount < maxAllowedSeats) {
                selectedTickets[type] = currentCount + 1;
                document.getElementById(`count-${type}`).textContent = selectedTickets[type];
                maxSeats = totalCount + 1; // Update maxSeats
                updateTicketSummary();

                // Enable seat selection when at least one ticket is selected
                toggleSeatSelection(true);
            } else {
                alert("You can select a maximum of 5 seats.");
            }
        });
    });

    document.querySelectorAll('.decrease-seat').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            const currentCount = selectedTickets[type] || 0;

            if (currentCount > 0) {
                selectedTickets[type] = currentCount - 1;
                document.getElementById(`count-${type}`).textContent = selectedTickets[type];
                maxSeats = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0); // Update maxSeats
                updateTicketSummary();

                // Disable seat selection if no tickets are selected
                if (maxSeats === 0) {
                    toggleSeatSelection(false);
                }
            }
        });
    });

    // Function to preview seats during hover based on maxSeats
    function previewSeats(row, startSeat) {
        document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview'));

        for (let i = 0; i < maxSeats; i++) {
            const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
            if (seatElement) {
                seatElement.classList.add('preview');
            }
        }
    }

    // Function to place seats on click
    function placeSeats(row, startSeat) {
        selectedSeats.forEach(pos => {
            const [r, s] = pos.split('-').map(Number);
            const seatElement = document.querySelector(`.seat[data-row='${r}'][data-seat-number='${s}']`);
            if (seatElement) seatElement.classList.remove('selected');
        });

        selectedSeats = [];
        for (let i = 0; i < maxSeats; i++) {
            const seatPosition = `${row}-${startSeat + i}`;
            selectedSeats.push(seatPosition);
            const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
            if (seatElement) seatElement.classList.add('selected');
        }
    }

    // Update ticket summary
    function updateTicketSummary() {
        const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);
        const totalPrice = Object.keys(selectedTickets).reduce((acc, type) => acc + (selectedTickets[type] * parseFloat(document.querySelector(`.increase-seat[data-type="${type}"]`).dataset.price)), 0);
        document.getElementById("ticket-count").textContent = `${totalTickets} ticket(s)`;
        document.getElementById("total-price").textContent = `DKK ${totalPrice.toFixed(2)}`;
    }

    // Event listeners for seat hover and click
    document.querySelectorAll('.seat').forEach(seat => {
        seat.addEventListener('mouseenter', () => {
            const row = parseInt(seat.getAttribute('data-row'));
            const startSeat = parseInt(seat.getAttribute('data-seat-number'));
            previewSeats(row, startSeat);
        });

        seat.addEventListener('mouseleave', () => {
            document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview'));
        });

        seat.addEventListener('click', () => {
            const row = parseInt(seat.getAttribute('data-row'));
            const startSeat = parseInt(seat.getAttribute('data-seat-number'));
            placeSeats(row, startSeat);
        });
    });

    document.getElementById('continue-button').addEventListener('click', () => {
    const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);
    if (totalTickets === 0 || selectedSeats.length === 0) {
        alert("Please select at least one seat and ticket type.");
        return;
    }

    // Save selected tickets and seats to session via AJAX
    fetch('save_selection.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ selectedTickets, selectedSeats })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to overview page if save was successful
            window.location.href = 'overview.php';
        } else {
            alert("Failed to save selection. Please try again.");
        }
    })
    .catch(error => console.error("Error:", error));
});

// After seats are selected, store row, seat number, and seat ID in sessionStorage
document.getElementById('continue-button').addEventListener('click', () => {
    const formattedSeats = selectedSeats.map(seatPos => {
        const [row, seatNumber] = seatPos.split('-');
        const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${seatNumber}']`);
        return {
            row: row,
            seatNumber: seatNumber,
            seatId: seatElement.dataset.seatId // get the Seat_ID
        };
    });

    sessionStorage.setItem('selectedSeats', JSON.stringify(formattedSeats));
    window.location.href = 'overview.php';
});



</script>
</body>
</html>
