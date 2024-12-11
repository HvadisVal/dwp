<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies Schedule</title>
    <link rel="stylesheet" href="/dwp/frontend/assets/css/movies.css">
</head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/controllers/NavbarController.php';
$navbar = new NavbarController();
$navbar->handleRequest();
 ?>
 
 
 <div class="container">
    <div class="week-navigation">
        <?php if ($offset > 0): ?>
            <a href="?week_offset=<?= $offset - 1 ?>" id="prev-week" class="nav-button">❮ Previous Week</a>
        <?php endif; ?>
        <a href="?week_offset=<?= $offset + 1 ?>" id="next-week" class="nav-button">Next Week ❯</a>
    </div>

    <div id="schedule-container">
        <?php foreach ($moviesById as $movieId => $movieData): ?>
            <div class="movie-container">
                <!-- Movie Information -->
                <div class="movie-info">
                    <?php if (!empty($movieData['details']['PosterPath'])): ?>
                        <div class="movie-poster">
                            <a href="/dwp/movie?movie_id=<?= urlencode($movieId); ?>">
                                <?php foreach ($movieData['details']['PosterPath'] as $imagePath): ?>
                                    <img src="<?= htmlspecialchars($imagePath); ?>" alt="<?= htmlspecialchars($movieData['details']['Title']); ?>" class="poster">
                                <?php endforeach; ?>
                            </a>     
                        </div> 
                    <?php endif; ?>

                    <div class="movie-details">
                        <h4><?= htmlspecialchars($movieData['details']['Title']); ?></h4>
                        <p>Duration: <?= htmlspecialchars($movieData['details']['Duration']); ?></p>
                        <p>Rating: <?= htmlspecialchars($movieData['details']['Rating']); ?></p>
                        <p>Age Limit: Allowed for children over <?= htmlspecialchars($movieData['details']['Rating']); ?> years</p>
                    </div>
                </div>

                <!-- Movie Showtimes by Date (Vertically) -->
                <div class="schedule">
                    <?php foreach ($allDates as $date): ?>
                        <div class="date-column">
                            <div class="date-header">
                                <?= date("D, d/m", strtotime($date)); ?>
                            </div>
                            <?php if (isset($movieData['showtimes'][$date])): ?>
                                <?php foreach ($movieData['showtimes'][$date] as $showtime): ?>
                                    <a href="/dwp/frontend/controllers/initialize_booking.php?movie_id=<?= htmlspecialchars($showtime['Movie_ID']); ?>&cinema_hall_id=<?= htmlspecialchars($showtime['CinemaHall_ID']); ?>&time=<?= urlencode($showtime['ShowTime']); ?>&date=<?= urlencode($showtime['ShowDate']); ?>" class="showtime-card">
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
        <?php endforeach; ?>
    </div>
</div>
