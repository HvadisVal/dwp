document.addEventListener('DOMContentLoaded', function() {
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);
});



// Guest Checkout Form Submission
$('#guestForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '/dwp/user/guest',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            response = JSON.parse(response);
            if (response.success) {
                location.reload(); // Reload page to display guest info
            } else {
                $('.error-message').text(response.message).show();
            }
        }
    });
});

// New User Form Submission
$('#newUserForm').on('submit', function(e) {
e.preventDefault();
$.ajax({
    url: '/dwp/user/new_user',
    type: 'POST',
    data: $(this).serialize(),
    dataType: 'json',  // Ensure response is expected as JSON
    success: function(response) {
        if (response.success) {
            const modalInstance = M.Modal.getInstance(document.getElementById('newUserModal'));
            modalInstance.close(); // Close the modal after success
            M.toast({html: 'User account created successfully! Please login.'});
        } else {
            $('.error-message').text(response.message).show();
        }
    },
    error: function(xhr, status, error) {
        console.error("An error occurred:", status, error);
        $('.error-message').text("An error occurred while creating the account. Please try again.").show();
    }
});
});


// Logout AJAX request
$('#logoutButton').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/dwp/user/logout',
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                location.reload();
            } else {
                console.error("Logout failed");
            }
        },
        error: function() {
            console.error("An error occurred during logout");
        }
    });
});

// Switch User AJAX request
$('#switchUserButton').on('click', function() {
    $.ajax({
        type: 'POST',
        url: '/dwp/user/switch',
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                location.reload(); // Reload page to reset to the initial state
            } else {
                console.error("Failed to switch user");
            }
        },
        error: function() {
            console.error("An error occurred while switching user");
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
// Initialize Materialize modals
var modals = document.querySelectorAll('.modal');
M.Modal.init(modals);

// Apply Coupon Code
document.getElementById('applyCoupon').addEventListener('click', function() {
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
});

document.addEventListener('DOMContentLoaded', function() {
// Initialize Materialize modals
var modals = document.querySelectorAll('.modal');
M.Modal.init(modals);

// Payment Button Click Event
document.getElementById('payButton').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent any form submission

    // Show the payment confirmation modal
    const paymentConfirmationModal = document.getElementById('paymentConfirmationModal');
    const modalInstance = M.Modal.getInstance(paymentConfirmationModal);
    modalInstance.open();
});
});

