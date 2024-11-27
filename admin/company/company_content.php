<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Company</title>
    <link rel="stylesheet" href="/dwp/admin/company/company.css" />
</head>
<body>

<h1>Manage Company</h1>

<!-- Display message if available -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<!-- Edit Company Information Section -->
<h2>Edit Company Details</h2>
<form method="POST" class="company-card company-form">
    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

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
