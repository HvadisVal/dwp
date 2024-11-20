// Edit User
document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.getElementById('editUserButton');
    const editModal = document.getElementById('editUserModal');
    const modalInstance = M.Modal.getInstance(editModal);

    if (editButton) {
        editButton.addEventListener('click', function () {
            modalInstance.open(); // Open the modal
        });
    } else {
        console.error('Edit Information button not found');
    }
});

document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/dwp/frontend/user/profile/edit_user.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            const editModal = document.getElementById('editUserModal');
            const modalInstance = M.Modal.getInstance(editModal);

            if (data.success) {
                M.toast({ html: 'Profile updated successfully.', classes: 'green' });
                modalInstance.close(); // Close the modal
                setTimeout(() => location.reload(), 1000); // Reload after success
            } else {
                M.toast({ html: data.message, classes: 'red' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            M.toast({ html: 'An error occurred.', classes: 'red' });
        });
});



// Delete Account
document.getElementById('deleteAccountButton').addEventListener('click', function () {
    if (confirm('Are you sure you want to delete your account?')) {
        fetch('/dwp/frontend/user/profile/delete_user.php', {
            method: 'POST',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    M.toast({ html: data.message });
                    window.location.href = '/dwp/frontend/user/login.php'; // Redirect after deletion
                } else {
                    M.toast({ html: data.message, classes: 'red' });
                }
            })
            .catch(error => console.error('Error:', error));
    }
});
