<?php
header("Content-Type: application/json");
include 'connection.php';

// Retrieve data from POST request
$user = $_POST['username'];
$exercise = $_POST['exercise'];
$duration = $_POST['duration'];
$kg = $_POST['kg'];
$reps = $_POST['reps'];
$notes = $_POST['notes'];
$goal = $_POST['goal'];
$intensity = $_POST['intensity']; // New intensity field

// Prepare user ID query
$userQuery = $conn->prepare("SELECT id FROM members_mobile WHERE username = ?");
$userQuery->bind_param("s", $user);
$userQuery->execute();
$userQuery->bind_result($userId);

if (!$userQuery->fetch()) {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    $userQuery->close();
    exit();
}
$userQuery->close();

// Insert query with the intensity field added
$stmt = $conn->prepare("INSERT INTO workouts (username, exercise, duration, kg, reps, notes, goal, intensity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiiisis", $user, $exercise, $duration, $kg, $reps, $notes, $goal, $intensity);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to insert workout']);
}

$stmt->close();
$conn->close();
?>
