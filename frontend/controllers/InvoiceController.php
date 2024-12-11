<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/InvoiceModel.php';

class InvoiceController {
    private $model;

    public function __construct($connection) {
        $this->model = new InvoiceModel($connection);
    }

    public function handleRequest() {
        $invoiceId = $_GET['invoice_id'] ?? null;

        if (!$invoiceId) {
            die("Invoice not found.");
        }

        // Check if the invoice belongs to a guest user
        $isGuest = isset($_GET['guest']) && $_GET['guest'] == 'true';  // Add this line to check for guest query parameter

        $invoice = $this->model->getInvoiceDetails($invoiceId, $isGuest);

        if (!$invoice) {
            die("Invoice not found.");
        }

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/invoice/invoice_content.php';
    }
}
