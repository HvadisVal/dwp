<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

try {
    $dbCon = dbCon($user, $pass);
} catch (Exception $e) {
    echo json_encode(["valid" => false, "message" => "Connection failed: " . $e->getMessage()]);
    exit;
}

// Get posted coupon code
$data = json_decode(file_get_contents('php://input'), true);
$couponCode = $data['couponCode'] ?? '';

file_put_contents('debug.log', "Input Data: " . print_r($data, true) . "\n", FILE_APPEND);
file_put_contents('debug.log', "Coupon Code: " . $couponCode . "\n", FILE_APPEND);

// Ensure total price exists
if (!isset($_SESSION['totalPrice']) || !is_numeric($_SESSION['totalPrice'])) {
    echo json_encode(["valid" => false, "message" => "Total price not set or invalid."]);
    exit;
}

// Ensure coupon code is provided
if (empty($couponCode)) {
    echo json_encode(["valid" => false, "message" => "No coupon code provided."]);
    exit;
}

// Check if coupon code is valid
try {
    $stmt = $dbCon->prepare("SELECT * FROM Coupon WHERE CouponCode = :couponCode AND ExpireDate >= CURDATE()");
    $stmt->bindParam(':couponCode', $couponCode);
    $stmt->execute();
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    file_put_contents('debug.log', "Query Result: " . print_r($coupon, true) . "\n", FILE_APPEND);

    if ($coupon && is_numeric($coupon['DiscountAmount'])) {
        $discount = (float)$coupon['DiscountAmount'];
        $newTotalPrice = max(0, $_SESSION['totalPrice'] - $discount); // Prevent negative prices
        echo json_encode(["valid" => true, "discount" => $discount, "newTotalPrice" => $newTotalPrice]);
    } else {
        echo json_encode(["valid" => false, "message" => "Invalid or expired coupon code."]);
    }
} catch (Exception $e) {
    echo json_encode(["valid" => false, "message" => "Database error: " . $e->getMessage()]);
    exit;
}
?>
