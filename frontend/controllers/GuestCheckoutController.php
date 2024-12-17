<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/GuestCheckoutModel.php';

class GuestCheckoutController {
    private $model;

    public function __construct($connection) {
        $this->model = new GuestCheckoutModel($connection);
    }

    public function handleRequest() {
        if (!isset($_SESSION['invoice_id'])) {
            die("Invoice ID not found in session.");
        }

        $invoiceId = $_SESSION['invoice_id'];
        $invoice = $this->model->getInvoiceDetails($invoiceId);

        if (!$invoice) {
            die("Invoice not found.");
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/guest_checkout/guest_checkout_content.php';
    }
}

$controller = new GuestCheckoutController($connection);
$controller->handleRequest();
