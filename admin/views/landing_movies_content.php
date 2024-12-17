<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
    <title>Manage Landing Page Movies</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/landing_movies.css">
</head>
<body>
<div class="container">
    <a href="/dwp/admin/dashboard" class="back-to-dashboard">
        <img src="../images/back-button.png" alt="">
    </a>

    <header>
        <h1>Manage Landing Page Movies</h1>
    </header>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <section class="add-movie">
        <h2>Add Movie to Landing Page</h2>
        <form method="POST" class="form-add">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="action" value="add">

            <fieldset>
                <label for="movie_id">Select Movie:</label>
                <select name="movie_id" id="movie_id" required>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo htmlspecialchars($movie['Movie_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars_decode($movie['Title'], ENT_QUOTES); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="display_order">Display Order:</label>
                <select name="display_order" id="display_order" required>
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <option value="<?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>" <?php echo in_array($i, $usedOrders) ? 'disabled' : ''; ?>>
                            <?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </fieldset>

            <button type="submit" class="add-button">Add Movie</button>
        </form>
    </section>

    <section class="existing-movies">
        <h2>Movies on Landing Page</h2>
        <div class="movies-grid">
            <?php foreach ($landingMovies as $movie): ?>
                <div class="movie-card">
                    <h3><?php echo htmlspecialchars_decode($movie['Title'], ENT_QUOTES); ?></h3>
                    <p>Display Order: <?php echo htmlspecialchars($movie['DisplayOrder'], ENT_QUOTES, 'UTF-8'); ?></p>

                    <form method="POST" class="form-update-order">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="landing_movie_id" value="<?php echo htmlspecialchars($movie['LandingMovie_ID'], ENT_QUOTES, 'UTF-8'); ?>">

                        <label for="new_display_order_<?php echo htmlspecialchars($movie['LandingMovie_ID'], ENT_QUOTES, 'UTF-8'); ?>">New Display Order:</label>
                        <select name="new_display_order" id="new_display_order_<?php echo htmlspecialchars($movie['LandingMovie_ID'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <option value="<?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>" <?php echo in_array($i, $usedOrders) ? 'disabled' : ''; ?>>
                                    <?php echo htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <button type="submit" class="edit-button">Update Order</button>
                    </form>

                    <form method="POST" class="form-delete">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="landing_movie_id" value="<?php echo htmlspecialchars($movie['LandingMovie_ID'], ENT_QUOTES, 'UTF-8'); ?>">

                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
</body>
</html>
