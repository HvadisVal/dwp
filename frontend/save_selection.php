<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['selectedSeats'], $data['selectedTickets'])) {
    $_SESSION['selectedSeats'] = $data['selectedSeats'];
    $_SESSION['selectedTickets'] = $data['selectedTickets'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
}
?>