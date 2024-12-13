<?php
error_reporting(E_ALL); // Enable all error reporting
ini_set('display_errors', 1); // Display errors on the page

require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/FetchController.php';


// Decode incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Check for errors in decoding
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Invalid JSON input");
}

// Create the controller and fetch the movies
$controller = new FetchController($connection); // Pass the $connection to the constructor
$movies = $controller->fetchMovies($data);

// Ensure movies are returned as JSON
if (empty($movies)) {
    echo json_encode([]); // Return empty array if no movies found
} else {
    header('Content-Type: application/json');
    echo json_encode($movies); // Return the movies as JSON
}
