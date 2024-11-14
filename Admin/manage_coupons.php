<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php"); 

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
            header("Location: /dwp/admin/manage-coupons");
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
            header("Location: /dwp/admin/manage-coupons");
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
            header("Location: /dwp/admin/manage-coupons");
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .container {
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
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            font-size: 16px;
            color: #555;
            box-sizing: border-box;
            margin-top: 8px;
        }
        button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .add-button, .edit-button, .delete-button {
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

        .add-button:hover {
            background: #1a252d; 
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        .edit-button {
            background-color: black;
            margin-right: 8px;
            disp
        }

        .edit-button:hover {
            background: #1a252d; 
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
            color: white;
            transition:  0.3s ease, color 0.3s ease; 
            transform: translateY(-1px);
        }

        
        .coupons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
            
        }

        .coupon-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .coupon-card input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            
            
        }

        .coupon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        /* Responsive grid */
        @media (max-width: 1024px) {
            .coupons-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .coupons-grid {
                grid-template-columns: 1fr;
            }
        }

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
    <div class="coupons-grid">
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

                <div class="button-group">
                    <button type="submit" name="edit_coupon" class="edit-button">Save Changes</button>
                    <button type="submit" name="delete_coupon" class="delete-button">Delete Coupon</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
