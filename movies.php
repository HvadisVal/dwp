<?php
// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Fetch all movies and their showtimes from the database
$moviesQuery = $dbCon->prepare("
SELECT m.*, s.CinemaHall_ID, s.ShowTime, s.ShowDate, c.Name as CinemaHall_Name, v.Format as Version
FROM Movie m
JOIN Screening s ON m.Movie_ID = s.Movie_ID
JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
LEFT JOIN Version v ON m.Version_ID = v.Version_ID
ORDER BY m.Movie_ID, s.ShowDate, s.ShowTime
");

$moviesQuery->execute();
$moviesData = $moviesQuery->fetchAll(PDO::FETCH_ASSOC);

// Organize the data by movie and date
$moviesById = [];
foreach ($moviesData as $data) {
    $movieId = $data['Movie_ID'];
    $date = $data['ShowDate'];
    
    if (!isset($moviesById[$movieId])) {
        $moviesById[$movieId] = [
            'details' => [
                'Title' => $data['Title'],
                'Duration' => $data['Duration'],
                'Rating' => $data['Rating'],
                'Description' => $data['Description'],
                'PosterPath' => "path-to-movie-poster.jpg", // Adjust the poster path here if dynamic
            ],
            'showtimes' => []
        ];
    }
    
    if (!isset($moviesById[$movieId]['showtimes'][$date])) {
        $moviesById[$movieId]['showtimes'][$date] = [];
    }

    $moviesById[$movieId]['showtimes'][$date][] = $data;
}

// Set the range of days (e.g., 7 days from today)
$daysToShow = 7;
$startDate = new DateTime();
$allDates = [];

for ($i = 0; $i < $daysToShow; $i++) {
    $allDates[] = $startDate->format('Y-m-d');
    $startDate->modify('+1 day');
}
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
            border-bottom: 1px solid #444;
        }
        .movie-info {
            width: 25%;
            padding-right: 20px;
        }
        .movie-details {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .poster {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .schedule {
            width: 75%;
            display: flex;
        }
        .date-column {
            flex: 1;
            padding: 0 10px;
        }
        .date-header {
            width: 120px; /* Adjust based on desired width */
    white-space: nowrap;
    text-align: center;
    padding: 10px;
    font-weight: bold;
    color: #ccc;
        }
        .showtime-card {
            background-color: green;
    padding: 10px;
    margin: 5px 0;
    border-radius: 8px;
    text-align: center;
    color: white;
    font-weight: bold;
    transition: transform 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-width: 100px; /* Set a minimum width to prevent narrow display */
        }
        .showtime-card:hover {
            transform: scale(1.05);
        }
        .showtime-card h6 {
            margin: 5px 0;
    font-size: 1em;
    font-weight: normal;
        }
        .showtime-card .version {
            font-size: 0.85em;
    color: #ddd;
    margin-top: 5px;
        }
        .no-showtimes {
            color: #888;
            font-size: 1em;
            font-style: italic;
            text-align: center;
            padding: 10px;
        }
    </style>
    </style>
</head>
<body>

<div class="container">
    <?php foreach ($moviesById as $movieId => $movieData): ?>
        <div class="movie-container">
            <!-- Movie Information -->
            <div class="movie-info">
                <img src="<?= htmlspecialchars($movieData['details']['PosterPath']); ?>" alt="<?= htmlspecialchars($movieData['details']['Title']); ?>" class="poster">
                <div class="movie-details">
                    <h4><?= htmlspecialchars($movieData['details']['Title']); ?></h4>
                    <p>Duration: <?= htmlspecialchars($movieData['details']['Duration']); ?></p>
                    <p>Age Limit: Allowed for children over <?= htmlspecialchars($movieData['details']['Rating']); ?> years</p>
                </div>
            </div>

             <!-- Movie Showtimes by Date (Vertically) -->
             <div class="schedule">
                <?php foreach ($allDates as $date): ?>
                    <div class="date-column">
                        <div class="date-header">
                            <?= date("D, d/m", strtotime($date)); ?>
                        </div>
                        <?php if (isset($movieData['showtimes'][$date])): ?>
                            <?php foreach ($movieData['showtimes'][$date] as $showtime): ?>
                                <a href="seat.php?movie_id=<?= htmlspecialchars($showtime['Movie_ID']); ?>&cinema_hall_id=<?= htmlspecialchars($showtime['CinemaHall_ID']); ?>&time=<?= urlencode($showtime['ShowTime']); ?>&date=<?= urlencode($showtime['ShowDate']); ?>" class="showtime-card">
                                    <h6><?= htmlspecialchars($showtime['CinemaHall_Name']); ?></h6>
                                    <h6><?= date("g:i a", strtotime($showtime['ShowTime'])); ?></h6>
                                    <div class="version"><?= htmlspecialchars($showtime['Version'] ?? 'Standard'); ?></div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-showtimes"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>
</html>
