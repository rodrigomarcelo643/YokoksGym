<?php
header('Content-Type: application/json');

include 'connection.php';

// Get the ID from the request
parse_str(file_get_contents("php://input"), $input);
$memberId = $input['id'] ?? '';

if ($memberId) {
    $sql = "DELETE FROM members WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $memberId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Deletion failed"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid ID"]);
}

$conn->close();
?>