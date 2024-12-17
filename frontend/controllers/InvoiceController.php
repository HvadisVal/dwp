<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/InvoiceModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/dwp');
$dotenv->load();


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

        $isGuest = isset($_GET['guest']) && $_GET['guest'] === 'true';
        $invoice = $this->model->getInvoiceDetails($invoiceId, $isGuest);

        if (!$invoice) {
            die("Invoice not found.");
        }

        $email = $isGuest ? $this->model->getGuestEmail($invoiceId) : $this->model->getUserEmail($invoiceId);

        if ($email) {
            $this->sendInvoiceEmail($email, $invoice); 
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/invoice/invoice_content.php';
    }

    private function sendInvoiceEmail($recipientEmail, $invoice) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();

            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_EMAIL'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_EMAIL'], 'FilmFusion');
            $mail->addAddress($recipientEmail);
            $mail->Subject = 'Your Invoice from FilmFusion';
            $mail->isHTML(true);
            $mail->Body = $this->generateInvoiceEmailContent($invoice);

            $mail->send();
            echo "Invoice sent successfully!";
        } catch (Exception $e) {
            echo "Failed to send invoice email. Error: {$mail->ErrorInfo}";
        }
    }

    private function generateInvoiceEmailContent($invoice) {
        return "
            <h2>Invoice #{$invoice['Invoice_ID']}</h2>
            <p><strong>Date:</strong> {$invoice['InvoiceDate']}</p>
            <p><strong>Status:</strong> {$invoice['InvoiceStatus']}</p>
            <hr>
            <h3>Booking Details</h3>
            <p><strong>Movie:</strong> {$invoice['MovieTitle']}</p>
            <p><strong>Showtime:</strong> {$invoice['ShowTime']} on {$invoice['ShowDate']}</p>
            <p><strong>Cinema Hall:</strong> {$invoice['CinemaHall']}</p>
            <p><strong>Seats:</strong> {$invoice['Seats']}</p>
            <p><strong>Tickets:</strong> {$invoice['NumberOfTickets']}</p>
            <hr>
            <h3>Payment</h3>
            <p><strong>Total Amount:</strong> DKK " . number_format($invoice['TotalAmount'], 2) . "</p>
            <hr>
            <p>Thank you for booking with FilmFusion!</p>
        ";
    }
}
