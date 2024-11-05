<?php 
require_once("../includes/session.php"); 
require_once("../includes/connection.php"); 
require_once("../includes/functions.php"); 

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Add Coupon
    if (isset($_POST['add_coupon'])) {
        $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
        $discountAmount = (float)trim($_POST['discount_amount']);
        $expireDate = $_POST['expire_date'];

        // Insert query
        $sql = "INSERT INTO Coupon (CouponCode, DiscountAmount, ExpireDate) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$couponCode, $discountAmount, $expireDate])) {
            $_SESSION['message'] = "Coupon added successfully!";
            header("Location: manage_coupons.php");
            exit();
        } else {
            echo "Error adding coupon.";
        }
    }
    // Edit Coupon
    elseif (isset($_POST['edit_coupon'])) {
        $couponId = (int)$_POST['coupon_id'];
        $couponCode = htmlspecialchars(trim($_POST['coupon_code']));
        $discountAmount = (float)trim($_POST['discount_amount']);
        $expireDate = $_POST['expire_date'];

        // Update query
        $sql = "UPDATE Coupon SET CouponCode = ?, DiscountAmount = ?, ExpireDate = ? WHERE Coupon_ID = ?";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$couponCode, $discountAmount, $expireDate, $couponId])) {
            $_SESSION['message'] = "Coupon updated successfully!";
            header("Location: manage_coupons.php");
            exit();
        } else {
            echo "Error updating coupon.";
        }
    }
    // Delete Coupon
    elseif (isset($_POST['delete_coupon'])) {
        $couponId = (int)$_POST['coupon_id'];

        // Delete query
        $sql = "DELETE FROM Coupon WHERE Coupon_ID = ?";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$couponId])) {
            $_SESSION['message'] = "Coupon deleted successfully!";
            header("Location: manage_coupons.php");
            exit();
        } else {
            echo "Error deleting coupon.";
        }
    }
}

// Fetch all coupons
$sql = "SELECT Coupon_ID, CouponCode, DiscountAmount, ExpireDate FROM Coupon";
$stmt = $connection->prepare($sql);
$stmt->execute();
$coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Manage Coupons</title>
    <style>
        /* General and form styling similar to your example */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .add-button { background-color: #4CAF50; color: white; }
        .edit-button { background-color: #2196F3; color: white; }
        .delete-button { background-color: #f44336; color: white; }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Coupons</h1>

    <!-- Add Coupon Form -->
    <h2>Add New Coupon</h2>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <label for="coupon_code">Coupon Code:</label>
        <input type="text" name="coupon_code" required>

        <label for="discount_amount">Discount Amount:</label>
        <input type="number" name="discount_amount" step="0.01" required>

        <label for="expire_date">Expire Date:</label>
        <input type="date" name="expire_date" required>

        <button type="submit" name="add_coupon" class="add-button">Add Coupon</button>
    </form>

    <!-- Existing Coupons -->
    <h2>Existing Coupons</h2>
    <?php foreach ($coupons as $coupon): ?>
        <form method="POST" class="coupon-card">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="coupon_id" value="<?php echo $coupon['Coupon_ID']; ?>">

            <label for="coupon_code">Coupon Code:</label>
            <input type="text" name="coupon_code" value="<?php echo htmlspecialchars($coupon['CouponCode']); ?>" required>

            <label for="discount_amount">Discount Amount:</label>
            <input type="number" name="discount_amount" value="<?php echo $coupon['DiscountAmount']; ?>" step="0.01" required>

            <label for="expire_date">Expire Date:</label>
            <input type="date" name="expire_date" value="<?php echo $coupon['ExpireDate']; ?>" required>

            <button type="submit" name="edit_coupon" class="edit-button">Save Changes</button>
            <button type="submit" name="delete_coupon" class="delete-button">Delete Coupon</button>
        </form>
        <hr>
    <?php endforeach; ?>
</div>

</body>
</html>
