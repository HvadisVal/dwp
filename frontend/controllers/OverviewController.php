<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/OverviewModel.php';

class OverviewController {
    private $model;

    public function __construct($connection) {
        $this->model = new OverviewModel($connection);
    }

    public function handleRequest() {
        $isLoggedIn = isset($_SESSION['user_id']);
        $isGuest = isset($_SESSION['guest_user_id']);
        $selectedSeats = $_SESSION['selectedSeats'] ?? [];
        $selectedTickets = $_SESSION['selectedTickets'] ?? [];

        if (empty($selectedTickets) || empty($selectedSeats)) {
            die("No tickets or seats selected. Please go back to select tickets.");
        }

        $ticketDetails = [];
        $totalPrice = 0;
        try {
            foreach ($selectedTickets as $type => $quantity) {
                $pricePerTicket = $this->model->getTicketPrice($type);
                $totalForType = $pricePerTicket * $quantity;
                $totalPrice += $totalForType;
                $ticketDetails[] = [
                    'type' => $type,
                    'price' => $pricePerTicket,
                    'quantity' => $quantity,
                    'total' => $totalForType,
                ];
            }
            $_SESSION['totalPrice'] = $totalPrice;
        } catch (Exception $e) {
            die("Error calculating prices: " . $e->getMessage());
        }

        $movie_id = $_SESSION['booking']['movie_id'] ?? null;
        $cinema_hall_id = $_SESSION['booking']['cinema_hall_id'] ?? null;
        $showtime = $_SESSION['booking']['time'] ?? null;

        $movie = $this->model->getMovieDetails($movie_id);

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/overview/overview_content.php';
    }
}
