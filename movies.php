<?php
// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Fetch all movies from the database
$moviesQuery = $dbCon->prepare("SELECT * FROM Movie");
$moviesQuery->execute();
$movies = $moviesQuery->fetchAll(PDO::FETCH_ASSOC);

// Mock data for showtimes and availability for demonstration
$showtimes = [
    "Tuesday" => ["11:30 AM", "1:30 PM", "3:30 PM"],
    "Wednesday" => ["12:30 PM", "4:00 PM"],
    "Thursday" => ["11:00 AM", "2:00 PM", "5:00 PM"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies Schedule</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: white;
        }
        .movie-container {
            margin-top: 30px;
            display: flex;
            padding: 20px;
        }
        .movie-info {
            width: 30%;
            padding-right: 30px;
        }
        .schedule {
            width: 70%;
        }
        .showtime-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .showtime {
            background-color: green;
            padding: 15px 0; /* Adjust padding for uniformity */
            margin: 10px 0;
            border-radius: 8px;
            text-align: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
            display: block; /* Ensure each time slot is block-level */
        }
        .showtime:hover {
            transform: scale(1.05); /* Slight hover effect */
        }
        .legend {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .legend span {
            padding: 10px;
            border-radius: 5px;
        }
        .legend .available {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <?php foreach ($movies as $movie): ?>
    <div class="movie-container">
        <!-- Movie Information -->
        <div class="movie-info">
            <img src="path-to-movie-poster.jpg" alt="<?= $movie['Title']; ?>" class="responsive-img">
            <h4><?= $movie['Title']; ?></h4>
            <p><strong>Duration:</strong> <?= $movie['Duration']; ?></p>
            <p><strong>Rating:</strong> <?= $movie['Rating']; ?> / 10</p>
        </div>

        <!-- Movie Showtimes -->
        <div class="schedule">
            <h5>Showtimes</h5>
            <div class="showtime-grid">
                <?php foreach ($showtimes as $day => $times): ?>
                    <div>
                        <h6><?= $day; ?></h6>
                        <?php foreach ($times as $time): ?>
                            <a href="../Seat.php?movie_id=<?= $movie['Movie_ID']; ?>&time=<?= urlencode($time); ?>&day=<?= urlencode($day); ?>" class="showtime">
                                <?= $time; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Legend -->
            <div class="legend">
                <span class="available">Available seats 20-100%</span>
            </div>
        </div>
    </div>
    <hr>
    <?php endforeach; ?>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
