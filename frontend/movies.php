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

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}

body {
    background: #121212;
    color: #ffffff;
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

.movie-container {
    display: flex;
    flex-wrap: wrap;
    padding: 20px;
    margin-bottom: 30px;
    background: #1e1e1e;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
}

.movie-info {
    flex: 1 1 25%;
    padding-right: 20px;
    text-align: center;
}

.poster {
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
}

.movie-details h4 {
    font-size: 1.5em;
    margin: 15px 0;
    color: white;
    font-weight: bold;
}

.movie-details p {
    font-size: 0.9em;
    margin: 5px 0;
    color: #ccc;
}

.schedule {
    flex: 1 1 75%;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.date-column {
    flex: 1 1 150px;
    background: #242424;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

.date-header {
    text-align: center;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 1.1em;
    color: #ffffff;
}

.showtime-card {
    background: linear-gradient(to right, #243642, #1a252d);
    padding: 10px;
    margin: 5px 0;
    border-radius: 8px;
    text-align: center;
    color: white;
    font-weight: bold;
    transition: transform 0.2s, background-color 0.2s;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.showtime-card:hover {
    transform: translateY(-5px);
    background: grey;
}

.showtime-card h6 {
    margin: 5px 0;
    font-size: 0.9em;
    font-weight: normal;
}

.showtime-card .version {
    font-size: 0.8em;
    color: #ffebcc;
    margin-top: 5px;
}

.no-showtimes {
    color: #888;
    font-size: 0.9em;
    font-style: italic;
    text-align: center;
    padding: 10px;
}

@media (max-width: 768px) {
    .movie-container {
        flex-direction: column;
    }

    .movie-info, .schedule {
        flex: 1 1 100%;
    }
}

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
                                <a href="/dwp/seat?movie_id=<?= htmlspecialchars($showtime['Movie_ID']); ?>&cinema_hall_id=<?= htmlspecialchars($showtime['CinemaHall_ID']); ?>&time=<?= urlencode($showtime['ShowTime']); ?>&date=<?= urlencode($showtime['ShowDate']); ?>" class="showtime-card">
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

<?php include 'footer.php'; ?>
</body>
</html>