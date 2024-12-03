<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class LandingModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", "");
    }

    public function getDistinctDates() {
        $query = "SELECT DISTINCT ShowDate 
                  FROM Screening 
                  WHERE ShowDate >= CURDATE() 
                  ORDER BY ShowDate";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMovies() {
        $query = "SELECT DISTINCT Movie.Movie_ID, 
                        Movie.Title,
                        (SELECT FileName 
                         FROM Media 
                         WHERE Media.Movie_ID = Movie.Movie_ID 
                         LIMIT 1) AS FileName
                  FROM Movie
                  JOIN Screening ON Movie.Movie_ID = Screening.Movie_ID";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVersions() {
        $query = "SELECT * FROM Version";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompanyDescription() {
        $query = "SELECT Description FROM Company LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Description'] ?? 'N/A';
    }

    public function generateNewsHTML() {
        $query = "SELECT n.Title, n.Content, n.DatePosted, m.FileName 
                  FROM News n
                  LEFT JOIN Media m ON n.News_ID = m.News_ID 
                  ORDER BY n.DatePosted DESC";
        $stmt = $this->db->prepare($query);
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
