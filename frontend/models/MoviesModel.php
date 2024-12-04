<?php
require_once("./includes/connection.php");

class MoviesModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAllMovies() {
        $sql = "
            SELECT m.*, s.CinemaHall_ID, s.ShowTime, s.ShowDate, c.Name as CinemaHall_Name, v.Format as Version,
                   GROUP_CONCAT(DISTINCT CASE WHEN media.IsFeatured = 1 THEN media.FileName END) as PosterFiles,
                   GROUP_CONCAT(DISTINCT CASE WHEN media.IsFeatured = 0 THEN media.FileName END) as GalleryFiles
            FROM Movie m
            JOIN Screening s ON m.Movie_ID = s.Movie_ID
            JOIN CinemaHall c ON s.CinemaHall_ID = c.CinemaHall_ID
            LEFT JOIN Version v ON m.Version_ID = v.Version_ID
            LEFT JOIN Media media ON m.Movie_ID = media.Movie_ID
            GROUP BY m.Movie_ID, s.ShowDate, s.ShowTime
            ORDER BY m.Movie_ID, s.ShowDate, s.ShowTime";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
