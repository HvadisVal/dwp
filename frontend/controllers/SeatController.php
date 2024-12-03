<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/SeatModel.php';

class SeatController {
    private $model;

    public function __construct() {
        $this->model = new SeatModel();
    }

    public function handleRequest() {
        $movieId = $_SESSION['booking']['movie_id'] ?? $_GET['movie_id'] ?? 0;
        $time = $_SESSION['booking']['time'] ?? $_GET['time'] ?? 'N/A';
        $cinemaHallID = $_SESSION['booking']['cinema_hall_id'] ?? $_GET['cinema_hall_id'] ?? 0;
        $date = $_SESSION['booking']['date'] ?? $_GET['date'] ?? '';

        // Validate movie and cinema hall IDs
        if (!$movieId || !$cinemaHallID) {
            die("Invalid movie or cinema hall ID.");
        }

        // Fetch required data using the model
        $movie = $this->model->getMovieDetails($movieId);
        $hall = $this->model->getCinemaHall($cinemaHallID);
        $seats = $this->model->getSeats($cinemaHallID);
        $ticketPrices = $this->model->getTicketPrices();
        $bookedSeats = $this->model->getBookedSeats($movieId, $cinemaHallID, $date, $time);

        // Convert booked seats for easier processing
        $bookedSeatsArray = array_map(function ($seat) {
            return $seat['Row'] . '-' . $seat['SeatNumber'];
        }, $bookedSeats);

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/seat/seat_content.php';
    }
}
