<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

if (!isset($_SESSION['booking']) || empty($_SESSION['booking'])) {
    die("No booking information found. Please start a new booking.");
}

$booking = $_SESSION['booking'] ?? [];
$selectedSeats = array_unique($_SESSION['selectedSeats'] ?? []); 
$selectedTickets = $_SESSION['selectedTickets'] ?? [];
$userId = $_SESSION['user_id'] ?? null;
$guestUserId = $_SESSION['guest_user_id'] ?? null; 
$totalPrice = $_SESSION['totalPrice'] ?? 0; 
$couponCode = $_SESSION['couponCode'] ?? null;

if (!$userId && !$guestUserId) {
    die("No logged-in user or guest detected. Please log in or continue as a guest.");
}

$dbCon = dbCon($user, $pass);

try {
    $couponId = null; 
    $discountedPrice = $totalPrice; 

    if (!empty($couponCode)) {
        $couponStmt = $dbCon->prepare("SELECT Coupon_ID, DiscountAmount FROM Coupon WHERE CouponCode = :coupon_code");
        $couponStmt->bindParam(':coupon_code', $couponCode, PDO::PARAM_STR);
        $couponStmt->execute();
        $couponResult = $couponStmt->fetch(PDO::FETCH_ASSOC);

        if ($couponResult) {
            $couponId = $couponResult['Coupon_ID']; 
            $discountAmount = $couponResult['DiscountAmount'];
            $discountedPrice = max(0, $totalPrice - $discountAmount); 
        }
    }

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

    if ($bookedSeats) {
        $bookedSeatNumbers = array_unique(array_column($bookedSeats, 'SeatNumber')); 
        die("Error: The following seats are already booked: " . implode(', ', $bookedSeatNumbers));
    }

    $stmt = $dbCon->prepare("
    INSERT INTO Booking (
        Movie_ID,
        User_ID,
        GuestUser_ID,
        BookingDate,
        NumberOfTickets,
        PaymentStatus,
        TotalPrice,
        Coupon_ID
    ) VALUES (
        :movie_id,
        :user_id,
        :guest_user_id,
        CURDATE(),
        :number_of_tickets,
        'Completed',
        :total_price,
        :coupon_id
    )
");
$numberOfTickets = array_sum($selectedTickets);
$stmt->bindParam(':movie_id', $booking['movie_id'], PDO::PARAM_INT);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->bindParam(':guest_user_id', $guestUserId, PDO::PARAM_INT);
$stmt->bindParam(':number_of_tickets', $numberOfTickets, PDO::PARAM_INT);
$stmt->bindParam(':total_price', $discountedPrice, PDO::PARAM_STR);
$stmt->bindParam(':coupon_id', $couponId, PDO::PARAM_INT | PDO::PARAM_NULL); 

if ($stmt->execute()) {
    $bookingId = $dbCon->lastInsertId(); 

        $invoiceStmt = $dbCon->prepare("
        INSERT INTO Invoice (InvoiceDate, TotalAmount, InvoiceStatus)
        VALUES (CURDATE(), :total_amount, 'Unpaid')
        ");
        $invoiceStmt->bindParam(':total_amount', $discountedPrice, PDO::PARAM_STR);
        $invoiceStmt->execute();

        $invoiceId = $dbCon->lastInsertId(); 

        $updateBookingStmt = $dbCon->prepare("
            UPDATE Booking
            SET Invoice_ID = :invoice_id
            WHERE Booking_ID = :booking_id
        ");
        $updateBookingStmt->bindParam(':invoice_id', $invoiceId, PDO::PARAM_INT);
        $updateBookingStmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
        $updateBookingStmt->execute();

        $_SESSION['invoice_id'] = $invoiceId;

        $seatTicketTypes = [];
        foreach ($selectedSeats as $index => $seat) {
            $seatTicketTypes[$seat][] = $selectedTickets[$index]; 
        }

        foreach ($seatTicketTypes as $seat => $ticketTypes) {
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
                    $ticketStmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT); 
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

        unset(
            $_SESSION['booking'],
            $_SESSION['selectedSeats'],
            $_SESSION['selectedTickets'],
            $_SESSION['totalPrice'],
            $_SESSION['couponCode'] 
        );

        if ($userId) {
            header("Location: /dwp/user/profiles?success=1");
            exit();
        } else {
            header("Location: /dwp/frontend/controllers/GuestCheckoutController.php");
            exit();
        }
    } else {
        echo "<p>Failed to save booking.</p>";
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}