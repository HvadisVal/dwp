<?php 
// admin/controllers/CouponController.php
require_once('./admin/models/CouponModel.php');
require_once('./includes/admin_session.php');
require_once('./includes/functions.php');

class CouponController {
    private $couponModel;

    public function __construct($connection) {
        $this->couponModel = new CouponModel($connection);
    }

    public function handleRequest() {
        $csrfToken = generate_csrf_token();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate CSRF token
            validate_csrf_token($_POST['csrf_token']);
            refresh_csrf_token();

            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add':
                    $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
                    if (!validate_for_letter_numbers($couponCode)) {
                        $_SESSION['message'] = "Coupon code can only contain letters and numbers.";
                        header("Location: /dwp/admin/manage-coupons");
                        exit();
                    }

                    // Validate discount_amount (using the reusable function)
                    $discountAmount = trim($_POST['discount_amount']);
                    if (!validate_numeric($discountAmount)) {
                        $_SESSION['message'] = "Please enter a valid discount amount (positive number).";
                        header("Location: /dwp/admin/manage-coupons");
                        exit();
                    }
                    $discountAmount = (float)$discountAmount;

                    // Validate expire_date (using the reusable function)
                    $expireDate = $_POST['expire_date'];
                    if (!validate_date($expireDate)) {
                        $_SESSION['message'] = "Please enter a valid expiration date (YYYY-MM-DD).";
                        header("Location: /dwp/admin/manage-coupons");
                        exit();
                    }

                    $this->couponModel->addCoupon($couponCode, $discountAmount, $expireDate);
                    $_SESSION['message'] = "Coupon added successfully!";
                    break;
                
                case 'edit':
                    $couponId = (int)$_POST['coupon_id'];
                    $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
                    if (!validate_for_letter_numbers($couponCode)) {
                        $_SESSION['message'] = "Coupon code can only contain letters and numbers.";
                        header("Location: /dwp/admin/manage-coupons");
                        exit();
                    }

                    // Validate discount_amount (using the reusable function)
                    $discountAmount = trim($_POST['discount_amount']);
                    if (!validate_numeric($discountAmount)) {
                        $_SESSION['message'] = "Please enter a valid discount amount (positive number).";
                        header("Location: /dwp/admin/manage-coupons");
                        exit();
                    }
                    $discountAmount = (float)$discountAmount;

                    // Validate expire_date (using the reusable function)
                    $expireDate = $_POST['expire_date'];
                    if (!validate_date($expireDate)) {
                        $_SESSION['message'] = "Please enter a valid expiration date (YYYY-MM-DD).";
                        header("Location: /dwp/admin/manage-coupons");
                        exit();
                    }

                    $this->couponModel->editCoupon($couponId, $couponCode, $discountAmount, $expireDate);
                    $_SESSION['message'] = "Coupon updated successfully!";
                    break;
                
                case 'delete':
                    $couponId = (int)$_POST['coupon_id'];
                    $this->couponModel->deleteCoupon($couponId);
                    $_SESSION['message'] = "Coupon deleted successfully!";
                    break;

                default:
                    $_SESSION['message'] = "Invalid action.";
                    break;
            }

            header("Location: /dwp/admin/manage-coupons");
            exit();
        }

        // Fetch all coupons to be passed to the view
        $coupons = $this->couponModel->getAllCoupons();
        include('admin/views/coupons_content.php');
    }
}
