// Login Form Submission
$('#loginForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: '/dwp/user/login',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            if (response.success) {
                location.reload(); // Reload page if login is successful
            } else {
                $('.error-message').text(response.message).show();
            }
        },
        error: function (xhr, status, error) {
            console.error("Login error:", status, error);
        }
    });
});

// New User Form Submission
$('#newUserForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: '/dwp/user/new_user', // Adjust the path as needed
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            if (response.success) {
                const modalInstance = M.Modal.getInstance(document.getElementById('newUserModal'));
                modalInstance.close(); // Close the modal after success
                M.toast({ html: 'User account created successfully! Please login.' });
            } else {
                $('.error-message').text(response.message).show();
            }
        },
        error: function (xhr, status, error) {
            console.error("New User error:", status, error);
        }
    });
});

 // Logout Button
 $(document).on('click', '#logoutButton', function () {
    $.ajax({
        url: '/dwp/user/logout', // Path to your logout script
        type: 'POST',
        success: function (response) {
            if (response.success) {
                location.reload(); // Reload the page to show the login button
            } else {
                console.error('Logout failed:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Logout error:', status, error);
        },
    });
});


// Initialize Materialize Modals
document.addEventListener('DOMContentLoaded', function () {
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);
});
