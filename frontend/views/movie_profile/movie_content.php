<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movieDetails['Title']); ?> - Movie Details</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/movie_profile.css">
</head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
$navbar = new NavbarController();
$navbar->handleRequest();
 ?>
 
<div class="container">
    <!-- Movie Information Section -->
    <div class="movie-container">
        <div class="movie-info">
            <!-- Movie Poster -->
            <?php if (!empty($movieDetails['PosterFiles'])): ?>
                <div class="movie-poster">
                    <?php foreach ($movieDetails['PosterFiles'] as $imagePath): ?>
                        <img src="<?= "./uploads/poster/" . htmlspecialchars($imagePath); ?>" alt="<?= htmlspecialchars($movieDetails['Title']); ?>" class="poster">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Movie Details (Title, Description, Director, etc.) -->
            <div class="movie-details">
                <h4><?= htmlspecialchars($movieDetails['Title']); ?></h4>
                <p><strong>Duration:</strong> <?= htmlspecialchars($movieDetails['Duration']); ?></p>
                <p><strong>Allowed for children over</strong> <?= htmlspecialchars(string: $movieDetails['AgeLimit']); ?> years</p>
                <p><strong>Rating:</strong> <?= htmlspecialchars(string: $movieDetails['Rating']); ?> </p>
                <p><strong>Director:</strong> <?= htmlspecialchars($movieDetails['Director']); ?></p>
                <p><strong>Language:</strong> <?= htmlspecialchars($movieDetails['Language']); ?></p>
                <p><strong>Year:</strong> <?= htmlspecialchars($movieDetails['Year']); ?></p>
                <p><strong>Description:</strong> 
                    <span id="short-description"><?= htmlspecialchars(substr($movieDetails['Description'], 0, 200)); ?>...</span>
                    <span id="full-description" style="display: none;"><?= nl2br(htmlspecialchars($movieDetails['Description'])); ?></span>
                    <a href="javascript:void(0);" id="expand-description" onclick="toggleDescription()">Read more</a>
                </p>

            </div>
        </div>
    </div>

    <!-- Gallery and Trailer Section -->
    <div class="gallery-trailer-section">
        <!-- Movie Gallery -->
        <?php if (!empty($movieDetails['GalleryFiles'])): ?>
            <div class="movie-gallery">
                <h5>Gallery</h5>
                <div class="gallery-images">
                    <?php foreach ($movieDetails['GalleryFiles'] as $imagePath): ?>
                        <img src="<?= "./uploads/gallery/" . htmlspecialchars($imagePath); ?>" alt="Gallery Image" class="gallery-image">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Movie Trailer Section -->
<div class="movie-trailer">
    <h4>Watch the Trailer</h4>
    <div class="trailer-container">
        <iframe width="560" height="315" 
                src="<?= nl2br(htmlspecialchars($movieDetails['TrailerLink'])); ?>" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" 
                allowfullscreen>
        </iframe>
    </div>
</div>




    <!-- Movie Screening Schedule Section -->
    <h5>Screening Schedule</h5>
    <div class="schedule">
        <?php foreach ($allDates as $date): ?>
            <div class="date-column">
                <div class="date-header">
                    <?= date("D, d/m", strtotime($date)); ?>
                </div>

                <?php if (isset($movieDetails['Showtimes'][$date])): ?>
                    <?php foreach ($movieDetails['Showtimes'][$date] as $showtime): ?>
                        <a href="/dwp/frontend/controllers/initialize_booking.php?movie_id=<?= htmlspecialchars($movieDetails['Movie_ID']); ?>&cinema_hall_id=<?= htmlspecialchars($showtime['CinemaHall_ID']); ?>&time=<?= urlencode($showtime['ShowTime']); ?>&date=<?= urlencode($date); ?>" class="showtime-card">
    <h6><?= htmlspecialchars($showtime['CinemaHall_Name']); ?></h6>
    <h6><?= date("g:i a", strtotime($showtime['ShowTime'])); ?></h6>
    <div class="version"><?= htmlspecialchars($showtime['Version'] ?? 'Standard'); ?></div>
</a>


                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-showtimes">No screenings available</div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
<script src="/dwp/frontend/assets/js/movie_profile.js"></script>
</body>
</html>
