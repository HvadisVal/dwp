<?php 
require_once("manage_coupons.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Coupons</title>
    <link rel="stylesheet" href="/dwp/admin/coupons/style.css" />


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