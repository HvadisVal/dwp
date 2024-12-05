<!-- admin/views/landing_movies_content.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo $csrfToken; ?>">
    <title>Manage landingpage Movies</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/landing_movies.css">
</head>
<body>
<div class="container">
    <a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt=""></a>

    <header>
        <h1>Manage landingpage Movies</h1>
    </header>
    <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="message">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <!-- Add Movie Section -->
    <section class="add-movie">
        <h2>Add Movie to landingpage</h2>
        <form method="POST" class="form-add">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="action" value="add">

            <fieldset>
                <label for="movie_id">Select Movie:</label>
                <select name="movie_id" id="movie_id" required>
                    <?php foreach ($movies as $movie): ?>
                        <option value="<?php echo $movie['Movie_ID']; ?>"><?php echo $movie['Title']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="display_order">Display Order:</label>
                <select name="display_order" id="display_order" required>
                    <!-- Dynamically generate options from 1 to 3, excluding used orders -->
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo in_array($i, $usedOrders) ? 'disabled' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </fieldset>

            <button type="submit" class="add-button">Add Movie</button>
        </form>
    </section>

    <!-- Existing landingpage Movies Section -->
    <section class="existing-movies">
        <h2>Movies on landingpage</h2>
        <div class="movies-grid">
            <?php foreach ($landingMovies as $movie): ?>
                <div class="movie-card">
                    <h3><?php echo htmlspecialchars($movie['Title']); ?></h3>
                    <p>Display Order: <?php echo $movie['DisplayOrder']; ?></p>

                    <!-- Update Display Order -->
                    <form method="POST" class="form-update-order">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="landing_movie_id" value="<?php echo $movie['LandingMovie_ID']; ?>">

                        <label for="new_display_order_<?php echo $movie['LandingMovie_ID']; ?>">New Display Order:</label>
                        <select name="new_display_order" id="new_display_order_<?php echo $movie['LandingMovie_ID']; ?>" required>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo in_array($i, $usedOrders) ? 'disabled' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <button type="submit" class="edit-button">Update Order</button>
                    </form>

                    <!-- Delete Movie -->
                    <form method="POST" class="form-delete">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="landing_movie_id" value="<?php echo $movie['LandingMovie_ID']; ?>">

                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
</body>
</html>
