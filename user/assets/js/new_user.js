$(document).ready(function() {
    $('#newUserForm').on('submit', function(event) {
        event.preventDefault();
        $('#message').removeClass('success-message error-message').text('');

        $.ajax({
            url: '', // Submitting to the same page
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#message').addClass('success-message').text(response.message);
                    $('#newUserForm')[0].reset(); // Reset the form
                } else {
                    $('#message').addClass('error-message').text(response.message);
                }
            },
            error: function() {
                $('#message').addClass('error-message').text("An error occurred while processing the request.");
            }
        });
    });
});