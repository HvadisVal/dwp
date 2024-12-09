

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="/dwp/admin/assets/css/movies.css" />
</head>
<body>
    
<a href="/dwp/admin/dashboard" class="back-to-dashboard"><img src="../images/back-button.png" alt=""></a>
<h1 class="header">Manage Movies</h1>

<?php if (isset($_SESSION['message'])): ?>
        <p><?php echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])): ?>
    <div class="error-messages">
        <?php foreach ($_SESSION['errors'] as $error): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    </div>
<?php endif; ?>

<h2 class="header">Add New Movie</h2>
<form method="POST" enctype="multipart/form-data" class="movie-card">

    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($movie['Title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="director">Director:</label>
    <input type="text" name="director" value="<?php echo htmlspecialchars($movie['Director'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="language">Language:</label>
    <input type="text" name="language" value="<?php echo htmlspecialchars($movie['Language'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="year">Year:</label>
    <input type="number" name="year" value="<?php echo htmlspecialchars($movie['Year'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="duration">Duration:</label>
    <input type="time" name="duration" value="<?php echo htmlspecialchars($movie['Duration'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>

    <label for="rating">Rating:</label>
    <input type="number" name="rating" value="<?php echo htmlspecialchars($movie['Rating'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required min="0" max="10">

    <label for="agelimit">Age Limit:</label>
    <input type="number" name="agelimit" value="<?php echo htmlspecialchars($movie['AgeLimit'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required min="0" max="18">

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars($movie['Description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>

    <label for="trailerlink">Trailer Link:</label>
    <input type="text" name="trailerlink" value="<?php echo htmlspecialchars($movie['TrailerLink'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g., https://youtube.com/watch?v=...">

    <label for="genre_id">Genre:</label>
    <select name="genre_id" id="genre_id" required onchange="toggleOtherInput('genre_id', 'other_genre')">
        <?php foreach ($genres as $genre): ?>
            <option value="<?php echo htmlspecialchars($genre['Genre_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($genre['Name'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
        <option value="other">Other</option>
    </select>
    <input type="text" id="other_genre" name="other_genre" placeholder="Enter new genre" style="display: none;">

    <label for="version_id">Version:</label>
    <select name="version_id" id="version_id" required onchange="toggleOtherInput('version_id', 'other_version')">
        <?php foreach ($versions as $version): ?>
            <option value="<?php echo htmlspecialchars($version['Version_ID'], ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($version['Format'], ENT_QUOTES, 'UTF-8'); ?>
            </option>
        <?php endforeach; ?>
        <option value="other">Other</option>
    </select>
    <input type="text" id="other_version" name="other_version" placeholder="Enter new version" style="display: none;">

    <label for="poster-upload">Upload New Movie Poster (required):</label>
    <input type="file" name="poster" accept="image/*" required id="poster-upload" onchange="displayFileName(event)">
    <label for="poster-upload">Choose Poster Image</label>
    <div class="file-name" id="fileNameContainer"></div>

    <label for="gallery-upload">Upload Gallery Images (required, min 1, max 5):</label>
    <input type="file" name="gallery[]" accept="image/*" multiple id="gallery-upload" onchange="displayGalleryFileNames(event); validateFileCount(this);">
    <label for="gallery-upload">Choose Gallery Images</label>
    <div class="file-name" id="galleryFileNamesContainer"></div>

    <br>

    <button type="submit" name="add_movie" class="add-button">Add Movie</button>
</form>



<!-- Existing Movies Section -->
<h2 class="header">Existing Movies</h2>
<div id="moviesContainer">
    <?php foreach ($movies as $movie): ?>
        <div class="movie-card">
            <form method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                <input type="hidden" name="movie_id" value="<?php echo $movie['Movie_ID']; ?>">

                <!-- Movie Details (title, director, etc.) -->
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Title'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="director">Director:</label>
                <input type="text" name="director" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Director'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="language">Language:</label>
                <input type="text" name="language" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Language'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="year">Year:</label>
                <input type="number" name="year" value="<?php echo (int)$movie['Year']; ?>" required>

                <label for="duration">Duration:</label>
                <input type="time" name="duration" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Duration'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="rating">Rating:</label>
                <input type="number" name="rating" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Rating'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required min="0" max="10">

                <label for="agelimit">Age Limit:</label>
                <input type="number" name="agelimit" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['AgeLimit'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required min="0" max="18">

                <label for="description">Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars(htmlspecialchars_decode($movie['Description'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="trailerlink">Trailer Link:</label>
                <input type="text" name="trailerlink" value="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['TrailerLink'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" required placeholder="e.g., https://youtube.com/watch?v=...">

                <!-- Genre Select -->
                <label for="genre_id">Genre:</label>
                <select name="genre_id" required>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo $genre['Genre_ID']; ?>" 
                            <?php if ($genre['Genre_ID'] == $movie['Genre_ID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars(htmlspecialchars_decode($genre['Name'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Version Select -->
                <label for="version_id">Version:</label>
                <select name="version_id" required>
                    <?php foreach ($versions as $version): ?>
                        <option value="<?php echo $version['Version_ID']; ?>" 
                            <?php if ($version['Version_ID'] == $movie['Version_ID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars(htmlspecialchars_decode($version['Format'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Display uploaded poster image -->
                <?php if (!empty($movie['ImageFileName'])): ?>
                    <div>
                        <img src="../uploads/poster/<?php echo htmlspecialchars(htmlspecialchars_decode($movie['ImageFileName'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Title'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" style="max-width: 100%; height: auto;">
                    </div>
                <?php else: ?>
                    <p>No image available for this movie.</p>
                <?php endif; ?>

                <label for="poster-<?php echo $movie['Movie_ID']; ?>">Upload New Movie Poster (required):</label>
                <input type="file" name="poster" accept="image/*" id="poster-<?php echo $movie['Movie_ID']; ?>" onchange="displayFileName(event, <?php echo $movie['Movie_ID']; ?>)"> 
                <label for="poster-<?php echo $movie['Movie_ID']; ?>" class="file-label">Choose New Poster</label>
                <div class="file-name" id="fileNameContainer-<?php echo $movie['Movie_ID']; ?>"></div>

                <!-- Display gallery images with delete checkboxes -->
                <?php if (!empty($movie['GalleryImages'])): ?>
                    <div>
                        <h4>Gallery Images:</h4>
                        <?php 
                        $galleryImages = explode(',', $movie['GalleryImages']);
                        foreach ($galleryImages as $galleryImage): ?>
                            <div style="display: flex; align-items: center;">
                                <img src="../uploads/gallery/<?php echo htmlspecialchars(htmlspecialchars_decode($galleryImage, ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars(htmlspecialchars_decode($movie['Title'], ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>" style="max-width: 100px; height: auto; margin: 5px;">
                                <label>
                                    <input type="checkbox" name="delete_gallery_images[]" value="<?php echo htmlspecialchars(htmlspecialchars_decode($galleryImage, ENT_QUOTES), ENT_QUOTES, 'UTF-8'); ?>"> Delete
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <label for="gallery-<?php echo $movie['Movie_ID']; ?>">Upload Gallery Images (required, min 1, max 5 in total):</label>
                <input type="file" name="gallery[]" accept="image/*" multiple 
                    id="gallery-<?php echo $movie['Movie_ID']; ?>" 
                    data-existing-files-count="<?php echo count($galleryImages); ?>" 
                    onchange="validateExistingFileCount(this)">
                <label for="gallery-<?php echo $movie['Movie_ID']; ?>" class="file-label">Choose Gallery Images</label>
                <div id="gallery-file-names-<?php echo $movie['Movie_ID']; ?>" class="file-names"></div>

                <br>
            
                <button type="submit" name="edit_movie" class="edit-button">Edit Movie</button>
                <button type="submit" name="delete_movie" class="delete-button">Delete Movie</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>


<script src="/dwp/admin/assets/js/movies.js" defer></script>
<script src="/dwp/includes/functions.js" defer></script>

</body>
