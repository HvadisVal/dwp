<?php
// Include functionality file
require_once 'landing.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Website</title>
    <link rel="stylesheet" href="/dwp/frontend/landing/style.css">
</head>
<body>
<?php include './frontend/navbar.php'; ?>

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
            <?php echo $newsHTML; ?>
        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </div>

    <div class="coming-soon">
    <a href="/dwp/movies"><h2>Today's screenings ></h2></a>
    <div class="movie-grid">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <a href="/dwp/movies">
                    <?php if (!empty($movie['FileName'])): ?>
                        <img src="uploads/poster/<?php echo htmlspecialchars($movie['FileName']); ?>" 
                             alt="<?php echo htmlspecialchars($movie['Title']); ?>" 
                             style="width: 100%; border-radius: 8px; margin-bottom: 10px;">
                    <?php else: ?>
                        <p>No Image Available</p>
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($movie['Title']); ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>



    <section class="about">
        <h2>About Us</h2>
        <p><?php echo htmlspecialchars($shortDescription); ?>...</p>
        <div class="readMore">
            <a href="/dwp/about"><p>Read More</p></a>
        </div>
    </section>

    <?php include './frontend/footer.php'; ?>
    <script src="/dwp/frontend/landing/javascript.js"></script>
</body>
</html>
