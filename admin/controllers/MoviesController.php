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
        
        $errors = [];
        
        $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
        $director = htmlspecialchars(trim($_POST['director']), ENT_QUOTES, 'UTF-8');
        $language = htmlspecialchars(trim($_POST['language']), ENT_QUOTES, 'UTF-8');
        $year = (int)trim($_POST['year']);
        $duration = trim($_POST['duration']);
        $rating = (float)trim($_POST['rating']);
        $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
        $trailerlink = htmlspecialchars(trim($_POST['trailerlink']), ENT_QUOTES, 'UTF-8');
        $agelimit = (int)trim($_POST['agelimit']);
        
        if (!validateLettersOnly($director)) {
            $errors[] = "Director should contain only letters and spaces.";
        }
        if (!validateLettersOnly($language)) {
            $errors[] = "Language should contain only letters.";
        }
        if (!validateYear($year)) {
            $errors[] = "Year must be a valid 4-digit number.";
        }
        if (!validateDuration($duration)) {
            $errors[] = "Duration must be in HH:MM:SS format.";
        }
        if (!validateRating($rating)) {
            $errors[] = "Rating must be a number between 1 and 10.";
        }
        if (!validateAgeLimit($agelimit)) {
            $errors[] = "Age limit must be a number between 0 and 18.";
        }
        if (!validateYouTubeEmbedLink($trailerlink)) {
            $errors[] = "Trailer link must start with 'https://www.youtube.com/embed/'.";
        }
    
        // Check if poster image is uploaded
        if (!isset($_FILES['poster']) || $_FILES['poster']['error'] === UPLOAD_ERR_NO_FILE) {
            $errors[] = "Poster image is required.";
        }

        // Check if at least one gallery image is uploaded
        if (!isset($_FILES['gallery']['name']) || count($_FILES['gallery']['name']) === 0) {
            $errors[] = "At least one gallery image is required.";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors; 
            $_SESSION['message'] = "Movie not added due to validation errors."; 
            header("Location: /dwp/admin/manage-movies"); 
            exit();
        }
        
        // Handle new genre and version
        $genreId = ($_POST['genre_id'] === 'other') ? $this->addGenre($_POST['other_genre']) : (int)$_POST['genre_id'];
        $versionId = ($_POST['version_id'] === 'other') ? $this->addVersion($_POST['other_version']) : (int)$_POST['version_id'];
        
        $movieData = [
            $title,
            $director,
            $language,
            $year,
            $duration,
            $rating,
            $description,
            $genreId,
            $versionId,
            $trailerlink,
            $agelimit
        ];
        
        if ($this->model->addMovie($movieData)) {
            $movieId = $connection->lastInsertId();
            // Handle image uploads
            $this->handleImageUploads($movieId, $connection);
            $_SESSION['message'] = "Movie added successfully!";
            header("Location: /dwp/admin/manage-movies");
            exit();
        } else {
            $_SESSION['message'] = "Movie not added!";
            header("Location: /dwp/admin/manage-movies");
            exit();
        }
    }
    
    
    

    private function editMovie() {
        global $connection;
        
        $movieId = (int)$_POST['movie_id'];
        $title = htmlspecialchars(trim($_POST['title']));
        $director = htmlspecialchars(trim($_POST['director']));
        $language = htmlspecialchars(trim($_POST['language']));
        $year = (int)trim($_POST['year']);
        $duration = trim($_POST['duration']);
        $rating = (float)trim($_POST['rating']);
        $description = htmlspecialchars(trim($_POST['description']));
        $genre_id = (int)$_POST['genre_id'];
        $version_id = (int)$_POST['version_id'];
        $trailerlink = htmlspecialchars(trim($_POST['trailerlink']));
        $agelimit = (int)$_POST['agelimit'];
        
        $errors = [];
        if (!validateLettersOnly($director)) {
            $errors[] = "Director should contain only letters and spaces.";
        }
        if (!validateLettersOnly($language)) {
            $errors[] = "Language should contain only letters.";
        }
        if (!validateYear($year)) {
            $errors[] = "Year must be a valid 4-digit number.";
        }
        if (!validateDuration($duration)) {
            $errors[] = "Duration must be in HH:MM:SS format.";
        }
        if (!validateRating($rating)) {
            $errors[] = "Rating must be a number between 1 and 10.";
        }
        if (!validateAgeLimit($agelimit)) {
            $errors[] = "Age limit must be a number between 0 and 18.";
        }
        if (!validateYouTubeEmbedLink($trailerlink)) {
            $errors[] = "Trailer link must start with 'https://www.youtube.com/embed/'.";
        }
    
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /dwp/admin/manage-movies?movie_id=" . $movieId); 
            exit();
        }
    
        $movieData = [
            $title,
            $director,
            $language,
            $year,
            $duration,
            $rating,
            $description,
            $genre_id,
            $version_id,
            $trailerlink,
            $agelimit,
            $movieId
        ];
        
        if ($this->model->updateMovie($movieData)) {
            // Handle poster replacement 
            if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
                deletePosterImage($movieId, $connection); 
                $_FILES['image'] = $_FILES['poster']; 
                uploadImage($movieId, 'movie', $connection);
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
        deleteImage($movieId, 'movie', $connection); 
    
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
            uploadImage($movieId, 'movie', $connection); 
        }
    
        // Upload new gallery images
        if (isset($_FILES['gallery']['name']) && count($_FILES['gallery']['name']) > 0) {
            $_FILES['image'] = $_FILES['gallery'];
            uploadImage($movieId, 'gallery', $connection); 
        }
    }
    
}

$controller = new MoviesController($connection);
$controller->handleRequest();
$movies = $controller->model->getAllMovies();
$genres = $controller->model->getGenres();
$versions = $controller->model->getVersions();

include('./admin/views/movies_content.php');
