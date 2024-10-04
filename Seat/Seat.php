<?php
// reserve.php

// Database connection
$host = 'localhost';
$dbname = 'dwp';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Get the selected seats from the form
$selected_seats = explode(',', $_POST['selected_seats']);
$screening_id = 1; // Example screening ID, should come from the user input or session

if (count($selected_seats) > 0) {
    foreach ($selected_seats as $seat_id) {
        // Check if the seat is already booked
        $query = "SELECT Status FROM Seat WHERE SeatID = :seat_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':seat_id', $seat_id);
        $stmt->execute();
        $seat = $stmt->fetch();

        if ($seat['Status'] == 'Available') {
            // Book the seat by updating its status
            $query = "UPDATE Seat SET Status = 'Booked' WHERE SeatID = :seat_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':seat_id', $seat_id);
            $stmt->execute();

            // Insert into the Ticket table
            $query = "INSERT INTO Ticket (TotalPrice, Type, ScreeningID, SeatID) 
                      VALUES (10.00, 'Standard', :screening_id, :seat_id)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':screening_id', $screening_id);
            $stmt->bindParam(':seat_id', $seat_id);
            $stmt->execute();
        }
    }
    echo "Seats reserved successfully!";
} else {
    echo "No seats selected.";
}
?>
