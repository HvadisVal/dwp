<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');


// Ensure booking session exists
if (!isset($_SESSION['booking']) || empty($_SESSION['booking'])) {
    die("No booking information found. Please start a new booking.");
}

// Get booking session data
$booking = $_SESSION['booking'] ?? [];
$selectedSeats = array_unique($_SESSION['selectedSeats'] ?? []); // Remove duplicates
$selectedTickets = $_SESSION['selectedTickets'] ?? [];
$guestUserId = $_SESSION['guest_user_id'] ?? null;
$guestFirstName = $_SESSION['guest_firstname'] ?? '';
$guestLastName = $_SESSION['guest_lastname'] ?? '';
$guestEmail = $_SESSION['guest_email'] ?? '';
$discountedPrice = $_SESSION['totalPrice'] ?? 0;

// Database connection
$dbCon = dbCon($user, $pass);

try {
    // Check if selected seats are already booked
    $seatPlaceholders = [];
foreach ($selectedSeats as $index => $seat) {
    $seatPlaceholders[] = ":seat" . $index;
}
$placeholders = implode(',', $seatPlaceholders);

// Updated query
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
    AND CONCAT(Seat.Row, '-', Seat.SeatNumber) IN ($placeholders)
");
$bookedSeatsQuery->bindParam(':movie_id', $booking['movie_id'], PDO::PARAM_INT);
$bookedSeatsQuery->bindParam(':cinema_hall_id', $booking['cinema_hall_id'], PDO::PARAM_INT);
$bookedSeatsQuery->bindParam(':show_date', $booking['date'], PDO::PARAM_STR);
$bookedSeatsQuery->bindParam(':show_time', $booking['time'], PDO::PARAM_STR);

// Bind seat placeholders dynamically
foreach ($selectedSeats as $index => $seat) {
    $bookedSeatsQuery->bindValue(":seat" . $index, $seat, PDO::PARAM_STR);
}
$bookedSeatsQuery->execute();


    $bookedSeats = $bookedSeatsQuery->fetchAll(PDO::FETCH_ASSOC);

    // If booked seats are found, display error
    if ($bookedSeats) {
        $bookedSeatNumbers = array_unique(array_column($bookedSeats, 'SeatNumber')); // Extract unique seat numbers
        die("Error: The following seats are already booked: " . implode(', ', $bookedSeatNumbers));
    }

    // Insert booking details
    $stmt = $dbCon->prepare("
        INSERT INTO Booking (
            Movie_ID,
            GuestUser_ID,
            BookingDate,
            NumberOfTickets,
            PaymentStatus,
            TotalPrice
        ) VALUES (
            :movie_id,
            :guest_user_id,
            CURDATE(),
            :number_of_tickets,
            'Completed',
            :total_price
        )
    ");
    $numberOfTickets = array_sum($selectedTickets);
    $stmt->bindParam(':movie_id', $booking['movie_id'], PDO::PARAM_INT);
    $stmt->bindParam(':guest_user_id', $guestUserId, PDO::PARAM_INT);
    $stmt->bindParam(':number_of_tickets', $numberOfTickets, PDO::PARAM_INT);
    $stmt->bindParam(':total_price', $discountedPrice, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $bookingId = $dbCon->lastInsertId(); // Get the inserted Booking_ID

// Generate the invoice
$invoiceStmt = $dbCon->prepare("
    INSERT INTO Invoice (InvoiceDate, TotalAmount, InvoiceStatus)
    VALUES (CURDATE(), :total_amount, 'Unpaid')
");
$invoiceStmt->bindParam(':total_amount', $discountedPrice, PDO::PARAM_STR);
$invoiceStmt->execute();

$invoiceId = $dbCon->lastInsertId(); // Get the inserted Invoice_ID


// Update the Booking table with the Invoice_ID
$updateBookingStmt = $dbCon->prepare("
    UPDATE Booking
    SET Invoice_ID = :invoice_id
    WHERE Booking_ID = :booking_id
");
$updateBookingStmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
$updateBookingStmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
$updateBookingStmt->execute();

// Save Invoice_ID in session for further use
$_SESSION['invoice_id'] = $invoiceId;

        // Insert tickets
        foreach ($selectedSeats as $seat) {
            $seatParts = explode('-', $seat);
            $row = $seatParts[0];
            $seatNumber = $seatParts[1];

            $seatQuery = $dbCon->prepare("
                SELECT Seat_ID 
                FROM Seat 
                WHERE CinemaHall_ID = :cinema_hall_id AND Row = :row AND SeatNumber = :seat_number
            ");
            $seatQuery->bindParam(':cinema_hall_id', $booking['cinema_hall_id'], PDO::PARAM_INT);
            $seatQuery->bindParam(':row', $row, PDO::PARAM_INT);
            $seatQuery->bindParam(':seat_number', $seatNumber, PDO::PARAM_INT);
            $seatQuery->execute();
            $seatResult = $seatQuery->fetch(PDO::FETCH_ASSOC);

            $seatId = $seatResult['Seat_ID'] ?? null;

            if ($seatId) {
                $ticketStmt = $dbCon->prepare("
                    INSERT INTO Ticket (Screening_ID, Seat_ID, Price_ID)
                    VALUES (
                        (SELECT Screening_ID 
                         FROM Screening 
                         WHERE Movie_ID = :movie_id 
                         AND CinemaHall_ID = :cinema_hall_id 
                         AND ShowDate = :show_date 
                         AND ShowTime = :show_time),
                        :seat_id,
                        (SELECT Price_ID FROM TicketPrice WHERE Type = :ticket_type)
                    )
                ");
                $ticketStmt->bindParam(':movie_id', $booking['movie_id'], PDO::PARAM_INT);
                $ticketStmt->bindParam(':cinema_hall_id', $booking['cinema_hall_id'], PDO::PARAM_INT);
                $ticketStmt->bindParam(':show_date', $booking['date'], PDO::PARAM_STR);
                $ticketStmt->bindParam(':show_time', $booking['time'], PDO::PARAM_STR);
                $ticketStmt->bindParam(':seat_id', $seatId, PDO::PARAM_INT);

                foreach ($selectedTickets as $type => $quantity) {
                    $ticketStmt->bindParam(':ticket_type', $type, PDO::PARAM_STR);
                    $ticketStmt->execute();
                }
            }
        }

/*         echo "<p>Booking successfully saved with Booking ID: $bookingId.</p>";
 */    } else {
        echo "<p>Failed to save booking.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

// Fetch movie details for display
$movieQuery = $dbCon->prepare("SELECT Title, Duration, Rating FROM Movie WHERE Movie_ID = 1");
$movieQuery->execute();
$movie = $movieQuery->fetch(PDO::FETCH_ASSOC);
/* print_r($movie);
 */


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="/dwp/frontend/checkout.css">
</head>
<body>
    <div class="container">
        <h2>Thank you for your order!</h2>
        <p>Your booking is now complete.</p>

        <h3>Booking Details</h3>
        <p><strong>Movie:</strong> <?= htmlspecialchars($movie['Title']); ?></p>
        <p><strong>Duration:</strong> <?= htmlspecialchars($movie['Duration']); ?> minutes</p>
        <p><strong>Rating:</strong> <?= htmlspecialchars($movie['Rating']); ?>/10</p>
        <p><strong>Showtime:</strong> <?= htmlspecialchars($booking['time']); ?> on <?= htmlspecialchars($booking['date']); ?></p>
        <p><strong>Cinema Hall:</strong> Hall <?= htmlspecialchars($booking['cinema_hall_id']); ?></p>

        <h3>Tickets and Seats</h3>
        <ul>
            <?php foreach ($selectedTickets as $type => $quantity): ?>
                <li><?= htmlspecialchars($quantity); ?> x <?= htmlspecialchars($type); ?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Selected Seats:</strong> <?= htmlspecialchars(implode(", ", $selectedSeats)); ?></p>
        <p><strong>Total Price:</strong> DKK <?= number_format($discountedPrice, 2); ?></p>

        <h3>Guest Details</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($guestFirstName . ' ' . $guestLastName); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($guestEmail); ?></p>

        <a href="/dwp/frontend/payment/invoice.php?invoice_id=<?= htmlspecialchars($_SESSION['invoice_id']); ?>" class="btn">View Invoice</a>

    </div>

    
</body>
</html>
