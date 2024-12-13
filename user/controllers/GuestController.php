<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/GuestModel.php');
class GuestController {
    private $model;

    public function __construct($connection) {
        $this->model = new GuestModel($connection);
    }
    
    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $firstname = $_POST['firstname'] ?? null;
            $lastname = $_POST['lastname'] ?? null;
            $email = $_POST['email'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $captcha_response = $_POST['g-recaptcha-response'] ?? '';

            // Your secret key from Google reCAPTCHA
            $secret_key = '6Ld1cpoqAAAAAIrjjBueOyKBY7M_c-QgigVuEk84'; // Use your actual secret key

            // Verify the CAPTCHA response
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

            // Check if CAPTCHA verification is successful
            if ($response_keys->success !== true || $response_keys->score < 0.5) {
                echo json_encode(['success' => false, 'message' => 'CAPTCHA validation failed. Please try again.']);
                exit;
            }

            if ($firstname && $lastname && $email && $phone) {
                try {
                    // Create the guest user
                    $guestId = $this->model->createGuest($firstname, $lastname, $email, $phone);
                    if ($guestId) {
                        session_start();
                        $_SESSION['guest_user_id'] = $guestId;
                        $_SESSION['guest_firstname'] = $firstname;
                        $_SESSION['guest_lastname'] = $lastname;
                        $_SESSION['guest_email'] = $email;

                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to create guest user.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'All fields are required.']);
            }
        } else {
            require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/user/views/guest/guest_form.php';
        }
    }
}
