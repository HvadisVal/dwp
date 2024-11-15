<?php
/* $user = "c5di1yb93_dwp";
$pass = "123456";

function dbCon ($user, $pass) {
    try {
        $dbCon = new PDO('mysql:host=localhost; dbname=c5di1yb93_dwp; charset=utf8', $user, $pass);
        return $dbCon;
    } catch (PDOException $err) {
        echo 'Connection failed: ' . $err->getMessage() . '<br>';
        die();
    }} */
    
    $user = "root";
    $pass = "";
    
    function dbCon ($user, $pass) {
        try {
            $dbCon = new PDO('mysql:host=localhost; dbname=c5di1yb93_dwp; charset=utf8', $user, $pass);
            return $dbCon;
        } catch (PDOException $err) {
            echo 'Connection failed: ' . $err->getMessage() . '<br>';
            die();
        }}