<?php
$user = "root";
$pass = "";

function dbCon ($user, $pass) {
    try {
        $dbCon = new PDO('mysql:host=localhost; dbname=dwp; charset=utf8', $user, $pass);
        return $dbCon;
    } catch (PDOException $err) {
        echo 'Connection failed: ' . $err->getMessage() . '<br>';
        die();
    }}
    