<?php
require_once("./includes/connection.php");

class LandingModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getDistinctDates() {
        $sql = "SELECT DISTINCT ShowDate 
                  FROM Screening 
                  WHERE ShowDate >= CURDATE() 
                  ORDER BY ShowDate";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function getLandingMovies() {
    $sql = "SELECT m.Movie_ID, m.Title, m.Description, lm.DisplayOrder,
                   (SELECT FileName 
                    FROM Media 
                    WHERE Media.Movie_ID = m.Movie_ID 
                    AND Media.IsFeatured = 0 
                    LIMIT 1) AS FileName,  
                   (SELECT MIN(ShowDate) 
                    FROM Screening 
                    WHERE Screening.Movie_ID = m.Movie_ID 
                    AND Screening.ShowDate >= CURDATE()) AS FirstScreeningDate  
              FROM LandingMovies lm
              JOIN Movie m ON lm.Movie_ID = m.Movie_ID
              ORDER BY RAND() LIMIT 1"; 
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



    public function getMovies() {
        $sql = "SELECT DISTINCT Movie.Movie_ID, 
                        Movie.Title,
                        (SELECT FileName 
                         FROM Media 
                         WHERE Media.Movie_ID = Movie.Movie_ID 
                         LIMIT 1) AS FileName
                  FROM Movie
                  JOIN Screening ON Movie.Movie_ID = Screening.Movie_ID";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVersions() {
        $sql = "SELECT * FROM Version";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompanyDescription() {
        $sql = "SELECT Description FROM Company LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Description'] ?? 'N/A';
    }

    public function generateNewsHTML() {
        $sql = "SELECT n.Title, n.Content, n.DatePosted, m.FileName 
                  FROM News n
                  LEFT JOIN Media m ON n.News_ID = m.News_ID 
                  ORDER BY n.DatePosted DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        return $newsHTML;
    }
}
