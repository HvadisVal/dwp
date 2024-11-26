<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php"); 


// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Add Coupon
    if (isset($_POST['add_coupon'])) {
        $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
        $discountAmount = (float)trim($_POST['discount_amount']);
        $expireDate = $_POST['expire_date'];

        // Insert query
        $sql = "INSERT INTO Coupon (CouponCode, DiscountAmount, ExpireDate) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$couponCode, $discountAmount, $expireDate])) {
            $_SESSION['message'] = "Coupon added successfully!";
            header("Location: /dwp/admin/manage-coupons");
            exit();
        } else {
            echo "Error adding coupon.";
        }
    }
    // Edit Coupon
    elseif (isset($_POST['edit_coupon'])) {
        $couponId = (int)$_POST['coupon_id'];
        $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
        $discountAmount = (float)trim($_POST['discount_amount']);
        $expireDate = $_POST['expire_date'];

        // Update query
        $sql = "UPDATE Coupon SET CouponCode = ?, DiscountAmount = ?, ExpireDate = ? WHERE Coupon_ID = ?";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$couponCode, $discountAmount, $expireDate, $couponId])) {
            $_SESSION['message'] = "Coupon updated successfully!";
            header("Location: /dwp/admin/manage-coupons");
            exit();
        } else {
            echo "Error updating coupon.";
        }
    }
    // Delete Coupon
    elseif (isset($_POST['delete_coupon'])) {
        $couponId = (int)$_POST['coupon_id'];

        // Delete query
        $sql = "DELETE FROM Coupon WHERE Coupon_ID = ?";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$couponId])) {
            $_SESSION['message'] = "Coupon deleted successfully!";
            header("Location: /dwp/admin/manage-coupons");
            exit();
        } else {
            echo "Error deleting coupon.";
        }
    }
}

// Fetch all coupons
$sql = "SELECT Coupon_ID, CouponCode, DiscountAmount, ExpireDate FROM Coupon";
$stmt = $connection->prepare($sql);
$stmt->execute();
$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); 
}
include('coupons_content.php');

