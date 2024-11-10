<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once("dbcon.php");

try {
    $dbCon = dbCon($user, $pass);
} catch (Exception $e) {
    echo json_encode(["valid" => false, "message" => "Connection failed: " . $e->getMessage()]);
    exit;
}

// Get posted coupon code
$data = json_decode(file_get_contents('php://input'), true);
$couponCode = $data['couponCode'] ?? '';

// Check if coupon code is valid
if ($couponCode) {
    $stmt = $dbCon->prepare("SELECT * FROM Coupon WHERE CouponCode = :couponCode AND ExpireDate >= CURDATE()");
    $stmt->bindParam(':couponCode', $couponCode);
    $stmt->execute();
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        $discount = $coupon['DiscountAmount'];
        $newTotalPrice = $_SESSION['totalPrice'] - $discount;
        echo json_encode(["valid" => true, "discount" => $discount, "newTotalPrice" => $newTotalPrice]);
    } else {
        echo json_encode(["valid" => false, "message" => "Invalid or expired coupon code."]);
    }
} else {
    echo json_encode(["valid" => false, "message" => "An unexpected error occurred. Please try again."]);
    exit;
}
?>
