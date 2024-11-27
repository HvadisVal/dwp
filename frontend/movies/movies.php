<?php
// Connect to the database
require_once("dbcon.php");
$dbCon = dbCon($user, $pass);

// Fetch all movies, showtimes, and their images (both posters and gallery images)
$moviesQuery = $dbCon->prepare("
SELECT m.*, s.CinemaHall_ID, s.ShowTime, s.ShowDate, c.Name as CinemaHall_Name, v.Format as Version,
    GROUP_CONCAT(DISTINCT CASE WHEN media.IsFeatured = 1 THEN media.FileName END) as PosterFiles,
    GROUP_CONCAT(DISTINCT CASE WHEN media.IsFeatured = 0 THEN media.FileName END) as GalleryFiles
FROM Movie m
JOIN Screening s ON m.Movie_ID = s.Movie_ID
JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
LEFT JOIN Version v ON m.Version_ID = v.Version_ID
LEFT JOIN Media media ON m.Movie_ID = media.Movie_ID
GROUP BY m.Movie_ID, s.ShowDate, s.ShowTime
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
                'PosterPath' => [],  // For movie posters
            ],
            'showtimes' => []
        ];
    }

    // Add poster images (featured)
    if ($data['PosterFiles']) {
        $posterFiles = explode(',', $data['PosterFiles']);
        $moviesById[$movieId]['details']['PosterPath'] = array_map(function($image) {
            return "./uploads/poster/" . $image; // Prefix the path to the images
        }, $posterFiles);
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