<?php
require_once("./includes/connection.php");

class SeatModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getMovieDetails($movieId) {
        $sql = "SELECT Title FROM Movie WHERE Movie_ID = :movie_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? ['Title' => 'Unknown Movie'];
    }

    public function getCinemaHall($cinemaHallID) {
        $sql = "SELECT * FROM CinemaHall WHERE CinemaHall_ID = :cinema_hall_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':cinema_hall_id', $cinemaHallID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSeats($cinemaHallID) {
        $sql = "SELECT * FROM Seat WHERE CinemaHall_ID = :cinema_hall_id ORDER BY Row, SeatNumber";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':cinema_hall_id', $cinemaHallID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTicketPrices() {
        $sql = "SELECT * FROM TicketPrice";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookedSeats($movieId, $cinemaHallID, $date, $time) {
        $sql = "
            SELECT Seat.Row, Seat.SeatNumber 
            FROM Ticket
            INNER JOIN Seat ON Ticket.Seat_ID = Seat.Seat_ID
            WHERE Ticket.Screening_ID = (
                SELECT Screening_ID 
                FROM Screening 
                WHERE Movie_ID = :movie_id 
                AND CinemaHall_ID = :cinema_hall_id 
                AND ShowDate = :show_date 
                AND ShowTime = :show_time
            )
        ";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->bindParam(':cinema_hall_id', $cinemaHallID, PDO::PARAM_INT);
        $stmt->bindParam(':show_date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':show_time', $time, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
