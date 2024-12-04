<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class OverviewModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", "");
    }

    public function getTicketPrice($type) {
        $query = "SELECT Price FROM TicketPrice WHERE Type = :type";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['Price'] ?? 0;
    }

    public function getMovieDetails($movieId) {
        $query = "SELECT * FROM Movie WHERE Movie_ID = :movie_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
