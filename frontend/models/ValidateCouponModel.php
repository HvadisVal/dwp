<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class ValidateCouponModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", ""); // Update with actual credentials
    }

    public function validateCoupon($couponCode, $totalPrice) {
        if (!$totalPrice || !is_numeric($totalPrice)) {
            return ["valid" => false, "message" => "Total price not set or invalid."];
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM Coupon WHERE CouponCode = :couponCode AND ExpireDate >= CURDATE()");
            $stmt->bindParam(':couponCode', $couponCode);
            $stmt->execute();
            $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($coupon && is_numeric($coupon['DiscountAmount'])) {
                $discount = (float)$coupon['DiscountAmount'];
                $newTotalPrice = max(0, $totalPrice - $discount);
                $_SESSION['discountedPrice'] = $newTotalPrice;

                return ["valid" => true, "discount" => $discount, "newTotalPrice" => $newTotalPrice];
            } else {
                return ["valid" => false, "message" => "Invalid or expired coupon code."];
            }
        } catch (Exception $e) {
            return ["valid" => false, "message" => "An error occurred: " . $e->getMessage()];
        }
    }
}
