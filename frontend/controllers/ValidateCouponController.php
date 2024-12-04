<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/ValidateCouponModel.php';

class ValidateCouponController {
    private $model;

    public function __construct() {
        $this->model = new ValidateCouponModel();
    }

    public function handleRequest() {
        header('Content-Type: application/json');

        // Decode input data
        $data = json_decode(file_get_contents('php://input'), true);
        $couponCode = $data['couponCode'] ?? '';

        if (empty($couponCode)) {
            echo json_encode(["valid" => false, "message" => "Please provide a coupon code."]);
            exit;
        }

        // Validate coupon
        $response = $this->model->validateCoupon($couponCode, $_SESSION['totalPrice'] ?? null);
        echo json_encode($response);
    }
}
