<?php
session_start();
header('Content-Type: application/json');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');

try {
    $dbCon = dbCon($user, $pass);
} catch (Exception $e) {
    echo json_encode(["valid" => false, "message" => "Database connection failed."]);
    exit;
}

// Get posted coupon code
$data = json_decode(file_get_contents('php://input'), true);
$couponCode = $data['couponCode'] ?? '';

if (empty($couponCode)) {
    echo json_encode(["valid" => false, "message" => "Please provide a coupon code."]);
    exit;
}

if (!isset($_SESSION['totalPrice']) || !is_numeric($_SESSION['totalPrice'])) {
    echo json_encode(["valid" => false, "message" => "Total price not set or invalid."]);
    exit;
}

try {
    $stmt = $dbCon->prepare("SELECT * FROM Coupon WHERE CouponCode = :couponCode AND ExpireDate >= CURDATE()");
    $stmt->bindParam(':couponCode', $couponCode);
    $stmt->execute();
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon && is_numeric($coupon['DiscountAmount'])) {
        $discount = (float)$coupon['DiscountAmount'];
        $newTotalPrice = max(0, $_SESSION['totalPrice'] - $discount);

        // Save the coupon code and discounted price to the session
        $_SESSION['couponCode'] = $couponCode;
        $_SESSION['discountedPrice'] = $newTotalPrice;

        echo json_encode(["valid" => true, "discount" => $discount, "newTotalPrice" => $newTotalPrice]);
    } else {
        echo json_encode(["valid" => false, "message" => "Invalid or expired coupon code."]);
    }
} catch (Exception $e) {
    echo json_encode(["valid" => false, "message" => "An error occurred: " . $e->getMessage()]);
}
