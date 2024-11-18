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
        
    /* Basic styles for the news slider */
.news-slider {
    position: relative;
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 10px; /* Optional: rounded corners for a polished look */
}

.news-slider h2 {
    font-size: 2rem;
    text-align: center;
    margin-bottom: 20px;
    font-family: 'Arial', sans-serif;
    color: white;
}

/* Slider container */
.slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

/* Each slider item (news article) */
.slider-item {
    min-width: 100%;
    padding: 60px;
    box-sizing: border-box;
    border-radius: 10px;
    text-align: center;
    background: linear-gradient(to right, #243642, #1a252d);
}

.slider-item img {
    width: 100%;  
    height: 400px;
    object-fit: cover;
    border-radius: 8px; 
    margin-bottom: 15px;
}

.slider-item h3 {
    font-size: 1.5rem;
    color: white;
    margin: 10px 0;
    font-weight: bold;
}

.slider-item p {
    font-size: 1rem;
    color: white;
    line-height: 1.5;
    margin-top: 20px;
}

/* Buttons for sliding */
button.prev, button.next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    font-size: 2rem;
    padding: 10px;
    cursor: pointer;
    z-index: 10;
}

button.prev {
    left: 10px;
}

button.next {
    right: 10px;
}

button.prev:hover, button.next:hover {
    background-color: black;
    
}

/* Responsive design */
@media (max-width: 768px) {
    .slider-item {
        padding: 10px;
    }

    .slider-item h3 {
        font-size: 1.2rem;
    }

    .slider-item p {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .slider-item h3 {
        font-size: 1rem;
    }

    .slider-item p {
        font-size: 0.8rem;
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


        @media (max-width: 768px) {
            .book-ticket {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>


    <div class="hero">
        <div class="hero-content">
            <h1>MARVEL<br>SPIDER-MAN<br>REMASTERED</h1>
            <a href="/dwp/movies" class="book-ticket">Book a ticket</a>
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

    <div class="news-slider">
    <h2>Film News</h2>
    <div class="slider">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "c5di1yb93_dwp"; // Replace with your actual database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch news along with the image from the Media table
        $sql = "SELECT n.Title, n.Content, n.DatePosted, m.FileName, m.Format
                FROM News n
                LEFT JOIN Media m ON n.News_ID = m.News_ID 
                ORDER BY n.DatePosted DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Loop through each news item and display it
            while ($row = $result->fetch_assoc()) {
                echo '<div class="slider-item">';

                
                // Assuming $imagePath is the correct path for your images
                if ($row['FileName']) {
                    // Construct the path
                    $imagePath = 'uploads/news_images/' . htmlspecialchars($row['FileName']);
                    echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row['Title']) . '" />';
                }


                echo '<h3>' . htmlspecialchars($row['Title']) . '</h3>';
                echo '<p>' . nl2br(htmlspecialchars($row['Content'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo "<p>No news found.</p>";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="next" onclick="moveSlide(1)">&#10095;</button>
</div>





    <script>
        let slideIndex = 0;

function showSlides() {
    let slides = document.querySelectorAll(".slider-item");
    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    }
    let slide = document.querySelector(".slider");
    slide.style.transform = "translateX(" + (-slideIndex * 100) + "%)";
}

function moveSlide(step) {
    slideIndex += step;
    showSlides();
}

// Initialize the slider
document.addEventListener("DOMContentLoaded", function() {
    showSlides();
});

    </script>


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

    <?php include 'footer.php'; ?>

</body>
</html>