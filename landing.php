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
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
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
            background: linear-gradient(to right, #243642, #1a252d);
        }

        .logo {
            background: white;
            padding: 0.5rem 3rem;
            color: black;
            border-radius: 25px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            width: 70%;
            font-weight: bold;
            gap: 5rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
        }

        .cart-icon {
            color: white;
            background: white;
            padding: 0.5rem 3rem;
            border-radius: 25px;
            font-size: 1.5rem;
        }

        .hero-content {
        position: relative;
        z-index: 01;
        margin-left: 0; /* Add left margin for positioning */
        align-self: start; /* Center vertically */
    }

    .hero {
            background-image: url("https://image.api.playstation.com/vulcan/img/rnd/202011/0714/Cu9fyu6DM41JPekXLf1neF9r.png");
            height: 100vh;
            width: 100%;
            background-size: cover;
            padding: 2rem;
            position: relative;
            min-height: 600px;
            display: flex; /* Keep this */
            flex-direction: column; /* Keep this */
            justify-content: center; /* Keep this */
            overflow: visible;
        }

    .spider-man-img {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 90%;
            object-fit: contain;
    }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
            color: white;
        }

        .book-ticket {
            background: linear-gradient(to right, #243642, #1a252d);
            color: white;
            padding: 1rem 4rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            margin-top: 1rem;
            width: 300px;
            text-align: center;
            font-size: 1.2rem;
            transition: opacity 0.3s ease;
        }

        .info-cards {
            display: flex;
            gap: 2rem;
            padding: 0 2rem;
            margin-top: -80px;
            position: relative;
            z-index: 2;
        }

        .info-card {
            flex: 1;
            background: #1a1a1a;
            border-radius: 32px;
            overflow: hidden;
            position: relative;
            min-height: 280px;
        }

        .info-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .info-card-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
            background: linear-gradient(to bottom, rgba(0,0,0,0.7), rgba(0,0,0,0.9));
            height: 100%;
        }

        .info-card h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: white;
        }

        .info-card p {
            color: rgba(255,255,255,0.8);
            line-height: 1.6;
        }

        .cinema-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 2rem;
        }

        .cinema-card {
            background: #1a1a1a;
            border-radius: 25px;
            padding: 1rem;
            min-height: 200px;
        }

        .film-description {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 2rem;
            background: #474747;
            margin: 4rem 0 4rem auto;
            width: 80%;
            border-radius: 32px 0 0 32px;
            overflow: hidden;
        }

        .film-description img {
            width: 400px;
            height: 500px;
            object-fit: cover;
            border-radius: 32px 0 0 32px;
        }

        .film-description-content {
            padding: 4rem;
            color: white;
        }

        .film-description-content h2 {
            font-size: 2.5rem;
            
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .film-description-content p {
            line-height: 1.6;
           
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        @media (max-width: 1200px) {
            .film-description {
                width: 80%;
            }
        }

        @media (max-width: 768px) {
            .film-description {
            width: 100%;
            grid-template-columns: 1fr;
            border-radius: 32px;
            margin: 4rem 0;
        }

            .film-description img {
                width: 100%;
                height: 300px;
            }
        }
        .coming-soon {
            padding: 2rem;
        }

        .coming-soon h2 {
            margin-bottom: 1rem;
            font-size: 2rem;
            text-decoration: underline;
            color: white;
        }

        .movie-grid {
            display: flex;
            overflow-x: auto;
            gap: 1.5rem;
            padding: 1rem 0;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
            scrollbar-width: none; /* Firefox */
        }

        .movie-grid::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        .movie-card {
            flex: 0 0 auto;
            width: 250px; /* Fixed width for each card */
            border-radius: 16px;
            overflow: hidden;
        }

        .movie-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 16px;
        }



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


        @media (max-width: 768px) {
            .book-ticket {
                width: 100%;
            }
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
        <div class="hero-content">
            <h1>MARVEL<br>SPIDER-MAN<br>REMASTERED</h1>
            <a href="#" class="book-ticket">Book a ticket</a>
        </div>
    </div>

    <div class="info-cards">
        <div class="info-card">
            <img src="https://image.api.playstation.com/vulcan/img/rnd/202011/0714/Cu9fyu6DM41JPekXLf1neF9r.png" alt="Cinema content 1">
            <div class="info-card-content">
                <h3>Cinema website</h3>
                <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
        </div>
        <div class="info-card">
            <img src="https://image.api.playstation.com/vulcan/img/rnd/202011/0714/Cu9fyu6DM41JPekXLf1neF9r.png" alt="Cinema content 2">
            <div class="info-card-content">
                <h3>Cinema website</h3>
                <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
        </div>
    </div>

    <div class="film-description">
        <img src="https://upload.wikimedia.org/wikipedia/en/2/21/Web_of_Spider-Man_Vol_1_129-1.png" alt="Spider-Man">
        <div class="film-description-content">
            <h2>Film Description/News</h2>
            <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            <p>is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
        </div>
    </div>


    <div class="coming-soon">
        <h2>Soon Out ></h2>
        <div class="movie-grid">
            <div class="movie-card">
                <img src="https://images.squarespace-cdn.com/content/v1/62e7a6142cb04e2a55567a3a/5b2cf195-fc3c-44f8-aa49-07b096ca177a/amazing%2Bmarketing%2B-%2Bfilms%2B-%2Bghostbusters.jpg" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="https://images.squarespace-cdn.com/content/v1/62e7a6142cb04e2a55567a3a/5b2cf195-fc3c-44f8-aa49-07b096ca177a/amazing%2Bmarketing%2B-%2Bfilms%2B-%2Bghostbusters.jpg" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="https://images.squarespace-cdn.com/content/v1/62e7a6142cb04e2a55567a3a/5b2cf195-fc3c-44f8-aa49-07b096ca177a/amazing%2Bmarketing%2B-%2Bfilms%2B-%2Bghostbusters.jpg" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="https://images.squarespace-cdn.com/content/v1/62e7a6142cb04e2a55567a3a/5b2cf195-fc3c-44f8-aa49-07b096ca177a/amazing%2Bmarketing%2B-%2Bfilms%2B-%2Bghostbusters.jpg" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="https://images.squarespace-cdn.com/content/v1/62e7a6142cb04e2a55567a3a/5b2cf195-fc3c-44f8-aa49-07b096ca177a/amazing%2Bmarketing%2B-%2Bfilms%2B-%2Bghostbusters.jpg" alt="Movie poster">
            </div>
            <div class="movie-card">
                <img src="https://images.squarespace-cdn.com/content/v1/62e7a6142cb04e2a55567a3a/5b2cf195-fc3c-44f8-aa49-07b096ca177a/amazing%2Bmarketing%2B-%2Bfilms%2B-%2Bghostbusters.jpg" alt="Movie poster">
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
        <p><img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="email icon" style="width: 18px; margin-right: 8px;">esbjergcin@gmail.com</p>
        <p><a href="https://www.google.com/maps/place/A+Place+To+Hotel/@55.4790321,8.4309662,16z/data=!4m9!3m8!1s0x464b215865b4798f:0xf395d7933406e938!5m2!4m1!1i2!8m2!3d55.4790317!4d8.4350756!16s%2Fg%2F11sg5pg5wp?entry=ttu&g_ep=EgoyMDI0MTAyMS4xIKXMDSoASAFQAw%3D%3D"><img src="https://cdn-icons-png.flaticon.com/512/684/684908.png" alt="location icon" style="width: 18px; margin-right: 8px;">Grådybet 73C 6700 Esbjerg</a></p>
    </div>
    <div class="social-icons">
            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" style="width: 60px;">
            <img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/c4/Snapchat_logo.svg/1024px-Snapchat_logo.svg.png" alt="Snapchat" style="width: 60px;">
        </div>
</footer>

</body>
</html>