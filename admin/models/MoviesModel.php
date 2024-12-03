<?php
require_once("./includes/connection.php");

class MoviesModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAllMovies() {
        $sql = "SELECT * FROM MovieDetails";  // Using the SQL view
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
