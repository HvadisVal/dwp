<?php
// admin/models/LandingMoviesModel.php
require_once("./includes/connection.php");

class LandingMoviesModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function addlandingMovie($movieId, $displayOrder) {
        // Check if the movie is already on the landing page
        if ($this->movieExistsOnLandingPage($movieId)) {
            // Remove the movie if it already exists
            $this->removeMovieFromLandingPage($movieId);
        }

        // Check if the display order already exists
        if ($this->displayOrderExists($displayOrder)) {
            return false; // Display order already exists
        }

        // Add the movie to the landing page
        $sql = "INSERT INTO LandingMovies (Movie_ID, DisplayOrder) VALUES (?, ?)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$movieId, $displayOrder]);
    }

    // Method to get the count of movies already on the landing page
    public function getLandingMoviesCount() {
        $sql = "SELECT COUNT(*) FROM LandingMovies";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Check if the movie is already on the landing page
    private function movieExistsOnLandingPage($movieId) {
        $sql = "SELECT COUNT(*) FROM LandingMovies WHERE Movie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$movieId]);
        return $stmt->fetchColumn() > 0;
    }

    // Method to check if the display order already exists
    private function displayOrderExists($displayOrder) {
        $sql = "SELECT COUNT(*) FROM LandingMovies WHERE DisplayOrder = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$displayOrder]);
        return $stmt->fetchColumn() > 0;
    }

    // Remove a movie from the landing page
    private function removeMovieFromLandingPage($movieId) {
        $sql = "DELETE FROM LandingMovies WHERE Movie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$movieId]);
    }

    // Method to fetch all movies not already on the landing page
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

    // Method to update display order
    public function updateDisplayOrder($landingMovieId, $newOrder) {
        // Check if the new order already exists
        if ($this->displayOrderExists($newOrder)) {
            return false; // Display order already exists
        }

        $sql = "UPDATE LandingMovies SET DisplayOrder = ? WHERE LandingMovie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$newOrder, $landingMovieId]);
    }

    // Method to delete a movie from the landing page
    public function deleteLandingMovie($landingMovieId) {
        $sql = "DELETE FROM LandingMovies WHERE LandingMovie_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$landingMovieId]);
    }
}
