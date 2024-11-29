<?php
require_once("./includes/connection.php");

class MoviesModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAllMovies() {
        $sql = "SELECT m.Movie_ID, m.Title, m.Director, m.Language, m.Year, m.Duration, m.Rating, m.Description, 
                       m.TrailerLink, m.AgeLimit, 
                       MAX(CASE WHEN media.IsFeatured = 1 THEN media.FileName END) AS ImageFileName,
                       GROUP_CONCAT(CASE WHEN media.IsFeatured = 0 THEN media.FileName END) AS GalleryImages,
                       g.Genre_ID AS Genre_ID, g.Name AS GenreName,
                       v.Version_ID AS Version_ID, v.Format AS VersionFormat
                FROM Movie m
                LEFT JOIN Media media ON m.Movie_ID = media.Movie_ID
                LEFT JOIN Genre g ON m.Genre_ID = g.Genre_ID
                LEFT JOIN Version v ON m.Version_ID = v.Version_ID
                GROUP BY m.Movie_ID";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGenres() {
        return $this->connection->query("SELECT Genre_ID, Name FROM Genre")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVersions() {
        return $this->connection->query("SELECT Version_ID, Format FROM Version")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMovie($movieData) {
        $sql = "INSERT INTO Movie (Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID, TrailerLink, AgeLimit) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($movieData);
    }

    public function updateMovie($movieData) {
        $sql = "UPDATE Movie SET 
                Title = ?, Director = ?, Language = ?, Year = ?, Duration = ?, Rating = ?, Description = ?, 
                Genre_ID = ?, Version_ID = ?, TrailerLink = ?, AgeLimit = ? 
                WHERE Movie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($movieData);
    }

    public function deleteMovie($movieId) {
        $sql = "DELETE FROM Movie WHERE Movie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$movieId]);
    }
}
