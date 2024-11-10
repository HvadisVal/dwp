<?php
session_start();
require_once("dbcon.php");

$data = json_decode(file_get_contents("php://input"), true);
$couponCode = $data['couponCode'] ?? '';

if (empty($couponCode)) {
    echo json_encode(['valid' => false, 'message' => 'Please enter a coupon code.']);
    exit;
}

$dbCon = dbCon('root', ''); // Pass the correct arguments here

try {
    // Retrieve coupon from database
    $couponQuery = $dbCon->prepare("SELECT DiscountAmount, ExpireDate FROM Coupon WHERE CouponCode = :couponCode");
    $couponQuery->bindParam(':couponCode', $couponCode);
    $couponQuery->execute();
    $coupon = $couponQuery->fetch(PDO::FETCH_ASSOC);

    // Check if coupon exists and is not expired
    if ($coupon && strtotime($coupon['ExpireDate']) >= time()) {
        $discountAmount = (float)$coupon['DiscountAmount'];
        $totalPrice = isset($_SESSION['totalPrice']) ? (float)$_SESSION['totalPrice'] : 0;

        // Calculate new total price
        $newTotalPrice = max(0, $totalPrice - $discountAmount); // Ensure price doesn't go below 0

        // Update session with new total price for consistency
        $_SESSION['totalPrice'] = $newTotalPrice;

        echo json_encode([
            'valid' => true,
            'discount' => number_format($discountAmount, 2),
            'newTotalPrice' => number_format($newTotalPrice, 2),
            'message' => "Coupon applied! You saved DKK $discountAmount."
        ]);
    } else {
        echo json_encode(['valid' => false, 'message' => 'Invalid or expired coupon code.']);
    }
} catch (PDOException $e) {
    echo json_encode(['valid' => false, 'message' => 'Database error.']);
}
?>