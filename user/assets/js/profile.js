document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.getElementById('editUserButton');
    const editModal = document.getElementById('editUserModal');
    const modalInstance = M.Modal.getInstance(editModal);

    if (editButton) {
        editButton.addEventListener('click', function () {
            modalInstance.open(); 
        });
    } else {
        console.error('Edit Information button not found');
    }
});

document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('/dwp/user/edit_user', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            const editModal = document.getElementById('editUserModal');
            const modalInstance = M.Modal.getInstance(editModal);

            if (data.success) {
                M.toast({ html: 'Profile updated successfully.', classes: 'green' });
                modalInstance.close(); 
                setTimeout(() => location.reload(), 1000); 
            } else {
                M.toast({ html: data.message, classes: 'red' });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            M.toast({ html: 'An error occurred.', classes: 'red' });
        });
});


document.getElementById('deleteAccountButton').addEventListener('click', function () {
    if (confirm('Are you sure you want to delete your account?')) {
        fetch('/dwp/user/delete_user', {
            method: 'POST',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    M.toast({ html: data.message });
                    window.location.href = '/dwp/landing';
                } else {
                    M.toast({ html: data.message, classes: 'red' });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                M.toast({ html: 'An error occurred while deleting the account.', classes: 'red' });
            });
    }
});




