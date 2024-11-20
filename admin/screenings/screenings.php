<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php"); 

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Add Screening
if (isset($_POST['add_screening'])) {
    $movieId = (int)$_POST['movie_id'];
    $cinemaHallId = (int)$_POST['cinemahall_id'];
    $showTime = $_POST['showtime']; // Expected in 'Y-m-d H:i:s' format

    $showDate = date('Y-m-d', strtotime($showTime));

    // Get movie duration from the database
    $sql = "SELECT Duration FROM Movie WHERE Movie_ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$movieId]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($movie) {
       // Retrieve and calculate the movie duration in seconds
$duration = $movie['Duration'];
$durationParts = explode(':', $duration);
$hours = isset($durationParts[0]) ? (int)$durationParts[0] : 0;
$minutes = isset($durationParts[1]) ? (int)$durationParts[1] : 0;
$seconds = isset($durationParts[2]) ? (int)$durationParts[2] : 0;
$durationInSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

// Calculate end time with 15-minute buffer
$showTimeTimestamp = strtotime($showTime);
$endTime = $showTimeTimestamp + $durationInSeconds;
$endTimePlus15 = $endTime + (15 * 60); // Add 15 minutes buffer

$endTimeFormatted = date('Y-m-d H:i:s', $endTime);
$endTimePlus15Formatted = date('Y-m-d H:i:s', $endTimePlus15);

// Check for existing screenings that overlap with the new screening time
$sql = "SELECT COUNT(*) FROM Screening s
        JOIN Movie m ON s.Movie_ID = m.Movie_ID
        WHERE s.CinemaHall_ID = ?
        AND (
            (s.ShowDate = ? AND s.ShowTime < ? AND DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND) > ?)
            OR (s.ShowDate = ? AND s.ShowTime >= ? AND s.ShowTime < ?)
            OR (s.ShowDate = ? AND DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND) > ?)
        )";

$stmt = $connection->prepare($sql);
$stmt->execute([
    $cinemaHallId,              // Cinema Hall ID
    $showDate,                  // Show Date, same date condition
    $endTimePlus15Formatted,    // New end time with buffer
    $showTime,                  // New start time
    $showDate,                  // Start time condition date
    $showTime,                  // Second condition start time
    $endTimeFormatted,          // Second condition end time
    $showDate,                  // Full day check if it spans into the next day
    $showTime                   // Base show time
]);

$existingCount = $stmt->fetchColumn();

if ($existingCount > 0) {
    echo "Error: There is already a screening scheduled at this time.";
} else {
            $sql = "INSERT INTO Screening (ShowDate, ShowTime, CinemaHall_ID, Movie_ID) VALUES (?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            if ($stmt->execute([$showDate, $showTime, $cinemaHallId, $movieId])) {
                $_SESSION['message'] = "Screening added successfully!";
                header("Location: /dwp/admin/manage-screenings");
                exit();
            } else {
                echo "Error adding screening.";
            }
        }
    } else {
        echo "Error: Movie not found.";
    }
}

if (isset($_POST['edit_screening'])) {
    $screeningId = (int)$_POST['screening_id'];
    $movieId = (int)$_POST['movie_id'];
    $cinemaHallId = (int)$_POST['cinemahall_id'];
    $showTime = $_POST['showtime']; // 'Y-m-d H:i:s' format

    $showDate = date('Y-m-d', strtotime($showTime));

    // Get movie duration from the database
    $sql = "SELECT Duration FROM Movie WHERE Movie_ID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$movieId]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($movie) {
        // Retrieve and calculate the movie duration in seconds
        $duration = $movie['Duration'];
        $durationParts = explode(':', $duration);
        $hours = isset($durationParts[0]) ? (int)$durationParts[0] : 0;
        $minutes = isset($durationParts[1]) ? (int)$durationParts[1] : 0;
        $seconds = isset($durationParts[2]) ? (int)$durationParts[2] : 0;
        $durationInSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

        // Calculate end time with 15-minute buffer
        $showTimeTimestamp = strtotime($showTime);
        $endTime = $showTimeTimestamp + $durationInSeconds;
        $endTimePlus15 = $endTime + (15 * 60); // Add 15 minutes buffer

        $endTimeFormatted = date('Y-m-d H:i:s', $endTime);
        $endTimePlus15Formatted = date('Y-m-d H:i:s', $endTimePlus15);

        // Check for existing screenings that overlap with the new screening time
        $sql = "SELECT COUNT(*) FROM Screening s
                JOIN Movie m ON s.Movie_ID = m.Movie_ID
                WHERE s.CinemaHall_ID = ?
                AND (
                    (s.ShowDate = ? AND s.ShowTime < ? AND DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND) > ?)
                    OR (s.ShowDate = ? AND s.ShowTime >= ? AND s.ShowTime < ?)
                    OR (s.ShowDate = ? AND DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND) > ?)
                )";

        $stmt = $connection->prepare($sql);
        $stmt->execute([
            $cinemaHallId,              // Cinema Hall ID
            $showDate,                  // Show Date, same date condition
            $endTimePlus15Formatted,    // New end time with buffer
            $showTime,                  // New start time
            $showDate,                  // Start time condition date
            $showTime,                  // Second condition start time
            $endTimeFormatted,          // Second condition end time
            $showDate,                  // Full day check if it spans into the next day
            $showTime                   // Base show time
        ]);

        $existingCount = $stmt->fetchColumn();

        if ($existingCount > 0) {
            echo "Error: There is already a screening scheduled at this time.";
        } else {
            // Update screening in the database
            $sql = "UPDATE Screening SET ShowDate = ?, ShowTime = ?, CinemaHall_ID = ?, Movie_ID = ? WHERE Screening_ID = ?";
            $stmt = $connection->prepare($sql);

            if ($stmt->execute([$showDate, $showTime, $cinemaHallId, $movieId, $screeningId])) {
                $_SESSION['message'] = "Screening updated successfully!";
                header("Location: /dwp/admin/manage-screenings");
                exit();
            } else {
                echo "Error updating screening.";
            }
        }
    } else {
        echo "Error: Movie not found.";
    }
}

    if (isset($_POST['delete_screening'])) {
        // Handle deleting a screening
        $screeningId = (int)$_POST['screening_id'];

        // Delete the screening
        $sql = "DELETE FROM Screening WHERE Screening_ID = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt->execute([$screeningId])) {
            $_SESSION['message'] = "Screening deleted successfully!";
        } else {
            echo "Error deleting screening.";
        }

        header("Location: /dwp/admin/manage-screenings");
        exit();
    }
}

// Fetch existing screenings
$sql = "SELECT Screening_ID, ShowDate, ShowTime, CinemaHall_ID, Movie_ID 
        FROM Screening 
        ORDER BY ShowDate ASC, ShowTime ASC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$screenings = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Fetch cinema halls
$sql = "SELECT CinemaHall_ID, Name FROM CinemaHall";
$stmt = $connection->prepare($sql);
$stmt->execute();
$cinemaHalls = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch movies
$sql = "SELECT Movie_ID, Title FROM Movie";
$stmt = $connection->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); 
}
include('screenings_content.php');