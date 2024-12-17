<?php
session_start();

$movieId = $_GET['movie_id'];
$cinemaHallId = $_GET['cinema_hall_id'];
$showTime = $_GET['time'];
$showDate = $_GET['date'];

$_SESSION['booking'] = [
    'movie_id' => $movieId,
    'cinema_hall_id' => $cinemaHallId,
    'time' => $showTime,
    'date' => $showDate,
];

if (!isset($_SESSION['booking'])) {
    die("Failed to store booking details in session.");
}

header("Location: /dwp/seat");
exit();
