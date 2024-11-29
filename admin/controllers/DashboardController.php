<?php
// admin/controllers/DashboardController.php
require_once('./includes/functions.php'); 
require_once('./includes/admin_session.php');

class DashboardController {
    // No model required in the constructor now
    public function getAdminEmail() {
        if (isset($_SESSION['admin_email']) && !empty($_SESSION['admin_email'])) {
            return $_SESSION['admin_email'];
        } else {
            redirect_to("/dwp/admin/login");
        }
    }
}

?>
