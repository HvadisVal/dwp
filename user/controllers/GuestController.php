<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/dwp/user/models/GuestModel.php');

class GuestController {
    private $model;

    public function __construct() {
        $connection = dbCon("root", "");
        $this->model = new GuestModel($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'] ?? null;
            $lastname = $_POST['lastname'] ?? null;
            $email = $_POST['email'] ?? null;
            $phone = $_POST['phone'] ?? null;

            if ($firstname && $lastname && $email && $phone) {
                try {
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
