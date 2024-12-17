<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Checkout</title>
    <link rel="stylesheet" href="/dwp/user/assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Guest Checkout</h2>
        <form id="guestForm" method="POST" action="/dwp/user/guest">
            <div>
                <label for="firstname">First Name:</label>
                <input type="text" name="firstname" id="firstname" required>
            </div>
            <div>
                <label for="lastname">Last Name:</label>
                <input type="text" name="lastname" id="lastname" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" id="phone" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
    <script>
        document.getElementById('guestForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('/dwp/user/guest', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Guest user created successfully!');
                    window.location.href = '/dwp/overview'; 
                } else {
                    alert(data.message || 'Failed to create guest user.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
