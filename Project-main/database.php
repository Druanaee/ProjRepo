<?php
$host = "notik.nameless.pw";
$baza = "notik";
$user = "notik";
$password = "N0t1kP455W0rd";
$conn = mysqli_connect($host, $user, $password, $baza);
if(!$conn) {
    http_response_code(500);
    die('Cannot initialize a connection to the database: ' . mysqli_error($connection));
}
?> 
