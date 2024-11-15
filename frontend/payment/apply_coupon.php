<?php
session_start();
require_once("../includes/connection.php");

$couponCode = $_POST['couponCode'] ?? '';
$response = ['success' => false, 'message' => 'Invalid coupon code'];

if ($couponCode) {
    $stmt = $connection->prepare("SELECT * FROM Coupon WHERE CouponCode = :couponCode AND ExpireDate >= CURDATE()");
    $stmt->bindParam(':couponCode', $couponCode);
    $stmt->execute();
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        $discountAmount = $coupon['DiscountAmount'];
        $totalPrice = $_SESSION['totalPrice'];
        $newTotalPrice = max(0, $totalPrice - $discountAmount);
        
        // Update session total price
        $_SESSION['totalPrice'] = $newTotalPrice;

        $response = ['success' => true, 'newTotalPrice' => number_format($newTotalPrice, 2)];
    } else {
        $response['message'] = "Invalid or expired coupon code";
    }
}

echo json_encode($response);
?>
