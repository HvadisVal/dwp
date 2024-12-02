<?php
// Include the database connection file
require_once 'dbcon.php';

// Connect to the database
$conn = dbCon($user, $pass);

// Query to retrieve Location and Email
$sql = "SELECT Location, Email FROM Company LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data was retrieved
$location = $result['Location'] ?? 'N/A';
$email = $result['Email'] ?? 'N/A';

include 'footer_content.php';
?>


