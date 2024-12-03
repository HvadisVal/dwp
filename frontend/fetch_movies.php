<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/FetchController.php';

// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Create the controller and fetch the movies
$controller = new FetchController();
$movies = $controller->fetchMovies($data);

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($movies);
