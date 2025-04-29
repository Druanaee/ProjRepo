<?php
include "index.php";

if($_SERVER["REQUEST_METHOD"] != "POST") { die(); }

function validateDateTime($date, $time, $format = 'Y-m-d H:i') {
    $datetime = "$date $time";
    $dateObj = date_create_from_format($format, $datetime);
    if (!$dateObj || date_format($dateObj, $format) !== $datetime) {
        return false; // Invalid date or time
    }
    return date_timestamp_get($dateObj) >= time();
}

$date = $_POST["date"];
$time = $_POST["time"];

if (!validateDateTime($date, $time)) {
    die('Invalid Date');
}

$description = $_POST["description"];
$query = "INSERT INTO db (`Description`, `Date`, `Time`, `OwnerId`) VALUES('$description', '$date', '$time', '$user_id')";
if(mysqli_query($conn, $query)) {
    header("Location: dodaj_wydarzenie.php?success=1");
    exit();
}
?>