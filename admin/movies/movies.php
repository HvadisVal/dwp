<?php 
require_once("./includes/admin_session.php"); 
require_once("./includes/connection.php"); 
require_once("./includes/functions.php"); 
require_once("../dwp/admin/image_functions.php"); 

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
        $agelimit = htmlspecialchars(trim($_POST['agelimit']));



        // Insert movie
        $sql = "INSERT INTO Movie (Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID, TrailerLink, AgeLimit) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$title, $director, $language, $year, $duration, $rating, $description, $genreId, $versionId, $trailerLink, $agelimit])) {
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
            header("Location: /dwp/admin/manage-movies"); 
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
        $agelimit = htmlspecialchars(trim($_POST['agelimit']));

    
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
                TrailerLink = ?,
                AgeLimit = ?
                WHERE Movie_ID = ?";
        $stmt = $connection->prepare($sql);
    
        if ($stmt->execute([$title, $director, $language, $year, $duration, $rating, $description, $genreId, $versionId, $trailerLink, $agelimit, $movieId])) {
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
            header("Location: /dwp/admin/manage-movies"); 
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
        header("Location: /dwp/admin/manage-movies");
        exit();
    }
}

$sql = "SELECT m.Movie_ID, m.Title, m.Director, m.Language, m.Year, m.Duration, m.Rating, m.Description, 
               m.TrailerLink, m.AgeLimit, 
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
include('movies_content.php');