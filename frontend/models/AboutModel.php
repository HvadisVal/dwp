<?php
require_once("./includes/connection.php");


class AboutModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAboutData() {
        $sql = "SELECT Location, Email, OpeningHours, Description FROM Company LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'Location' => 'N/A',
            'Email' => 'N/A',
            'OpeningHours' => 'N/A',
            'Description' => 'N/A',
        ];
    }
}
