<?php 
// admin/controllers/MessageController.php
require_once('./admin/models/MessageModel.php');
require_once('./includes/admin_session.php');

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
        $reply = htmlspecialchars(trim($reply)); // Sanitize the reply input
        if ($this->messageModel->replyToMessage($messageId, $reply)) {
            $_SESSION['message'] = "Reply sent successfully!";
        } else {
            $_SESSION['message'] = "Failed to send reply.";
        }
        header('Location: /dwp/admin/manage-messages');
        exit();
    }
}
