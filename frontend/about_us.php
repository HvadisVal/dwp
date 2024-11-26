<?php
// Include the database connection file
require_once 'dbcon.php';

// Connect to the database
$conn = dbCon($user, $pass);

// Query to retrieve Location and Email
$sql = "SELECT Location, Email, OpeningHours, Description FROM Company LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if data was retrieved
$location = $result['Location'] ?? 'N/A';
$email = $result['Email'] ?? 'N/A';
$openingHours = $result['OpeningHours'] ?? 'N/A';
$description = $result['Description'] ?? 'N/A';
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FilmFusion</title>
    <style>
        * {
    box-sizing: border-box!important;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif!important;
}

body {
    background: #000!important;
    color: white!important;
}

/* Hero Section */
.hero {
    height: 100vh!important;
    background: url('https://m.economictimes.com/thumb/msid-104359417,width-1200,height-900,resizemode-4,imgsize-54656/cinema-halls1.jpg') no-repeat center center/cover!important;
    display: flex!important;
    align-items: center!important;
    justify-content: center!important;
    text-align: center!important;
    padding: 0 20px!important;
}
.hero h1 {
    font-size: 48px!important;
    font-weight: 600!important;
    margin-bottom: 20px!important;
    color: #ffffff!important;
}
.hero p {
    font-size: 18px!important;
    max-width: 800px!important;
    margin: 0 auto!important;
    color: #dcdcdc!important;
}

/* About Section */
.about {
    padding: 80px 40px!important;
    background-color: #2c2c2c!important;
}
.about h2 {
    text-align: center!important;
    font-size: 36px!important;
    margin-bottom: 20px!important;
    color: white!important;
}
.about p {
    max-width: 1100px!important;
    margin: 0 auto 20px auto!important;
    font-size: 18px!important;
    color: white!important;
}

/* Contact Information */
.contact {
    background-color: #1c1c1c!important;
    padding: 60px 40px!important;
    display: flex!important;
    flex-direction: column!important;
    align-items: center!important;
}
.contact h3 {
    font-size: 28px!important;
    margin-bottom: 10px!important;
    color: white!important;
}
.contact p {
    font-size: 16px!important;
    margin: 10px 0!important;
    color: white!important;
}

.openingH {
    width: 250px!important;
    display: flex!important;
    text-align: center!important; 
}

/* Footer */
footer {
    background-color: #000!important;
    color: #777!important;
    text-align: center!important;
    padding: 20px 40px!important;
    font-size: 14px!important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column!important;
        align-items: flex-start!important;
    }
    .navbar .menu {
        margin-top: 10px!important;
    }
    .hero h1 {
        font-size: 32px!important;
    }
    .about h2 {
        font-size: 28px!important;
    }
}

    </style>
</head>
<body>

<?php include 'frontend/navbar/navbar_structure.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Welcome to FilmFusion</h1>
            <p>Experience movies like never before in the heart of MovieTown.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <h2>About Us</h2>
        <p>
        <?php echo htmlspecialchars($description); ?>
        </p>
       
    </section>

    <!-- Contact Information -->
    <section class="contact">
        <h3>Contact Us</h3>
        <p>
            <strong>Email:</strong> 
                <a href="mailto:<?php echo htmlspecialchars($email); ?>" style="color: white; text-decoration: underline;">
                    <?php echo htmlspecialchars($email); ?>
                </a>
            </p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></p>
        <p><strong>Opening Hours:</strong></p>
        <p class="openingH"><?php echo htmlspecialchars($openingHours); ?></p>
       
        
    </section>

    <!-- Footer -->
    <footer>
        © 2024 FilmFusion. All rights reserved.
    </footer>

</body>
</html>
