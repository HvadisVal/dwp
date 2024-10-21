<?php
// Initialize the session.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page.
header("Location: adminLogin.php");
exit;
?>


//not sure we need logout for both user and admin