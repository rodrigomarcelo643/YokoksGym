<?php
header('Content-Type: application/json');
include 'connection.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Use a prepared statement to delete the workout
    $query = "DELETE FROM workouts WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Delete failed']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Query preparation failed: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No id provided']);
}

$conn->close();
?>
