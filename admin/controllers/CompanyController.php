<?php
require_once("./includes/admin_session.php");
require_once("./includes/functions.php");
require_once("./admin/models/CompanyModel.php");

// CSRF token handling
generate_csrf_token();

class CompanyController {
    private $model;
    private $companyId = 1; // Default company ID

    public function __construct($connection) {
        $this->model = new CompanyModel($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
        } else {
            $this->showCompanyPage();
        }
    }

    private function handlePostRequest() {
        // Validate CSRF token
        validate_csrf_token($_POST['csrf_token']);
        refresh_csrf_token();  // Refresh CSRF token to avoid reuse

        if (isset($_POST['edit_company'])) {
            $this->editCompany();
        } else {
            $_SESSION['message'] = "Invalid action.";
            header("Location: /dwp/admin/manage-company");
            exit();
        }
    }

    private function editCompany() {
        $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
        $openingHours = htmlspecialchars(trim($_POST['opening_hours']), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $location = htmlspecialchars(trim($_POST['location']), ENT_QUOTES, 'UTF-8');
    
        if (!validate_email($email)) {
            $_SESSION['message'] = "Invalid email address. Please enter a valid email.";
            header("Location: /dwp/admin/manage-company", true, 303);
            exit();
        }

        if ($this->model->updateCompanyInfo($this->companyId, $name, $description, $openingHours, $email, $location)) {
            $_SESSION['message'] = "Company information updated successfully!";
        } else {
            $_SESSION['message'] = "Error updating company information.";
        }
    
        header("Location: /dwp/admin/manage-company", true, 303);
        exit();
    }
    

    private function showCompanyPage() {
        $company = $this->model->getCompanyInfo($this->companyId);
        include("./admin/views/company.php"); // Only include once here in the controller
    }
}

