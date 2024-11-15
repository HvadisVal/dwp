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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Screenings</title>
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h1, h2 {
            color: black;
            text-align: center;
            margin: 25px 0;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 24px;
        }

        .screening-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        #screeningContainer {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            padding: 0 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-top: 16px;
            display: block;
            color: #666;
        }

        input[type="datetime-local"], select {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            color: #555;
            box-sizing: border-box;
            margin-top: 8px;
        }

        /* Button Styling */
        .add-button, .edit-button, .delete-button {
            background: black;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
        }

        .add-button {
            background-color: black;
        }

        .add-button:hover {
            background: #1a252d; 
            transition: 0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        .edit-button:hover {
            background: #1a252d; 
            transition: 0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
            transition: 0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            #screeningContainer {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            h1, h2 {
                font-size: 1.5em;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            #screeningContainer {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
        }
    </style>
</head>
<body>

<h1>Manage Screenings</h1>

<!-- Add Screening Section -->
<h2>Add New Screening</h2>
<form method="POST" class="screening-card">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label for="cinemahall_id">Cinema Hall:</label>
    <select name="cinemahall_id" required>
        <option value="">Select Cinema Hall</option>
        <?php foreach ($cinemaHalls as $hall): ?>
            <option value="<?php echo $hall['CinemaHall_ID']; ?>"><?php echo htmlspecialchars($hall['Name']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="movie_id">Movie:</label>
    <select name="movie_id" required>
        <option value="">Select Movie</option>
        <?php foreach ($movies as $movie): ?>
            <option value="<?php echo $movie['Movie_ID']; ?>"><?php echo htmlspecialchars($movie['Title']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="showtime">Show Time:</label>
    <input type="datetime-local" name="showtime" required>

    <button type="submit" name="add_screening" class="add-button">Add Screening</button>
</form>

<!-- Existing Screenings Section -->
<h2>Existing Screenings</h2>
<div id="screeningContainer">
    <?php foreach ($screenings as $screening): ?>
        <div class="screening-card">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="screening_id" value="<?php echo $screening['Screening_ID']; ?>">

                <label for="cinemahall_id">Cinema Hall:</label>
                <select name="cinemahall_id" required>
                    <?php foreach ($cinemaHalls as $hall): ?>
                        <option value="<?php echo $hall['CinemaHall_ID']; ?>" <?php echo $hall['CinemaHall_ID'] == $screening['CinemaHall_ID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($hall['Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="movie_id">Movie:</label>
                <select name="movie_id" required>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo $movie['Movie_ID']; ?>" <?php echo $movie['Movie_ID'] == $screening['Movie_ID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($movie['Title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="showtime">Show Time:</label>
                <input type="datetime-local" name="showtime" value="<?php echo date('Y-m-d\TH:i', strtotime($screening['ShowDate'] . ' ' . $screening['ShowTime'])); ?>" required>

                <button type="submit" name="edit_screening" class="edit-button">Edit Screening</button>
                <button type="submit" name="delete_screening" class="delete-button">Delete Screening</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>