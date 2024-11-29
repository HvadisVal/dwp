<!-- admin/views/coupons_content.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo $csrfToken; ?>"> <!-- Store CSRF token here -->
    <title>Manage Coupons</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/coupons.css">
    <script src="/dwp/admin/assets/js/coupons.js" defer></script>
</head>

<body>
<div class="container">
    <header>
        <h1>Manage Coupons</h1>
    </header>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . $_SESSION['message'] . '</div>';
        // Optionally clear the message after displaying it
        unset($_SESSION['message']);
    }
    ?>


    <!-- Add Coupon Section -->
    <section class="add-coupon">
        <h2>Add New Coupon</h2>
        <form method="POST" class="form-add">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="action" value="add">

            <fieldset>
                <label for="coupon_code">Coupon Code:</label>
                <input type="text" name="coupon_code" id="coupon_code" placeholder="Enter coupon code" required>

                <label for="discount_amount">Discount Amount:</label>
                <input type="number" name="discount_amount" id="discount_amount" min="0" step="1" placeholder="Enter discount amount" required>

                <label for="expire_date">Expire Date:</label>
                <input type="date" name="expire_date" id="expire_date" required>
            </fieldset>

            <button type="submit" class="add-button">Add Coupon</button>
        </form>
    </section>

    <!-- Existing Coupons Section -->
    <section class="existing-coupons">
        <h2>Existing Coupons</h2>
        <div class="coupons-grid">
            <?php foreach ($coupons as $coupon): ?>
                <form method="POST" class="coupon-card">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    <input type="hidden" name="coupon_id" value="<?php echo $coupon['Coupon_ID']; ?>">
                    <input type="hidden" name="action" value="edit">

                    <fieldset>
                        <label for="coupon_code_<?php echo $coupon['Coupon_ID']; ?>">Coupon Code:</label>
                        <input type="text" name="coupon_code" id="coupon_code_<?php echo $coupon['Coupon_ID']; ?>" 
                               value="<?php echo htmlspecialchars($coupon['CouponCode']); ?>" required>

                        <label for="discount_amount_<?php echo $coupon['Coupon_ID']; ?>">Discount Amount:</label>
                        <input type="number" name="discount_amount" id="discount_amount_<?php echo $coupon['Coupon_ID']; ?>" 
                               value="<?php echo $coupon['DiscountAmount']; ?>" min="0" step="1" required>

                        <label for="expire_date_<?php echo $coupon['Coupon_ID']; ?>">Expire Date:</label>
                        <input type="date" name="expire_date" id="expire_date_<?php echo $coupon['Coupon_ID']; ?>" 
                               value="<?php echo $coupon['ExpireDate']; ?>" required>
                    </fieldset>

                    <div class="button-group">
                        <button type="submit" class="edit-button">Save Changes</button>
                        <button type="button" class="delete-button" 
                                onclick="confirmDelete(<?php echo $coupon['Coupon_ID']; ?>)">Delete Coupon</button>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </section>
</div>
</body>
</html>
