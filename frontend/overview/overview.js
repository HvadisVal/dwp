document.addEventListener('DOMContentLoaded', function () {
    // Initialize Materialize modals
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    // Logout AJAX request
    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function () {
            $.ajax({
                type: 'POST',
                url: '/dwp/user/logout',
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        location.reload();
                    } else {
                        console.error("Logout failed");
                    }
                },
                error: function () {
                    console.error("An error occurred during logout");
                }
            });
        });
    }

    // Switch User AJAX request
    const switchUserButton = document.getElementById('switchUserButton');
    if (switchUserButton) {
        switchUserButton.addEventListener('click', function () {
            $.ajax({
                type: 'POST',
                url: '/dwp/frontend/user/switch_user.php',
                success: function (response) {
                    try {
                        const data = typeof response === "string" ? JSON.parse(response) : response;
                        if (data.success) {
                            location.reload();
                        } else {
                            M.toast({ html: data.message || "Failed to switch user. Please try again." });
                        }
                    } catch (e) {
                        console.error("Invalid JSON response:", response);
                        M.toast({ html: "An unexpected error occurred." });
                    }
                },
                error: function () {
                    console.error("AJAX request failed");
                    M.toast({ html: "Unable to switch user at the moment. Try again later." });
                }
            });
        });
    }

    // Apply Coupon Code
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

            fetch('/dwp/validate-coupon', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ couponCode })
            })
            .then(response => response.json())
            .then(data => {
                const couponMessage = document.getElementById('couponMessage');
                const modalTotalPrice = document.getElementById('modalTotalPrice');

                if (data.valid) {
                    couponMessage.style.color = 'green';
                    couponMessage.textContent = `Coupon applied! You saved DKK ${data.discount}.`;
                    modalTotalPrice.textContent = `DKK ${data.newTotalPrice}`;
                } else {
                    couponMessage.style.color = 'red';
                    couponMessage.textContent = data.message;
                }
                couponMessage.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }

    // Payment Button Click Event
    const payButton = document.getElementById('payButton');
    if (payButton) {
        payButton.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent any form submission

            // Show the payment confirmation modal
            const paymentConfirmationModal = document.getElementById('paymentConfirmationModal');
            const modalInstance = M.Modal.getInstance(paymentConfirmationModal);
            modalInstance.open();
        });
    }
});
