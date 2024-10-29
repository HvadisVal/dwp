<?php 
require_once("../includes/session.php"); 
require_once("../includes/connection.php"); 
require_once("../includes/functions.php"); 

// CSRF Protection: Generate token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if admin is logged in, otherwise redirect to login page
// if (!isset($_SESSION['admin_id'])) {
//    redirect_to("adminLogin.php"); // Redirect to the admin login page if not logged in
// }

// Handle the form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF token check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Refresh CSRF token to avoid reuse
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    if (isset($_POST['add_movie'])) {
        // Add new movie
        $title = htmlspecialchars(trim($_POST['title']));
        $director = htmlspecialchars(trim($_POST['director']));
        $language = htmlspecialchars(trim($_POST['language']));
        $year = (int)trim($_POST['year']);
        $duration = trim($_POST['duration']);
        $rating = (float)trim($_POST['rating']);
        $description = htmlspecialchars(trim($_POST['description']));
        $genreId = (int)trim($_POST['genre_id']);
        $versionId = (int)trim($_POST['version_id']);
        $trailerLink = htmlspecialchars(trim($_POST['trailerlink'])); // Get trailer link


        // Insert query with prepared statement
        $sql = "INSERT INTO Movie (Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID, TrailerLink) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);

        if ($stmt->execute([$title, $director, $language, $year, $duration, $rating, $description, $genreId, $versionId, $trailerLink])) {
            // Get the last inserted movie ID
            $movieId = $connection->lastInsertId();

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
        $trailerLink = htmlspecialchars(trim($_POST['trailerlink'])); // Get trailer link

        // Update query with prepared statement
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
            $_SESSION['message'] = "Movie updated successfully!";
            header("Location: manage_movies.php"); 
            exit();
        } else {
            echo "Error updating movie.";
        }
    } elseif (isset($_POST['delete_movie'])) {
        // Delete movie logic
        $movieId = (int)trim($_POST['movie_id']);
    
        // 1. Fetch the paths of associated media files
        $sql = "SELECT FileName FROM Media WHERE Movie_ID = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$movieId]);
        
    
        // 4. Delete the movie record
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

// Fetch movies for display
$sql = "SELECT m.Movie_ID, m.Title, m.Director, m.Language, m.Year, m.Duration, m.Rating, m.Description, m.Genre_ID, m.Version_ID, m.TrailerLink
        FROM Movie m";
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
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling */
        #moviesContainer { display: flex; flex-direction: column; gap: 16px; }
        .movie-card { border: 1px solid #ddd; border-radius: 8px; padding: 16px; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; }
        .movie-card label { font-weight: bold; margin-top: 8px; display: block; color: #333; }
        .movie-card input[type="text"], .movie-card input[type="number"], .movie-card input[type="time"], .movie-card textarea {
            display: block; width: 100%; border: none; border-bottom: 1px solid #ccc; background-color: transparent; padding: 4px 0; font-size: 16px; color: #555;
        }
        .movie-card textarea { resize: none; height: 60px; }
        .movie-card select { width: 100%; padding: 4px 0; border: none; border-bottom: 1px solid #ccc; font-size: 16px; color: #555; background-color: transparent; }
        .movie-card input:focus, .movie-card textarea:focus, .movie-card select:focus { outline: none; border-bottom: 1px solid #007bff; }
        .edit-button, .add-button { margin-top: 16px; background-color: #007bff; color: white; border: none; padding: 10px 16px; border-radius: 4px; cursor: pointer; transition: background-color 0.3s; }
        .edit-button:hover, .add-button:hover { background-color: #0056b3; }
        .delete-button { 
            margin-top: 16px; 
            background-color: #dc3545; 
            color: white; 
            border: none; 
            padding: 10px 16px; 
            border-radius: 4px; 
            cursor: pointer; 
            transition: background-color 0.3s; 
        }
        .delete-button:hover { 
            background-color: #c82333; 
        }
    </style>
</head>
<body>

<h1>Manage Movies</h1>

<!-- Add Movie Section -->
<h2>Add New Movie</h2>
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
    <select name="genre_id" required>
        <?php foreach ($genres as $genre): ?>
            <option value="<?php echo $genre['Genre_ID']; ?>"><?php echo htmlspecialchars($genre['Name']); ?></option>
        <?php endforeach; ?>
    </select>

    <label for="version_id">Version:</label>
    <select name="version_id" required>
        <?php foreach ($versions as $version): ?>
            <option value="<?php echo $version['Version_ID']; ?>"><?php echo htmlspecialchars($version['Format']); ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="add_movie" class="add-button">Add Movie</button>
</form>

<!-- Existing Movies Section -->
<h2>Existing Movies</h2>
<div id="moviesContainer">
    <?php foreach ($movies as $movie): ?>
        <div class="movie-card">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" name="movie_id" value="<?php echo $movie['Movie_ID']; ?>">

                <!-- Movie Details (title, director, etc.) -->
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($movie['Title']); ?>" required>

                <!-- Continue with other fields... -->
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

                <label for="genre_id">Genre:</label>
                <select name="genre_id" required>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo $genre['Genre_ID']; ?>" <?php if ($genre['Genre_ID'] == $movie['Genre_ID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($genre['Name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="version_id">Version:</label>
                <select name="version_id" required>
                    <?php foreach ($versions as $version): ?>
                        <option value="<?php echo $version['Version_ID']; ?>" <?php if ($version['Version_ID'] == $movie['Version_ID']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($version['Format']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="edit_movie" class="edit-button">Edit Movie</button>
                <button type="submit" name="delete_movie" class="delete-button">Delete Movie</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>


</body>
</html>
