<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Website</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #000;
            color: white;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: #1a1a1a;
        }

        .logo {
            background: white;
            padding: 0.5rem 1rem;
            color: black;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .cart-icon {
            color: white;
            font-size: 1.5rem;
        }

        .hero {
            background: #8B0000;
            padding: 2rem;
            position: relative;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .book-ticket {
            background: #333;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            margin-top: 1rem;
        }

        .cinema-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 2rem;
        }

        .cinema-card {
            background: #1a1a1a;
            border-radius: 8px;
            padding: 1rem;
            min-height: 200px;
        }

        .film-description {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 2rem;
            padding: 2rem;
            background: #333;
        }

        .film-description img {
            width: 200px;
            border-radius: 8px;
        }

        .coming-soon {
            padding: 2rem;
        }

        .coming-soon h2 {
            margin-bottom: 1rem;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .movie-card img {
            width: 100%;
            border-radius: 8px;
        }

        footer {
            background: #1a1a1a;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        footer a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">logo</div>
        <div class="nav-links">
            <a href="#">NEWS</a>
            <a href="#">FILMS</a>
            <a href="#">TICKETS</a>
            <a href="#">ABOUT US</a>
        </div>
        <div class="cart-icon">🛒</div>
    </nav>

    <div class="hero">
        <h1>SPIDER-MAN<br>REMASTERED</h1>
        <a href="#" class="book-ticket">Book a ticket</a>
    </div>

    <div class="cinema-cards">
        <div class="cinema-card">
            <h3>Cinema website</h3>
            <p>Lorem ipsum text example</p>
        </div>
        <div class="cinema-card">
            <h3>Cinema website</h3>
            <p>Lorem ipsum text example</p>
        </div>
    </div>

    <div class="film-description">
        <img src="/api/placeholder/200/300" alt="Spider-Man poster">
        <div>
            <h2>Film Description/News</h2>
            <p>Lorem ipsum description text</p>
        </div>
    </div>

    <div class="coming-soon">
        <h2>Soon Out ></h2>
        <div class="movie-grid">
            <div class="movie-card">
                <img src="/api/placeholder/150/225" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="/api/placeholder/150/225" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="/api/placeholder/150/225" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="/api/placeholder/150/225" alt="Movie poster">
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-links">
            <a href="#">News</a>
            <a href="#">Films</a>
            <a href="#">Tickets</a>
            <a href="#">About Us</a>
        </div>
        <div class="contact-info">
            <h3>Contact Us</h3>
            <p>esbjergcin@gmail.com</p>
            <p>Grådybet 73C 6700 Esbjerg</p>
            <div class="social-icons">
                <span>📷</span>
                <span>👻</span>
            </div>
        </div>
    </footer>
</body>
</html>