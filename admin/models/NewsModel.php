<?php
// NewsModel.php
require_once('./includes/connection.php');

class NewsModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // Add a news article
    public function addNews($title, $content, $datePosted) {
        $sql = "INSERT INTO News (Title, Content, DatePosted) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute([$title, $content, $datePosted])) {
            return $this->connection->lastInsertId(); // Return the new news ID
        }
        return false;
    }

    // Edit a news article
    public function editNews($newsId, $title, $content, $datePosted) {
        $sql = "UPDATE News SET Title = ?, Content = ?, DatePosted = ? WHERE News_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$title, $content, $datePosted, $newsId]);
    }

    // Delete a news article
    public function deleteNews($newsId) {
        $sql = "DELETE FROM News WHERE News_ID = ?";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$newsId]);
    }

    // Fetch all news articles
    public function getAllNews() {
        $sql = "SELECT News_ID, Title, Content, DatePosted FROM News";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch media associated with news
    public function getNewsMedia($newsId) {
        $sql = "SELECT FileName FROM Media WHERE News_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$newsId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
