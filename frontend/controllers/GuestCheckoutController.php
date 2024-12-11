<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/GuestCheckoutModel.php';

class GuestCheckoutController {
    private $model;

    public function __construct($connection) {
        $this->model = new GuestCheckoutModel($connection);
    }

    public function handleRequest() {
        // Check if invoice ID exists in session
        if (!isset($_SESSION['invoice_id'])) {
            die("Invoice ID not found in session.");
        }

        // Get invoice data from the model
        $invoiceId = $_SESSION['invoice_id'];
        $invoice = $this->model->getInvoiceDetails($invoiceId);

        if (!$invoice) {
            die("Invoice not found.");
        }

        // Pass the invoice data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/guest_checkout/guest_checkout_content.php';
    }
}

// Assuming you have a connection object, call the handleRequest method
$controller = new GuestCheckoutController($connection);
$controller->handleRequest();
