<?php
require_once("./includes/connection.php");

class LandingMoviesModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function addlandingMovie($movieId, $displayOrder) {
        if ($this->movieExistsOnLandingPage($movieId)) {
            $this->removeMovieFromLandingPage($movieId);
        }

        if ($this->displayOrderExists($displayOrder)) {
            return false; 
        }

        $sql = "INSERT INTO LandingMovies (Movie_ID, DisplayOrder) VALUES (?, ?)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$movieId, $displayOrder]);
    }

    public function getLandingMoviesCount() {
        $sql = "SELECT COUNT(*) FROM LandingMovies";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    private function movieExistsOnLandingPage($movieId) {
        $sql = "SELECT COUNT(*) FROM LandingMovies WHERE Movie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$movieId]);
        return $stmt->fetchColumn() > 0;
    }

    private function displayOrderExists($displayOrder) {
        $sql = "SELECT COUNT(*) FROM LandingMovies WHERE DisplayOrder = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$displayOrder]);
        return $stmt->fetchColumn() > 0;
    }

    private function removeMovieFromLandingPage($movieId) {
        $sql = "DELETE FROM LandingMovies WHERE Movie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$movieId]);
    }

    public function getAllMoviesNotOnLandingPage() {
        $sql = "SELECT Movie_ID, Title FROM Movie WHERE Movie_ID NOT IN (SELECT Movie_ID FROM LandingMovies)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllMovies() {
        $sql = "SELECT Movie_ID, Title FROM Movie";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getlandingMovies() {
        $sql = "SELECT hm.LandingMovie_ID, m.Title, hm.DisplayOrder FROM LandingMovies hm
                JOIN Movie m ON hm.Movie_ID = m.Movie_ID ORDER BY hm.DisplayOrder";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDisplayOrder($landingMovieId, $newOrder) {
        if ($this->displayOrderExists($newOrder)) {
            return false; 
        }

        $sql = "UPDATE LandingMovies SET DisplayOrder = ? WHERE LandingMovie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$newOrder, $landingMovieId]);
    }

    public function deleteLandingMovie($landingMovieId) {
        $sql = "DELETE FROM LandingMovies WHERE LandingMovie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$landingMovieId]);
    }
}
