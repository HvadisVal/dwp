<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dwp/dbcon.php';

class MoviesModel {
    private $db;

    public function __construct() {
        $this->db = dbCon("root", "");
    }

    public function getFilteredMovies($date, $movieId, $versionId) {
        $query = "SELECT DISTINCT Movie.Movie_ID, Movie.Title, 
                         (SELECT FileName 
                          FROM Media 
                          WHERE Media.Movie_ID = Movie.Movie_ID 
                          LIMIT 1) AS FileName
                  FROM Movie
                  INNER JOIN Screening ON Movie.Movie_ID = Screening.Movie_ID
                  LEFT JOIN Version ON Movie.Version_ID = Version.Version_ID
                  WHERE 1=1";

        $params = [];

        if ($date) {
            $query .= " AND Screening.ShowDate = :date";
            $params[':date'] = $date;
        }

        if ($movieId) {
            $query .= " AND Movie.Movie_ID = :movieId";
            $params[':movieId'] = $movieId;
        }

        if ($versionId) {
            $query .= " AND Movie.Version_ID = :versionId";
            $params[':versionId'] = $versionId;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
