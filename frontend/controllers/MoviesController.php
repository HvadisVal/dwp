<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/MoviesModel.php';

class MoviesController {
    private $model;

    public function __construct($connection) {
        $this->model = new MoviesModel($connection);
    }

    public function handleRequest() {
        // Fetch all movies and their details
        $moviesData = $this->model->getAllMovies();
        $moviesById = [];

        foreach ($moviesData as $data) {
            $movieId = $data['Movie_ID'];
            $date = $data['ShowDate'];

            if (!isset($moviesById[$movieId])) {
                $moviesById[$movieId] = [
                    'details' => [
                        'Title' => $data['Title'],
                        'Duration' => $data['Duration'],
                        'Rating' => $data['Rating'],
                        'Description' => $data['Description'],
                        'PosterPath' => [],
                    ],
                    'showtimes' => []
                ];
            }

            // Add poster images
            if ($data['PosterFiles']) {
                $posterFiles = explode(',', $data['PosterFiles']);
                $moviesById[$movieId]['details']['PosterPath'] = array_map(function ($image) {
                    return "./uploads/poster/" . $image;
                }, $posterFiles);
            }

            if (!isset($moviesById[$movieId]['showtimes'][$date])) {
                $moviesById[$movieId]['showtimes'][$date] = [];
            }

            $moviesById[$movieId]['showtimes'][$date][] = $data;
        }

        // Get the offset for the week (this could be a parameter passed by GET/POST)
        $offset = isset($_GET['week_offset']) ? (int)$_GET['week_offset'] : 0;

        // Calculate the start date based on the offset
        $startDate = new DateTime();
        $startDate->modify('monday this week'); // Start of the current week
        $startDate->modify("+$offset weeks"); // Adjust based on the week offset

        $allDates = [];
        for ($i = 0; $i < 7; $i++) {
            $allDates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }


        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/movies/movies_content.php';
    }
}
