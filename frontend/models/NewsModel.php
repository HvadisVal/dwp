<?php
require_once("./includes/connection.php");

class NewsModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
    public function getNewsWithMedia() {
        $sql = "
            SELECT 
                News.Title, 
                News.Content, 
                News.DatePosted, 
                Media.FileName, 
                Media.Format 
            FROM News 
            LEFT JOIN Media ON News.News_ID = Media.News_ID
            ORDER BY News.DatePosted DESC
        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
