<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seats</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/seat.css">
    </head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
$navbar = new NavbarController();
$navbar->handleRequest();
 ?>

<div class="container">
    <h4><?= htmlspecialchars_decode($hall['Name']); ?> - Seat Selection</h4>
    <p>Movie: <?= htmlspecialchars_decode($movie['Title']); ?> | Time: <?= htmlspecialchars_decode($time ?? 'N/A'); ?></p>
    <p id="selection-message" style="font-size: 18px; color: white; text-decoration: underline; ">Please select the ticket quantity and type.</p>

    <div class="seat-selection-container">
    <div class="ticket-selection">
        <h5>Select Ticket Type and Quantity <small>(Max 5 seats total)</small></h5>
        <div class="ticket-type-container">
            <?php foreach ($ticketPrices as $ticketPrice): ?>
                <div class="ticket-type-row">
                    <div class="ticket-info">
                        <h6 class="ticket-type"><?= htmlspecialchars_decode($ticketPrice['Type']); ?></h6>
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

        $seatId = $seat['Row'] . '-' . $seat['SeatNumber'];
        $isBooked = in_array($seatId, $bookedSeatsArray);

        $seatClass = $isBooked ? 'seat booked' : 'seat disabled';
        echo "<div class='{$seatClass}' data-seat-id='" . htmlspecialchars($seat['Seat_ID']) . "' data-seat-number='" . htmlspecialchars($seat['SeatNumber']) . "' data-row='" . htmlspecialchars($seat['Row']) . "'>" . str_pad($seat['SeatNumber'], 2, '0', STR_PAD_LEFT) . "</div>";
    }
    echo '</div>';
    ?>
</div>

</div>

   
</div>
<div class="ticket-summary">
        <p id="ticket-count">0 tickets</p>
        <p id="total-price">DKK 0</p>
        <button class="continue-button" id="continue-button" style="display: none;">Continue</button>
        
    </div>
<script src="/dwp/frontend/assets/js/seat.js"></script>


</body>
</html>