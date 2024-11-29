<?php
require_once("./includes/admin_session.php");
require_once("./includes/functions.php");
require_once("./includes/image_functions.php");
require_once("./admin/models/MoviesModel.php");

class MoviesController {
    public $model;

    public function __construct($connection) {
        $this->model = new MoviesModel($connection);
    }

    public function handleRequest() {
        // CSRF token generation and validation
        generate_csrf_token();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf_token($_POST['csrf_token']);
            refresh_csrf_token();

            if (isset($_POST['add_movie'])) {
                $this->addMovie();
            } elseif (isset($_POST['edit_movie'])) {
                $this->editMovie();
            } elseif (isset($_POST['delete_movie'])) {
                $this->deleteMovie();
            }
        }
    }

    private function addMovie() {
        global $connection;

        // Handle new genre
        $genreId = ($_POST['genre_id'] === 'other') ? $this->addGenre($_POST['other_genre']) : (int)$_POST['genre_id'];

        // Handle new version
        $versionId = ($_POST['version_id'] === 'other') ? $this->addVersion($_POST['other_version']) : (int)$_POST['version_id'];

        $movieData = [
            htmlspecialchars(trim($_POST['title'])),
            htmlspecialchars(trim($_POST['director'])),
            htmlspecialchars(trim($_POST['language'])),
            (int)trim($_POST['year']),
            trim($_POST['duration']),
            (float)trim($_POST['rating']),
            htmlspecialchars(trim($_POST['description'])),
            $genreId,
            $versionId,
            htmlspecialchars(trim($_POST['trailerlink'])),
            htmlspecialchars(trim($_POST['agelimit']))
        ];

        if ($this->model->addMovie($movieData)) {
            $movieId = $connection->lastInsertId();

            // Handle image uploads
            $this->handleImageUploads($movieId, $connection);

            $_SESSION['message'] = "Movie added successfully!";
            header("Location: /dwp/admin/manage-movies");
            exit();
        }
    }

    private function editMovie() {
        global $connection;
        
        $movieId = (int)$_POST['movie_id'];
        $movieData = [
            htmlspecialchars(trim($_POST['title'])),
            htmlspecialchars(trim($_POST['director'])),
            htmlspecialchars(trim($_POST['language'])),
            (int)trim($_POST['year']),
            trim($_POST['duration']),
            (float)trim($_POST['rating']),
            htmlspecialchars(trim($_POST['description'])),
            (int)$_POST['genre_id'],
            (int)$_POST['version_id'],
            htmlspecialchars(trim($_POST['trailerlink'])),
            htmlspecialchars(trim($_POST['agelimit'])),
            $movieId
        ];
    
        if ($this->model->updateMovie($movieData)) {
            // Handle poster replacement if a new one is uploaded
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                deletePosterImage($movieId, $connection); // Delete the existing poster
                $_FILES['image'] = $_FILES['poster']; // Assign the file to the 'image' input
                uploadImage($movieId, 'movie', $connection); // Upload the new poster
            }
    
            // Handle gallery image deletions
            if (!empty($_POST['delete_gallery_images'])) {
                foreach ($_POST['delete_gallery_images'] as $fileName) {
                    deleteGalleryImage($fileName, $movieId, $connection); // Delete specific gallery images
                }
            }
    
            // Upload new gallery images
            if (isset($_FILES['gallery']['name']) && count($_FILES['gallery']['name']) > 0) {
                $_FILES['image'] = $_FILES['gallery'];
                uploadImage($movieId, 'gallery', $connection);
            }
    
            $_SESSION['message'] = "Movie updated successfully!";
            header("Location: /dwp/admin/manage-movies");
            exit();
        }
    }
    
    

    private function deleteMovie() {
        global $connection;
    
        $movieId = (int)$_POST['movie_id'];
        deleteImage($movieId, 'movie', $connection); // Deletes all images (poster + gallery) for the movie
    
        if ($this->model->deleteMovie($movieId)) {
            $_SESSION['message'] = "Movie deleted successfully!";
            header("Location: /dwp/admin/manage-movies");
            exit();
        }
    }
    

    private function addGenre($genreName) {
        global $connection;

        $sql = "INSERT INTO Genre (Name, Description) VALUES (?, '')";
        $stmt = $connection->prepare($sql);
        $stmt->execute([htmlspecialchars(trim($genreName))]);
        return $connection->lastInsertId();
    }

    private function addVersion($versionName) {
        global $connection;

        $sql = "INSERT INTO Version (Format, AdditionalFee) VALUES (?, 0.00)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([htmlspecialchars(trim($versionName))]);
        return $connection->lastInsertId();
    }

    private function handleImageUploads($movieId, $connection) {
        // Upload new poster
        if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
            $_FILES['image'] = $_FILES['poster'];
            uploadImage($movieId, 'movie', $connection); // Handles the poster upload
        }
    
        // Upload new gallery images
        if (isset($_FILES['gallery']['name']) && count($_FILES['gallery']['name']) > 0) {
            $_FILES['image'] = $_FILES['gallery'];
            uploadImage($movieId, 'gallery', $connection); // Handles the gallery images upload
        }
    }
    
}

// Instantiate and handle request
$controller = new MoviesController($connection);
$controller->handleRequest();
$movies = $controller->model->getAllMovies();
$genres = $controller->model->getGenres();
$versions = $controller->model->getVersions();

include('./admin/views/movies_content.php');
