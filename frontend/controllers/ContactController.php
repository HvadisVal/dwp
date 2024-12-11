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

            if (!$email) {
                throw new Exception("Invalid email address.");
            }

            if ($this->model->saveMessage($name, $email, $subject, $message)) {
                $successMessage = "Your message has been sent successfully!";
                require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/contact_us/contact_form.php');
            } else {
                throw new Exception("Failed to send your message. Please try again later.");
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/contact_us/contact_form.php');
        }
    }
}
?>
