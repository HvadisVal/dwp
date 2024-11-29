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

    public static function checkScreeningOverlap($movieId, $cinemaHallId, $showTime, $screeningId = null) {
        global $connection;
    
        // Get the movie duration
        $sql = "SELECT Duration FROM Movie WHERE Movie_ID = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$movieId]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($movie) {
            // Duration in seconds
            $duration = $movie['Duration'];
            $durationParts = explode(':', $duration);
            $hours = isset($durationParts[0]) ? (int)$durationParts[0] : 0;
            $minutes = isset($durationParts[1]) ? (int)$durationParts[1] : 0;
            $seconds = isset($durationParts[2]) ? (int)$durationParts[2] : 0;
            $durationInSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
    
            // Calculate end time and buffer
            $showTimeTimestamp = strtotime($showTime);
            $endTime = $showTimeTimestamp + $durationInSeconds;
            $endTimePlus15 = $endTime + (15 * 60); // Add 15 minutes buffer
    
            $endTimeFormatted = date('Y-m-d H:i:s', $endTime);
            $endTimePlus15Formatted = date('Y-m-d H:i:s', $endTimePlus15);
    
            // Check for overlapping screenings, but exclude the current screening if it's an update
            $sql = "SELECT COUNT(*) FROM Screening s
                    JOIN Movie m ON s.Movie_ID = m.Movie_ID
                    WHERE s.CinemaHall_ID = ?
                    AND (
                        (s.ShowDate = ? AND s.ShowTime < ? AND DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND) > ?)
                        OR (s.ShowDate = ? AND s.ShowTime >= ? AND s.ShowTime < ?)
                        OR (s.ShowDate = ? AND DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND) > ?)
                    )";
    
            // If updating, exclude the screening that is being updated from the check
            if ($screeningId) {
                $sql .= " AND s.Screening_ID != ?";
            }
    
            $stmt = $connection->prepare($sql);
            if ($screeningId) {
                $stmt->execute([
                    $cinemaHallId,              // Cinema Hall ID
                    date('Y-m-d', strtotime($showTime)), // Show Date
                    $endTimePlus15Formatted,    // New end time with buffer
                    $showTime,                  // New start time
                    date('Y-m-d', strtotime($showTime)), // Start time condition date
                    $showTime,                  // Second condition start time
                    $endTimeFormatted,          // Second condition end time
                    date('Y-m-d', strtotime($showTime)), // Full day check if it spans into the next day
                    $showTime,                  // Base show time
                    $screeningId                // Exclude the current screening if updating
                ]);
            } else {
                $stmt->execute([
                    $cinemaHallId,              // Cinema Hall ID
                    date('Y-m-d', strtotime($showTime)), // Show Date
                    $endTimePlus15Formatted,    // New end time with buffer
                    $showTime,                  // New start time
                    date('Y-m-d', strtotime($showTime)), // Start time condition date
                    $showTime,                  // Second condition start time
                    $endTimeFormatted,          // Second condition end time
                    date('Y-m-d', strtotime($showTime)), // Full day check if it spans into the next day
                    $showTime                   // Base show time
                ]);
            }
    
            $existingCount = $stmt->fetchColumn();
    
            return $existingCount > 0; // Return true if there's an overlap
        }
    
        return false;
    }
    
    // Add screening with overlap check
    public static function addScreening($movieId, $cinemaHallId, $showTime) {
        if (self::checkScreeningOverlap($movieId, $cinemaHallId, $showTime)) {
            return false; // Return false if there's an overlap
        }

        global $connection;
        $showDate = date('Y-m-d', strtotime($showTime));

        $sql = "INSERT INTO Screening (ShowDate, ShowTime, CinemaHall_ID, Movie_ID) 
                VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        return $stmt->execute([$showDate, $showTime, $cinemaHallId, $movieId]);
    }

    // Update screening with overlap check
    public static function updateScreening($screeningId, $movieId, $cinemaHallId, $showTime) {
        // Exclude the current screening from the overlap check
        if (self::checkScreeningOverlap($movieId, $cinemaHallId, $showTime, $screeningId)) {
            return false; // Return false if there's an overlap
        }
    
        global $connection;
        $showDate = date('Y-m-d', strtotime($showTime));
        $sql = "UPDATE Screening 
                SET ShowDate = ?, ShowTime = ?, CinemaHall_ID = ?, Movie_ID = ? 
                WHERE Screening_ID = ?";
        $stmt = $connection->prepare($sql);
        return $stmt->execute([$showDate, $showTime, $cinemaHallId, $movieId, $screeningId]);
    }
    

    public static function deleteScreening($screeningId) {
        global $connection;
        $sql = "DELETE FROM Screening WHERE Screening_ID = ?";
        $stmt = $connection->prepare($sql);
        return $stmt->execute([$screeningId]);
    }
}
