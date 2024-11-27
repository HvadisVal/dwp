<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php");

// CSRF token handling
generate_csrf_token();

// Company Manager Class
class CompanyManager {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    // Fetch company information
    public function getCompanyInfo($companyId) {
        $sql = "SELECT * FROM Company WHERE Company_ID = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$companyId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update company information
    public function updateCompanyInfo($companyId, $name, $description, $openingHours, $email, $location) {
        $sql = "UPDATE Company SET Name = ?, Description = ?, OpeningHours = ?, Email = ?, Location = ? WHERE Company_ID = ?";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([$name, $description, $openingHours, $email, $location, $companyId]);
    }
}

// Create instance of CompanyManager class
$companyManager = new CompanyManager($connection);

// Default company ID (assuming there's only one company with ID 1)
$companyId = 1;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    validate_csrf_token($_POST['csrf_token']);
    refresh_csrf_token();  // Refresh CSRF token to avoid reuse
    
    // Switch to handle different actions
    switch (true) {
        case isset($_POST['edit_company']):
            // Handle editing company information
            $name = htmlspecialchars(trim($_POST['name']));
            $description = htmlspecialchars(trim($_POST['description']));
            $openingHours = htmlspecialchars(trim($_POST['opening_hours']));
            $email = htmlspecialchars(trim($_POST['email']));
            $location = htmlspecialchars(trim($_POST['location']));

            if ($companyManager->updateCompanyInfo($companyId, $name, $description, $openingHours, $email, $location)) {
                $_SESSION['message'] = "Company information updated successfully!";
                header("Location: /dwp/admin/manage-company"); 
                exit();
            } else {
                echo "Error updating company information.";
            }
            break;

        default:
            $_SESSION['message'] = "Invalid action.";
            header("Location: /dwp/admin/manage-company"); 
            exit();
    }
}

// Fetch company information
$company = $companyManager->getCompanyInfo($companyId);

// Display any messages
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}

include('company_content.php');
