<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/InvoiceModel.php';

class InvoiceController {
    private $model;

    public function __construct() {
        $this->model = new InvoiceModel();
    }

    public function handleRequest() {
        $invoiceId = $_GET['invoice_id'] ?? null;

        if (!$invoiceId) {
            die("Invoice not found.");
        }

        $invoice = $this->model->getInvoiceDetails($invoiceId);

        if (!$invoice) {
            die("Invoice not found.");
        }

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/payment/invoice_content.php';
    }
}
