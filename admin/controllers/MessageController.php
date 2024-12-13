<?php 
// admin/controllers/MessageController.php
require_once('./admin/models/MessageModel.php');
require_once('./includes/admin_session.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable('/Applications/XAMPP/xamppfiles/htdocs/DWP');
$dotenv->load();

class MessageController {
    private $messageModel;

    public function __construct($connection) {
        $this->messageModel = new MessageModel($connection);
    }

    public function handleRequest() {
        // Fetch all contact messages to be passed to the view
        $messages = $this->messageModel->getAllMessages();
        include('admin/views/messages_content.php');
    }

    // Handle reply to message
    public function replyToMessage($messageId, $reply) {
        // Fetch the recipient email and subject based on the Message ID
        $message = $this->messageModel->getMessageDetails($messageId);
    
        if (!$message) {
            $_SESSION['message'] = "Message not found.";
            header('Location: /dwp/admin/manage-messages');
            exit();
        }
    
        $recipientEmail = $message['Email'];
        $subject = $message['Subject'];
    
        // Sanitize the reply
        $reply = htmlspecialchars(trim($reply));
    
        // Store the reply in the database
        if ($this->messageModel->replyToMessage($messageId, $reply)) {
            // Send the reply email
            if ($this->sendReplyEmail($recipientEmail, 'Re: ' . $subject, $reply)) {
                $_SESSION['message'] = "Reply sent successfully!";
            } else {
                $_SESSION['message'] = "Reply saved, but email could not be sent.";
            }
        } else {
            $_SESSION['message'] = "Failed to save reply.";
        }
    
        header('Location: /dwp/admin/manage-messages');
        exit();
    }
    
    

    private function sendReplyEmail($recipientEmail, $subject, $reply) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
    
            // Use $_ENV variables directly
            $mail->Host = $_ENV['SMTP_HOST'] ?? 'send.one.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_EMAIL'] ?? 'noreply@filmfusion.dk';
            $mail->Password = $_ENV['SMTP_PASSWORD'] ?? 'your_password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['SMTP_PORT'] ?? 465;
    
            $mail->setFrom($_ENV['SMTP_EMAIL'], 'Admin - FilmFusion');
            $mail->addAddress($recipientEmail);
            $mail->Subject = $subject;
            $mail->isHTML(true);
    
            // Compose the email body for the reply
            $mail->Body = $this->generateReplyContent($reply);
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error sending email: " . $mail->ErrorInfo); // Log the error
            return false;
        }
    }

    private function generateReplyContent($reply) {
        return "
            <p>Hello,</p>
            <p>Thank you for reaching out. Here is our reply to your query:</p>
            <p>{$reply}</p>
            <p>Best regards,<br>FilmFusion Team</p>
            <br>
            <p>Please do not reply to this email as it is an automated reply.</p>
        ";
    }
    

    
    
    
}
