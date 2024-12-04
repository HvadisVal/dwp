<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/MoviesModel.php';

class MoviesController {
    private $model;

    public function __construct($connection) {
        // Pass the connection to the AboutModel constructor
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

        // Prepare dates for the next 7 days
        $daysToShow = 7;
        $startDate = new DateTime();
        $allDates = [];

        for ($i = 0; $i < $daysToShow; $i++) {
            $allDates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }

        // Pass data to the view
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/movies/movies_content.php';
    }
}
