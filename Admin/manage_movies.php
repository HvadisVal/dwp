<?php 
require_once("../includes/session.php"); 
require_once("../includes/connection.php"); 
require_once("../includes/functions.php"); 

// Check if admin is logged in, otherwise redirect to login page
// if (!isset($_SESSION['admin_id'])) {
//    redirect_to("adminLogin.php"); // Redirect to the admin login page if not logged in
// }

// Handle the edit form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_movie'])) {
    $movieId = $_POST['movie_id'];
    $title = $_POST['title'];
    $director = $_POST['director'];
    $language = $_POST['language'];
    $year = $_POST['year'];
    $duration = $_POST['duration'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    $genreId = $_POST['genre_id'];
    $versionId = $_POST['version_id'];

    // Update query
    $sql = "UPDATE Movie SET 
            Title = ?, 
            Director = ?, 
            Language = ?, 
            Year = ?, 
            Duration = ?, 
            Rating = ?, 
            Description = ?, 
            Genre_ID = ?, 
            Version_ID = ? 
            WHERE Movie_ID = ?";

    // Prepare and execute the statement
    $stmt = $connection->prepare($sql);
    if ($stmt->execute([$title, $director, $language, $year, $duration, $rating, $description, $genreId, $versionId, $movieId])) {
        echo "Movie updated successfully!";
    } else {
        echo "Error updating movie.";
    }
}

// Fetch movies for display
$sql = "SELECT m.Movie_ID, m.Title, m.Director, m.Language, m.Year, m.Duration, m.Rating, m.Description, g.Name AS Genre_Name, v.Format AS Version_Format 
        FROM Movie m 
        LEFT JOIN Genre g ON m.Genre_ID = g.Genre_ID 
        LEFT JOIN Version v ON m.Version_ID = v.Version_ID";

$stmt = $connection->query($sql);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Movies</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional CSS for styling -->
    <style>
        /* Basic styles for movie divs */
        .movie-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 16px;
            margin: 16px 0;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        .movie-card h2 {
            margin: 0;
            font-size: 24px;
        }
        .movie-card p {
            margin: 5px 0;
        }
        .edit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Manage Movies</h1>

<div id="moviesContainer">
    <?php if ($movies): ?>
        <?php foreach ($movies as $row): ?>
            <div class="movie-card">
                <h2><?php echo $row['Title']; ?></h2>
                <p><strong>Director:</strong> <?php echo $row['Director']; ?></p>
                <p><strong>Language:</strong> <?php echo $row['Language']; ?></p>
                <p><strong>Year:</strong> <?php echo $row['Year']; ?></p>
                <p><strong>Duration:</strong> <?php echo $row['Duration']; ?></p>
                <p><strong>Rating:</strong> <?php echo $row['Rating']; ?></p>
                <p><strong>Description:</strong> <?php echo $row['Description']; ?></p>
                <p><strong>Genre:</strong> <?php echo $row['Genre_Name']; ?></p>
                <p><strong>Version:</strong> <?php echo $row['Version_Format']; ?></p>
                <button class="edit-button" onclick="editMovie(<?php echo $row['Movie_ID']; ?>)">Edit</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No movies found</p>
    <?php endif; ?>
</div>

<!-- Edit Movie Modal -->
<div id="editMovieModal" style="display:none;">
    <form method="POST" id="editMovieForm">
        <input type="hidden" name="movie_id" id="movie_id" value="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <label for="director">Director:</label>
        <input type="text" name="director" id="director" required>
        <label for="language">Language:</label>
        <input type="text" name="language" id="language" required>
        <label for="year">Year:</label>
        <input type="number" name="year" id="year" required>
        <label for="duration">Duration:</label>
        <input type="time" name="duration" id="duration" required>
        <label for="rating">Rating:</label>
        <input type="number" name="rating" id="rating" required min="0" max="10">
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <label for="genre_id">Genre ID:</label>
        <input type="number" name="genre_id" id="genre_id" required>
        <label for="version_id">Version ID:</label>
        <input type="number" name="version_id" id="version_id" required>
        <button type="submit" name="edit_movie">Update Movie</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
</div>

<script>
function editMovie(movieId) {
    const row = document.querySelector(`.movie-card h2:contains(${movieId})`).parentElement;
    const cells = row.getElementsByTagName("p");

    document.getElementById('movie_id').value = movieId;
    document.getElementById('title').value = cells[0].innerText.replace("Title: ", "");
    document.getElementById('director').value = cells[1].innerText.replace("Director: ", "");
    document.getElementById('language').value = cells[2].innerText.replace("Language: ", "");
    document.getElementById('year').value = cells[3].innerText.replace("Year: ", "");
    document.getElementById('duration').value = cells[4].innerText.replace("Duration: ", "");
    document.getElementById('rating').value = cells[5].innerText.replace("Rating: ", "");
    document.getElementById('description').value = cells[6].innerText.replace("Description: ", "");
    document.getElementById('genre_id').value = cells[7].innerText.replace("Genre: ", "");
    document.getElementById('version_id').value = cells[8].innerText.replace("Version: ", "");

    document.getElementById('editMovieModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('editMovieModal').style.display = 'none';
}
</script>

</body>
</html>
