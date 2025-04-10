<?php
header('Content-Type: application/json');
require_once '../../database.php';

function sendResponse($statusCode, $data) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(405, ['error' => 'Method Not Allowed']);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['login']) || !isset($input['password'])) {
    sendResponse(400, ['error' => 'Invalid input']);
}

$username = $input['login'];
$passwordHash = $input['password'];

$username = mysqli_real_escape_string($conn, $username);
$passwordHash = mysqli_real_escape_string($conn, $passwordHash);


if (strlen($username) < 4 || strlen($username) > 64) {
    sendResponse(400, ['error' => 'Username must be between 4 and 64 characters']);
}

if (strlen($passwordHash) !== 64 || !preg_match('/^[0-9a-f]{64}$/i', $passwordHash)) {
    sendResponse(400, ['error' => 'Invalid password format']);
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    sendResponse(400, ['error' => 'Username can only contain letters, numbers, and underscores']);
}

$query = "SELECT id FROM users WHERE Username = '$username'";
$result = mysqli_query($conn, $query);

if (!$result) {
    sendResponse(500, ['error' => 'Database error']);
}

if (mysqli_num_rows($result) > 0) {
    sendResponse(409, ['error' => 'Username already exists']);
}

$insertQuery = "INSERT INTO users (Username, PasswordHash) VALUES ('$username', '$passwordHash')";
if (!mysqli_query($conn, $insertQuery)) {
    sendResponse(500, ['error' => 'Failed to create user']);
}

$userId = mysqli_insert_id($conn);

$token = bin2hex(random_bytes(32));
$token = mysqli_real_escape_string($conn, $token);
$tokenQuery = "INSERT INTO access_tokens (UserId, Token) VALUES ('$userId', '$token')";
if (!mysqli_query($conn, $tokenQuery)) {
    sendResponse(500, ['error' => 'Failed to create access token']);
}

sendResponse(200, ['access_token' => $token]);
mysqli_close($conn);
?>