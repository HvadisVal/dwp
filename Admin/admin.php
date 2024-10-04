<?php require_once "../dbcon.php"; ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php //confirm_logged_in(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Overview</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: black;
            color: white;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #1a1a1a;
        }

        header img {
            width: 50px;
            cursor: pointer;
        }

        nav {
            display: flex;
            gap: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .hero-section {
            background-color: #e50914;
            padding: 50px;
            text-align: center;
            position: relative;
        }

        .hero-section img {
            width: 200px;
        }

        .hero-section h1 {
            font-size: 50px;
            margin: 20px 0;
        }

        .hero-section .cta {
            margin: 20px 0;
        }

        .cta button {
            background-color: white;
            color: black;
            padding: 15px 30px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            font-weight: bold;
        }

        .content-section {
            display: flex;
            padding: 20px;
            justify-content: space-around;
            text-align: center;
        }

        .content-section div {
            width: 30%;
        }

        .content-section img {
            width: 100%;
            border-radius: 15px;
        }

        .film-description {
            padding: 20px;
            text-align: justify;
            background-color: #333;
            margin: 20px auto;
            max-width: 90%;
            border-radius: 15px;
        }

        .soon-out-section {
            padding: 20px;
            text-align: center;
        }

        .soon-out-section h2 {
            font-size: 30px;
        }

        .soon-out-section img {
            width: 150px;
            border-radius: 10px;
            margin: 10px;
        }

        footer {
            background-color: #1a1a1a;
            padding: 20px;
            display: flex;
            justify-content: space-around;
        }

        footer div {
            flex: 1;
            text-align: center;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
        }

        .footer-section div {
            margin: 10px 20px;
        }

        .footer-section h3 {
            margin-bottom: 10px;
            color: #e50914;
        }

        footer address {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <header>
        <img src="path-to-logo.png" alt="Logo">
        <nav>
            <a href="#">News</a>
            <a href="#">Films</a>
            <a href="#">Tickets</a>
            <a href="#">About</a>
            <a href="#">More</a>
        </nav>
        <img src="path-to-cart-icon.png" alt="Cart">
    </header>

    <section class="hero-section">
        <img src="path-to-spiderman-image.png" alt="Spider-Man Remastered">
        <h1>SPIDER-MAN REMASTERED</h1>
        <div class="cta">
            <button>Book Ticket</button>
        </div>
    </section>

    <section class="content-section">
        <div>
            <img src="path-to-cinema-image1.png" alt="Cinema Website Image 1">
            <p>Cinema Website Description</p>
        </div>
        <div>
            <img src="path-to-cinema-image2.png" alt="Cinema Website Image 2">
            <p>Cinema Website Description</p>
        </div>
    </section>

    <section class="film-description">
        <h2>Film Description</h2>
        <p>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
        </p>
    </section>

    <section class="soon-out-section">
        <h2>Soon Out &gt;</h2>
        <div>
            <img src="path-to-movie-image1.png" alt="Movie 1">
            <img src="path-to-movie-image2.png" alt="Movie 2">
            <img src="path-to-movie-image3.png" alt="Movie 3">
        </div>
    </section>

    <footer>
        <div class="footer-section">
            <div>
                <h3>Menu</h3>
                <a href="#">News</a><br>
                <a href="#">Films</a><br>
                <a href="#">Tickets</a><br>
                <a href="#">About</a><br>
                <a href="#">More</a>
            </div>

            <div>
                <h3>Contact Us</h3>
                <address>
                    Gradybet 73C, 110<br>
                    Esbjerg 6700<br>
                    <a href="mailto:esbjerghcinema@gmail.com">esbjerghcinema@gmail.com</a>
                </address>
            </div>

            <div>
                <h3>Follow Us</h3>
                <p>Social Media Links Here</p>
            </div>
        </div>
    </footer>
<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
