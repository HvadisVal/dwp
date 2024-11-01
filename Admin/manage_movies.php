<?php 
require_once("../includes/session.php"); 
require_once("../includes/connection.php"); 
require_once("../includes/functions.php"); 
require_once("./image_functions.php"); // Include the new file

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));


    if (isset($_POST['add_movie'])) {
        // Check and insert new genre if necessary
        if ($_POST['genre_id'] === 'other' && !empty(trim($_POST['other_genre']))) {
            $newGenre = htmlspecialchars(trim($_POST['other_genre']));
            $sql = "INSERT INTO Genre (Name, Description) VALUES (?, '')";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$newGenre]);
            $genreId = $connection->lastInsertId();
        } else {
            $genreId = (int)trim($_POST['genre_id']);
        }

        // Check and insert new version if necessary
        if ($_POST['version_id'] === 'other' && !empty(trim($_POST['other_version']))) {
            $newVersion = htmlspecialchars(trim($_POST['other_version']));
            $sql = "INSERT INTO Version (Format, AdditionalFee) VALUES (?, 0.00)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$newVersion]);
            $versionId = $connection->lastInsertId();
        } else {
            $versionId = (int)trim($_POST['version_id']);
        }

        // Movie details
        $title = htmlspecialchars(trim($_POST['title']));
        $director = htmlspecialchars(trim($_POST['director']));
        $language = htmlspecialchars(trim($_POST['language']));
        $year = (int)trim($_POST['year']);
        $duration = trim($_POST['duration']);
        $rating = (float)trim($_POST['rating']);
        $description = htmlspecialchars(trim($_POST['description']));
        $trailerLink = htmlspecialchars(trim($_POST['trailerlink']));

        // Insert movie
        $sql = "INSERT INTO Movie (Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID, TrailerLink) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$title, $director, $language, $year, $duration, $rating, $description, $genreId, $versionId, $trailerLink])) {
            $movieId = $connection->lastInsertId();

            // Handle image upload for poster
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                $_FILES['image'] = $_FILES['poster']; // Set 'poster' as 'image' to work with the function
                uploadImage($movieId, 'movie', $connection); // Pass type as 'movie'
            }


            // Handle gallery images upload
            if (isset($_FILES['gallery']['name']) && count($_FILES['gallery']['name']) > 0) {
                $_FILES['image'] = $_FILES['gallery']; // Reassign 'gallery' files to 'image' for function compatibility
                uploadImage($movieId, 'gallery', $connection);
            }

            $_SESSION['message'] = "Movie added successfully!";
            header("Location: manage_movies.php"); 
            exit();
        } else {
            echo "Error adding movie.";
        }
    } elseif (isset($_POST['edit_movie'])) {
        // Update existing movie
        $movieId = (int)trim($_POST['movie_id']);
        $title = htmlspecialchars(trim($_POST['title']));
        $director = htmlspecialchars(trim($_POST['director']));
        $language = htmlspecialchars(trim($_POST['language']));
        $year = (int)trim($_POST['year']);
        $duration = trim($_POST['duration']);
        $rating = (float)trim($_POST['rating']);
        $description = htmlspecialchars(trim($_POST['description']));
        $genreId = (int)trim($_POST['genre_id']);
        $versionId = (int)trim($_POST['version_id']);
        $trailerLink = htmlspecialchars(trim($_POST['trailerlink']));
    
        // Update movie
        $sql = "UPDATE Movie SET 
                Title = ?, 
                Director = ?, 
                Language = ?, 
                Year = ?, 
                Duration = ?, 
                Rating = ?, 
                Description = ?, 
                Genre_ID = ?, 
                Version_ID = ?, 
                TrailerLink = ? 
                WHERE Movie_ID = ?";
        $stmt = $connection->prepare($sql);
    
        if ($stmt->execute([$title, $director, $language, $year, $duration, $rating, $description, $genreId, $versionId, $trailerLink, $movieId])) {
            // Handle image upload if a new image is provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                deletePosterImage($movieId, $connection); // Ensure this function is correct
                uploadImage($movieId, 'movie', $connection); // Upload new poster image
            }
    
            // Handle gallery images
            if (isset($_FILES['gallery']['name']) && count($_FILES['gallery']['name']) > 0) {
                // Reassign gallery files to 'image' for uploadImage function
                $_FILES['image'] = $_FILES['gallery']; 
                uploadImage($movieId, 'gallery', $connection); 
            }
            
            // Handle deletion of selected gallery images
            if (isset($_POST['delete_gallery_images']) && is_array($_POST['delete_gallery_images'])) {
                foreach ($_POST['delete_gallery_images'] as $galleryImage) {
                    deleteGalleryImage($galleryImage, $movieId, $connection); // Ensure this function is defined
                }
            }
    
            $_SESSION['message'] = "Movie updated successfully!";
            header("Location: manage_movies.php"); 
            exit();
        } else {
            echo "Error updating movie.";
        }
    }
     elseif (isset($_POST['delete_movie'])) {
        // Delete movie logic
        $movieId = (int)trim($_POST['movie_id']);

        // Delete associated image
        deleteImage($movieId, 'movie', $connection); // Delete the image before removing the movie

        // Delete the movie record
        $sql = "DELETE FROM Movie WHERE Movie_ID = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt->execute([$movieId])) {
            $_SESSION['message'] = "Movie deleted successfully!";
        } else {
            echo "Error deleting movie.";
        }

        // Redirect after deletion
        header("Location: manage_movies.php");
        exit();
    }
}

