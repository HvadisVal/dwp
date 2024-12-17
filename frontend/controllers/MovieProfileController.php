<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/models/MovieProfileModel.php';

class MovieProfileController {
    private $model;

    public function __construct($connection) {
        $this->model = new MovieProfileModel($connection);
    }

    public function handleRequest() {
        $movieId = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
        if ($movieId <= 0) {
            echo "Invalid movie ID.";
            exit;
        }

        $rawMovieData = $this->model->getMovieDetails($movieId);
        if (!$rawMovieData) {
            echo "Movie not found.";
            exit;
        }

        $movieDetails = [
            'Movie_ID' => $rawMovieData[0]['Movie_ID'],
            'Title' => $rawMovieData[0]['Title'],
            'Director' => $rawMovieData[0]['Director'],
            'Language' => $rawMovieData[0]['Language'],
            'Year' => $rawMovieData[0]['Year'],
            'Duration' => $rawMovieData[0]['Duration'],
            'Rating' => $rawMovieData[0]['Rating'],
            'Description' => $rawMovieData[0]['Description'],
            'TrailerLink' => $rawMovieData[0]['TrailerLink'],
            'AgeLimit' => $rawMovieData[0]['AgeLimit'],
            'PosterFiles' => explode(',', $rawMovieData[0]['PosterFiles']),
            'GalleryFiles' => explode(',', $rawMovieData[0]['GalleryFiles']),
            'Showtimes' => [], 
        ];

        $weekOffset = isset($_GET['week_offset']) ? (int)$_GET['week_offset'] : 0;

        $startDate = new DateTime();
        $startDate->modify('monday this week'); 
        $startDate->modify("+$weekOffset weeks"); 

        foreach ($rawMovieData as $data) {
            $showDate = $data['ShowDate'];
            if (!isset($movieDetails['Showtimes'][$showDate])) {
                $movieDetails['Showtimes'][$showDate] = [];
            }
            $movieDetails['Showtimes'][$showDate][] = [
                'CinemaHall_ID' => $data['CinemaHall_ID'],
                'CinemaHall_Name' => $data['CinemaHall_Name'],
                'ShowTime' => $data['ShowTime'],
                'Version' => $data['Version'],
            ];
        }

        $daysToShow = 7;
        $allDates = [];
        for ($i = 0; $i < $daysToShow; $i++) {
            $allDates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }

        require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/frontend/views/movie_profile/movie_content.php';
    }
}
