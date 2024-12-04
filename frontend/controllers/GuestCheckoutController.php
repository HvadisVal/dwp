<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/GuestCheckoutModel.php';


class GuestCheckoutController {
    private $model;

    public function __construct() {
        $this->model = new GuestCheckoutModel();
    }

    public function handleRequest() {
        session_start();
    
        // Debug session data
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
    
        if (!isset($_SESSION['invoice_id'])) {
            die("Invoice ID not found in session.");
        }
    
        $invoiceId = $_SESSION['invoice_id'];
        $invoice = $this->model->getInvoiceDetails($invoiceId);
    
        // Debug the fetched invoice
        echo "<pre>";
        print_r($invoice);
        echo "</pre>";
        exit;
    
        if (!$invoice) {
            die("Invoice not found.");
        }
    
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/guest_checkout/guest_checkout_content.php';
    }
    
}
