<?php
require_once("./includes/connection.php");

class CompanyModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // Fetch company information
    public function getCompanyInfo($companyId) {
        $sql = "SELECT * FROM Company WHERE Company_ID = ? LIMIT 1";  // Use LIMIT 1 to ensure only one result
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$companyId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    // Update company information
    public function updateCompanyInfo($companyId, $name, $description, $openingHours, $email, $location) {
        $sql = "UPDATE Company SET Name = ?, Description = ?, OpeningHours = ?, Email = ?, Location = ? WHERE Company_ID = ? ";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$name, $description, $openingHours, $email, $location, $companyId]);
    }
}
