<?php
// Include the database connection file
require_once 'dbcon.php';

// Connect to the database
$conn = dbCon($user, $pass);

// Query to retrieve Location and Email
$sql = "SELECT Location, Email FROM Company LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data was retrieved
$location = $result['Location'] ?? 'N/A';
$email = $result['Email'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        footer {
            background: linear-gradient(to right, #243642, #1a252d);
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center; 
            gap: 2rem;
        }

        .footer-links {
            display: flex;
            text-decoration: underline;
            flex-direction: column;
            gap: 1rem;
        }

        footer a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .contact-info h3 {
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .contact-info p {
            color: white;
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 1.5rem; /* Increase gap for more spacing */
            align-items: center;
            margin-top: 1rem;
        }

        .social-icons img {
            padding: 8px;
            transition: transform 0.3s ease, background-color 0.3s ease; 
            cursor: pointer;
        }

        .social-icons img:hover {
            transform: scale(1.1); 
            background-color: #f09433; 
        }
    </style>
</head>
<body>
<footer>
    <div class="footer-links">
        <a href="#">News</a>
        <a href="#">Films</a>
        <a href="#">Tickets</a>
        <a href="#">About Us</a>
    </div>
    <div class="contact-info">
        <h3>Contact Us</h3>
        <p><img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="email icon" style="width: 18px; margin-right: 8px;">
           <?php echo htmlspecialchars($email); ?></p>
        <p><a href="https://www.google.com/maps/search/<?php echo urlencode($location); ?>" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="location icon" style="width: 18px; margin-right: 8px;">
            <?php echo htmlspecialchars($location); ?>
        </a></p>
    </div>
    <div class="social-icons">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" style="width: 60px;">
        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/c4/Snapchat_logo.svg/1024px-Snapchat_logo.svg.png" alt="Snapchat" style="width: 60px;">
    </div>
</footer>
</body>
</html>