$sql = "SELECT m.Movie_ID, m.Title, m.Director, m.Language, m.Year, m.Duration, m.Rating, m.Description, 
               m.TrailerLink, 
               MAX(CASE WHEN media.IsFeatured = 1 THEN media.FileName END) AS ImageFileName,
               GROUP_CONCAT(CASE WHEN media.IsFeatured = 0 THEN media.FileName END) AS GalleryImages,
               g.Genre_ID AS Genre_ID, g.Name AS GenreName,
               v.Version_ID AS Version_ID, v.Format AS VersionFormat
        FROM Movie m
        LEFT JOIN Media media ON m.Movie_ID = media.Movie_ID
        LEFT JOIN Genre g ON m.Genre_ID = g.Genre_ID
        LEFT JOIN Version v ON m.Version_ID = v.Version_ID
        GROUP BY m.Movie_ID";  
$stmt = $connection->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);




// Fetch genres and versions
$genres = $connection->query("SELECT Genre_ID, Name FROM Genre")->fetchAll(PDO::FETCH_ASSOC);
$versions = $connection->query("SELECT Version_ID, Format FROM Version")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']); // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .header{
            margin: 20px 0;
            padding: 10px; 
            display: flex;
            justify-content: center;  
        }

   
#moviesContainer {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 items in a row */
    gap: 10px; /* space between items */
    padding: 10px;
    flex-direction: column;
    max-width: 1200px;
    margin: 0 auto;
}

/* Grid layout for movie cards */
.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-top: 24px;
}

/* Form grid layout */
.movie-card {
    border: none;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    background-color: white;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}



.movie-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.movie-card label {
    font-weight: 600;
    margin-top: 8px;
    display: block;
    color: #374151;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.movie-card input[type="text"],
.movie-card input[type="number"],
.movie-card input[type="time"],
.movie-card textarea {
    display: block;
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    background-color: #f9fafb;
    padding: 8px 12px;
    font-size: 1rem;
    color: #1f2937;
    transition: all 0.2s ease;
    margin-top: 4px;
}

.movie-card textarea {
    resize: vertical;
    min-height: 80px;
    line-height: 1.5;
    grid-column: 1 / -1;
}

.movie-card select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 1rem;
    color: #1f2937;
    background-color: #f9fafb;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 40px;
}

.movie-card input:focus,
.movie-card textarea:focus,
.movie-card select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background-color: white;
}

.buttons-container {
    grid-column: 1 / -1;
    display: flex;
    gap: 12px;
    margin-top: 24px;
}

.edit-button,
.add-button {
    background: black;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
}

.edit-button:hover,
.add-button:hover {
    background: #1a252d; 
    color: white;
    transition:  0.3s ease, color 0.3s ease; 
    transform: translateY(-1px);
}

.delete-button {
    background-color: #ef4444;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.delete-button:hover {
    background-color: #dc2626;
    transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

/* Add subtle animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.movie-card {
    animation: fadeIn 0.3s ease-out;
}
    </style>
</head>
<body>
    <script>
        function validateFileCount(input) {
    const maxFiles = 5;
    console.log(`Selected files: ${input.files.length}`); // Log the number of files selected
    if (input.files.length > maxFiles) {
        alert(`You can only upload a maximum of ${maxFiles} images.`);
        input.value = ""; // Clear the input
    }
}
    </script>

<h1 class="header">Manage Movies</h1>

<!-- Add Movie Section -->
<h2 class="header">Add New Movie</h2>
<form method="POST" enctype="multipart/form-data" class="movie-card">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

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

    <label for="poster">Upload Poster Image:</label>
    <input type="file" name="poster" accept="image/*" required>

    <label for="gallery">Upload Gallery Images (up to 5):</label>
    <input type="file" name="gallery[]" accept="image/*" multiple id="galleryInput" onchange="validateFileCount(this)">

    <button type="submit" name="add_movie" class="add-button">Add Movie</button>
</form>


<!-- Existing Movies Section -->
<h2 class="header">Existing Movies</h2>
<div id="moviesContainer">
    <?php foreach ($movies as $movie): ?>
        <div class="movie-card">
            <form method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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

                <label for="image">Upload New Movie Image (optional):</label>
                <input type="file" name="image" accept="image/*"> 

                <!-- Display uploaded poster image -->
                <?php if (!empty($movie['ImageFileName'])): ?>
                    <div>
                        <img src="../uploads/poster/<?php echo htmlspecialchars($movie['ImageFileName']); ?>" alt="<?php echo htmlspecialchars($movie['Title']); ?>" style="max-width: 100%; height: auto;">
                    </div>
                <?php else: ?>
                    <p>No image available for this movie.</p>
                <?php endif; ?>

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

                <label for="gallery">Upload Additional Gallery Images (up to 5 total):</label>
                <input type="file" name="gallery[]" accept="image/*" multiple 
       id="galleryInput" 
       data-existing-files-count="<?php echo count($galleryImages); ?>" 
       onchange="validateExistingFileCount(this)">
                <button type="submit" name="edit_movie" class="edit-button">Edit Movie</button>
                <button type="submit" name="delete_movie" class="delete-button">Delete Movie</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>




<script>
function toggleOtherInput(selectId, inputId) {
    var selectElement = document.getElementById(selectId);
    var inputElement = document.getElementById(inputId);
    if (selectElement.value === 'other') {
        inputElement.style.display = 'block';
    } else {
        inputElement.style.display = 'none';
    }
}
function validateExistingFileCount(input) {
    const maxFiles = 5;
    const existingFilesCount = parseInt(input.getAttribute('data-existing-files-count')) || 0;
    const fileCount = input.files.length;

    if (fileCount + existingFilesCount > maxFiles) {
        alert(`You can only upload a maximum of ${maxFiles - existingFilesCount} additional images.`);
        input.value = ''; // Clear the input
    }
}

</script>