<?php
session_start();
header('Content-Type: application/json');
include 'connection.php';

if (!isset($_SESSION['staffUsername'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$password = $data['password'] ?? '';


$username = $_SESSION['staffUsername'];
$stmt = $conn->prepare("SELECT staffPassword FROM addstaff WHERE staffUsername = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
 
    if (password_verify($password, $user['staffPassword'])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

$stmt->close();
$conn->close();
?>