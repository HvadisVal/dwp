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
            max-width: 800px;
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

<?php include 'navbar.html'; ?>


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
            FilmFusion is your destination for an unparalleled cinema experience, blending the latest technology with a warm, welcoming ambiance. Located in the heart of MovieTown, FilmFusion features a mix of blockbuster films, independent cinema, and exclusive screenings that cater to all tastes.
        </p>
        <p>
            Our venue boasts luxurious reclining seats, advanced Dolby Atmos surround sound, and crystal-clear 4K projection in every theater. With spacious aisles, gourmet concessions, and a dedicated lounge for VIP members, FilmFusion transforms moviegoing into a memorable event.
        </p>
        <p>
            Whether you’re here for a family outing, a date night, or a solo escape into the magic of film, FilmFusion offers a viewing experience that’s both comfortable and captivating. Join us for seasonal film festivals, midnight premieres, and our signature “Retro Movie Nights” that celebrate the classics. FilmFusion—where the magic of cinema comes alive.
        </p>
    </section>

    <!-- Contact Information -->
    <section class="contact">
        <h3>Contact Us</h3>
        <p><strong>Email:</strong> <a href="mailto:contact@filmfusion.com" style="color: white; text-decoration: underline;">contact@filmfusion.com</a></p>
        <p><strong>Location:</strong> 123 Cinema Street, MovieTown, MT 12345</p>
        <p><strong>Opening Hours:</strong></p>
        <p>Mon-Fri: 10:00 AM - 11:00 PM</p>
        <p>Sat-Sun: 9:00 AM - 12:00 AM</p>
    </section>

    <!-- Footer -->
    <footer>
        © 2024 FilmFusion. All rights reserved.
    </footer>

</body>
</html>
