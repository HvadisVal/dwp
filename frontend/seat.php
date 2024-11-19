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
        background-color: grey;
        opacity: 0.6;
    }
    .seat.selected {
        background-color: grey;
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
        font-weight: bold;
        font-size: 16px;
        bottom: 0;
        width: 100%;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
    }
    .continue-button {
        background: linear-gradient(to right, #243642, #1a252d);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: transform 0.2s;
    }
    .continue-button:hover {
        transform: translateY(-2px);
    }
    .seat-selection-container {
        display: flex;
        gap: 20px;
        width: 100%;
    }

    /* Ticket Selection Section */
    .ticket-selection {
        width: 30%; /* 1/3 of the screen */
        padding: 15px;
        background-color: #222;
        border-radius: 8px;
    }
    .ticket-selection h5 {
        font-size: 1.3rem;
        margin-bottom: 10px;
    }
    .ticket-type-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .ticket-type-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px;
        background-color: #333;
        border-radius: 8px;
    }
    .ticket-info {
        display: flex;
        flex-direction: column;
    }
    .ticket-type {
        font-size: 1rem;
        
        margin: 0;
    }
    .ticket-price {
        color: white;
        font-size: 0.9rem;
        font-weight: bold;
        margin: 0;
    }
    .counter-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .counter-controls button {
        background-color: #444;
        color: white;
        padding: 5px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }
    .counter-controls span {
        font-size: 1rem;
        color: white;
        width: 20px;
        text-align: center;
    }

    .btn-small {
        background-color: #444;
        color: white;
        padding: 5px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    .btn-small:hover {
        background-color: white;
        color:black;
    }

    /* Seat Layout Section */
    .seat-layout {
        width: 70%; /* 2/3 of the screen */
        background-color: #111;
        padding: 15px;
        border-radius: 8px;
    }
    .screen-label {
        text-align: center;
        margin-bottom: 20px;
        padding: 10px;
        font-weight: bold;
       
        font-size: 1.2rem;
        background-color: #444;
        border-radius: 5px;
    }
    .seat-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .row-label {
        margin-right: 10px;
        font-weight: bold;
      
        min-width: 40px; /* Space for row number */
        text-align: right;
    }
    .seat {
        width: 30px;
        height: 30px;
        margin: 5px;
        background-color: #4CAF50;
        border-radius: 5px;
        text-align: center;
        line-height: 30px;
        font-size: 0.9rem;
        cursor: pointer;
    }
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <h4><?= htmlspecialchars($hall['Name']); ?> - Seat Selection</h4>
    <p>Movie: <?= htmlspecialchars($movie['Title']); ?> | Time: <?= htmlspecialchars($time); ?></p>

    <!-- Instructional Messages -->
    <p id="selection-message" style="font-size: 18px; color: white; text-decoration: underline; ">Please select the ticket quantity and type.</p>

    <div class="seat-selection-container">
    <!-- Left side: Ticket Type Selection -->
    <div class="ticket-selection">
        <h5>Select Ticket Type and Quantity <small>(Max 5 seats total)</small></h5>
        <div class="ticket-type-container">
            <?php foreach ($ticketPrices as $ticketPrice): ?>
                <div class="ticket-type-row">
                    <div class="ticket-info">
                        <h6 class="ticket-type"><?= htmlspecialchars($ticketPrice['Type']); ?></h6>
                        <p class="ticket-price">DKK <?= number_format($ticketPrice['Price'], 2); ?></p>
                    </div>
                    <div class="counter-controls">
                        <button class="btn-small decrease-seat btn-flat" data-type="<?= $ticketPrice['Type']; ?>" data-price="<?= $ticketPrice['Price']; ?>">-</button>
                        <span id="count-<?= $ticketPrice['Type']; ?>">0</span>
                        <button class="btn-small increase-seat btn-flat" data-type="<?= $ticketPrice['Type']; ?>" data-price="<?= $ticketPrice['Price']; ?>">+</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Right side: Seat Layout with Screen and Row Labels -->
    <div class="seat-layout">
        <div class="screen-label">SCREEN</div>
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
    </div>
</div>

   <!-- Ticket Summary and Continue Button -->
   <div class="ticket-summary">
        <p id="ticket-count">0 tickets</p>
        <p id="total-price">DKK 0</p>
        <button class="continue-button" id="continue-button" style="display: none;">Continue</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    let selectedTickets = {};
    let selectedSeats = [];
    const maxSeats = 5;
    const selectionMessage = document.getElementById('selection-message');
    const continueButton = document.getElementById('continue-button');

    function updateTicketSummary() {
        const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);
        document.getElementById("ticket-count").textContent = `${totalTickets} ticket(s)`;
        document.getElementById("total-price").textContent = `DKK ${Object.keys(selectedTickets).reduce((acc, type) => acc + (selectedTickets[type] * parseFloat(document.querySelector(`.increase-seat[data-type="${type}"]`).dataset.price)), 0).toFixed(2)}`;
        selectionMessage.textContent = totalTickets > 0 ? "Please select your seats." : "Please select the ticket quantity and type.";
        continueButton.style.display = totalTickets > 0 && selectedSeats.length > 0 ? "block" : "none";
    }

    document.querySelectorAll('.increase-seat').forEach(button => {
        button.addEventListener('click', () => {
            const type = button.dataset.type;
            const currentCount = selectedTickets[type] || 0;
            const totalCount = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

            if (totalCount < maxSeats) {
                selectedTickets[type] = currentCount + 1;
                document.getElementById(`count-${type}`).textContent = selectedTickets[type];
                updateTicketSummary();
                document.querySelectorAll('.seat').forEach(seat => seat.classList.remove('disabled'));
            } else {
                alert("You can select a maximum of 5 seats.");
            }
        });
    });

    document.querySelectorAll('.decrease-seat').forEach(button => {
        button.addEventListener('click', () => {
            const type = button.dataset.type;
            const currentCount = selectedTickets[type] || 0;

            if (currentCount > 0) {
                selectedTickets[type] = currentCount - 1;
                document.getElementById(`count-${type}`).textContent = selectedTickets[type];
                updateTicketSummary();
                if (Object.values(selectedTickets).reduce((acc, count) => acc + count, 0) === 0) {
                    document.querySelectorAll('.seat').forEach(seat => seat.classList.add('disabled'));
                }
            }
        });
    });

    // Function to preview seats in groups based on selected tickets
    function previewSeats(row, startSeat) {
        const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);
        document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview'));

        for (let i = 0; i < totalTickets; i++) {
            const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
            if (seatElement) {
                seatElement.classList.add('preview');
            }
        }
    }

    // Function to select seats in groups based on selected tickets
    function selectSeats(row, startSeat) {
        const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

        selectedSeats.forEach(pos => {
            const [r, s] = pos.split('-').map(Number);
            const seatElement = document.querySelector(`.seat[data-row='${r}'][data-seat-number='${s}']`);
            if (seatElement) seatElement.classList.remove('selected');
        });

        selectedSeats = [];
        for (let i = 0; i < totalTickets; i++) {
            const seatPosition = `${row}-${startSeat + i}`;
            selectedSeats.push(seatPosition);
            const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
            if (seatElement) seatElement.classList.add('selected');
        }
        updateTicketSummary();
    }

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
            selectSeats(row, startSeat);
        });
    });


  // Continue Button: Separate Logic for Final Selection Check and AJAX Call
document.getElementById('continue-button').addEventListener('click', () => {
    const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

    if (totalTickets === 0) {
        alert("Please select at least one ticket.");
        return;
    } else if (selectedSeats.length === 0) {
        alert("Please select at least one seat.");
        return;
    } else {
        // AJAX call to save the selected tickets and seats
        fetch('/dwp/save-selection', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ selectedTickets, selectedSeats })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to overview if saving was successful
                window.location.href = '/dwp/overview';
            } else {
                // Show error if something went wrong
                alert(data.message || "Failed to save selection. Please try again.");
            }
        })
        .catch(error => console.error("Error:", error));
    }
});
</script>
</body>
</html>