document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch('/dwp/user/login', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '/dwp/';
        } else {
            document.getElementById('loginMessage').textContent = data.message || 'Login failed.';
        }
    })
    .catch(error => {
        document.getElementById('loginMessage').textContent = 'An error occurred. Please try again.';
        console.error('Error:', error);
    });
});
