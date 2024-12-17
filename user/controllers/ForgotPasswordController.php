<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/vendor/autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/ForgotPasswordModel.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . '/dwp');
$dotenv->load();

class ForgotPasswordController {
    private $model;

    public function __construct($connection) {
        $this->model = new ForgotPasswordModel($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                echo "Invalid email address.";
                exit();
            }

            try {
                $token = $this->model->generateResetToken($email);
                if ($token) {
                    $resetLink = "https://filmfusion.dk/dwp/user/reset-password?token=$token";
                    $this->sendResetEmail($email, $resetLink);
                    echo "Password reset link has been sent to your email.";
                } else {
                    echo "Email not found.";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/password_form/forgot_password_form.php');
        }
    }

    public function sendResetEmail($email, $resetLink) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_EMAIL'];
            $mail->Password = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port = $_ENV['SMTP_PORT'];

            $mail->setFrom('noreply@filmfusion.dk', 'FilmFusion Support'); 
            $mail->addAddress($email);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Click the following link to reset your password: $resetLink";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}


