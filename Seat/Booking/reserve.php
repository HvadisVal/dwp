<?php
// reserve.php

// Database connection settings
$host = 'localhost';
$dbname = 'dwp';
$username = 'root';
$password = '';

try {
    // Establish the connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the selected seats from the form submission
$selected_seats = explode(',', $_POST['selected_seats']);
$screening_id = 1;  // Example screening ID; replace with dynamic input if needed
$total_price = 0;   // Variable to calculate the total price of the reservation

if (count($selected_seats) > 0) {
    // Begin transaction to ensure consistency
    $conn->beginTransaction();

    try {
        foreach ($selected_seats as $seat_id) {
            // Check if the seat is already booked
            $query = "SELECT Status FROM Seat WHERE SeatID = :seat_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':seat_id', $seat_id);
            $stmt->execute();
            $seat = $stmt->fetch();

            // If the seat is available, proceed to book it
            if ($seat && $seat['Status'] == 'Available') {
                // Mark the seat as booked
                $update_query = "UPDATE Seat SET Status = 'Booked' WHERE SeatID = :seat_id";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bindParam(':seat_id', $seat_id);
                $update_stmt->execute();

                // Insert a new ticket for the booked seat
                $ticket_price = 10.00; // Example ticket price; modify as needed
                $total_price += $ticket_price;

                $insert_ticket_query = "INSERT INTO Ticket (TotalPrice, Type, ScreeningID, SeatID) 
                                        VALUES (:total_price, 'Standard', :screening_id, :seat_id)";
                $ticket_stmt = $conn->prepare($insert_ticket_query);
                $ticket_stmt->bindParam(':total_price', $ticket_price);
                $ticket_stmt->bindParam(':screening_id', $screening_id);
                $ticket_stmt->bindParam(':seat_id', $seat_id);
                $ticket_stmt->execute();
            } else {
                // If seat is already booked, rollback and throw an error
                throw new Exception("Seat with ID $seat_id is already booked.");
            }
        }

        // Commit the transaction
        $conn->commit();

        // Display success message
        echo "Seats reserved successfully! Total Price: $" . number_format($total_price, 2);

    } catch (Exception $e) {
        // If any error occurs, rollback the transaction
        $conn->rollBack();
        echo "Failed to reserve seats: " . $e->getMessage();
    }
} else {
    echo "No seats were selected.";
}
?>
s