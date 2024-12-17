<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/FetchController.php';

$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("Invalid JSON input");
}

$controller = new FetchController($connection);
$movies = $controller->fetchMovies($data);

if (empty($movies)) {
    echo json_encode([]);
} else {
    header('Content-Type: application/json');
    echo json_encode($movies); 
}
