<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class AboutModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", ""); // Update with actual credentials
    }

    public function getAboutData() {
        $query = "SELECT Location, Email, OpeningHours, Description FROM Company LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'Location' => 'N/A',
            'Email' => 'N/A',
            'OpeningHours' => 'N/A',
            'Description' => 'N/A',
        ];
    }
}
