<?php
session_start();

// Retrieve booking details from the URL
$movieId = $_GET['movie_id'];
$cinemaHallId = $_GET['cinema_hall_id'];
$showTime = $_GET['time'];
$showDate = $_GET['date'];

// Store booking details in the session
$_SESSION['booking'] = [
    'movie_id' => $movieId,
    'cinema_hall_id' => $cinemaHallId,
    'time' => $showTime,
    'date' => $showDate,
];

// Debugging: Confirm session data
if (!isset($_SESSION['booking'])) {
    die("Failed to store booking details in session.");
}

// Redirect to the seat selection page
header("Location: /dwp/seat");
exit();
