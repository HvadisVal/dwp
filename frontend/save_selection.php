<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['selectedSeats'], $data['selectedTickets'])) {
    $totalSeats = count($data['selectedSeats']);
    $totalTickets = array_sum($data['selectedTickets']);

    if ($totalSeats !== $totalTickets) {
        echo json_encode(['success' => false, 'message' => 'The number of selected seats does not match the total tickets.']);
        exit;
    }

    $_SESSION['selectedSeats'] = $data['selectedSeats'];
    $_SESSION['selectedTickets'] = $data['selectedTickets'];
    echo json_encode(['success' => true]);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid data received']);
    exit;
}
