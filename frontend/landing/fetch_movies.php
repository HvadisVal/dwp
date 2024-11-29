<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

// Connect to the database
$conn = dbCon($user, $pass);
$pdo = dbCon($user, $pass);

$data = json_decode(file_get_contents('php://input'), true);

$date = $data['date'] ?? null;
$movieId = $data['movieId'] ?? null;
$versionId = $data['versionId'] ?? null;

$query = "SELECT DISTINCT Movie.Movie_ID, Movie.Title, 
                 (SELECT FileName 
                  FROM Media 
                  WHERE Media.Movie_ID = Movie.Movie_ID 
                  LIMIT 1) AS FileName
          FROM Movie
          INNER JOIN Screening ON Movie.Movie_ID = Screening.Movie_ID
          LEFT JOIN Version ON Movie.Version_ID = Version.Version_ID
          WHERE 1=1";

$params = [];

if ($date) {
    $query .= " AND Screening.ShowDate = :date";
    $params[':date'] = $date;
}

if ($movieId) {
    $query .= " AND Movie.Movie_ID = :movieId";
    $params[':movieId'] = $movieId;
}

if ($versionId) {
    $query .= " AND Movie.Version_ID = :versionId"; // Filter by Version_ID
    $params[':versionId'] = $versionId;
}

// Execute query and fetch results
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return results as JSON
echo json_encode($movies);
?>
