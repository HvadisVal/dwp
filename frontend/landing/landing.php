<?php
// Include the database connection file
require_once 'dbcon.php';

// Connect to the database
$conn = dbCon($user, $pass);

// Fetch company description
$sql = "SELECT Description FROM Company LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$description = $result['Description'] ?? 'N/A';
$shortDescription = substr($description, 0, 352); // Truncate for display

$sql = "SELECT DISTINCT Movie.Title, 
               (SELECT FileName 
                FROM Media 
                WHERE Media.Movie_ID = Movie.Movie_ID 
                LIMIT 1) AS FileName
        FROM Movie
        JOIN Screening ON Movie.Movie_ID = Screening.Movie_ID
        WHERE Screening.ShowDate = CURDATE()";
$stmt = $conn->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch news with images
$sql = "SELECT n.Title, n.Content, n.DatePosted, m.FileName 
        FROM News n
        LEFT JOIN Media m ON n.News_ID = m.News_ID 
        ORDER BY n.DatePosted DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate news HTML
$newsHTML = '';
foreach ($newsItems as $news) {
    $imagePath = !empty($news['FileName']) ? 'uploads/news_images/' . htmlspecialchars($news['FileName']) : '';
    $newsHTML .= '<div class="slider-item">';
    if ($imagePath) {
        $newsHTML .= '<img src="' . $imagePath . '" alt="' . htmlspecialchars($news['Title']) . '" />';
    }
    $newsHTML .= '<h3>' . htmlspecialchars($news['Title']) . '</h3>';
    $newsHTML .= '<p>' . nl2br(htmlspecialchars($news['Content'])) . '</p>';
    $newsHTML .= '</div>';
}

