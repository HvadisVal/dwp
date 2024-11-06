<?php 
require_once("../includes/session.php"); 
require_once("../includes/connection.php"); 
require_once("../includes/functions.php");

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    if (isset($_POST['edit_company'])) {
        // Handle editing company information
        $companyId = 1; // Assuming there is only one company and its ID is 1
        $name = htmlspecialchars(trim($_POST['name']));
        $description = htmlspecialchars(trim($_POST['description']));
        $openingHours = htmlspecialchars(trim($_POST['opening_hours']));
        $email = htmlspecialchars(trim($_POST['email']));
        $location = htmlspecialchars(trim($_POST['location']));

        // Update query with prepared statement
        $sql = "UPDATE Company SET Name = ?, Description = ?, OpeningHours = ?, Email = ?, Location = ? WHERE Company_ID = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt->execute([$name, $description, $openingHours, $email, $location, $companyId])) {
            $_SESSION['message'] = "Company information updated successfully!";
            header("Location: manage_company.php"); 
            exit();
        } else {
            echo "Error updating company information.";
        }
    }
}

// Fetch company information
$sql = "SELECT * FROM Company WHERE Company_ID = 1"; // Assuming there's only one company with ID 1
$stmt = $connection->prepare($sql);
$stmt->execute();
$company = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Company</title>
    <style>
        /* General Styling */
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h1, h2 {
            color: black;
            text-align: center;
            margin: 25px 0;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.5em;
            margin-bottom: 24px;
        }

        /* Form and Container */
        .company-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            background-color: #fff;
        }

        .company-form {
            max-width: 800px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-top: 16px;
            display: block;
            color: #666;
        }

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            color: #555;
            box-sizing: border-box;
            margin-top: 8px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .save-button {
            background: black;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
        }

        .save-button:hover {
            background: #1a252d; 
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<h1>Manage Company</h1>

<!-- Edit Company Information Section -->
<h2>Edit Company Details</h2>
<form method="POST" class="company-card company-form">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label for="name">Company Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($company['Name']); ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars($company['Description']); ?></textarea>

    <label for="opening_hours">Opening Hours:</label>
    <input type="text" name="opening_hours" value="<?php echo htmlspecialchars($company['OpeningHours']); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($company['Email']); ?>" required>

    <label for="location">Location:</label>
    <input type="text" name="location" value="<?php echo htmlspecialchars($company['Location']); ?>" required>

    <button type="submit" name="edit_company" class="save-button">Save Changes</button>
</form>

</body>
</html>
