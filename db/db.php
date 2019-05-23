<?php
include '../config/app.php';
try
{
    $connect = new PDO("mysql:host=localhost;dbname=" . $dbname . ";charset=utf8", $dbuser, $dbpass);
    $connect->exec("SET CHARACTER SET utf8");
    $connect->exec("set names utf8");
    return $connect;
} catch (PDOException $error) {
    echo "Error in Connect";
}
