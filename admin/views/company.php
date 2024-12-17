<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Company</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/company.css" />
</head>
<body>
    
<a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt=""></a>

<h1>Manage Company</h1>

<!-- Displaying messages -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="message"><?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?></div>
<?php endif; ?>

<h2>Edit Company Details</h2>

<form method="POST" class="company-card company-form">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

    <label for="name">Company Name:</label>
    <input type="text" name="name" 
           value="<?php echo htmlspecialchars(htmlspecialchars_decode($company['Name'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars(htmlspecialchars_decode($company['Description'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?></textarea>

    <label for="opening_hours">Opening Hours:</label>
    <input type="text" name="opening_hours" 
           value="<?php echo htmlspecialchars(htmlspecialchars_decode($company['OpeningHours'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" 
           value="<?php echo htmlspecialchars(htmlspecialchars_decode($company['Email'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="location">Location:</label>
    <input type="text" name="location" 
           value="<?php echo htmlspecialchars(htmlspecialchars_decode($company['Location'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

    <button type="submit" name="edit_company" class="save-button">Save Changes</button>
</form>

</body>
</html>
