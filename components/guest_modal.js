document.addEventListener('DOMContentLoaded', function () {
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



function onCaptchaCompleted() {
    // Enable the "Continue" button
    $('#continueButton').prop('disabled', false);
    console.log('CAPTCHA verified. Login button enabled.');
}



   $(document).ready(function() {
    // Handle the login form submission
    $('#guestForm').submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        var username = $('#username').val();
        var password = $('#password').val();
        var captchaResponse = grecaptcha.getResponse(); // Get the reCAPTCHA response

        // Ensure the CAPTCHA is completed
        if (!captchaResponse || captchaResponse.length === 0) {
            $('.error-message');
            return; // Stop further execution if CAPTCHA is not filled
        }

        // Submit the form data using AJAX
        $.ajax({
            url: 'guest_modal.php',  // Use the current PHP file
            method: 'POST',
            data: {
                username: username,
                password: password,
                'g-recaptcha-response': captchaResponse
            },
            success: function(response) {
                if (response.trim() === 'CAPTCHA verified. Proceeding with login...') {
                    // Redirect or update UI for successful login
                    alert('Login successful!');
                } else {
                    // Handle error, for example invalid credentials or CAPTCHA failure
                    $('.error-message').text(response).show();
                }
            },
        });
    });
});


// Initialize Materialize Modals
document.addEventListener('DOMContentLoaded', function () {
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);
});




