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

// Проверка длины входных данных (дополнительная валидация)
if (strlen($username) < 4 || strlen($passwordHash) !== 64) {
    sendResponse(400, ['error' => 'Invalid username or password format']);
}

$query = "SELECT id, PasswordHash FROM users WHERE Username = '$username'";
$result = mysqli_query($conn, $query);
if (!$result) {
    sendResponse(500, ['error' => 'Database error']);
}

if (mysqli_num_rows($result) === 0) {
    sendResponse(401, ['error' => 'Invalid username or password']);
}

$user = mysqli_fetch_assoc($result);
if ($passwordHash !== $user['PasswordHash']) {
    sendResponse(401, ['error' => 'Invalid username or password']);
}

$userId = $user['id'];

$token = bin2hex(random_bytes(32));
$tokenQuery = "INSERT INTO access_tokens (UserId, Token) VALUES ('$userId', '$token')";
if (!mysqli_query($conn, $tokenQuery)) {
    sendResponse(500, ['error' => 'Failed to create access token']);
}

sendResponse(200, ['access_token' => $token]);
?>