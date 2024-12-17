<?php 
class CouponModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function addCoupon($couponCode, $discountAmount, $expireDate) {
        $sql = "INSERT INTO Coupon (CouponCode, DiscountAmount, ExpireDate) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$couponCode, $discountAmount, $expireDate]);
    }

    public function editCoupon($couponId, $couponCode, $discountAmount, $expireDate) {
        $sql = "UPDATE Coupon SET CouponCode = ?, DiscountAmount = ?, ExpireDate = ? WHERE Coupon_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$couponCode, $discountAmount, $expireDate, $couponId]);
    }

    public function deleteCoupon($couponId) {
        $sql = "DELETE FROM Coupon WHERE Coupon_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$couponId]);
    }

    public function getAllCoupons() {
        $sql = "SELECT Coupon_ID, CouponCode, DiscountAmount, ExpireDate FROM Coupon";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
