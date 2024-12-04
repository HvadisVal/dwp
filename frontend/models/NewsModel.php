<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class NewsModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", ""); // Update with actual credentials if needed
    }

    public function getNewsWithMedia() {
        $query = "
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

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
