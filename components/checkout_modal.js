document.addEventListener('DOMContentLoaded', function () {
    // Initialize Materialize Modals
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    // Apply Coupon Logic
    const applyCouponButton = document.getElementById('applyCoupon');
    if (applyCouponButton) {
        applyCouponButton.addEventListener('click', function () {
            const couponCode = document.getElementById('couponCode').value.trim();
            if (!couponCode) {
                const couponMessage = document.getElementById('couponMessage');
                couponMessage.style.color = 'red';
                couponMessage.textContent = "Please enter a coupon code.";
                couponMessage.style.display = 'block';
                return;
            }

            fetch('/dwp/frontend/payment/validate_coupon.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ couponCode })
            })
                .then(response => response.json())
                .then(data => {
                    const couponMessage = document.getElementById('couponMessage');
                    const totalPriceDisplay = document.getElementById('totalPriceDisplay');

                    if (data.valid) {
                        couponMessage.style.color = 'green';
                        couponMessage.textContent = `Coupon applied! You saved DKK ${data.discount}.`;
                        totalPriceDisplay.textContent = `DKK ${data.newTotalPrice.toFixed(2)}`;
                    } else {
                        couponMessage.style.color = 'red';
                        couponMessage.textContent = data.message;
                    }
                    couponMessage.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error applying coupon:', error);
                });
        });
    }

    // Checkout Form Submission
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Simulated Payment Logic
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            console.log('Processing payment with method:', paymentMethod);
            alert('Payment processed successfully!');

            // Close the modal
            const modalInstance = M.Modal.getInstance(document.getElementById('checkoutModal'));
            modalInstance.close();
        });
    }
});
