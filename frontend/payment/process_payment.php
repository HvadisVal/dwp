<?php
session_start();
require_once("../includes/connection.php");

$paymentMethod = $_POST['paymentMethod'] ?? '';
$totalPrice = $_SESSION['totalPrice'] ?? 0;

if ($paymentMethod && $totalPrice > 0) {
    $stmt = $connection->prepare("INSERT INTO Payment (AmountPaid, PaymentMethod, PaymentDate, PaymentStatus) VALUES (:amountPaid, :paymentMethod, CURDATE(), 'Completed')");
    $stmt->bindParam(':amountPaid', $totalPrice);
    $stmt->bindParam(':paymentMethod', $paymentMethod);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment failed. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid payment details.']);
}
?>
