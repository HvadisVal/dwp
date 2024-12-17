<?php
require_once('./admin/models/LandingMoviesModel.php');
require_once('./includes/admin_session.php');
require_once('./includes/functions.php');

class LandingMoviesController {
    private $landingMoviesModel;

    public function __construct($connection) {
        $this->landingMoviesModel = new LandingMoviesModel($connection);
    }

    public function handleRequest() {
        $csrfToken = generate_csrf_token();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            validate_csrf_token($_POST['csrf_token']);
            refresh_csrf_token();

            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add':
                    $movieId = (int)$_POST['movie_id'];
                    $displayOrder = (int)$_POST['display_order'];

                    // Check if there are already 3 movies on the landing page
                    $landingMoviesCount = $this->landingMoviesModel->getLandingMoviesCount();

                    if ($landingMoviesCount >= 3) {
                        $_SESSION['message'] = "You cannot add more than 3 movies to the landing page.";
                    } else {
                        if ($this->landingMoviesModel->addlandingMovie($movieId, $displayOrder)) {
                            $_SESSION['message'] = "Movie added to the landing page successfully!";
                        } else {
                            $_SESSION['message'] = "A movie with that display order already exists!";
                        }
                    }

                    // Fetch all available movies excluding the ones already on the landing page
                    $movies = $this->landingMoviesModel->getAllMoviesNotOnLandingPage();
                    break;

                case 'update':
                    $landingMovieId = (int)$_POST['landing_movie_id'];
                    $newOrder = (int)$_POST['new_display_order'];
                    if ($this->landingMoviesModel->updateDisplayOrder($landingMovieId, $newOrder)) {
                        $_SESSION['message'] = "Display order updated successfully!";
                    } else {
                        $_SESSION['message'] = "A movie with that display order already exists!";
                    }
                    break;

                case 'delete':
                    $landingMovieId = (int)$_POST['landing_movie_id'];
                    $this->landingMoviesModel->deleteLandingMovie($landingMovieId);
                    $_SESSION['message'] = "Movie deleted from landing page!";
                    break;

                default:
                    $_SESSION['message'] = "Invalid action.";
                    break;
            }

            header("Location: /dwp/admin/manage-landing");
            exit();
        }

        $movies = $this->landingMoviesModel->getAllMoviesNotOnLandingPage();
        $landingMovies = $this->landingMoviesModel->getlandingMovies();

        $usedOrders = [];
        foreach ($landingMovies as $movie) {
            $usedOrders[] = $movie['DisplayOrder'];
        }

        include('./admin/views/landing_movies_content.php');
    }
}
