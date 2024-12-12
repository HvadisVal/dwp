<?php 
// admin/models/MessageModel.php
class MessageModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // Fetch all contact messages
    public function getAllMessages() {
        $sql = "SELECT Message_ID, Name, Email, Subject, Message, Submitted_At, Reply FROM ContactMessages ORDER BY Submitted_At DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Store the reply to a message
    public function replyToMessage($messageId, $reply) {
        $sql = "UPDATE ContactMessages SET Reply = ? WHERE Message_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$reply, $messageId]);
    }
}
