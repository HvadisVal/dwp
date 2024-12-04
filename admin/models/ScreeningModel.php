<?php
// Path: admin/models/ScreeningModel.php
require_once('./includes/connection.php');

class ScreeningModel {

    public static function fetchAllScreenings() {
        global $connection;
        $sql = "SELECT Screening_ID, ShowDate, ShowTime, CinemaHall_ID, Movie_ID 
                FROM Screening 
                ORDER BY ShowDate ASC, ShowTime ASC";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchCinemaHalls() {
        global $connection;
        $sql = "SELECT CinemaHall_ID, Name FROM CinemaHall";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchMovies() {
        global $connection;
        $sql = "SELECT Movie_ID, Title FROM Movie";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Add screening with overlap check
    public static function addScreening($movieId, $cinemaHallId, $showTime) {
        global $connection;
        $showDate = date('Y-m-d', strtotime($showTime));
    
        $sql = "INSERT INTO Screening (ShowDate, ShowTime, CinemaHall_ID, Movie_ID) 
                VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
    
        try {
            return $stmt->execute([$showDate, $showTime, $cinemaHallId, $movieId]);
        } catch (PDOException $e) {
            // Handle SQL error (e.g., overlap error from the trigger)
            return false;
        }
    }
    
    public static function updateScreening($screeningId, $movieId, $cinemaHallId, $showTime) {
        global $connection;
        $showDate = date('Y-m-d', strtotime($showTime));
        $sql = "UPDATE Screening 
                SET ShowDate = ?, ShowTime = ?, CinemaHall_ID = ?, Movie_ID = ? 
                WHERE Screening_ID = ?";
        $stmt = $connection->prepare($sql);
    
        try {
            return $stmt->execute([$showDate, $showTime, $cinemaHallId, $movieId, $screeningId]);
        } catch (PDOException $e) {
            // Handle SQL error (e.g., overlap error from the trigger)
            return false;
        }
    }
    
    

    public static function deleteScreening($screeningId) {
        global $connection;
        $sql = "DELETE FROM Screening WHERE Screening_ID = ?";
        $stmt = $connection->prepare($sql);
        return $stmt->execute([$screeningId]);
    }
}
