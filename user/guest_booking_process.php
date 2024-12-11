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
$userId = $_SESSION['user_id'] ?? null;
$guestUserId = $_SESSION['guest_user_id'] ?? null; // For guest users
$discountedPrice = $_SESSION['totalPrice'] ?? 0;

// Determine if it's a logged-in user or a guest user
if (!$userId && !$guestUserId) {
    die("No logged-in user or guest detected. Please log in or continue as a guest.");
}

// Database connection
$dbCon = dbCon($user, $pass);

try {
    // Check if selected seats are already booked
    $seatPlaceholders = [];
    foreach ($selectedSeats as $index => $seat) {
        $seatPlaceholders[] = ":seat" . $index;
    }
    $placeholders = implode(',', $seatPlaceholders);

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
            User_ID,
            GuestUser_ID,
            BookingDate,
            NumberOfTickets,
            PaymentStatus,
            TotalPrice
        ) VALUES (
            :movie_id,
            :user_id,
            :guest_user_id,
            CURDATE(),
            :number_of_tickets,
            'Completed',
            :total_price
        )
    ");
    $numberOfTickets = array_sum($selectedTickets);
    $stmt->bindParam(':movie_id', $booking['movie_id'], PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':guest_user_id', $guestUserId, PDO::PARAM_INT); // If it's a guest, this value will be used
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

        // Save Invoice_ID in session for further use (e.g., PDF generation)
        $_SESSION['invoice_id'] = $invoiceId;

        // Group ticket types by seat number to prevent duplication
        $seatTicketTypes = [];
        foreach ($selectedSeats as $index => $seat) {
            $seatTicketTypes[$seat][] = $selectedTickets[$index]; // Associate ticket types with each seat
        }

        // Insert tickets only once per seat for each ticket type
        foreach ($seatTicketTypes as $seat => $ticketTypes) {
            $seatParts = explode('-', $seat);
            $row = $seatParts[0];
            $seatNumber = $seatParts[1];

            // Fetch seat ID from the database
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
                // Now insert the ticket for each seat and its ticket types (Child, Standard, etc.)
                foreach ($ticketTypes as $ticketType) {
                    $ticketStmt = $dbCon->prepare("
                        INSERT INTO Ticket (Booking_ID, Screening_ID, Seat_ID, Price_ID)
                        VALUES (
                            :booking_id,
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
                    $ticketStmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT); // Associate the ticket with the Booking_ID
                    $ticketStmt->bindParam(':movie_id', $booking['movie_id'], PDO::PARAM_INT);
                    $ticketStmt->bindParam(':cinema_hall_id', $booking['cinema_hall_id'], PDO::PARAM_INT);
                    $ticketStmt->bindParam(':show_date', $booking['date'], PDO::PARAM_STR);
                    $ticketStmt->bindParam(':show_time', $booking['time'], PDO::PARAM_STR);
                    $ticketStmt->bindParam(':seat_id', $seatId, PDO::PARAM_INT);
                    $ticketStmt->bindParam(':ticket_type', $ticketType, PDO::PARAM_STR);
                    $ticketStmt->execute();
                }
            }
        }

        // After processing, clear the session and redirect
        unset($_SESSION['booking'], $_SESSION['selectedSeats'], $_SESSION['selectedTickets'], $_SESSION['totalPrice']);
        header("Location: /dwp/frontend/controllers/GuestCheckoutController.php");
        exit();
    } else {
        echo "<p>Failed to save booking.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
