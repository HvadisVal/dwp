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

include 'movies_content.php';
?>