<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class MovieModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", "");
    }

    public function getMovieDetails($movieId) {
        // Fetch movie details with showtimes, poster, and gallery images
        $query = "
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
            GROUP BY m.Movie_ID, s.ShowDate, s.ShowTime
            ORDER BY s.ShowDate, s.ShowTime";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':movieId', $movieId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
