

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="/dwp/admin/movies/movies.css" />
</head>
<body>

<h1 class="header">Manage Movies</h1>

<!-- Add Movie Section -->
<h2 class="header">Add New Movie</h2>
<form method="POST" enctype="multipart/form-data" class="movie-card">

    <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">

    <label for="title">Title:</label>
    <input type="text" name="title" required>

    <label for="director">Director:</label>
    <input type="text" name="director" required>

    <label for="language">Language:</label>
    <input type="text" name="language" required>

    <label for="year">Year:</label>
    <input type="number" name="year" required>

    <label for="duration">Duration:</label>
    <input type="time" name="duration" required>

    <label for="rating">Rating:</label>
    <input type="number" name="rating" required min="0" max="10">

    <label for="agelimit">Age Limit:</label>
    <input type="number" name="agelimit" required>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea>

    <label for="trailerlink">Trailer Link:</label>
    <input type="text" name="trailerlink" required placeholder="e.g., https://youtube.com/watch?v=...">

    <label for="genre_id">Genre:</label>
    <select name="genre_id" id="genre_id" required onchange="toggleOtherInput('genre_id', 'other_genre')">
        <?php foreach ($genres as $genre): ?>
            <option value="<?php echo $genre['Genre_ID']; ?>"><?php echo htmlspecialchars($genre['Name']); ?></option>
        <?php endforeach; ?>
        <option value="other">Other</option>
    </select>
    <input type="text" id="other_genre" name="other_genre" placeholder="Enter new genre" style="display: none;">

    <label for="version_id">Version:</label>
    <select name="version_id" id="version_id" required onchange="toggleOtherInput('version_id', 'other_version')">
        <?php foreach ($versions as $version): ?>
            <option value="<?php echo $version['Version_ID']; ?>"><?php echo htmlspecialchars($version['Format']); ?></option>
        <?php endforeach; ?>
        <option value="other">Other</option>
    </select>
    <input type="text" id="other_version" name="other_version" placeholder="Enter new version" style="display: none;">

    <!-- Poster upload -->
    <label for="image-<?php echo $movie['Movie_ID']; ?>">Upload New Movie Poster (required):</label>     
    <input type="file" name="poster" accept="image/*" required id="poster-upload" onchange="displayFileName(event)">
    <label for="poster-upload">Choose Poster Image</label>
    <div class="file-name" id="fileNameContainer"></div> <!-- Display file name here -->


    <!-- Gallery upload (multiple files) -->
    <label for="gallery-<?php echo $movie['Movie_ID']; ?>">Upload Gallery Images (required, min 1, max 5):</label>
    <input type="file" name="gallery[]" accept="image/*" multiple id="gallery-upload" onchange="displayGalleryFileNames(event); validateFileCount(this);">
    <label for="gallery-upload">Choose Gallery Images</label>
    <div class="file-name" id="galleryFileNamesContainer"></div> <!-- Display gallery file names here -->

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
                <input type="text" name="title" value="<?php echo htmlspecialchars($movie['Title']); ?>" required>

                <label for="director">Director:</label>
                <input type="text" name="director" value="<?php echo htmlspecialchars($movie['Director']); ?>" required>

                <label for="language">Language:</label>
                <input type="text" name="language" value="<?php echo htmlspecialchars($movie['Language']); ?>" required>

                <label for="year">Year:</label>
                <input type="number" name="year" value="<?php echo $movie['Year']; ?>" required>

                <label for="duration">Duration:</label>
                <input type="time" name="duration" value="<?php echo $movie['Duration']; ?>" required>

                <label for="rating">Rating:</label>
                <input type="number" name="rating" value="<?php echo $movie['Rating']; ?>" required min="0" max="10">

                <label for="agelimit">Age Limit:</label>
                <input type="number" name="agelimit" value="<?php echo $movie['AgeLimit']; ?>" required min="0" max="18">

                <label for="description">Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($movie['Description']); ?></textarea>

                <label for="trailerlink">Trailer Link:</label>
                <input type="text" name="trailerlink" value="<?php echo htmlspecialchars($movie['TrailerLink']); ?>" required placeholder="e.g., https://youtube.com/watch?v=...">

                <!-- Genre Select -->
                <label for="genre_id">Genre:</label>
                <select name="genre_id" required>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo $genre['Genre_ID']; ?>" 
                            <?php if ($genre['Genre_ID'] == $movie['Genre_ID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($genre['Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Version Select -->
                <label for="version_id">Version:</label>
                <select name="version_id" required>
                    <?php foreach ($versions as $version): ?>
                        <option value="<?php echo $version['Version_ID']; ?>" 
                            <?php if ($version['Version_ID'] == $movie['Version_ID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($version['Format']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Display uploaded poster image -->
                <?php if (!empty($movie['ImageFileName'])): ?>
                    <div>
                        <img src="../uploads/poster/<?php echo htmlspecialchars($movie['ImageFileName']); ?>" alt="<?php echo htmlspecialchars($movie['Title']); ?>" style="max-width: 100%; height: auto;">
                    </div>
                <?php else: ?>
                    <p>No image available for this movie.</p>
                <?php endif; ?>

                <label for="image-<?php echo $movie['Movie_ID']; ?>">Upload New Movie Poster (required):</label>
                <input type="file" name="image" accept="image/*" id="image-<?php echo $movie['Movie_ID']; ?>" onchange="displayFileName(event, <?php echo $movie['Movie_ID']; ?>)"> 
                <label for="image-<?php echo $movie['Movie_ID']; ?>" class="file-label">Choose New Poster</label>
                <div class="file-name" id="fileNameContainer-<?php echo $movie['Movie_ID']; ?>"></div>

                <!-- Display gallery images with delete checkboxes -->
                <?php if (!empty($movie['GalleryImages'])): ?>
                    <div>
                        <h4>Gallery Images:</h4>
                        <?php 
                        $galleryImages = explode(',', $movie['GalleryImages']);
                        foreach ($galleryImages as $galleryImage): ?>
                            <div style="display: flex; align-items: center;">
                                <img src="../uploads/gallery/<?php echo htmlspecialchars($galleryImage); ?>" alt="<?php echo htmlspecialchars($movie['Title']); ?>" style="max-width: 100px; height: auto; margin: 5px;">
                                <label>
                                    <input type="checkbox" name="delete_gallery_images[]" value="<?php echo htmlspecialchars($galleryImage); ?>"> Delete
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($movie['GalleryImages'])): ?>
                    <?php $galleryImages = explode(',', $movie['GalleryImages']); ?>
                <?php else: ?>
                    <?php $galleryImages = []; ?>
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

<script src="/dwp/admin/movies/movies.js" defer></script>
<script src="/dwp/includes/functions.js" defer></script>

</body>
