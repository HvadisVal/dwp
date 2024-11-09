<?php
session_start();
require_once("dbcon.php");

header('Content-Type: application/json');

// Replace 'your_username' and 'your_password' with actual database credentials
$dbCon = dbCon('root', ''); // Pass the correct arguments here

// Retrieve the coupon code from the AJAX request
$inputData = json_decode(file_get_contents('php://input'), true);
$couponCode = $inputData['couponCode'] ?? null;

if ($couponCode) {
    // Prepare query to check if coupon code exists and is valid
    $stmt = $dbCon->prepare("SELECT * FROM Coupon WHERE CouponCode = :couponCode AND ExpireDate >= CURDATE()");
    $stmt->bindParam(':couponCode', $couponCode);
    $stmt->execute();
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon && isset($_SESSION['totalPrice'])) {
        // Coupon is valid
        $discount = $coupon['DiscountAmount'];
        $newTotalPrice = max($_SESSION['totalPrice'] - $discount, 0); // Ensure price doesn’t go below 0
        $_SESSION['totalPrice'] = $newTotalPrice; // Update session with new total price

        echo json_encode([
            "valid" => true,
            "discount" => $discount,
            "newTotalPrice" => number_format($newTotalPrice, 2)
        ]);
    } else {
        // Coupon is invalid, expired, or total price isn’t set
        echo json_encode([
            "valid" => false,
            "message" => "Invalid or expired coupon code."
        ]);
    }
} else {
    // No coupon code provided
    echo json_encode([
        "valid" => false,
        "message" => "Please enter a coupon code."
    ]);
}
?>