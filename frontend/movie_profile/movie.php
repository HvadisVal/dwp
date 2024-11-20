<?php
// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Get the movie ID from the URL parameter
$movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
if ($movieId <= 0) {
    echo "Invalid movie ID.";
    exit;
}

// Set the range of days (e.g., 7 days from today)
$daysToShow = 7;
$startDate = new DateTime();
$endDate = (clone $startDate)->modify("+$daysToShow days");

// Format the dates for SQL query
$startDateFormatted = $startDate->format('Y-m-d');
$endDateFormatted = $endDate->format('Y-m-d');

// Fetch movie details with showtimes, poster, and gallery images, filtering by date range
$movieQuery = $dbCon->prepare("
    SELECT m.*, 
           s.CinemaHall_ID, 
           s.ShowTime, 
           s.ShowDate, 
           c.Name AS CinemaHall_Name, 
           v.Format AS Version,
           GROUP_CONCAT(DISTINCT CASE WHEN media.IsFeatured = 1 THEN media.FileName END) AS PosterFiles,
           GROUP_CONCAT(DISTINCT CASE WHEN media.IsFeatured = 0 THEN media.FileName END) AS GalleryFiles

    FROM Movie m
    LEFT JOIN Screening s ON m.Movie_ID = s.Movie_ID
    LEFT JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
    LEFT JOIN Version v ON m.Version_ID = v.Version_ID
    LEFT JOIN Media media ON m.Movie_ID = media.Movie_ID
    WHERE m.Movie_ID = :movieId
    AND s.ShowDate BETWEEN :startDate AND :endDate  -- Filter by date range
    GROUP BY m.Movie_ID, s.ShowDate, s.ShowTime
    ORDER BY s.ShowDate, s.ShowTime
");

// Bind parameters and execute the query
$movieQuery->bindParam(':movieId', $movieId);
$movieQuery->bindParam(':startDate', $startDateFormatted);
$movieQuery->bindParam(':endDate', $endDateFormatted);
$movieQuery->execute();
$movieData = $movieQuery->fetchAll(PDO::FETCH_ASSOC);

// If no movie found, show an error message
if (!$movieData) {
    echo "Movie not found.";
    exit;
}

// Organize movie data by date and showtime
$movieDetails = [];
foreach ($movieData as $data) {
    $movieDetails['Title'] = $data['Title'];
    $movieDetails['Duration'] = $data['Duration'];
    $movieDetails['Rating'] = $data['Rating'];
    $movieDetails['Description'] = $data['Description'];
    $movieDetails['Director'] = $data['Director'];
    $movieDetails['Language'] = $data['Language'];
    $movieDetails['Year'] = $data['Year'];
    $movieDetails['TrailerLink'] = $data['TrailerLink'];
    $movieDetails['Genre_ID'] = $data['Genre_ID'];
    $movieDetails['Version'] = $data['Version'];

    // Add poster images (featured)
    $movieDetails['PosterFiles'] = explode(',', $data['PosterFiles']);
    $movieDetails['GalleryFiles'] = explode(',', $data['GalleryFiles']);

    // Organize showtimes by date
    $showDate = $data['ShowDate'];
    if (!isset($movieDetails['Showtimes'][$showDate])) {
        $movieDetails['Showtimes'][$showDate] = [];
    }
    $movieDetails['Showtimes'][$showDate][] = $data;
}

// Create a list of dates for the next 7 days
$allDates = [];
$startDateClone = clone $startDate;
for ($i = 0; $i < $daysToShow; $i++) {
    $allDates[] = $startDateClone->format('Y-m-d');
    $startDateClone->modify('+1 day');
}


include('movie_content.php');
