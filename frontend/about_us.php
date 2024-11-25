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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        body {
            background: #000;
            color: white;
        }

        
        /* Hero Section */
        .hero {
            height: 100vh;
            background: url('https://m.economictimes.com/thumb/msid-104359417,width-1200,height-900,resizemode-4,imgsize-54656/cinema-halls1.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 20px;
        }
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .hero p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
            color: #dcdcdc;
        }

        /* About Section */
        .about {
            padding: 80px 40px;
            background-color: #2c2c2c;
        }
        .about h2 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
            color: white;
        }
        .about p {
            max-width: 1100px;
            margin: 0 auto 20px auto;
            font-size: 18px;
            color: white;
            
        }

        /* Contact Information */
        .contact {
            background-color: #1c1c1c;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .contact h3 {
            font-size: 28px;
            margin-bottom: 10px;
            color: white;
        }
        .contact p {
            font-size: 16px;
            margin: 10px 0;
            color: white;
        }

        .openingH{
            width: 250px;
            display: flex;
            text-align: center; 
              
        }

        /* Footer */
        footer {
            background-color: #000;
            color: #777;
            text-align: center;
            padding: 20px 40px;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }
            .navbar .menu {
                margin-top: 10px;
            }
            .hero h1 {
                font-size: 32px;
            }
            .about h2 {
                font-size: 28px;
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
