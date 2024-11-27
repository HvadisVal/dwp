<?php
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php");

$csrfToken = generate_csrf_token();

class CouponManager {
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

$couponManager = new CouponManager($connection);

// Generate CSRF token
generate_csrf_token();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    validate_csrf_token($_POST['csrf_token']);

    // Refresh CSRF token to avoid reuse
    refresh_csrf_token();

    // Determine action
    $action = $_POST['action'] ?? '';

    // Process action
    switch ($action) {
        case 'add':
            $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
            $discountAmount = (float)trim($_POST['discount_amount']);
            $expireDate = $_POST['expire_date'];

            if ($couponManager->addCoupon($couponCode, $discountAmount, $expireDate)) {
                $_SESSION['message'] = "Coupon added successfully!";
            } else {
                $_SESSION['message'] = "Error adding coupon.";
            }
            break;

        case 'edit':
            $couponId = (int)$_POST['coupon_id'];
            $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
            $discountAmount = (float)trim($_POST['discount_amount']);
            $expireDate = $_POST['expire_date'];

            if ($couponManager->editCoupon($couponId, $couponCode, $discountAmount, $expireDate)) {
                $_SESSION['message'] = "Coupon updated successfully!";
            } else {
                $_SESSION['message'] = "Error updating coupon.";
            }
            break;

        case 'delete':
            $couponId = (int)$_POST['coupon_id'];

            if ($couponManager->deleteCoupon($couponId)) {
                $_SESSION['message'] = "Coupon deleted successfully!";
            } else {
                $_SESSION['message'] = "Error deleting coupon.";
            }
            break;

        default:
            $_SESSION['message'] = "Invalid action.";
            break;
    }

    header("Location: /dwp/admin/manage-coupons");
    exit();
}

// Fetch all coupons
$coupons = $couponManager->getAllCoupons();

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}

include('coupons_content.php');
?>
