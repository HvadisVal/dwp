<?php
require_once("./includes/admin_session.php");
require_once("./includes/functions.php");
require_once("./admin/models/ScreeningModel.php");

class ScreeningController {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleFormSubmission();
        }

        $screenings = ScreeningModel::fetchAllScreenings();
        $cinemaHalls = ScreeningModel::fetchCinemaHalls();
        $movies = ScreeningModel::fetchMovies();

        require_once("./admin/views/screenings_content.php");
    }

    private function handleFormSubmission() {
        validate_csrf_token($_POST['csrf_token']);
        refresh_csrf_token();

        if (isset($_POST['add_screening'])) {
            $movieId = (int)$_POST['movie_id'];
            $cinemaHallId = (int)$_POST['cinemahall_id'];
            $showTime = $_POST['showtime'];

            if (ScreeningModel::addScreening($movieId, $cinemaHallId, $showTime)) {
                $_SESSION['message'] = "Screening added successfully!";
            } else {
                $_SESSION['message'] = "Error adding screening: Time slot overlaps with another screening.";
            }
            header("Location: /dwp/admin/manage-screenings");
            exit();
        }

        if (isset($_POST['edit_screening'])) {
            $screeningId = (int)$_POST['screening_id'];
            $movieId = (int)$_POST['movie_id'];
            $cinemaHallId = (int)$_POST['cinemahall_id'];
            $showTime = $_POST['showtime'];
    
            if (ScreeningModel::updateScreening($screeningId, $movieId, $cinemaHallId, $showTime)) {
                $_SESSION['message'] = "Screening updated successfully!";
            } else {
                $_SESSION['message'] = "Error updating screening: Time slot overlaps with another screening.";
            }
            header("Location: /dwp/admin/manage-screenings");
            exit();
        }

        if (isset($_POST['delete_screening'])) {
            $screeningId = (int)$_POST['screening_id'];

            if (ScreeningModel::deleteScreening($screeningId)) {
                $_SESSION['message'] = "Screening deleted successfully!";
            } else {
                $_SESSION['message'] = "Error deleting screening.";
            }
            header("Location: /dwp/admin/manage-screenings");
            exit();
        }
    }
}

