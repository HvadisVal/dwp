<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/ContactModel.php');

class ContactController {
    private $model;

    public function __construct($connection) {
        // Initialize the ContactModel and pass the database connection
        $this->model = new ContactModel($connection);
    }

    // Show the contact form
    public function showForm() {
        try {
            $company = $this->model->getCompanyDetails();
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/contact_us/contact_form.php');
        } catch (Exception $e) {
            echo "Error fetching company details: " . $e->getMessage();
        }
    }

    // Handle form submission
    public function submitForm() {
        try {
            // Validate and sanitize input
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
            $message = htmlspecialchars($_POST['message']);
            $captcha_response = $_POST['g-recaptcha-response'] ?? '';

            if (!$email) {
                throw new Exception("Invalid email address.");
            }

            // Verify CAPTCHA response
            $secret_key = '6Ld1cpoqAAAAAIrjjBueOyKBY7M_c-QgigVuEk84'; // Use your actual secret key

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => $secret_key,
                'response' => $captcha_response
            ];

            $options = [
                'http' => [
                    'method' => 'POST',
                    'content' => http_build_query($data),
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
                ]
            ];

            $context = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $response_keys = json_decode($verify);

            // Check CAPTCHA verification result
            if (!$response_keys->success || $response_keys->score < 0.5) {
                throw new Exception("CAPTCHA validation failed. Please try again.");
            }

            // If all input is valid, save the message
            if ($this->model->saveMessage($name, $email, $subject, $message)) {
                // Send a JSON response
                echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);
            } else {
                throw new Exception("Failed to send your message. Please try again later.");
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
