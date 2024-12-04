<?php
require_once("./includes/connection.php");

class OverviewModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getTicketPrice($type) {
        $sql = "SELECT Price FROM TicketPrice WHERE Type = :type";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Price'] ?? 0;
    }

    public function getMovieDetails($movieId) {
        $sql = "SELECT * FROM Movie WHERE Movie_ID = :movie_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
