<?php
// Database
require_once('./database.php');

// Method validation
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    die('Only POST requests are allowed');
}

// Required fields check
$required_fields = array('id', 'date', 'time', 'description');
foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        http_response_code(400);
        die($field . ' required');
    }
}

$id = $_POST["id"];
$date = $_POST["date"];
$time = $_POST["time"];
$description = $_POST["description"];

// Fields type validation
if (!ctype_digit(strval($id))) {
    http_response_code(400);
    die('ID should be an integer.');
}

$id = intval($id);
$date = strval($date);
$time = strval($time);
$description = strval($description);

$query = "UPDATE db SET `Description` = ?, `Time` = ?, `Date` = ? WHERE `id` = ?";
$statement = mysqli_prepare($conn, $query);
if (!$statement) {
    mysqli_close($conn);

    http_response_code(500);
    die('Cannot prepare query: ' . mysqli_error($conn));
}

mysqli_stmt_bind_param($statement, "sssi", $description, $time, $date, $id);
$result = mysqli_stmt_execute($statement);
if (!$result) {
    $error = mysqli_stmt_error($statement);

    mysqli_stmt_close($statement);
    mysqli_close($conn);

    die('Statement execution error: ' . $error);
}

mysqli_stmt_close($statement);
mysqli_close($conn);

header("Location: index.php?success=1");
exit();

?>