
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Website</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/landing.css">
</head>
<body>
    
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
$navbar = new NavbarController();
$navbar->handleRequest();
 ?>


<div class="hero">
    <?php if (!empty($landingMovies)): ?>
        <img src="uploads/gallery/<?php echo htmlspecialchars($landingMovies[0]['FileName']); ?>" alt="<?php echo htmlspecialchars($landingMovies[0]['Title']); ?>">
        <div class="hero-content">
            <h1><?php echo htmlspecialchars($landingMovies[0]['Title']); ?></h1>
            <?php if (empty($landingMovies[0]['FirstScreeningDate'])): ?>
                <p>Coming Soon</p>
            <?php else: ?>
                <p>From: <?php echo date('F j, Y', strtotime($landingMovies[0]['FirstScreeningDate'])); ?></p>
            <?php endif; ?>
            <a href="/dwp/movie?movie_id=<?php echo $landingMovies[0]['Movie_ID']; ?>" class="book-ticket">Read more</a>
        </div>
    <?php else: ?>
        <p>No movies available to display.</p>
    <?php endif; ?>
</div>


<div class="info-cards">
<?php if (!empty($landingMovies)): ?>
    <div class="info-card">
        <img src="uploads/gallery/<?php echo htmlspecialchars($landingMovies[0]['FileName']); ?>" alt="<?php echo htmlspecialchars($landingMovies[0]['Title']); ?>">
        <div class="info-card-content">
                <h3>Description</h3>
                <p><?php echo htmlspecialchars($landingMovies[0]['Description']); ?></p>
            </div>
        </div>
        <?php else: ?>
        <p>No movies available to display.</p>
    <?php endif; ?>
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
    <a href="/dwp/movies"><h2>Screenings ></h2></a>
    <div class="filter-container">
    <div class="filters">
            <!-- Date Filter -->
            <select id="select-date" class="filter-dropdown">
                <option value="" disabled selected>Select date</option>
                <?php foreach ($dates as $date): ?>
                    <option value="<?php echo htmlspecialchars($date['ShowDate']); ?>">
                        <?php echo htmlspecialchars(date("F j, Y", strtotime($date['ShowDate']))); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Movie Filter -->
            <select id="select-movie" class="filter-dropdown">
                <option value="" disabled selected>Select movie</option>
                <?php foreach ($movies as $movie): ?>
                    <option value="<?php echo htmlspecialchars($movie['Movie_ID']); ?>">
                        <?php echo htmlspecialchars($movie['Title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Version Filter -->
            <select id="select-version" class="filter-dropdown">
                <option value="" disabled selected>Select version</option>
                <?php foreach ($versions as $version): ?>
                    <option value="<?php echo htmlspecialchars($version['Version_ID']); ?>">
                        <?php echo htmlspecialchars($version['Format']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Reset Filters Button -->
        <button id="reset-filters" class="reset-button">Reset Filters</button>
    </div>
    <div class="movie-grid">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <a href="/dwp/movie?movie_id=<?php echo htmlspecialchars($movie['Movie_ID']); ?>">
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

    <script src="/dwp/frontend/assets/js/landing.js"></script>
</body>
</html>
