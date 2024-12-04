<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/includes/connection.php';

class FooterModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getFooterData() {
        $sql = "SELECT Location, Email FROM Company LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'Location' => 'N/A',
            'Email' => 'N/A',
        ];
    }
}
?>
