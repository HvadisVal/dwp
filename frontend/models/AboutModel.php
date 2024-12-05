<?php
require_once("./includes/connection.php");


class AboutModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getAboutData() {
        $sql = "SELECT Name, Location, Email, OpeningHours, Description FROM Company LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'Name' => 'N/A',
            'Location' => 'N/A',
            'Email' => 'N/A',
            'OpeningHours' => 'N/A',
            'Description' => 'N/A',
        ];
    }
}
