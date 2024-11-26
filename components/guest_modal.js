document.addEventListener('DOMContentLoaded', function () {
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);
});

// Guest Checkout Form Submission
$('#guestForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '/dwp/frontend/user/guest.php',
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

