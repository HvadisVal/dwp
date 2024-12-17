<?php 
class MessageModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAllMessages() {
        $sql = "SELECT Message_ID, Name, Email, Subject, Message, Submitted_At, Reply FROM ContactMessages ORDER BY Submitted_At DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function replyToMessage($messageId, $reply) {
        $sql = "UPDATE ContactMessages SET Reply = ? WHERE Message_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$reply, $messageId]);
    }

    public function getMessageById($messageId) {
        $sql = "SELECT * FROM ContactMessages WHERE Message_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$messageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getMessageDetails($messageId) {
        $sql = "SELECT Email, Subject FROM ContactMessages WHERE Message_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$messageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    
}
