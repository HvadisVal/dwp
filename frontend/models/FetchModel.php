<?php
require_once("./includes/connection.php");

class MoviesModel {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
    public function getFilteredMovies($date, $movieId, $versionId) {
        $sql = "SELECT DISTINCT Movie.Movie_ID, Movie.Title, 
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
            $sql .= " AND Screening.ShowDate = :date";
            $params[':date'] = $date;
        }

        if ($movieId) {
            $sql .= " AND Movie.Movie_ID = :movieId";
            $params[':movieId'] = $movieId;
        }

        if ($versionId) {
            $sql .= " AND Movie.Version_ID = :versionId";
            $params[':versionId'] = $versionId;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
